<img align="right" src="http://www.propertywindow.com/img/logo_red_new.png" />

Property Window Engine [![by](https://img.shields.io/badge/by-%40marcgeurts-ff69b4.svg?style=flat-square)](https://github.com/marcgeurts)
========================

This is the propertywindow engine repository that runs on [Docker](https://www.docker.com/). The main tools used are Symfony, Docker and Docker Compose. Other things included are:

- PHP 7.1 + PHP-FPM
- Nginx
- Xdebug
- Opcache

Table of Contents 
==================

- [Installation](#installation)
- [FAQ](#faq)

## Installation

> Before anything, you need to make sure you have Docker properly setup in your environment. For that, refer to the official documentation for both [Docker](https://docs.docker.com/) and [Docker Compose](https://docs.docker.com/compose/). Also make sure you have [Docker Machine](https://docs.docker.com/machine/) properly setup.

Build and run the containers:

```bash
docker-compose up -d --build
```

Once that's done, you should be able to access the application on the IP that docker (or Docker Machine) is running at.

## FAQ

Coming soon...
