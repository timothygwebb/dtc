"""
DTCClient – lightweight Python wrapper around the DTC REST API.

This module encapsulates all HTTP communication with a running DTC instance
so that higher-level agents and CLI tools do not need to deal with raw
requests or response parsing.
"""

from __future__ import annotations

import os
from typing import Any, Dict, Optional

try:
    import requests
except ImportError as exc:  # pragma: no cover
    raise ImportError(
        "The 'requests' package is required. Install it with: pip install requests"
    ) from exc


class DTCClient:
    """Thin client for the DTC admin REST API.

    Parameters
    ----------
    base_url:
        Base URL of the DTC instance, e.g. ``https://dtc.example.com``.
    api_key:
        Optional API key or session token used for authentication.
        Falls back to the ``DTC_API_KEY`` environment variable when omitted.
    timeout:
        HTTP request timeout in seconds (default: 30).
    """

    def __init__(
        self,
        base_url: str,
        api_key: Optional[str] = None,
        timeout: int = 30,
    ) -> None:
        self.base_url = base_url.rstrip("/")
        self.api_key = api_key or os.environ.get("DTC_API_KEY", "")
        self.timeout = timeout
        self._session = requests.Session()
        if self.api_key:
            self._session.headers.update({"Authorization": f"Bearer {self.api_key}"})

    # ------------------------------------------------------------------
    # Public helpers
    # ------------------------------------------------------------------

    def get_domains(self) -> list[Dict[str, Any]]:
        """Return a list of all domains managed by this DTC instance.

        Returns
        -------
        list[dict]
            Each element contains at minimum ``name`` and ``status`` keys.

        Raises
        ------
        requests.HTTPError
            If the server returns a non-2xx status code.
        """
        return self._get("/api/domains")

    def get_domain(self, domain: str) -> Dict[str, Any]:
        """Return details for a single domain.

        Parameters
        ----------
        domain:
            Fully-qualified domain name.

        Returns
        -------
        dict
            Domain details as returned by the DTC API.
        """
        return self._get(f"/api/domains/{domain}")

    def create_domain(self, domain: str, **kwargs: Any) -> Dict[str, Any]:
        """Create a new domain on the DTC instance.

        Parameters
        ----------
        domain:
            Fully-qualified domain name.
        **kwargs:
            Additional parameters forwarded to the API payload.

        Returns
        -------
        dict
            Created domain record.
        """
        payload: Dict[str, Any] = {"name": domain, **kwargs}
        return self._post("/api/domains", json=payload)

    def delete_domain(self, domain: str) -> bool:
        """Delete a domain from the DTC instance.

        Parameters
        ----------
        domain:
            Fully-qualified domain name.

        Returns
        -------
        bool
            ``True`` if deletion was successful.
        """
        response = self._session.delete(
            f"{self.base_url}/api/domains/{domain}",
            timeout=self.timeout,
        )
        try:
            response.raise_for_status()
        except requests.HTTPError as exc:
            raise requests.HTTPError(
                f"Failed to delete domain '{domain}': {exc}"
            ) from exc
        return True

    # ------------------------------------------------------------------
    # Private helpers
    # ------------------------------------------------------------------

    def _get(self, path: str) -> Any:
        """Perform a GET request and return parsed JSON."""
        try:
            response = self._session.get(
                f"{self.base_url}{path}", timeout=self.timeout
            )
            response.raise_for_status()
            return response.json()
        except requests.HTTPError as exc:
            raise requests.HTTPError(f"GET {path} failed: {exc}") from exc
        except requests.ConnectionError as exc:
            raise requests.ConnectionError(
                f"Cannot connect to DTC at {self.base_url}: {exc}"
            ) from exc

    def _post(self, path: str, **kwargs: Any) -> Any:
        """Perform a POST request and return parsed JSON."""
        try:
            response = self._session.post(
                f"{self.base_url}{path}", timeout=self.timeout, **kwargs
            )
            response.raise_for_status()
            return response.json()
        except requests.HTTPError as exc:
            raise requests.HTTPError(f"POST {path} failed: {exc}") from exc
        except requests.ConnectionError as exc:
            raise requests.ConnectionError(
                f"Cannot connect to DTC at {self.base_url}: {exc}"
            ) from exc
