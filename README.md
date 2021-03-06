# slim-sandbox

Sandbox project with a reasonable [Slim3](https://www.slimframework.com/) setup.

# Layout

## config

Config is stored in the `./config` directory.

General config is loaded from `config.neon`.  Local settings can be placed in `local.neon`.  The corresponding trees are then recursively merged.  The config is available in the slim app's container under `settings` key, so

``` php
$settings = $container->get('settings');
```

## logs

Logs go to `php://stderr` (useful if run from docker, this is the default) or `./logs/app.log` otherwise.

## public

The starting point of the application is `./public/index.php` file.  For a simple REST application with no UI nothing else is usually necessary to be added to the `./public` directory.

## src

Holds the actual logic of the application.

The `bootstrap.php` file should be `require_once` from the "starting point" of the application (`./public/index.php`), it returns a configured `Slim\App` instance.

Configure your routes in `Router.php` method `registerRoutes`.  It is adviced to use "controller callback" syntax, that is `class:method`, see the example.

Dependency Injection Container is configured in `Configurator` method `configureContainer`.  A good convention for naming of the services is to use the full qualified names of the classes, using the PHP `::class` operator.

## tests

Tests for the application are stored here.  Additional configuration for dev tools is also stored here.

## www

Contains the `nginx` setup as well as the `Dockerfile` used to build it into a production image.

# Dev tools

## Dev server

To start the built-in dev server on port `8080`, run

    composer start

If you have `docker-compose` available, it is adviced to use the provided docker stack.

## Docker stack

### Dev stack

To run the dev stack, use

    docker-compose up -d

This boots the application running using the php dev server on port 8080.  Try to visit http://localhost:8080/hello/Alice to see if everything works.  Local changes to the source files **will** be immediately visible because this setup mounts the `$PWD` into the image.  The path in the image is the same as on the host so that static analysis tools don't have problems with path translations if you execute them from the host.

### Production stack

The production stack includes the app on a backend network (running via `php-fpm` on port `9000`) and an [nginx](https://www.nginx.com/) frontend listening on port `8080`.

To run the production stack, use

    docker-compose -f docker-compose.prod.yml up -d

Remember that for the first time and after every change you need to rebuild the images.  The application is copied into the image so that it is deployable without requiring git, pulling in dependencies etc.  Therefore your local changes **will not** be visible in the production images until a rebuild.

To build the images, run

    docker-compose -f docker-compose.prod.yml build

You might want to adjust the names of the images in the `docker-compose.prod.yml` file.

## Nette Tester

[Nette Tester](https://github.com/nette/tester/) is a lightweight alternative to [PHPUnit](https://phpunit.de/).

Place your tests under `./tests/` followed by PSR-4 compatible directory structure, so a class `App\Controllers\Hello` goes into `./tests/App/Controllers/Hello.phpt`.

Remember to `require_once __DIR__ .'/../bootstrap.php'` (add appropriate number of `../` to point to `./tests/bootstrap.php`) to enable autoloading of your classes.

Tests should be under `Tests\` namespace followed by the namespace of the class being tested, so the test class `App\Controllers\HelloTest` goes under `Tests\App\Controllers` namespace.

Run

    composer tester

to run the testsuite.

If you need additional extensions to load during tests, add them to `./tests/php.ini` (`json` is included by default).

## PHPStan - PHP Static analysis

[PHPStan](https://github.com/phpstan/phpstan) is a static code analysis tool.  It is already set up in the repo, to run the report use

    composer phpstan

## PHP Code Sniffer

Uses the [SalesChamp](https://github.com/SalesChamp/codesniffer-ruleset) ruleset.

Usage:

    composer phpcs
