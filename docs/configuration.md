# Configuration Reference

This document covers post-install configuration for both the DTC hosting panel and the Python agentic CLI.

---

## DTC Hosting Panel

### Database

DTC requires a running MySQL or MariaDB instance. After running the installer, edit the generated configuration file to point to your database:

```
/etc/dtc/dtc.conf
```

Key settings:

| Setting | Description |
|---------|-------------|
| `mysql_host` | Hostname or IP of the MySQL/MariaDB server |
| `mysql_user` | Database user DTC uses for its schema |
| `mysql_password` | Password for the database user |
| `mysql_database` | Name of the DTC database |

### Web Server

DTC generates Apache or Nginx virtual-host configurations. Ensure the web server user has read access to `/usr/share/dtc/admin/`.

### Mail

Mail services (Postfix + Courier or Postfix + Dovecot) are configured via files in `/etc/dtc/`. Consult the man pages for details:

```bash
man dtc_autodeploy
man dtc-chroot-shell
```

### Logs

DTC writes logs to `/var/log/dtc/`. Review these regularly for unusual activity.

---

## Python Agentic CLI

The CLI is configured through environment variables or command-line flags.

### Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| `DTC_BASE_URL` | Base URL of the DTC instance, e.g. `https://dtc.example.com` | `http://localhost` |
| `DTC_API_KEY` | API key or session token for authentication | *(empty — unauthenticated)* |

Set them in your shell profile or export them before running the CLI:

```bash
export DTC_BASE_URL=https://dtc.example.com
export DTC_API_KEY=your-api-key-here
python cli.py domains list
```

### Command-Line Flags

The same values can be passed as flags, which take precedence over environment variables:

```bash
python cli.py --base-url https://dtc.example.com --api-key your-api-key-here domains list
```

### Authentication

When `DTC_API_KEY` (or `--api-key`) is set, every request includes an `Authorization: Bearer <token>` header. Leave it empty only if the DTC instance does not require authentication.

### HTTP Timeout

The default HTTP timeout is **30 seconds**. It can be adjusted programmatically by passing `timeout=<seconds>` when constructing a `DTCClient` instance directly (omitting it keeps the 30-second default):

```python
from core.dtc_client import DTCClient

client = DTCClient(
    base_url="https://dtc.example.com",
    api_key="your-api-key",
    timeout=60,  # overrides the default 30-second timeout
)
```
