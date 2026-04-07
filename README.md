# dtc
Domain Technologie Control

The documentation for this project is compiled and installed during installation.

If you need to view it for assistance during or before installation it can be found at the link below.

https://github.com/timothygwebb/dtc/blob/master/doc/html/en/2.html

How to contribute.
Clone the repository or fork it to /usr/share

cd /usr/share

git clone https://github.com/timothygwebb/dtc.git

Install required dependencies before package build.

Dependencies:

Debian Users:

Install dependencies as follows (Debian 10 Buster / 11 Bullseye):

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

apt-get update or aptitude update

apt-get upgrade or aptitude upgrade

Checkout -b your branch

make changes.

git add/rm

git commit

git push

How to build from source

Install required dependencies before package build.

Dependencies:

Debian Users:

Install dependencies as follows:

```bash
apt-get install build-essential devscripts debhelper dpkg-dev
```

Also install the runtime dependencies listed above, then build:

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

Then Debian Users:

dpkg-buildpackage in /usr/share/dtc directory after clone.

Other Users:
******************************************************************
*Please select one of the following targets:                     *
*install-dtc-stats-daemon, install-dtc-common, bsd-ports-packages*
*install-dtc-dos-firewall or make debian-packages                *
*Note that debian users should NOT use make debian-packages      *
*directly, but dpkg-buildpackage that will call it.              *
******************************************************************

The above process will build the following packages:

- dtc-postfix-dovecot
- dtc-cyrus
- dtc-stats-daemon
- dtc-common
- dtc-autodeploy
- dtc-core
- dtc-toaster
- dtc-postfix-courier
- dtc-dos-firewall

The generated `.deb` packages will be placed in the parent directory of your chosen build directory.

Change to the parent directory that contains the built packages:

cd /usr/share

Install the desired package or packages from the list above. For example:

dpkg -i --force all dtc*.deb

If you install `dtc-common`, run the installer afterward:

How to install.
/usr/share/dtc/admin/install/install

How to uninstall
/usr/share/dtc/admin/install/uninstall.

