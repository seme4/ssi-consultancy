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

sameAs Lite commit [e07bd50641bbe1cf3c4b140d682018d0ec6b15eb](https://github.com/seme4/sameas-lite/commit/e07bd50641bbe1cf3c4b140d682018d0ec6b15eb) cloned on Th19/03/15 was used. This was the most up-to-date version at the time of writing.

The platforms used were virtual machine images of:

* [Ubuntu](http://www.ubuntu.com/) 14.04.1.
* [Scientific Linux](https://www.scientificlinux.org/) 7.0 (Nitrogen).
* [Fedora](https://getfedora.org/) workstation 21. 

Each were 64-bit operating systems configured with 1 GB RAM and 20 GB hard disk. The images were run on a Dell Latitude E7440:

* 64-bit Intel Core i5-4310U CPU 2GHz, 2.60GHz 2 core.
* 8GB RAM.
* 185GB hard disk.
* Windows 7 Enterprise Service Pack 1.

The virtual machine images ran under [VMware Player](http://www.vmware.com/uk/products/player) 6.0.3. This is no longer available. The nearest version is [6.0.5](https://my.vmware.com/web/vmware/free#desktop_end_user_computing/vmware_player/6_0). The current version is now [VMWare Player 7.1.0](https://my.vmware.com/web/vmware/free#desktop_end_user_computing/vmware_player/7_0) 

---

## Recommendations to help deployers

### Provide a deployers guide

At present, there is no information as to how anyone can deploy sameAs Lite for use. This can be found by looking at the sameAs Lite source code and searching Google but this would be a deterrent to all but the most dedicated of deployers.

Provide a deployers guide explaining how a deployer can:

* Install sameAs Lite and its prerequisites and dependencies.
* Configure sameAs Lite to expose linked data stores and the database schema these must conform to.
* Configure sameAs Lite for use with both SQLite and MySQL.
* Identify and solve common installation and deployment problems.
* Change the branding of sameAs Lite with institution-specific styles, colours and logos.

An example, written concurrently with this report, is at [Deployer's Guide](./DeployersGuide.md).

[Deployer and Developer Reference](./Reference.md) contains a summary of useful information for both deployers and developers.

### Provide stable releases for deployers

At present, deployers can only take a version from the master branch from the Git repository. In the longer term, deployers could either use:

* A tag of the repository, known to be stable and bug-free. In which case the deployer can then do, after the above:

<p/>

    $ git checkout TAG_NAME

* A pre-bundled TAR.GZ file prepared using `make tarball`.
* A pre-bundled ZIP or TAR.GZ file prepared using GitHub's release feature:
  - [Creating Releases](https://help.github.com/articles/creating-releases/)
  - [Release Your Software](https://github.com/blog/1547-release-your-software)

### Decide which operating systems are to be supported

The deployers guide should state what operating systems are supported, and also what others sameAs Lite is known to run on.

### Decide which Apache versions, and other web servers, are to be supported

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

The deployers guide should state what web servers are supported, and also what others sameAs Lite is known to run under.

### Decide what MySQL versions are to be supported

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

The deployers guide should state what versions of MySQL are supported, and also what others sameAs Lite is known to run with.

sameAs Lite is compatible with MariaDB under Scientific Linux 7 and Fedora 21.

### Crowd source known deployment configurations

Due to the myriad flavours of Linux and versions of Apache, SQLite, MySQL, and PHP and the different ways in which these can be configured, it is impractical to write complete instructions for every combination. Such information can be crowd-sourced from existing, and future, deployers and developers, by encouraging them to contribute any deviations from the deployers guide they needed to adopt when deploying sameAs Lite upon their own server. These can be published on a web site or other project resource.

### Clarify what config.ttl is for

.htaccess refers to:

    <Files config.ttl>

but there is no config.ttl in the repository.

.ttl is a [Turtle](http://en.wikipedia.org/wiki/Turtle_%28syntax%29) file.

### Provide a sample data set

Provide a sample data set that a deployer can use to check their deployment. Alternatively, or in addition, provide links to online examples of suitable data sets, for example, a set of sample data downloaded via one of the REST endpoints of sameAs.org.

### Provide a deployment checklist

Provide a checklist of what a deployer should look for in the user interface to validate that sameAs Lite has been deployed correctly and that a data store is ready for use.

### Provide a deployer test suite

To complement the checklist and sample data set, provide a test suite, based on curl perhaps, that pings all the REST endpoints to validate a deployment.

### Describe how to rebrand sameAs Lite

Provide documentation on what files deployers need to edit or replace, and the changes they need to make, to brand sameAs Lite with institution-specific styles, colours and logos.

### Provide a command-line and/or web-based admin interface

At present, deployers configure sameAs Lite to expose data stores by editing the index.php file. This requires no knowledge of PHP - deployers can just copy-and-paste a code fragment, then edit the connection URL, database name, username and password. However, it could improve usability, and remove the need for deployers to edit raw PHP by providing either a simple command-line admin tool for configuring sameAs Lite to expose data stores and/or providing a web-based admin interface.

---

## Recommendations to help developers

### Provide a developer's guide

At present the following information can found via Google, and inspecting the sameAs Lite source code:

* How a developer can install sameAs Lite and the prerequisites and dependencies required to develop and test sameAs Lite.
* How a developer can run the style checker, auto-generate documentation, create releases and configure and run unit tests.

There is no information on:

* Coding standards, beyond those embedded within the style checker-related files.
* Guidelines for writing tests.
* How a developer can run performance tests and check that their changes have not degraded performance.

It would help developers get up to speed more rapidly if there is a guide for developers were provided which documented all of these.

An example, written as a side-effect of this report, is at [Developer's Guide](./DevelopersGuide.md).

[REST API examples](./RESTAPIexamples.md) contains examples of invocations of sameAs Lite REST endpoints, and examples of what they return, which can be useful for developers.

### Make the test database configurable

tests/phpUnit/StoreTest.php defines:

    const DSN = 'sqlite:test.sqlite';

The test database driver, URL, database, username and password should be configurable, via a configuration file, so developers don't need to edit PHP code.

### Provide tests that use the database

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

### Provide more unit tests

There are only 4 at present.

### Tests should set up and tear down database tables

Ideally, tests should setup and teardown their own tables in the database, rather than assume they've been generated elsewhere. This both makes it easier to run the tests and makes the tests standalone.

### Clarify dev target in Makefile

Makefile has:

    .PHONY: docs dev libs tests

But there is no dev target in Makefile. This implies that this reference should be deleted.

### Comment all Makefile targets

Makefile's dev and tests targets are not commented in the Makefile's comment block. The tests target should be commented, as should dev, depending upon whether it should be there or should be deleted.

### Provide human-readable coding standards

These should cover both the requirements expected by PHP_CodeSniffer and phpDocumentor.

### Clarify if a developer has to act upon dependency suggestions

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

### Add a .gitignore file

There are a number of auto-generated files that can appear in the sameAs Lite source directory. These are flagged as untracked by Git when running `git status`:

    $ git status
    On branch master
    Your branch is up-to-date with 'origin/master'.

    Untracked files:
      (use "git add <file>..." to include in what will be committed)

	composer.lock
	dev-tools/phpdoc-tmp/
	docs/
	test.sqlite
	vendor/

    no changes added to commit (use "git add" and/or "git commit -a")

Create a `.gitignore` file so that these auto-generated files are ignored. The contents can initially be:
	
    # Auto-generated directories
    dev-tools/phpdoc-tmp/
    docs/
    vendor/

    # Auto-generated files
    composer.lock
    test.sqlite

This has been submitted as a [pull request](https://github.com/seme4/sameas-lite/pull/1).

### Use a continuous integration server

A [continuous integration](http://en.wikipedia.org/wiki/Continuous_integration) server provides an automated build-and-test environment that can be linked to a source code repository. An automated build-and-test run can be scheduled at regular intervals (e.g. nightly) and/or every time code is commited to the repository. Different build-and-test jobs can be set up for different branches in a repository, allowing each developer to have their own set of build-and-test jobs, for example. They help to ensure that the software can build and that tests are run, and regularly. They can also help to provide an indication as to when developer-specific modifications, extensions or fixes are ready to be merged into the software. For more information, see the Institute guide on [How continuous integration can help you regularly test and release your software](http://software.ac.uk/how-continuous-integration-can-help-you-regularly-test-and-release-your-software).

[Jenkins](https://jenkins-ci.org/) is a popular, open source, continuous integration server. See our guide on [Getting started with Jenkins](https://github.com/softwaresaved/build_and_test_examples/blob/master/jenkins/README.md).

 There are numerous examples of developers using Jenkins for PHP-based applications. See, for example, [PHP Quality Assurance with Jenkins](http://www.sitepoint.com/series/php-quality-assurance-with-jenkins/) and [Template for Jenkins Jobs for PHP Projects](http://jenkins-php.org/).

### Output style checking reports into files

If there are a large number of style violations then these will scroll off the top of the terminal window when `make checks` is run. Outputting these reports into files would allow a developer to review them at their leisure.

PHP_CodeSniffer can output its reports to files in a variety of formats. For example: XML, comma-separated values, or [Checkstyle](http://checkstyle.sourceforge.net/)-compliant XML. Checkstyle is of interest. It is a popular style checking tool for Java and there are a number of scripts and applications that can also be used with PHP and which can process Checkstyle documents. For example, Jenkins supports a [Checkstyle plugin](https://wiki.jenkins-ci.org/display/JENKINS/Checkstyle+Plugin) which parses Checkstyle documents and reports the results from within Jenkins. This would allow style checking to be integrated into any automated build-and-test environment for sameAs Lite.

### Output test reports into files

If there are a large number of tests then these will scroll off the top of the terminal window when `make tests` is run. Outputting these reports into files would allow a developer to review them at their leisure.

phpUnit can output its reports in a variety of formats. For example: agile text, agile HTML, JSON, [TAP](https://testanything.org/) (Test Anything Protocol), and [JUnit](http://junit.org). JUnit is of interest. It is a popular unit test framework for Java. Its XML report format has been adopted by unit test frameworks for a number of languages and there are a number of scripts and and applications that can also be used with PHP and which can process JUnit XML test reports. Jenkina supports a [JUnit plugin](https://wiki.jenkins-ci.org/display/JENKINS/JUnit+Plugin) which parses JUnit documents and reports the results from within Jenkins. This would allow testing to be integrated into any automated build-and-test environment for sameAs Lite.

---

## What I need to continue to review from a deployer and developer perspective

As a deployer:

* Sample linked data sets.
* A list of the checks you do to ensure that sameAs Lite has been deployed and is working correctly.

As a developer:

* How to do performance tests?
* Sample performance data, especially, Hugh's data set for which performance is known.
* How to understand and update style checks.

Comments on the foregoing and problems in [REST API examples](./RESTAPIexamples.md) would also be useful.
