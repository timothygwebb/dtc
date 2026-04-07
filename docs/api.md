# API Reference

This document covers the DTC REST API endpoints consumed by the Python client and the full CLI command reference.

---

## REST API Endpoints

All endpoints are relative to the `DTC_BASE_URL` (e.g. `https://dtc.example.com`).

Requests that require authentication must include the header:

```
Authorization: Bearer <api-key>
```

### Domains

| Method | Path | Description |
|--------|------|-------------|
| `GET` | `/api/domains` | List all domains |
| `GET` | `/api/domains/{domain}` | Get details for a specific domain |
| `POST` | `/api/domains` | Create a new domain |
| `DELETE` | `/api/domains/{domain}` | Delete a domain |

#### `GET /api/domains`

Returns a JSON array of domain objects. Each object contains at minimum:

```json
[
  { "name": "example.com", "status": "active" }
]
```

#### `GET /api/domains/{domain}`

Returns a JSON object with the details for the given domain.

#### `POST /api/domains`

Request body (JSON):

```json
{ "name": "example.com" }
```

Additional fields are forwarded to the DTC API as-is. Returns the created domain record.

#### `DELETE /api/domains/{domain}`

Returns HTTP 204 on success.

---

## Python Client (`core.DTCClient`)

```python
from core.dtc_client import DTCClient

client = DTCClient(
    base_url="https://dtc.example.com",
    api_key="your-api-key",   # or set DTC_API_KEY env var
    timeout=30,                # optional, default 30 s
)
```

### Methods

| Method | Description |
|--------|-------------|
| `get_domains()` | Returns `list[dict]` of all domains |
| `get_domain(domain)` | Returns `dict` with domain details |
| `create_domain(domain, **kwargs)` | Creates a domain; returns the created record |
| `delete_domain(domain)` | Deletes a domain; returns `True` on success |

All methods raise `requests.HTTPError` on non-2xx responses and `requests.ConnectionError` when the server is unreachable.

---

## Python Agent (`agents.DomainAgent`)

`DomainAgent` wraps `DTCClient` and catches exceptions, always returning a structured `dict` rather than raising.

```python
from core.dtc_client import DTCClient
from agents.domain_agent import DomainAgent

client = DTCClient(base_url="https://dtc.example.com", api_key="...")
agent = DomainAgent(client)
```

### Methods

#### `list_domains() → dict`

```python
result = agent.list_domains()
# Success:  {"ok": True, "domains": [...]}
# Failure:  {"ok": False, "operation": "list_domains", "error": "..."}
```

#### `describe_domain(domain) → dict`

```python
result = agent.describe_domain("example.com")
# Success:  {domain details dict}
# Failure:  {"ok": False, "operation": "describe_domain", "error": "..."}
```

#### `provision_domain(domain, options=None) → dict`

```python
result = agent.provision_domain("example.com", options={"plan": "basic"})
# Success:  {created domain record}
# Failure:  {"ok": False, "operation": "provision_domain", "error": "..."}
```

#### `remove_domain(domain) → dict`

```python
result = agent.remove_domain("example.com")
# Success:  {"ok": True, "domain": "example.com"}
# Failure:  {"ok": False, "operation": "remove_domain", "error": "..."}
```

### Module-level convenience functions

The same operations are also available as module-level functions that accept a `DTCClient` directly:

```python
from agents.domain_agent import list_domains, describe_domain, provision_domain, remove_domain
```

---

## CLI Reference

```
usage: dtc-agent [-h] [--base-url BASE_URL] [--api-key API_KEY] {domains} ...
```

### Global flags

| Flag | Environment variable | Description |
|------|---------------------|-------------|
| `--base-url URL` | `DTC_BASE_URL` | Base URL of the DTC instance |
| `--api-key KEY` | `DTC_API_KEY` | API key / session token |

### `domains` subcommands

```bash
python cli.py domains list
python cli.py domains describe <domain>
python cli.py domains provision <domain>
python cli.py domains remove <domain>
```

| Subcommand | Description |
|------------|-------------|
| `list` | Print a JSON array of all domains |
| `describe <domain>` | Print details for the given domain |
| `provision <domain>` | Create the given domain |
| `remove <domain>` | Delete the given domain |

### Exit codes

| Code | Meaning |
|------|---------|
| `0` | Success |
| `1` | The API returned an error payload or a connection failure occurred |

### Examples

```bash
# Use environment variables
export DTC_BASE_URL=https://dtc.example.com
export DTC_API_KEY=secret

python cli.py domains list
python cli.py domains describe example.com
python cli.py domains provision newsite.com
python cli.py domains remove oldsite.com
```
