Property Window Engine
========================
[![by](https://img.shields.io/badge/by-%40marcgeurts-blue.svg)](https://github.com/marcgeurts) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/marcgeurts/propertywindow-engine/badges/quality-score.png?b=master&s=8b820292927489dd0e37b8f3c87062fbd1c1aa1b)](https://scrutinizer-ci.com/g/marcgeurts/propertywindow-engine/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/marcgeurts/propertywindow-engine/badges/coverage.png?b=master&s=f8a091208c6e51c6ed30580cce43ef065ade237c)](https://scrutinizer-ci.com/g/marcgeurts/propertywindow-engine/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/marcgeurts/propertywindow-engine/badges/build.png?b=master&s=6051db0f484eb293c8dbdea4a804703150345880)](https://scrutinizer-ci.com/g/marcgeurts/propertywindow-engine/build-status/master)

This is the propertywindow engine repository that runs on [Docker](https://www.docker.com/). The main tools used are Symfony 3, Docker and Docker Compose. Other things included are:

- PHP 7.1 + PHP-FPM
- MySQL
- Nginx
- Opcache
- Xdebug
- PHP Unit Testing
- PHP Codesniffer
- Scrutinizer


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

* Create a docker machine:
```bash
$ docker-machine create propertywindow --driver virtualbox
```
* Add new container to docker-machine
```bash
$ eval $(docker-machine env propertywindow)
```

* Build and run the containers:
```bash
$ docker-compose up -d --build
```
* Get containers IP address and update host (replace IP according to your configuration)
```bash
$ docker-machine ip propertywindow
```
> unix only (on Windows, edit C:\Windows\System32\drivers\etc\hosts)

```bash
$ sudo echo "192.168.99.100 engine.propertywindow.local" >> /etc/hosts
```

* Composer install & create database
```bash
$ docker-compose exec php bash
$ composer install
$ php app/console doctrine:database:create
$ php app/console doctrine:schema:update --force
$ php app/console doctrine:fixtures:load --no-interaction
```
* Once that's done, you should be able to access the application on the http://engine.propertywindow.local

---

## Usage

> Helpful commands for developing

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

Run Testing:
```bash
$ composer test
```

PHP Unit Testing:
```bash
$ vendor/bin/phpunit
```

PHP Codesniffer:
```bash
$ vendor/bin/phpcs --standard=PSR2 src/ tests/
```
---

## Troubleshooting

No troubles so far :)

