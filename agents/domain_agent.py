"""
DomainAgent – agentic interface for DTC domain management.

This agent wraps the :class:`core.DTCClient` and exposes a higher-level
interface suitable for use by AI orchestration frameworks.  Every public
method is fully type-annotated and includes comprehensive docstrings so that
LLM tool-calling can auto-generate accurate schemas.
"""

from __future__ import annotations

from typing import Any, Dict, Optional

from core.dtc_client import DTCClient


class DomainAgent:
    """Agent responsible for domain-lifecycle operations in DTC.

    Parameters
    ----------
    client:
        An initialised :class:`core.DTCClient` instance.
    """

    def __init__(self, client: DTCClient) -> None:
        self._client = client

    # ------------------------------------------------------------------
    # Public agent interface
    # ------------------------------------------------------------------

    def list_domains(self) -> Dict[str, Any]:
        """List all domains managed by the DTC instance.

        Returns
        -------
        dict
            ``{"ok": True, "domains": [...]}`` on success, or
            ``{"ok": False, "operation": ..., "error": ...}`` on failure.
        """
        try:
            domains = self._client.get_domains()
            return {"ok": True, "domains": domains}
        except Exception as exc:
            return self._fallback_error("list_domains", exc)

    def describe_domain(self, domain: str) -> Dict[str, Any]:
        """Return detailed information about a specific domain.

        Parameters
        ----------
        domain:
            Fully-qualified domain name, e.g. ``example.com``.

        Returns
        -------
        dict
            Domain details or an error payload on failure.
        """
        try:
            return self._client.get_domain(domain)
        except Exception as exc:
            return self._fallback_error("describe_domain", exc)

    def provision_domain(
        self, domain: str, options: Optional[Dict[str, Any]] = None
    ) -> Dict[str, Any]:
        """Create and configure a new domain.

        Parameters
        ----------
        domain:
            Fully-qualified domain name.
        options:
            Optional configuration overrides passed to the DTC API.

        Returns
        -------
        dict
            Created domain record or an error payload on failure.
        """
        try:
            return self._client.create_domain(domain, **(options or {}))
        except Exception as exc:
            return self._fallback_error("provision_domain", exc)

    def remove_domain(self, domain: str) -> Dict[str, Any]:
        """Remove a domain from the DTC instance.

        Parameters
        ----------
        domain:
            Fully-qualified domain name.

        Returns
        -------
        dict
            Success payload ``{"ok": True}`` or an error payload on failure.
        """
        try:
            self._client.delete_domain(domain)
            return {"ok": True, "domain": domain}
        except Exception as exc:
            return self._fallback_error("remove_domain", exc)

    # ------------------------------------------------------------------
    # Private helpers
    # ------------------------------------------------------------------

    @staticmethod
    def _fallback_error(operation: str, exc: Exception) -> Dict[str, Any]:
        """Return a safe, structured error payload instead of raising.

        This ensures that agent callers always receive a dict and never an
        unhandled exception, making the agent safe to use in automated
        pipelines.

        Parameters
        ----------
        operation:
            Name of the operation that failed.
        exc:
            The underlying exception.

        Returns
        -------
        dict
            ``{"ok": False, "operation": ..., "error": ...}``
        """
        return {
            "ok": False,
            "operation": operation,
            "error": str(exc),
        }


# ---------------------------------------------------------------------------
# Module-level public functions
# ---------------------------------------------------------------------------
# These convenience wrappers allow callers to invoke agent operations without
# explicitly managing a DomainAgent instance, which is useful for one-shot
# calls from orchestration frameworks and tool-calling LLMs.


def list_domains(client: DTCClient) -> Dict[str, Any]:
    """List all domains managed by the DTC instance.

    Parameters
    ----------
    client:
        An initialised :class:`core.DTCClient` instance.

    Returns
    -------
    dict
        ``{"ok": True, "domains": [...]}`` on success, or
        ``{"ok": False, "operation": ..., "error": ...}`` on failure.
    """
    return DomainAgent(client).list_domains()


def describe_domain(client: DTCClient, domain: str) -> Dict[str, Any]:
    """Return detailed information about a specific domain.

    Parameters
    ----------
    client:
        An initialised :class:`core.DTCClient` instance.
    domain:
        Fully-qualified domain name, e.g. ``example.com``.

    Returns
    -------
    dict
        Domain details or an error payload on failure.
    """
    return DomainAgent(client).describe_domain(domain)


def provision_domain(
    client: DTCClient,
    domain: str,
    options: Optional[Dict[str, Any]] = None,
) -> Dict[str, Any]:
    """Create and configure a new domain.

    Parameters
    ----------
    client:
        An initialised :class:`core.DTCClient` instance.
    domain:
        Fully-qualified domain name.
    options:
        Optional configuration overrides passed to the DTC API.

    Returns
    -------
    dict
        Created domain record or an error payload on failure.
    """
    return DomainAgent(client).provision_domain(domain, options=options)


def remove_domain(client: DTCClient, domain: str) -> Dict[str, Any]:
    """Remove a domain from the DTC instance.

    Parameters
    ----------
    client:
        An initialised :class:`core.DTCClient` instance.
    domain:
        Fully-qualified domain name.

    Returns
    -------
    dict
        Success payload ``{"ok": True}`` or an error payload on failure.
    """
    return DomainAgent(client).remove_domain(domain)
