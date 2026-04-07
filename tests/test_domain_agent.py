"""
Tests for the DomainAgent in agents/domain_agent.py.
"""

from __future__ import annotations

from unittest.mock import MagicMock, patch

import pytest

from agents.domain_agent import (
    DomainAgent,
    describe_domain,
    list_domains,
    provision_domain,
    remove_domain,
)
from core.dtc_client import DTCClient


@pytest.fixture()
def mock_client() -> MagicMock:
    """Return a MagicMock that stands in for a real DTCClient."""
    return MagicMock(spec=DTCClient)


@pytest.fixture()
def agent(mock_client: MagicMock) -> DomainAgent:
    """Return a DomainAgent wired to the mock client."""
    return DomainAgent(mock_client)


class TestListDomains:
    def test_returns_domain_list(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.get_domains.return_value = [{"name": "example.com", "status": "active"}]
        result = agent.list_domains()
        assert result["ok"] is True
        assert result["domains"] == [{"name": "example.com", "status": "active"}]
        mock_client.get_domains.assert_called_once()

    def test_returns_fallback_on_error(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.get_domains.side_effect = RuntimeError("connection refused")
        result = agent.list_domains()
        assert result["ok"] is False
        assert "connection refused" in result["error"]
        assert result["operation"] == "list_domains"


class TestDescribeDomain:
    def test_returns_domain_details(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        expected = {"name": "example.com", "status": "active", "owner": "admin"}
        mock_client.get_domain.return_value = expected
        result = agent.describe_domain("example.com")
        assert result == expected
        mock_client.get_domain.assert_called_once_with("example.com")

    def test_returns_fallback_on_error(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.get_domain.side_effect = ValueError("not found")
        result = agent.describe_domain("missing.com")
        assert result["ok"] is False
        assert result["operation"] == "describe_domain"


class TestProvisionDomain:
    def test_creates_domain_with_options(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.create_domain.return_value = {"name": "new.com", "status": "pending"}
        result = agent.provision_domain("new.com", options={"quota": 100})
        assert result["name"] == "new.com"
        mock_client.create_domain.assert_called_once_with("new.com", quota=100)

    def test_creates_domain_without_options(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.create_domain.return_value = {"name": "bare.com"}
        result = agent.provision_domain("bare.com")
        assert result["name"] == "bare.com"
        mock_client.create_domain.assert_called_once_with("bare.com")

    def test_returns_fallback_on_error(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.create_domain.side_effect = Exception("quota exceeded")
        result = agent.provision_domain("fail.com")
        assert result["ok"] is False
        assert "quota exceeded" in result["error"]


class TestRemoveDomain:
    def test_removes_domain_successfully(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.delete_domain.return_value = True
        result = agent.remove_domain("old.com")
        assert result == {"ok": True, "domain": "old.com"}
        mock_client.delete_domain.assert_called_once_with("old.com")

    def test_returns_fallback_on_error(self, agent: DomainAgent, mock_client: MagicMock) -> None:
        mock_client.delete_domain.side_effect = PermissionError("access denied")
        result = agent.remove_domain("protected.com")
        assert result["ok"] is False
        assert result["operation"] == "remove_domain"


# ---------------------------------------------------------------------------
# Tests for module-level public functions
# ---------------------------------------------------------------------------


class TestModuleLevelListDomains:
    def test_delegates_to_agent(self, mock_client: MagicMock) -> None:
        mock_client.get_domains.return_value = [{"name": "example.com"}]
        result = list_domains(mock_client)
        assert result["ok"] is True
        assert result["domains"] == [{"name": "example.com"}]
        mock_client.get_domains.assert_called_once()

    def test_returns_fallback_on_error(self, mock_client: MagicMock) -> None:
        mock_client.get_domains.side_effect = RuntimeError("timeout")
        result = list_domains(mock_client)
        assert result["ok"] is False
        assert "timeout" in result["error"]


class TestModuleLevelDescribeDomain:
    def test_delegates_to_agent(self, mock_client: MagicMock) -> None:
        expected = {"name": "example.com", "status": "active"}
        mock_client.get_domain.return_value = expected
        result = describe_domain(mock_client, "example.com")
        assert result == expected
        mock_client.get_domain.assert_called_once_with("example.com")

    def test_returns_fallback_on_error(self, mock_client: MagicMock) -> None:
        mock_client.get_domain.side_effect = ValueError("not found")
        result = describe_domain(mock_client, "missing.com")
        assert result["ok"] is False
        assert result["operation"] == "describe_domain"


class TestModuleLevelProvisionDomain:
    def test_delegates_to_agent_with_options(self, mock_client: MagicMock) -> None:
        mock_client.create_domain.return_value = {"name": "new.com"}
        result = provision_domain(mock_client, "new.com", options={"quota": 50})
        assert result["name"] == "new.com"
        mock_client.create_domain.assert_called_once_with("new.com", quota=50)

    def test_delegates_to_agent_without_options(self, mock_client: MagicMock) -> None:
        mock_client.create_domain.return_value = {"name": "bare.com"}
        result = provision_domain(mock_client, "bare.com")
        assert result["name"] == "bare.com"
        mock_client.create_domain.assert_called_once_with("bare.com")

    def test_returns_fallback_on_error(self, mock_client: MagicMock) -> None:
        mock_client.create_domain.side_effect = Exception("quota exceeded")
        result = provision_domain(mock_client, "fail.com")
        assert result["ok"] is False
        assert "quota exceeded" in result["error"]


class TestModuleLevelRemoveDomain:
    def test_delegates_to_agent(self, mock_client: MagicMock) -> None:
        mock_client.delete_domain.return_value = True
        result = remove_domain(mock_client, "old.com")
        assert result == {"ok": True, "domain": "old.com"}
        mock_client.delete_domain.assert_called_once_with("old.com")

    def test_returns_fallback_on_error(self, mock_client: MagicMock) -> None:
        mock_client.delete_domain.side_effect = PermissionError("access denied")
        result = remove_domain(mock_client, "protected.com")
        assert result["ok"] is False
        assert result["operation"] == "remove_domain"
