## Repro case for infite-loop in exception handlers

This repository aims to reproduce the issue described in:
 * https://github.com/symfony/symfony/issues/26438
 * https://github.com/getsentry/sentry-php/issues/552
 * https://github.com/getsentry/sentry-symfony/issues/119


Required:

 - Docker Compose 1.14 or newer
 - Docker 17.06 or newer
 - a Sentry DSN

### Reproduction steps (OSX)

Create a file named `docker-compose.override.yml` with the following contents:

``` yaml
version: '3.0'
services:
  php:
    environment:
      - SENTRY_DSN=YOUR-SENTRY-DSN
```

``` bash
# create containers and install dependencies
docker-compose up --build -d
docker-compose exec php composer install

# first request will succeed (an error will be shown)
curl localhost:8000

# subsequent requests will get stuck in an infinite loop
curl localhost:8000
```

### Reproduction steps (Linux)

> Note: avoids some permission issues by defining UID & GID for the process running in the container

Create a file named `docker-compose.override.yml` with the following contents:

``` yaml
version: '3.0'
services:
  php:
    environment:
      - SENTRY_DSN=YOUR-SENTRY-DSN
    user: "$HUID:$HGID"
```

``` bash
# create containers and install dependencies
HUID=$(id -u) HGID=$(id -g) docker-compose up --build -d
HUID=$(id -u) HGID=$(id -g) docker-compose exec php composer install


# requests will get stuck in an infinite loop
curl http://localhost:8000
```
