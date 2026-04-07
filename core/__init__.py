"""
Core business-logic module for DTC agentic integrations.

This package separates reusable domain logic from agent entry-points so that
individual agents stay thin and the underlying logic is easy to test in
isolation.
"""

from .dtc_client import DTCClient

__all__ = ["DTCClient"]
