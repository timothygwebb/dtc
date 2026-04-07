"""
Agents package for DTC agentic AI integrations.

Each module in this package is a self-contained agent that exposes a small,
well-defined public interface so that orchestration layers (LangChain, AutoGen,
custom pipelines, etc.) can invoke them without understanding DTC internals.
"""

from .domain_agent import (
    DomainAgent,
    describe_domain,
    list_domains,
    provision_domain,
    remove_domain,
)

__all__ = [
    "DomainAgent",
    "describe_domain",
    "list_domains",
    "provision_domain",
    "remove_domain",
]
