# sameAs Lite Deployer and Developer Review

Mike Jackson, The Software Sustainability Institute / EPCC, The University of Edinburgh

## Introduction

[sameAs.org](http://sameas.org) is a search engine for linked data that, if given a URI, returns URIs that are co-referent, should any be known to it. The engine searches information harvested from a number of sources. sameAs.org is maintained by [Seme4 Limited](http://www.seme4.com). [sameAs Lite](http://github.com/seme4/sameas-lite) is a refactored, free open source, version of the software that powers sameAs.org.

sameAs Lite is implemented as two [PHP](http://php.net/) libraries, one which implements the core storage management functionality, and one which implements a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) web application. These depend upon a number of other libraries and [PHP Composer](https://getcomposer.org/) is used for dependency management. 

It is intended that the core library can be used within other applications, outwith the REST web application. Originally the core library could be used as-is with [SQLite](http://www.sqlite.org/) but the core library currently only supports [MySQL](http://www.mysql.com). There is a desire to make sameAs Lite database agnostic, but without degrading performance.

### About this document

This is a review of sameAs Lite from the perspective of deployers and developers. It is based on an attempt to install sameAs Lite, and tools to develop it, using:

* Foregoing information, provided by Hugh Glaser and Ian Millard (the developers of sameAs.org and sameAs Lite).
* Contents of the sameAs Lite GitHub repository.
* Documentation for third-party software packages.
* Online resources found via Google.

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

### Write a deployers guide

There is no information on how to deploy sameAs Lite. This can be uncovered by looking at the sameAs Lite source code, third-party software documentation, and searching Google but this would be a deterrent to all but the most dedicated of deployers. Write a deployers guide which covers:

* Installing sameAs Lite and its prerequisites.
* Configuring sameAs Lite to expose linked data stores held within SQLite and MySQL.
* Database schema these linked data stores must conform to.
* Identifying and solving common installation and deployment problems.
* Rebranding sameAs Lite with institution-specific styles, colours and logos.

### Provide stable releases for deployers

Deployers can only take a version of sameAs Lite from the master branch from the Git repository. In the longer term, deployers could either use:

* A tag of the repository, known to be stable and bug-free. In which case the deployer can then do, after the above:

<p/>

    $ git checkout TAG_NAME

* A pre-bundled tar.gz file, prepared using `make tarball`.
* A pre-bundled zip or tar.gz file prepared using GitHub's release feature:
  - [Creating Releases](https://help.github.com/articles/creating-releases/)
  - [Release Your Software](https://github.com/blog/1547-release-your-software)

### Decide which operating systems are supported

The deployers guide should state what operating systems are supported, and also what others sameAs Lite is known to run on.

### Decide which Apache versions, and other web servers, are supported

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

using a new module, mod_authz_host. It then comments that "For compatibility with old configurations, the new module mod_access_compat is provided".

The deployers guide should state what web servers are supported, and also what others sameAs Lite is known to run under.

### Decide which MySQL versions are supported

[MySQL](http://www.mysql.com) is now owned by Oracle. There is also a GPL-licensed fork of MySQL, [MariaDB](https://mariadb.org), now available. For example, within the Ubuntu package manager:

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

sameAs Lite is compatible with MariaDB on Scientific Linux 7 and Fedora 21.

### Crowd-source known deployment configurations

Due to the myriad flavours of Linux, versions of Apache, other web servers, SQLite, MySQL, PHP and the different ways in which these can be configured, it is impractical to write deployment instructions for every combination. This information can be crowd-sourced from existing, and future, deployers and developers, by encouraging them to contribute any deviations from the deployers guide they needed to adopt when deploying sameAs Lite. These can be published on a web site or other project resource.

### Clarify what config.ttl is for

.htaccess refers to a [Turtle](http://en.wikipedia.org/wiki/Turtle_%28syntax%29) file:

    <Files config.ttl>

There is no config.ttl in the repository.

### Provide sample data

Provide sample data that a deployer can use to check their deployment. Alternatively, or in addition, provide links to online examples of suitable data, for example, linked data downloaded via one of the REST endpoints of sameAs.org.

### Write a deployment validation checklist

Write a checklist of what a deployer should look for in the user interface to validate that sameAs Lite has been deployed correctly and that a data store is ready for use.

### Implement a deployer test suite

To complement the checklist and sample data, implement a test suite that pings all the REST endpoints to validate a deployment.

### Document how to rebrand sameAs Lite

Document what files deployers need to edit or replace, and the changes they need to make, to brand sameAs Lite with institution-specific styles, colours and logos.

### Implement a command-line and/or web-based admin interface

Deployers configure sameAs Lite to expose data stores by editing the index.php file. This requires no knowledge of PHP - deployers can just copy-and-paste a code fragment, then edit the connection URL, database name, username and password. However, it could improve usability, and remove the need for deployers to edit raw PHP, by providing either a simple command-line admin tool for configuring sameAs Lite to expose data stores and/or providing a web-based admin interface.

---

## Recommendations to help developers

### Write a developer's guide

The following information can found via Google, third-party software documentation, and inspecting the sameAs Lite source code:

* Installing sameAs Lite and the prerequisites required to develop and test sameAs Lite.
* Running the style checker.
* Auto-generating API documentation.
* Creating releases.
* Configuring and running unit tests.

Write a deployers guide which covers the above and other information needed by developers (the following sections elaborate on this).

### Clarify dev target in Makefile

Makefile has:

    .PHONY: docs dev libs tests

But there is no dev target in Makefile. This implies that this reference should be deleted.

### Comment all Makefile targets

Makefile's dev and tests targets are not commented in the Makefile's comment block. The tests target should be commented, as should dev, depending upon whether it should be there or should be deleted.

### Write human-readable coding standards

Coding standards are implict as [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) configuration files within dev-tools/CodeStandard/. A human-readable version should be provided.

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

Document whether these need to be acted upon, or can be safely ignored.

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

An example is in the [gitignore](https://github.com/softwaresaved/sameas-lite/tree/gitignore) branch of https://github.com/softwaresaved/sameas-lite:

* [.gitignore](https://github.com/softwaresaved/sameas-lite/blob/gitignore/.gitignore)

### Use a continuous integration server

A [continuous integration](http://en.wikipedia.org/wiki/Continuous_integration) server provides an automated build-and-test environment that can be linked to a source code repository. A build-and-test run can be scheduled at regular intervals (e.g. nightly) and/or every time code is commited to the repository. Different build-and-test jobs can be set up for different branches in a repository, allowing each developer to have their own set of build-and-test jobs, for example. Continuous integration servers can help to ensure that software can build and that tests are run regularly. They also help to provide an indication as to when developer-specific modifications, extensions or fixes are ready to be merged. For more information, see the Institute guide on [How continuous integration can help you regularly test and release your software](http://software.ac.uk/how-continuous-integration-can-help-you-regularly-test-and-release-your-software).

[Jenkins](https://jenkins-ci.org/) is a popular, open source, continuous integration server. See our guide on [Getting started with Jenkins](https://github.com/softwaresaved/build_and_test_examples/blob/master/jenkins/README.md). There are numerous examples of developers using Jenkins for PHP-based applications. See, for example, [PHP Quality Assurance with Jenkins](http://www.sitepoint.com/series/php-quality-assurance-with-jenkins/) and [Template for Jenkins Jobs for PHP Projects](http://jenkins-php.org/).

### Output style checking reports into files

If there are a large number of style violations then reports on these will scroll off the top of the terminal window when `make checks` is run. Output these reports into files to allow a developer to review them at their leisure.

PHP_CodeSniffer can output its reports in a variety of formats: XML, comma-separated values, or [Checkstyle](http://checkstyle.sourceforge.net/)-compliant XML. Checkstyle is a popular style checking tool for Java and there are a number of applications that can be used with PHP and which can process Checkstyle reports. For example, Jenkins supports a [Checkstyle plugin](https://wiki.jenkins-ci.org/display/JENKINS/Checkstyle+Plugin) which parses Checkstyle reports and presents these from within Jenkins.

### Output test reports into files

If there are a large number of tests then reports on these will scroll off the top of the terminal window when `make tests` is run. Output these reports into files to allow a developer to review them at their leisure.

[PHPUnit](https://phpunit.de/) can output its reports in a variety of formats: agile text, agile HTML, JSON, [TAP](https://testanything.org/) (Test Anything Protocol), and [JUnit](http://junit.org)-compliant XML. JUnit is a popular test framework for Java and there are a number of applications that can be used with PHP and which can process JUnit test reports. Jenkins supports a [JUnit plugin](https://wiki.jenkins-ci.org/display/JENKINS/JUnit+Plugin) which parses JUnit test reports and presents these from within Jenkins.

### Use PHPUnit code coverage

[Code coverage](http://en.wikipedia.org/wiki/Code_coverage) can provide one metric as to how effective a set of tests are in testing code. It summarises the lines of code that are executed as a side-effect of running the tests. PHPUnit supports code coverage, via [Xdebug](http://xdebug.org). It should be borne in mind:

> Even if 100 percent test coverage were possible, that is not a sufficient criterion for testing. Roughly 35 percent of software defects emerge from missing logic paths, and another 40 percent from the execution of a unique combination of logic paths. They will not be caught by 100 percent coverage. 

Fact 33. from Glass, R. (2002) Facts and Fallacies of Software Engineering, Addison-Wesley, 2002. ([PDF](http://ff.tu-sofia.bg/~bogi/France/SoftEng/books/Addison%20Wesley%20-%20Robert%20L%20Glass%20-%20Facts%20and%20Fallacies%20of%20Software%20Engineering.pdf)).

### Output code coverage reports into files

PHPUnit can output its reports in a variety of formats: XML, [Crap4J](http://www.crap4j.org/) (Change Risk Analysis and Predictions), HTML, PHPUnit XML, a PHP_CodeCoverage object and [Clover](https://www.atlassian.com/software/clover)-compliant XML. Clover is a popular code coverage framework for Java and there are a number of applications that can be used with PHP and which can process Clover code coverage reports. Jenkins supports a [Clover PHP Plugin](https://wiki.jenkins-ci.org/display/JENKINS/Clover+PHP+Plugin) which parses Clover code coverage reports and presents these from within Jenkins.

### Promote, and mandate, test development

Testing can be promoted as an important aspect of preserving, and promoting, the image of both sameAs Lite and its developers. If sameAs Lite is buggy and brittle then deployers may abandon it and potential deployers may be deterred from using it (and, in the worst case, other software from the same developers).

The process for using the source code repository can mandate that any new functions or components must be complemented by tests, that these tests are reviewed by another developer, and that the tests must pass, before these functions or components are merged into any release branch. Likewise, a contributions policy can mandate that any new functions or components, provided by third-party developers, are complemented by tests.

For example, the [MAUS](http://micewww.pp.rl.ac.uk/projects/maus/wiki) (MICE Analysis User Software) project impose the following conditions before [Merging code to the trunk](http://micewww.pp.rl.ac.uk/projects/maus/wiki/Merging_code_to_the_trunk):

* Developers must have their own personal branch tested on the MAUS Jenkins server.
* The developer's personal branch must pass all the MAUS style, unit, integration, and application tests.
* Every function must have a unit test.
* Application tests should be written to test an overall area of functionality.
* Code coverage should be 80% or above.
* Code should not generate any compiler warnings.
* Code should not cause any memory leaks.

The MAUS project have regularly e-mailed their developers with the names of classes and functions that fell below the 80% level, or violated the MAUS style checker.

## Define performance requirements

A key non-functional requirement of the sameAs Lite core library is good performance. A significant amount of performance analysis has been done with the core library on a variety of machines. Sample data for which the performance of the core library is known are available from Hugh and Ian.

There are a number of ways to reduce the risk that developers do not degrade the performance of the core library:

* Highlight, in the developers guide, that performance is a key non-functional requirement.
* If any code has been written in a non-intuitive or cryptic way to improve performance, then provide comments that explain why the code is this way. This can prevent developers inadvertently cleaning up or refactoring this code but, as a result, degrading performance.
* Document how performance testing can be done.
* Distribute data sets for which performance is known, their performance data, and details of the conditions under which this data was gathered,
* Implement a suite of automated performance tests based on these data sets.
* Make performance a part of the conditions for merging code into a release
* Extend any process for using the source code repository to mandate that code must satisfy performance criteria before being merged into a release branch.

---

## Example documents

A number of example documents have been written as a side-effect of this report:

* [sameAs Lite concepts](./Concepts.md) - sameAs Lite concepts and database schema.
* [Deployer's Guide](./DeployersGuide.md)
* [Set up development environment](SetupDevelopment.md)
* [Day-to-day development](./DayToDayDevelopment.md)
* [Deployer and Developer Reference](./Reference.md) - useful operating system-specific information for both deployers and developers.
* [REST API examples](./RESTAPIExamples.md) - examples of invocations of sameAs Lite REST endpoints, and examples of what they return, which can be useful for deployers and developers.
