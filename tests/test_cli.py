"""
Tests for the CLI entry point in cli.py.
"""

from __future__ import annotations

import json
from unittest.mock import MagicMock, patch

import pytest

import cli


@pytest.fixture(autouse=True)
def _patch_client(monkeypatch: pytest.MonkeyPatch) -> MagicMock:
    """Patch DTCClient so tests never make real HTTP calls."""
    mock = MagicMock()
    monkeypatch.setattr("cli.DTCClient", mock)
    return mock


@pytest.fixture(autouse=True)
def _patch_agent(monkeypatch: pytest.MonkeyPatch) -> MagicMock:
    """Patch DomainAgent so tests control return values."""
    mock = MagicMock()
    monkeypatch.setattr("cli.DomainAgent", mock)
    return mock


def _agent_instance(monkeypatch_fixture: pytest.MonkeyPatch) -> MagicMock:
    return cli.DomainAgent.return_value  # type: ignore[attr-defined]


class TestCLIDomainsListCommand:
    def test_exits_zero_on_success(self, capsys: pytest.CaptureFixture) -> None:
        cli.DomainAgent.return_value.list_domains.return_value = {
            "ok": True,
            "domains": [{"name": "a.com"}],
        }
        rc = cli.run(["--base-url", "http://x", "domains", "list"])
        assert rc == 0
        out = capsys.readouterr().out
        data = json.loads(out)
        assert data["domains"][0]["name"] == "a.com"

    def test_exits_one_on_error_payload(self, capsys: pytest.CaptureFixture) -> None:
        cli.DomainAgent.return_value.list_domains.return_value = {
            "ok": False,
            "operation": "list_domains",
            "error": "boom",
        }
        rc = cli.run(["--base-url", "http://x", "domains", "list"])
        assert rc == 1


class TestCLIDomainsDescribeCommand:
    def test_exits_zero_on_success(self, capsys: pytest.CaptureFixture) -> None:
        cli.DomainAgent.return_value.describe_domain.return_value = {"name": "b.com"}
        rc = cli.run(["--base-url", "http://x", "domains", "describe", "b.com"])
        assert rc == 0
        cli.DomainAgent.return_value.describe_domain.assert_called_once_with("b.com")


class TestCLIDomainsProvisionCommand:
    def test_exits_zero_on_success(self, capsys: pytest.CaptureFixture) -> None:
        cli.DomainAgent.return_value.provision_domain.return_value = {"name": "c.com"}
        rc = cli.run(["--base-url", "http://x", "domains", "provision", "c.com"])
        assert rc == 0
        cli.DomainAgent.return_value.provision_domain.assert_called_once_with("c.com")


class TestCLIDomainsRemoveCommand:
    def test_exits_zero_on_success(self, capsys: pytest.CaptureFixture) -> None:
        cli.DomainAgent.return_value.remove_domain.return_value = {"ok": True, "domain": "d.com"}
        rc = cli.run(["--base-url", "http://x", "domains", "remove", "d.com"])
        assert rc == 0

    def test_exits_one_on_error_payload(self, capsys: pytest.CaptureFixture) -> None:
        cli.DomainAgent.return_value.remove_domain.return_value = {
            "ok": False,
            "operation": "remove_domain",
            "error": "not found",
        }
        rc = cli.run(["--base-url", "http://x", "domains", "remove", "gone.com"])
        assert rc == 1


# ---------------------------------------------------------------------------
# Standalone test functions
# ---------------------------------------------------------------------------


def test_build_parser_returns_parser() -> None:
    parser = cli.build_parser()
    assert parser is not None
    assert parser.prog == "dtc-agent"


def test_run_domains_list_success(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    mock_client_cls = MagicMock()
    mock_agent_cls = MagicMock()
    mock_agent_cls.return_value.list_domains.return_value = {"ok": True, "domains": []}
    monkeypatch.setattr("cli.DTCClient", mock_client_cls)
    monkeypatch.setattr("cli.DomainAgent", mock_agent_cls)
    rc = cli.run(["--base-url", "http://x", "domains", "list"])
    assert rc == 0


def test_run_domains_list_error(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    mock_client_cls = MagicMock()
    mock_agent_cls = MagicMock()
    mock_agent_cls.return_value.list_domains.return_value = {
        "ok": False,
        "operation": "list_domains",
        "error": "timeout",
    }
    monkeypatch.setattr("cli.DTCClient", mock_client_cls)
    monkeypatch.setattr("cli.DomainAgent", mock_agent_cls)
    rc = cli.run(["--base-url", "http://x", "domains", "list"])
    assert rc == 1


def test_run_domains_describe(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    mock_client_cls = MagicMock()
    mock_agent_cls = MagicMock()
    mock_agent_cls.return_value.describe_domain.return_value = {"name": "z.com"}
    monkeypatch.setattr("cli.DTCClient", mock_client_cls)
    monkeypatch.setattr("cli.DomainAgent", mock_agent_cls)
    rc = cli.run(["--base-url", "http://x", "domains", "describe", "z.com"])
    assert rc == 0
    mock_agent_cls.return_value.describe_domain.assert_called_once_with("z.com")


def test_run_domains_provision(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    mock_client_cls = MagicMock()
    mock_agent_cls = MagicMock()
    mock_agent_cls.return_value.provision_domain.return_value = {"name": "z.com"}
    monkeypatch.setattr("cli.DTCClient", mock_client_cls)
    monkeypatch.setattr("cli.DomainAgent", mock_agent_cls)
    rc = cli.run(["--base-url", "http://x", "domains", "provision", "z.com"])
    assert rc == 0
    mock_agent_cls.return_value.provision_domain.assert_called_once_with("z.com")


def test_run_domains_remove_success(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    mock_client_cls = MagicMock()
    mock_agent_cls = MagicMock()
    mock_agent_cls.return_value.remove_domain.return_value = {"ok": True, "domain": "z.com"}
    monkeypatch.setattr("cli.DTCClient", mock_client_cls)
    monkeypatch.setattr("cli.DomainAgent", mock_agent_cls)
    rc = cli.run(["--base-url", "http://x", "domains", "remove", "z.com"])
    assert rc == 0


def test_run_domains_remove_error(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    mock_client_cls = MagicMock()
    mock_agent_cls = MagicMock()
    mock_agent_cls.return_value.remove_domain.return_value = {
        "ok": False,
        "operation": "remove_domain",
        "error": "not found",
    }
    monkeypatch.setattr("cli.DTCClient", mock_client_cls)
    monkeypatch.setattr("cli.DomainAgent", mock_agent_cls)
    rc = cli.run(["--base-url", "http://x", "domains", "remove", "z.com"])
    assert rc == 1


def test_run_client_init_failure(monkeypatch: pytest.MonkeyPatch, capsys: pytest.CaptureFixture) -> None:
    def bad_client(*args: object, **kwargs: object) -> None:
        raise RuntimeError("bad config")

    monkeypatch.setattr("cli.DTCClient", bad_client)
    rc = cli.run(["--base-url", "http://x", "domains", "list"])
    assert rc == 1
    err = capsys.readouterr().err
    assert "bad config" in err
