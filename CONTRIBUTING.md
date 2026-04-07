# Contributing to DTC

Thank you for your interest in contributing to **Domain Technologie Control (DTC)**!

## Getting Started

1. Fork the repository or clone it directly to `/usr/share`:
   ```bash
   cd /usr/share
   git clone https://github.com/timothygwebb/dtc.git
   ```

2. Create a new branch for your change:
   ```bash
   git checkout -b feature/my-improvement
   ```

3. Make your changes and commit them:
   ```bash
   git add .
   git commit -m "Short description of change"
   git push origin feature/my-improvement
   ```

4. Open a pull request against the `main` branch.

## Code Style

- PHP files should follow PSR-12 coding standards.
- Shell scripts should be POSIX-compatible where possible.
- Perl scripts should include `use strict;` and `use warnings;`.

## Running Tests

Install Python test dependencies and run the test suite:

```bash
pip install -r requirements.txt
pytest
```

## Reporting Bugs

Open an issue describing the problem, steps to reproduce, expected behaviour, and actual behaviour.

## Security Issues

Please **do not** open a public issue for security vulnerabilities. See [SECURITY.md](SECURITY.md) for the responsible-disclosure process.

## License

By contributing you agree that your contributions will be licensed under the [GNU Lesser General Public License v2.1](LICENSE.md).
