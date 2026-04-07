# Installation Guide

This guide covers two installation paths:

1. [Debian package install](#debian-package-install) — for deploying the full DTC hosting control panel.
2. [Python CLI setup](#python-cli-setup) — for using the agentic Python CLI against an existing DTC instance.

---

## Debian Package Install

### Prerequisites

Install build tools:

```bash
apt-get install build-essential devscripts debhelper dpkg-dev
```

Install runtime dependencies (Debian 10 Buster / 11 Bullseye):

```bash
apt-get install \
  default-mysql-client default-mysql-server galera-3 altermime amavisd-new \
  clamav clamav-daemon clamav-freshclam courier-authlib expect \
  libberkeleydb-perl libclamav9 libconvert-binhex-perl libconvert-tnef-perl \
  libconvert-uulib-perl libcourier-unicode4 libdbd-mysql-perl \
  libio-multiplex-perl libjemalloc1 libmime-tools-perl libnet-cidr-perl \
  libnet-server-perl libtfm1 libunix-syslog-perl maildrop \
  mariadb-client mariadb-server mysql-server pax ripole tcl-expect \
  composer jsonlint php-composer-ca-bundle php-composer-semver \
  php-composer-spdx-licenses php-composer-xdebug-handler php-json-schema \
  php-symfony-console php-symfony-filesystem php-symfony-finder \
  php-symfony-polyfill-php80 php-symfony-process
```

### Build

Clone the repository to `/usr/share` and build the Debian packages:

```bash
cd /usr/share
git clone https://github.com/timothygwebb/dtc.git
cd dtc
dpkg-buildpackage
```

The generated `.deb` packages are placed in the parent directory (`/usr/share`).

Built packages include:

- `dtc-postfix-dovecot`
- `dtc-cyrus`
- `dtc-stats-daemon`
- `dtc-common`
- `dtc-autodeploy`
- `dtc-core`
- `dtc-toaster`
- `dtc-postfix-courier`
- `dtc-dos-firewall`

### Install

Change to the parent directory and install the desired packages:

```bash
cd /usr/share
dpkg -i --force-all dtc*.deb
```

If you installed `dtc-common`, run the installer afterward:

```bash
/usr/share/dtc/admin/install/install
```

### Non-Debian Systems

Run `make` from the repository root and choose one of the following targets:

| Target | Description |
|--------|-------------|
| `install-dtc-stats-daemon` | Install the stats daemon |
| `install-dtc-common` | Install the common package |
| `bsd-ports-packages` | Build BSD ports packages |
| `install-dtc-dos-firewall` | Install the DoS firewall |

> **Note:** Debian users should use `dpkg-buildpackage` rather than `make debian-packages` directly.

### Uninstall

```bash
/usr/share/dtc/admin/install/uninstall
```

---

## Python CLI Setup

The Python CLI requires Python 3.8+ and an already-running DTC instance.

### Install dependencies

```bash
pip install -r requirements.txt
```

### Verify

```bash
python cli.py --help
```

See [api.md](api.md) for usage examples and a full command reference.
