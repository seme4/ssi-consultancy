# sameAs Lite Developers's Guide

How to setup a development enviroment for sameAs Lite and guidelines on day-to-day development activities.

**Note:** These instructions apply to a deployment of sameAs Lite on Ubuntu 14.10. Other operating systems may differ in how packages are installed, the versions of these packages. Consult the relevant documentation for your operating system.

You should be familiar with the [Deployer's Guide](./DeployersGuide.md) and havve installed the software listed in it.

---

## Set up development environment

### Create GitHub account and application token

* GitHub is a popular project hosting infrastructure.
* An account is needed to install development tools needed by sameAs Lite.

Create an account on [GitHub](http://github.com).

Create an application token:

* Log in to GitHub
* Click settings cog
* Click Applications
* Click Personal access tokens
* Click Generate new token
* Enter Token description: PHP Composer
* Click Generate token
* Copy application token

Register application token with Composer

    $ /usr/bin/composer.phar config -g github-oauth.github.com TOKEN

This stores the token in ~/.composer.

---

### Install curl

* Command line tool and library for interacting over HTTP(S).
* Useful for testing sameAs Lite.

Install:

    $ apt-get install curl
    $ curl --version
    curl 7.35.0 (x86_64-pc-linux-gnu) libcurl/7.35.0 OpenSSL/1.0.1f zlib/1.2.8 libidn/1.28 librtmp/2.3

---

### Install PHP development tools

Run:

    $ make install-dev
    # install libraries to run tests, generate documentation, etc
    /usr/bin/composer.phar update --dev
    You are using the deprecated option "dev". Dev packages are installed by default now.
    Loading composer repositories with package information
    Updating dependencies (including require-dev)
      - Installing phpdocumentor/unified-asset-installer (1.1.2)
      - Installing phpdocumentor/template-xml (1.2.0)
      - Installing phpdocumentor/template-checkstyle (1.2.1)
      - Installing phpdocumentor/template-old-ocean (1.3.2)
      - Installing phpdocumentor/template-abstract (1.2.2)
      - Installing phpdocumentor/template-zend (1.3.2)
      - Installing phpdocumentor/template-new-black (1.3.2)
      - Installing phpdocumentor/template-responsive (1.3.5)
      - Installing phpdocumentor/template-responsive-twig (1.2.5)
      - Installing phpdocumentor/template-clean (1.0.6)
      - Installing phpdocumentor/reflection-docblock (2.0.4)
      - Installing nikic/php-parser (v0.9.5)
      - Installing psr/log (1.0.0)
      - Installing phpdocumentor/reflection (1.0.7)
      - Installing symfony/finder (v2.6.5)
      - Installing phpdocumentor/fileset (1.0.0)
      - Installing phpdocumentor/graphviz (1.0.3)
      - Installing zendframework/zend-stdlib (2.3.7)
      - Installing zendframework/zend-filter (2.3.7)
      - Installing zendframework/zend-eventmanager (2.3.7)
      - Installing zendframework/zend-math (2.3.7)
      - Installing zendframework/zend-json (2.3.7)
      - Installing zendframework/zend-serializer (2.3.7)
      - Installing zendframework/zend-servicemanager (2.3.7)
      - Installing zendframework/zend-cache (2.3.7)
      - Installing zendframework/zend-i18n (2.3.7)
      - Installing zendframework/zend-config (2.3.7)
      - Installing kherge/version (1.0.1)
      - Installing seld/jsonlint (1.3.1)
      - Installing justinrainbow/json-schema (1.3.7)
      - Installing herrera-io/json (1.0.3)
      - Installing herrera-io/phar-update (1.0.3)
      - Installing doctrine/lexer (v1.0.1)
      - Installing doctrine/annotations (v1.2.3)
      - Installing phpoption/phpoption (1.4.0)
      - Installing phpcollection/phpcollection (0.4.0)
      - Installing jms/parser-lib (1.0.0)
      - Installing jms/metadata (1.5.1)
      - Installing jms/serializer (0.16.0)
      - Installing symfony/filesystem (v2.6.5)
      - Installing symfony/config (v2.6.5)
      - Installing symfony/stopwatch (v2.6.5)
      - Installing symfony/event-dispatcher (v2.6.5)
      - Installing zetacomponents/base (1.9)
      - Installing zetacomponents/document (1.3.1)
      - Installing symfony/process (v2.6.5)
      - Installing erusev/parsedown (1.5.1)
      - Installing monolog/monolog (1.13.1)
      - Installing phenx/php-font-lib (0.2.2)
      - Installing dompdf/dompdf (v0.6.1)
      - Installing symfony/console (v2.6.5)
      - Installing symfony/translation (v2.6.5)
      - Installing symfony/validator (v2.6.5)
      - Installing pimple/pimple (v1.1.1)
      - Installing cilex/console-service-provider (1.0.0)
      - Installing cilex/cilex (1.1.0)
      - Installing phpdocumentor/phpdocumentor (v2.8.2)
      - Installing squizlabs/php_codesniffer (2.3.0)
      - Installing sebastian/diff (1.2.0)
      - Installing fabpot/php-cs-fixer (v1.5.1)
      - Installing sebastian/version (1.0.4)
      - Installing sebastian/git (2.0.0)
      - Installing theseer/fdomdocument (1.6.0)
      - Installing sebastian/finder-facade (1.1.0)
      - Installing phploc/phploc (2.1.0)
      - Installing sebastian/global-state (1.0.0)
      - Installing sebastian/recursion-context (1.0.0)
      - Installing sebastian/exporter (1.2.0)
      - Installing sebastian/environment (1.2.1)
      - Installing sebastian/comparator (1.1.1)
      - Installing symfony/yaml (v2.6.5)
      - Installing doctrine/instantiator (1.0.4)
      - Installing phpspec/prophecy (v1.3.1)
      - Installing phpunit/php-text-template (1.2.0)
      - Installing phpunit/phpunit-mock-objects (2.3.0)
      - Installing phpunit/php-timer (1.0.5)
      - Installing phpunit/php-file-iterator (1.3.4)
      - Installing phpunit/php-token-stream (1.4.0)
      - Installing phpunit/php-code-coverage (2.0.15)
      - Installing phpunit/phpunit (4.5.0)
      - Installing symfony/class-loader (v2.6.5)
      - Installing symfony/dependency-injection (v2.6.5)
      - Installing behat/transliterator (v1.0.1)
      - Installing behat/gherkin (v4.3.0)
      - Installing behat/behat (v3.0.15)
      ...

**Troubleshooting - The requested PHP extension ext-xsl is missing from your system**

If you see:

    Your requirements could not be resolved to an installable set of packages.
      Problem 1
        - The requested PHP extension ext-xsl * is missing from your system.
      Problem 2
        - phpdocumentor/phpdocumentor v2.0.0 requires phpdocumentor/template-zend ~1.3 -> satisfiable by phpdocumentor/template-zend[1.3.0, 1.3.1, 1.3.2].
        ...
        - phpdocumentor/phpdocumentor v2.8.2 requires phpdocumentor/template-zend ~1.3 -> satisfiable by phpdocumentor/template-zend[1.3.0, 1.3.1, 1.3.2].
        - phpdocumentor/phpdocumentor v2.3.1 requires dompdf/dompdf dev-master@dev -> no matching package found.
        ...
        - phpdocumentor/template-zend 1.3.2 requires ext-xsl * -> the requested PHP extension xsl is missing from your system.
        ...
        - Installation request for phpdocumentor/phpdocumentor * -> satisfiable by phpdocumentor/phpdocumentor[v2.0.0, v2.0.1, v2.1.0, v2.2.0, v2.3.0, v2.3.1, v2.3.2, v2.4.0, v2.5.0, v2.6.0, v2.6.1, v2.7.0, v2.7.1, v2.8.0, v2.8.1, v2.8.2].

    Potential causes:
     - A typo in the package name
     - The package is not available in a stable-enough version according to your minimum-stability setting
       see <https://groups.google.com/d/topic/composer-dev/_g3ASeIFlrc/discussion> for more details.

    Read <http://getcomposer.org/doc/articles/troubleshooting.md> for further common problems.
    make: *** [install-dev] Error 2

then you need to install php5-xsl.

**Troubleshooting - enter your GitHub credentials to go over the API rate limit**

If you see:
 
        Downloading: connection...
    Could not fetch https://api.github.com/repos/phpDocumentor/phpDocumentor2/zipball/1c6a3bd696de9153a0d8596e2fc26cf866ac9c2d, enter your GitHub credentials to go over the API rate limit
    A token will be created and stored in "/root/.composer/auth.json", your password will never be stored
    To revoke access to this token you can visit https://github.com/settings/applications

Then enter your GitHub username and password, as requested, and installation will continue.

Alternatively, set up an application token as suggested above.

---

## Day-to-day development

### Run tests

Run:

    $ make tests

The results of the test run will be shown e..g:

    # run tests
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/phpUnit/
    PHPUnit 4.5.0 by Sebastian Bergmann and contributors.

    ....

    Time: 92 ms, Memory: 3.00Mb

    OK (4 tests, 4 assertions)

**Troubleshooting - Unable to to connect to sqlite // could not find driver**

If you see:

    Exception: Unable to to connect to sqlite // could not find driver

then you need to install php5-sqlite.

---

### Create API documentation

Run:

    $ make docs

The documentation is placed in docs/ and can be browsed via docs/index.html.

---

### Run coding style check

Run:

    $ make checks

The results of the style check will be displayed.

---

### Create source release

Run:

    $ make tarball

The source release is placed in sameAsLite-dev.tar.gz.

**Warning** this first removes all auto-generated files, including dependencies.

---

### Clean up

To remove auto-generated documentation, run:

    $ make clean-docs

To remove all auto-generated files, including dependencies, and revert back to clean distribution state, run:

    $ make clean-dist

---

## Coding style checker

PHP_CodeSniffer is used:

* https://www.squizlabs.com/php-codesniffer/
* https://github.com/squizlabs/PHP_CodeSniffer

This is installed automatically by Composer:

    $ ./vendor/bin/phpcbf --version
    PHP_CodeSniffer version 2.3.0 (stable) by Squiz (http://www.squiz.net)
    $ ./vendor/bin/phpcs --version
    PHP_CodeSniffer version 2.3.0 (stable) by Squiz (http://www.squiz.net)

TODO - provide information on coding style.

---

## Auto-generated documentation

phpDocumentor is used:

* http://www.phpdoc.org/

This is installed automatically by Composer:

    $ ./vendor/bin/phpdoc --version
    phpDocumentor version 2.8.2

TODO - provide information on commenting style.

---

## Tests

PHPUnit is used:

* https://phpunit.de/

This is installed automatically by Composer:

    $ ./vendor/bin/phpunit --version
    PHPUnit 4.5.0 by Sebastian Bergmann and contributors.

TODO - provide information on configuring and writing tests, and any manual tests (e.g. of deployment).

---

## Database schema

When used with MySQL, sameAs Lite assumes the following schema for a data store:

    +--------+--------------+------+-----+---------+-------+
    | Field  | Type         | Null | Key | Default | Extra |
    +--------+--------------+------+-----+---------+-------+
    | canon  | varchar(256) | YES  | MUL | NULL    |       |
    | symbol | varchar(256) | NO   | PRI |         |       |
    +--------+--------------+------+-----+---------+-------+

TODO elaborate on schema and what fields mean.
