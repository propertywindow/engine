Property Window Engine [![by](https://img.shields.io/badge/by-%40marcgeurts-ff69b4.svg?style=flat-square)](https://bitbucket.org/geurtsmarc)
========================

This is the propertywindow engine repository that runs on [Docker](https://www.docker.com/). The main tools used are Symfony 3, Docker and Docker Compose. Other things included are:

- PHP 7.1 + PHP-FPM
- MySQL
- Nginx
- Opcache
- Xdebug
- PhpMyAdmin
- PHP Unit Testing
- PHP Codesniffer


---
Table of Contents 
==================

- [Installation](#installation)
- [Usage](#usage)
- [Testing](#testing)
- [Troubleshooting](#troubleshooting)
---
## Installation

> Before anything, you need to make sure you have Docker properly setup in your environment. For that, refer to the official documentation for both [Docker](https://docs.docker.com/) and [Docker Compose](https://docs.docker.com/compose/). Also make sure you have [Docker Machine](https://docs.docker.com/machine/) properly setup.

* Build and run the containers:
```bash
$ docker-compose up -d --build
```

* Add new container to docker-machine
```bash
$ eval $(docker-machine env php71)
```

* Get containers IP address and update host (replace IP according to your configuration)
```bash
$ docker-machine ip php71
```
> unix only (on Windows, edit C:\Windows\System32\drivers\etc\hosts)

```bash
$ sudo echo "192.168.99.100 property-engine.dev" >> /etc/hosts
```

* Composer install & create database
```bash
$ docker-compose exec php bash
$ composer install
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:update --force
$ php app/console doctrine:fixtures:load --no-interaction
```

* Once that's done, you should be able to access the application on the http://propertywindow-engine.dev

---

## Usage

Build all docker containers:
```bash
$ docker-compose build
```
Run all docker containers:
```bash
$ docker-compose up -d
```
View all docker containers:
```bash
$ docker-compose ps
```
Stop all docker containers:
```bash
$ docker-compose stop
```
Update tables:
```bash
$ php/app console doctrine:generate:schema --force
```
Load data fixtures:
```bash
$ php app/console doctrine:fixtures:load
```
---

## Testing

> Before every commit please make sure the following tests pass successful.

PHP Unit Testing:
```bash
$ vendor/bin/phpunit
```

PHP Codesniffer:
```bash
$ vendor/bin/phpcs
```
---

## Troubleshooting

No troubles so far :)

