"""
cli.py – command-line entry point for DTC agentic operations.

Usage
-----
    python cli.py --help
    python cli.py --base-url https://dtc.example.com domains list
    python cli.py --base-url https://dtc.example.com domains describe example.com
    python cli.py --base-url https://dtc.example.com domains provision example.com
    python cli.py --base-url https://dtc.example.com domains remove example.com
"""

from __future__ import annotations

import argparse
import json
import os
import sys
from typing import List, Optional

from agents.domain_agent import DomainAgent
from core.dtc_client import DTCClient


def build_parser() -> argparse.ArgumentParser:
    """Construct and return the top-level argument parser."""
    parser = argparse.ArgumentParser(
        prog="dtc-agent",
        description="DTC agentic AI command-line interface",
    )
    parser.add_argument(
        "--base-url",
        default=os.environ.get("DTC_BASE_URL", "http://localhost"),
        help="Base URL of the DTC instance (env: DTC_BASE_URL)",
    )
    parser.add_argument(
        "--api-key",
        default=os.environ.get("DTC_API_KEY", ""),
        help="DTC API key or session token (env: DTC_API_KEY)",
    )

    subparsers = parser.add_subparsers(dest="resource", required=True)

    # --- domains sub-command -----------------------------------------
    domain_parser = subparsers.add_parser("domains", help="Domain management")
    domain_sub = domain_parser.add_subparsers(dest="action", required=True)

    domain_sub.add_parser("list", help="List all domains")

    describe_p = domain_sub.add_parser("describe", help="Describe a domain")
    describe_p.add_argument("domain", help="Fully-qualified domain name")

    provision_p = domain_sub.add_parser("provision", help="Create a domain")
    provision_p.add_argument("domain", help="Fully-qualified domain name")

    remove_p = domain_sub.add_parser("remove", help="Delete a domain")
    remove_p.add_argument("domain", help="Fully-qualified domain name")

    return parser


def run(argv: Optional[List[str]] = None) -> int:
    """Parse arguments and dispatch to the appropriate agent method.

    Parameters
    ----------
    argv:
        Argument list (defaults to ``sys.argv[1:]``).

    Returns
    -------
    int
        Exit code – 0 on success, 1 on error.
    """
    parser = build_parser()
    args = parser.parse_args(argv)

    try:
        client = DTCClient(base_url=args.base_url, api_key=args.api_key)
        agent = DomainAgent(client)
    except Exception as exc:
        print(f"Failed to initialize DTC client: {exc}", file=sys.stderr)
        return 1

    result: object = None

    if args.resource == "domains":
        if args.action == "list":
            result = agent.list_domains()
        elif args.action == "describe":
            result = agent.describe_domain(args.domain)
        elif args.action == "provision":
            result = agent.provision_domain(args.domain)
        elif args.action == "remove":
            result = agent.remove_domain(args.domain)

    print(json.dumps(result, indent=2))
    if isinstance(result, dict) and result.get("ok") is False:
        return 1
    return 0


if __name__ == "__main__":
    sys.exit(run())
