"""
Tests for the DTCClient in core/dtc_client.py.
"""

from __future__ import annotations

from unittest.mock import MagicMock, patch

import pytest
import requests

from core.dtc_client import DTCClient


@pytest.fixture()
def client() -> DTCClient:
    """Return a DTCClient pointed at a fake base URL."""
    return DTCClient(base_url="http://dtc.test", api_key="test-key")


class TestDTCClientInit:
    def test_strips_trailing_slash(self) -> None:
        c = DTCClient(base_url="http://dtc.test/", api_key="k")
        assert c.base_url == "http://dtc.test"

    def test_uses_env_api_key(self, monkeypatch: pytest.MonkeyPatch) -> None:
        monkeypatch.setenv("DTC_API_KEY", "env-key")
        c = DTCClient(base_url="http://dtc.test")
        assert c.api_key == "env-key"

    def test_explicit_key_takes_precedence(self, monkeypatch: pytest.MonkeyPatch) -> None:
        monkeypatch.setenv("DTC_API_KEY", "env-key")
        c = DTCClient(base_url="http://dtc.test", api_key="explicit-key")
        assert c.api_key == "explicit-key"

    def test_auth_header_set_when_key_provided(self) -> None:
        c = DTCClient(base_url="http://dtc.test", api_key="mytoken")
        assert c._session.headers.get("Authorization") == "Bearer mytoken"


class TestGetDomains:
    def test_returns_domains(self, client: DTCClient) -> None:
        mock_response = MagicMock()
        mock_response.json.return_value = [{"name": "example.com"}]
        mock_response.raise_for_status.return_value = None

        with patch.object(client._session, "get", return_value=mock_response) as mock_get:
            result = client.get_domains()

        assert result == [{"name": "example.com"}]
        mock_get.assert_called_once_with("http://dtc.test/api/domains", timeout=30)

    def test_raises_http_error(self, client: DTCClient) -> None:
        mock_response = MagicMock()
        mock_response.raise_for_status.side_effect = requests.HTTPError("500")

        with patch.object(client._session, "get", return_value=mock_response):
            with pytest.raises(requests.HTTPError):
                client.get_domains()

    def test_raises_connection_error(self, client: DTCClient) -> None:
        with patch.object(
            client._session, "get", side_effect=requests.ConnectionError("refused")
        ):
            with pytest.raises(requests.ConnectionError):
                client.get_domains()


class TestGetDomain:
    def test_returns_single_domain(self, client: DTCClient) -> None:
        mock_response = MagicMock()
        mock_response.json.return_value = {"name": "example.com", "status": "active"}
        mock_response.raise_for_status.return_value = None

        with patch.object(client._session, "get", return_value=mock_response):
            result = client.get_domain("example.com")

        assert result["name"] == "example.com"


class TestCreateDomain:
    def test_posts_payload(self, client: DTCClient) -> None:
        mock_response = MagicMock()
        mock_response.json.return_value = {"name": "new.com", "status": "pending"}
        mock_response.raise_for_status.return_value = None

        with patch.object(client._session, "post", return_value=mock_response) as mock_post:
            result = client.create_domain("new.com", quota=50)

        assert result["name"] == "new.com"
        _, kwargs = mock_post.call_args
        assert kwargs["json"] == {"name": "new.com", "quota": 50}


class TestDeleteDomain:
    def test_returns_true_on_success(self, client: DTCClient) -> None:
        mock_response = MagicMock()
        mock_response.raise_for_status.return_value = None

        with patch.object(client._session, "delete", return_value=mock_response):
            assert client.delete_domain("old.com") is True

    def test_raises_http_error_on_failure(self, client: DTCClient) -> None:
        mock_response = MagicMock()
        mock_response.raise_for_status.side_effect = requests.HTTPError("403")

        with patch.object(client._session, "delete", return_value=mock_response):
            with pytest.raises(requests.HTTPError):
                client.delete_domain("forbidden.com")

    def test_raises_connection_error(self, client: DTCClient) -> None:
        with patch.object(
            client._session, "delete", side_effect=requests.ConnectionError("refused")
        ):
            with pytest.raises(requests.ConnectionError):
                client.delete_domain("unreachable.com")


# ---------------------------------------------------------------------------
# Standalone test functions
# ---------------------------------------------------------------------------


def test_client_default_timeout() -> None:
    c = DTCClient(base_url="http://dtc.test", api_key="k")
    assert c.timeout == 30


def test_client_custom_timeout() -> None:
    c = DTCClient(base_url="http://dtc.test", api_key="k", timeout=60)
    assert c.timeout == 60


def test_client_no_api_key_no_auth_header(monkeypatch: pytest.MonkeyPatch) -> None:
    monkeypatch.delenv("DTC_API_KEY", raising=False)
    c = DTCClient(base_url="http://dtc.test")
    assert "Authorization" not in c._session.headers


def test_get_domain_url_includes_domain_name() -> None:
    c = DTCClient(base_url="http://dtc.test", api_key="k")
    mock_response = MagicMock()
    mock_response.json.return_value = {"name": "example.com"}
    mock_response.raise_for_status.return_value = None

    with patch.object(c._session, "get", return_value=mock_response) as mock_get:
        c.get_domain("example.com")

    called_url = mock_get.call_args[0][0]
    assert called_url == "http://dtc.test/api/domains/example.com"


def test_create_domain_url() -> None:
    c = DTCClient(base_url="http://dtc.test", api_key="k")
    mock_response = MagicMock()
    mock_response.json.return_value = {"name": "new.com"}
    mock_response.raise_for_status.return_value = None

    with patch.object(c._session, "post", return_value=mock_response) as mock_post:
        c.create_domain("new.com")

    called_url = mock_post.call_args[0][0]
    assert called_url == "http://dtc.test/api/domains"


def test_delete_domain_url_includes_domain_name() -> None:
    c = DTCClient(base_url="http://dtc.test", api_key="k")
    mock_response = MagicMock()
    mock_response.raise_for_status.return_value = None

    with patch.object(c._session, "delete", return_value=mock_response) as mock_del:
        c.delete_domain("old.com")

    called_url = mock_del.call_args[0][0]
    assert called_url == "http://dtc.test/api/domains/old.com"


def test_get_domains_raises_http_error_with_message() -> None:
    c = DTCClient(base_url="http://dtc.test", api_key="k")
    mock_response = MagicMock()
    mock_response.raise_for_status.side_effect = requests.HTTPError("500")

    with patch.object(c._session, "get", return_value=mock_response):
        with pytest.raises(requests.HTTPError, match="GET /api/domains failed"):
            c.get_domains()
