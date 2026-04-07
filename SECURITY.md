# Security Policy

## Supported Versions

| Version | Supported          |
| ------- | ------------------ |
| latest  | :white_check_mark: |
| older   | :x:                |

## Reporting a Vulnerability

If you discover a security vulnerability in DTC, please **do not** open a public GitHub issue.

Instead, report it responsibly by emailing the maintainer directly (see the repository's contact information) or by using GitHub's private vulnerability reporting feature:

1. Go to the **Security** tab of this repository.
2. Click **Report a vulnerability**.
3. Fill in the form describing the issue, affected versions, and steps to reproduce.

We aim to acknowledge reports within **48 hours** and provide a remediation timeline within **7 days**.

## Security Best Practices for Deployers

- Always run DTC behind a firewall and restrict admin panel access to trusted IP ranges.
- Keep the underlying OS and all dependencies up to date.
- Use strong, unique passwords for the MySQL/MariaDB root account and the DTC admin account.
- Enable TLS/SSL for all web-facing endpoints.
- Regularly review `/var/log/dtc/` logs for unusual activity.
