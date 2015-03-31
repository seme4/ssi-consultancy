# sameAs Lite Deployer and Developer Review

Mike Jackson, The Software Sustainability Institute / EPCC, The University of Edinburgh

## Introduction

[sameAs.org](http://sameas.org) is a search engine for linked data that, if given a URI, returns URIs that are co-referent, should any be known to it. The engine searches information harvested from a number of sources. sameAs.org is maintained by [Seme4 Limited](http://www.seme4.com). [sameAs Lite](http://github.com/seme4/sameas-lite) is a refactored, free open source, version of the software that powers sameAs.org.

sameAs Lite is implemented as two [PHP](http://php.net/) libraries, one which implements the core storage management functionality, and one which implements a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) web application. These depend upon a number of other libraries and [PHP Composer](https://getcomposer.org/) is used for dependency management. 

It is intended that the core library can be used within other applications, outwith the REST web application. Originally the core library could be used as-is with [SQLite](http://www.sqlite.org/) but the core library currently only supports [MySQL](http://www.mysql.com). There is a desire to make it database agnostic, but without degrading performance.

A key non-functional requirement of the core library is that performance must be very good. As a result, a significant amount of performance analysis has been done with the core library on a variety of machines. Sample data for which the performance of the core library is known are available.

There are a small set of PHP unit tests. A goal is for the core library to be supported by a comprehensive suite of tests, though it has proved time consuming to write effective tests.

### About this document

This is a review of sameAs Lite from the perspective of deployers and developers. It is based on an attempt to install sameAs Lite, and tools to develop it, using:

* Foregoing information, provided by Hugh Glaser and Ian Millard (the developers of sameAs.org and sameAs Lite).
* Contents of the sameAs Lite GitHub repository.
* Online resources found using Google.

---

## Specifications


### sameAs Lite

sameAs Lite commit [e07bd50641bbe1cf3c4b140d682018d0ec6b15eb](https://github.com/seme4/sameas-lite/commit/e07bd50641bbe1cf3c4b140d682018d0ec6b15eb) cloned on Th19/03/15 was used. This was the most up-to-date version at the time of writing.

### Ubuntu 14.10

The platform used was:

* Ubuntu 14.10 64-bit
* 1GB RAM
* 20GB hard disk
* Running under VMWare Player 6.0.3, see below.

Running on:

* Dell Latitude E7440.
* 64-bit Intel Core i5-4310U CPU 2GHz, 2.60GHz 2 core.
* 8GB RAM.
* 185GB hard disk.
* Windows 7 Enterprise Service Pack 1.

### VMWare Player 6.0.3

* [VMware Player](http://www.vmware.com/uk/products/player)
* This page comments that "Player Pro is licensed for commercial use and is enabled to run restricted virtual machines. If you simply want to learn about virtual machines or run virtual machines at home you can always use VMware Player for free" which includes a link to free VMWare Player versions.

To Download:

* Go to [Download VMWare Player](http://www.vmware.com/go/downloadplayer/).

Or:

* Go to [Downloads](https://my.vmware.com/web/vmware/downloads)
* Scroll down to VMWare Player 
* Click Download Product

Current version is now [VMWare Player 7.1.0](https://my.vmware.com/web/vmware/free#desktop_end_user_computing/vmware_player/7_0) 

My version is 6.0.3 which seems not to be available. The nearest version is [6.0.5](https://my.vmware.com/web/vmware/free#desktop_end_user_computing/vmware_player/6_0).

---

## Provide a deployer's guide

At present, there is no information as to how anyone can deploy sameAs Lite for use. This can be found by looking at the sameAs Lite source code and hitting Google but this would be a deterrent to all but the most dedicated of deployers.

Provide a guide explaining how a deployer can:

* Install sameAs Lite and its prerequisites and dependencies.
* Configure sameAs Lite to expose linked data stores, the schema expected by sameAs Lite etc.
* Configure sameAs Lite for use with both SQLite and MySQL.
* How to identify and solve common installation and deployment problems.
* How to change the branding of sameAs Lite with institution-specific styles, colours and logos.

A work-in-progress example, written as a side-effect of this report, is at [Deployer's Guide](./DeployersGuide.md).

[Deployer and Developer Reference](./Reference.md) contains a summary of useful information for both deployers and developers.

---

## Provide stable releases for deployers

In the longer term, deployers could either use:

* A tag of the repository, known to be stable and bug-free. In which case the deployer can then do, after the above:

<p/>

    $ git checkout TAG_NAME

* A pre-bundled TAR.GZ file prepared using `make tarball`.
* A pre-bundled ZIP or TAR.GZ file prepared using GitHub's release feature:
  - [Creating Releases](https://help.github.com/articles/creating-releases/)
  - [Release Your Software](https://github.com/blog/1547-release-your-software)

---

## Decide which operating systems are to be supported

The deployers guide should state what operating systems are supported, and also what others sameAs Lite is known to run on (e.g. from existing deployers).

---

## Decide which Apache versions, and other web servers, are to be supported

.htaccess uses:

    <Files .htaccess>
      Order Allow,Deny
      Deny from all
    </Files>

Apache's [Upgrading to 2.4 from 2.2](http://httpd.apache.org/docs/2.4/upgrading.html) comments that:
    Order deny,allow
    Deny from all

has been replaced by:

    Require all denied

using a new module mod_authz_host. It then comments that "For compatibility with old configurations, the new module mod_access_compat is provided".

The deployers guide should state what web servers are supported, and also what others sameAs Lite is known to run on (e.g. from existing deployers).

---

## Decide what MySQL versions are to be supported

[MySQL](http://www.mysql.com) is now owned by Oracle. There is a GPL-licensed fork of MySQL, [MariaDB](https://mariadb.org) is GPL fork of MySQL also available:

    $ sudo apt-cache search mysql | grep mysql-server
    mysql-server - MySQL database server (metapackage depending on the latest version)
    mysql-server-5.5 - MySQL database server binaries and system database setup
    mysql-server-core-5.5 - MySQL database server binaries
    mysql-server-5.6 - MySQL database server binaries and system database setup
    mysql-server-core-5.6 - MySQL database server binaries

    $ sudo apt-cache search mysql | grep mariadb-server
    mariadb-server-5.5 - MariaDB database server binaries
    mariadb-server-core-5.5 - MariaDB database core server files

The deployers guide should state what versions of MySQL are supported, and also what others sameAs Lite is known to run on (e.g. from existing deployers).

---

## Clarify what config.ttl is for

.htaccess refers to:

    <Files config.ttl>

but there is no config.ttl in the repository.

.ttl is [Turtle](http://en.wikipedia.org/wiki/Turtle_%28syntax%29)

---

## Provide a sample data set

Provide a sample data set that a deployer can use to check their deployment.

---

## Provide a deployment checklist

Provide a checklist of what a deployer should look for in the user interface to validate that sameAs Lite has been deployed correctly and a data store is ready for use.

---

## Provide a deployer test suite

Based on the sample data set provide a test suite, based on curl perhaps, that pings all the REST endpoints to validate a deployment.

---

## Provide a developer's guide

At present the following information can found via Google, and inspecting the sameAs Lite source code:

* How a developer can install sameAs Lite and the prerequisites and dependencies required to develop and test sameAs Lite.
* How a developer can run the style checker, auto-generate documentation, create releases and configure and run unit tests.

There is no information on:

* Coding standards, beyond those embedded within the style checker-related source code.
* Guidelines for writing tests.
* How a developer can run performance tests and check that their changes have not degraded performance.

It would help developers get up to speed more rapidly if there is a guide for developers were provided which documented all of these.

A work-in-progress example, written as a side-effect of this report, is at [Developer's Guide](./DevelopersGuide.md).

[REST API examples](./RESTAPIexamples.md) contains examples of invocations of sameAs Lite REST endpoints, and examples of what they return, which can be useful for developers.

---

## Make the test database configurable

tests/phpUnit/StoreTest.php defines:

    const DSN = 'sqlite:test.sqlite';

The test database driver, URL, database, username and password should be configurable, via a configuration file, so developers don't need to edit PHP code.

---

## Tests should use the database

tests/phpUnit/StoreTest.php defines:

    const DSN = 'sqlite:test.sqlite';

and calls:

    $s = new Store(self::DSN, self::STORE_NAME);

If the driver is not present then `make tests` fails:

    Exception: Unable to to connect to sqlite // could not find driver

    /var/www/html/sameas-lite/src/Store.php:143
    /var/www/html/sameas-lite/src/Store.php:622
    /var/www/html/sameas-lite/tests/phpUnit/StoreTest.php:91

The failure line is:

    $this->dbHandle = new \PDO($this->dsn, $this->dbUser, $this->dbPass);

If the driver is present then all 4 tests pass, even if sqlite or sqlite3 are not installed.

    $ sqlite
    The program 'sqlite' is currently not installed. You can install it by typing:
    apt-get install sqlite
    $ sqlite3
    The program 'sqlite3' is currently not installed. You can install it by typing:
    apt-get install sqlite3

The tests don't use the database. This relates to...

---

## Provide more unit tests

There are only 4 at present.

---

## Tests should set up and tear down database tables

Ideally, tests should setup and teardown their own tables in the database, rather than assume they've been generated elsewhere. This both makes it easier to run the tests and makes the tests standalone.

---

## Clarify dev target in Makefile

Makefile has:

    .PHONY: docs dev libs tests

But there is no dev target in Makefile. This implies that this reference should be deleted.

---

## Comment all Makefile targets

Makefile's dev and tests targets are not commented in the Makefile's comment block. The tests target should be commented, as should dev, depending upon whether it should be there or should be deleted.

---

## Provide human-readable coding standards

These should cover both the requirements expected by PHP_CodeSniffer and phpDocumentor and be published.

---

## Clarify if a developer has to act upon dependency suggestions

When running:

    $ make install-dev

After the dependencies have installed, a number of messages are printed:

    phpdocumentor/reflection-docblock suggests installing dflydev/markdown (~1.0)
    zendframework/zend-filter suggests installing zendframework/zend-crypt (Zend\Crypt component)
    zendframework/zend-filter suggests installing zendframework/zend-uri (Zend\Uri component for UriNormalize filter)
    zendframework/zend-math suggests installing ext-gmp (If using the gmp functionality)
    zendframework/zend-math suggests installing ircmaxell/random-lib (Fallback random byte generator for Zend\Math\Rand if OpenSSL/Mcrypt extensions are unavailable)
    zendframework/zend-json suggests installing zendframework/zend-http (Zend\Http component)
    zendframework/zend-json suggests installing zendframework/zend-server (Zend\Server component)
    zendframework/zend-json suggests installing zendframework/zendxml (To support Zend\Json\Json::fromXml() usage)
    zendframework/zend-servicemanager suggests installing ocramius/proxy-manager (ProxyManager 0.5.* to handle lazy initialization of services)
    zendframework/zend-servicemanager suggests installing zendframework/zend-di (Zend\Di component)
    zendframework/zend-cache suggests installing zendframework/zend-session (Zend\Session component)
    zendframework/zend-cache suggests installing ext-apc (APC >= 3.1.6 to use the APC storage adapter)
    zendframework/zend-cache suggests installing ext-memcached (Memcached >= 1.0.0 to use the Memcached storage adapter)
    zendframework/zend-cache suggests installing ext-wincache (WinCache, to use the WinCache storage adapter)
    zendframework/zend-i18n suggests installing ext-intl (Required for most features of Zend\I18n; included in default builds of PHP)
    zendframework/zend-i18n suggests installing zendframework/zend-validator (You should install this package to use the provided validators)
    zendframework/zend-i18n suggests installing zendframework/zend-view (You should install this package to use the provided view helpers)
    zendframework/zend-i18n suggests installing zendframework/zend-resources (Translation resources)
    symfony/event-dispatcher suggests installing symfony/http-kernel ()
    monolog/monolog suggests installing graylog2/gelf-php (Allow sending log messages to a GrayLog2 server)
    monolog/monolog suggests installing raven/raven (Allow sending log messages to a Sentry server)
    monolog/monolog suggests installing doctrine/couchdb (Allow sending log messages to a CouchDB server)
    monolog/monolog suggests installing ruflin/elastica (Allow sending log messages to an Elastic Search server)
    monolog/monolog suggests installing videlalvaro/php-amqplib (Allow sending log messages to an AMQP server using php-amqplib)
    monolog/monolog suggests installing ext-amqp (Allow sending log messages to an AMQP server (1.0+ required))
    monolog/monolog suggests installing ext-mongo (Allow sending log messages to a MongoDB server)
    monolog/monolog suggests installing aws/aws-sdk-php (Allow sending log messages to AWS services like DynamoDB)
    monolog/monolog suggests installing rollbar/rollbar (Allow sending log messages to Rollbar)
    symfony/validator suggests installing doctrine/cache (For using the default cached annotation reader and metadata cache.)
    symfony/validator suggests installing symfony/http-foundation ()
    symfony/validator suggests installing symfony/intl ()
    symfony/validator suggests installing egulias/email-validator (Strict (RFC compliant) email validation)
    symfony/validator suggests installing symfony/property-access (For using the 2.4 Validator API)
    symfony/validator suggests installing symfony/expression-language (For using the 2.4 Expression validator)
    phpdocumentor/phpdocumentor suggests installing ext-twig (Enabling the twig extension improves the generation of twig based templates.)
    phpdocumentor/phpdocumentor suggests installing ext-xslcache (Enabling the XSLCache extension improves the generation of xml based templates.)
    sebastian/global-state suggests installing ext-uopz (*)
    phpunit/php-code-coverage suggests installing ext-xdebug (>=2.2.1)
    phpunit/phpunit suggests installing phpunit/php-invoker (~1.1)
    symfony/dependency-injection suggests installing symfony/proxy-manager-bridge (Generate service proxies to lazy load them)
    behat/behat suggests installing behat/symfony2-extension (for integration with Symfony2 web framework)
    behat/behat suggests installing behat/yii-extension (for integration with Yii web framework)
    behat/behat suggests installing behat/mink-extension (for integration with Mink testing framework)
    Writing lock file
    Generating autoload files

Whether these need to be acted upon, or can be ignored, should be documented.

---

## What I need to continue to review from a deployer and developer perspective

As a deployer:

* Sample linked data sets.
* A list of the checks you do to ensure that sameAs Lite has been deployed and is working correctly.

As a developer:

* How to do performance tests?
* Sample performance data, especially, Hugh's data set for which performance is known.
* How to understand and update style checks.

I also have access to a Scientific Linux 6 virtual machine, and write deployment info for that if that would be useful?

I could try an installation using Apache 2.2, on the SL6 VM mentioned above, and write deployment info for that this would be useful?

Comments on the foregoing and problems in [REST API examples](./RESTAPIexamples.md) would also be useful.
