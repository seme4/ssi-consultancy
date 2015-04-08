# sameAs Lite Developers's Guide

How to setup a development enviroment for sameAs Lite and guidelines on day-to-day development activities.

You should be familiar with the [Deployer's Guide](./DeployersGuide.md) and havve installed the software listed in it.

---

# Set up development environment

## Install GraphViz

[GraphViz](http://www.graphviz.org/) is open source graph visualisation software. It is used to create images for API documentation.

### Ubuntu 14.04

Install:

    $ apt-get install graphviz
    $ dot -V
    dot - graphviz version 2.36.0 (20140111.2315)

### Scientific Linux 7

Install:

    $ yum install graphviz
    $ dot -V
    dot - graphviz version 2.30.1 (20140505.1332)

### Fedora 21

Install:

    $ yum install graphviz
    $ dot -V
    dot - graphviz version 2.38.0 (20140413.2041)

---

## Install Patch

[Patch](http://www.gnu.org/software/diffutils/manual/html_node/Overview.html) is a tool to update, or patch, files. It is used by PHP_CodeSniffer to fix files that violate coding standards.

### Ubuntu 14.04

Patch is already provided:

    $ patch -v
    GNU patch 2.7.1

### Scientific Linux 7

Install:

    $ yum install patch
    $ patch -v
    GNU patch 2.7.1

### Fedora 21

Install:

    $ yum install patch
    $ patch -v
    GNU patch 2.7.5

---

## Create GitHub account and application token

[GitHub](http://github.com) is a popular project hosting infrastructure. An account is needed use PHP Composer to install sameAs Lite's PHP dependencies.

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

## Install PHP development tools

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

# Day-to-day development

## Run tests

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

### Run specific tests

Run a specific test function, for example:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --filter testExceptionIsRaisedForInvalidDSN tests/phpUnit/ 

Run all the tests in a specific class, for example:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --filter StoreTest tests/phpUnit/ 

### Create an agile test report file

Run:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --testdox-text tests.txt tests/phpUnit/ 
    $ cat tests.txt
    SameAsLite\Store
     [x] Exception is raised for invalid d s n
     [x] Exception is raised for invalid dbase table name
     [x] Store can be constructed for valid constructor arguments
     [x] An empty store can be dumped

### Create an JUnit XML test report

[JUnit](http://junit.org) is a popular unit test framework for Java. Its XML report format has been adopted by unit test frameworks for a number of languages and there are a number of scripts and and applications that can also be used with PHP and which can process JUnit XML test reports. 

Run:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --log-junit tests.xml tests/phpUnit/ 
    $ cat tests.xml
    <?xml version="1.0" encoding="UTF-8"?>
    <testsuites>
      <testsuite name="tests/phpUnit/" tests="4" assertions="4" failures="0" errors="0" time="0.021694">
        <testsuite name="SameAsLite\StoreTest" file="/var/www/html/sameas-lite/tests/phpUnit/StoreTest.php" tests="4" assertions="4" failures="0" errors="0" time="0.021694">
          <testcase name="testExceptionIsRaisedForInvalidDSN" class="SameAsLite\StoreTest" file="/var/www/html/sameas-lite/tests/phpUnit/StoreTest.php" line="55" assertions="1" time="0.017870"/>
          <testcase name="testExceptionIsRaisedForInvalidDbaseTableName" class="SameAsLite\StoreTest" file="/var/www/html/sameas-lite/tests/phpUnit/StoreTest.php" line="66" assertions="1" time="0.000317"/>
          <testcase name="testStoreCanBeConstructedForValidConstructorArguments" class="SameAsLite\StoreTest" file="/var/www/html/sameas-lite/tests/phpUnit/StoreTest.php" line="76" assertions="1" time="0.002105"/>
          <testcase name="testAnEmptyStoreCanBeDumped" class="SameAsLite\StoreTest" file="/var/www/html/sameas-lite/tests/phpUnit/StoreTest.php" line="87" assertions="1" time="0.001402"/>
        </testsuite>
      </testsuite>
    </testsuites>

### Create test reports in other formats

Test reports can also be generated in JSON, [TAP](https://testanything.org/) (Test Anything Protocol) format and HTML-based agile documentation. For details see:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --help

---

## Create API documentation

Run:

    $ make docs

The documentation is placed in docs/ and can be browsed via docs/index.html.

**Troubleshooting - Unable to find the `dot` command**

If you see:

    Unable to find the `dot` command of the GraphViz package. Is GraphViz correctly installed and present in your path? 

Then you need to install GraphViz.

---

## Run coding standards check

Run:

    $ make checks

The results of the check will be displayed.

**Troubleshooting - Error 1(ignored)**

If you see:

    make: [checks] Error 1 (ignored)

Or, for Fedora 21, you see:

    Makefile:27: recipe for target 'checks' failed
    make: [checks] Error 1 (ignored)

then this means one or more checks failed.

**Troubleshooting - sh: patch: command not found**

If you see:

    sh: patch: command not found

Then you need to install Patch.

### Create an XML coding standards report

Run:

    $ ./vendor/bin/phpcs --standard=dev-tools/CodeStandard --report=xml --report-file=style.xml ./
    $ cat style.xml 
    <?xml version="1.0" encoding="UTF-8"?>
    <phpcs version="2.3.0">
    <file name="/var/www/html/sameas-lite/index.php" errors="4" warnings="1" fixable="0">
     <error line="9" column="4" source="Squiz.Commenting.FileComment.SubpackageTagOrder" severity="5" fixable="0">The tag in position 2 should be the @subpackage tag</error>
     <error line="10" column="4" source="Squiz.Commenting.FileComment.AuthorTagOrder" severity="5" fixable="0">The tag in position 3 should be the @author tag</error>
     <error line="11" column="4" source="Squiz.Commenting.FileComment.CopyrightTagOrder" severity="5" fixable="0">The tag in position 4 should be the @copyright tag
    </error>
     <error line="34" column="2" source="Squiz.Commenting.FileComment.MissingSubpackageTag" severity="5" fixable="0">Missing @subpackage tag in file comment</error>
     <warning line="43" column="1" source="Generic.Commenting.Todo.TaskFound" severity="5" fixable="0">Comment refers to a TODO task &quot;think about abstraction of dbase connection, store and dataset. it&quot;</warning>
    </file>
    ...
    </phpcs>

### Create an comma-separated values coding standards report

Run:
    
    $ ./vendor/bin/phpcs --standard=dev-tools/CodeStandard --report=csv --report-file=style.csv ./
    Time: 1.02 secs; Memory: 18.75Mb
    $ cat style.csv 
    File,Line,Column,Type,Message,Source,Severity,Fixable
    "/var/www/html/sameas-lite/index.php",9,4,error,"The tag in position 2 should be the @subpackage tag",Squiz.Commenting.FileComment.SubpackageTagOrder,5,0
    "/var/www/html/sameas-lite/index.php",10,4,error,"The tag in position 3 should be the @author tag",Squiz.Commenting.FileComment.AuthorTagOrder,5,0
    "/var/www/html/sameas-lite/index.php",11,4,error,"The tag in position 4 should be the @copyright tag",Squiz.Commenting.FileComment.CopyrightTagOrder,5,0
    "/var/www/html/sameas-lite/index.php",34,2,error,"Missing @subpackage tag in file comment",Squiz.Commenting.FileComment.MissingSubpackageTag,5,0
    "/var/www/html/sameas-lite/index.php",43,1,warning,"Comment refers to a TODO task \"think about abstraction of dbase connection, store and dataset. it\"",Generic.Commenting.Todo.TaskFound,5,0
    ...

### Create a Checkstyle-compliant XML coding standards report.

[Checkstyle](http://checkstyle.sourceforge.net/) is a popular style checking tool for Java and there are a number of scripts and applications that can also be used with PHP and which can process Checkstyle documents. 

Run:

    $ ./vendor/bin/phpcs --standard=dev-tools/CodeStandard --report=checkstyle --report-file=checkstyle.xml ./
    Time: 998ms; Memory: 18.75Mb
    $ cat checkstyle.xml
    <?xml version="1.0" encoding="UTF-8"?>
    <checkstyle version="2.3.0">
    <file name="/var/www/html/sameas-lite/index.php">
     <error line="9" column="4" severity="error" message="The tag in position 2 should be the @
    subpackage tag" source="Squiz.Commenting.FileComment.SubpackageTagOrder"/>
     <error line="10" column="4" severity="error" message="The tag in position 3 should be the 
    @author tag" source="Squiz.Commenting.FileComment.AuthorTagOrder"/>
     <error line="11" column="4" severity="error" message="The tag in position 4 should be the 
    @copyright tag" source="Squiz.Commenting.FileComment.CopyrightTagOrder"/>
     <error line="34" column="2" severity="error" message="Missing @subpackage tag in file comm
    ent" source="Squiz.Commenting.FileComment.MissingSubpackageTag"/>
     <error line="43" column="1" severity="warning" message="Comment refers to a TODO task &quo
    t;think about abstraction of dbase connection, store and dataset. it&quot;" source="Generic
    .Commenting.Todo.TaskFound"/>
    </file>
    ...
    </checkstyle>

---

## Create source release

Run:

    $ make tarball

The source release is placed in sameAsLite-dev.tar.gz.

**Warning** this first removes all auto-generated files, including dependencies.

---

## Clean up

To remove auto-generated documentation, run:

    $ make clean-docs

To remove all auto-generated files, including dependencies, and revert back to clean distribution state, run:

    $ make clean-dist

---

## Coding standards

sameAs Lite source code must comply with the following coding standards:

* PHP Framework Interop Group [Basic coding standard](http://www.php-fig.org/psr/psr-1/) (PSR1)
* PHP Framework Interop Group [Coding style guide](http://www.php-fig.org/psr/psr-2/) (PSR2)
* No unused function parameters.
* No FIXME comments.
* No TODO comments. 

### Commenting code

Every class, function, and member variable must be commented. [phpDocumentor](http://www.phpdoc.org/) comments and tags are used so that API documentation can be auto-generated from the source code.

An example class comment is:

    /**
     * SameAs Lite
     *
     * This class provides a specialised storage capability for SameAs pairs.
     *
     * @package   SameAsLite
     * @author    Seme4 Ltd <sameAs@seme4.com>
     * @copyright 2009 - 2014 Seme4 Ltd
     * @link      http://www.seme4.com
     * @version   0.0.1
     * @license   MIT Public License
     * ...
     */

An example member variable comment is:

    /** @var \PDO $dbHandle The PDO object for the DB, once opened */
    protected $dbHandle;

Example function comments are:

    /**
     * Establish connection to database, if not already made
     *
     * @throws \Exception Exception is thrown if connection fails or table cannot be accessed/created.
     */
    public function connect()
    ...
  
    /**
     * This is the simple method to query a store with a symbol
     *
     * Looks up the given symbol in a store, and returns the bundle with all
     * the symbols in it (including the one given). The bundle is ordered with
     * canon(s) first, then non-canons, in alpha order of symbols.
     *
     * @param string $symbol The symbol to be looked up
     * @return string[] An array of the symbols, which is singleton of the given symbol of nothing was found
     */
    public function querySymbol($symbol)
    ...

For more on phpDocumentor comments and tags, see [Learn about phpDocumentor](http://www.phpdoc.org/docs/latest/index.html) especially the sections:

* [Your First Set of Documentation](http://www.phpdoc.org/docs/latest/getting-started/your-first-set-of-documentation.html)
* [Inside DocBlocks](http://www.phpdoc.org/docs/latest/guides/docblocks.html)

### How API documentation is auto-generated

[phpDocumentor](http://www.phpdoc.org/) comments and tags are used to document PHP source code. 

phpDocumentor is installed automatically by Composer:

    $ ./vendor/bin/phpdoc --version
    phpDocumentor version 2.8.2

### How style checking works

[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) is used as a style checker. 

PHP_CodeSniffer's tools are installed automatically by Composer:

    $ ./vendor/bin/phpcbf --version
    PHP_CodeSniffer version 2.3.0 (stable) by Squiz (http://www.squiz.net)
    $ ./vendor/bin/phpcs --version
    PHP_CodeSniffer version 2.3.0 (stable) by Squiz (http://www.squiz.net)

When `make checks` is run, two passes are done:

1. PHP Code Beautifier and Fixer (phpcbf) is run to identify deviations from the coding style, and to fix these if possible.
2. PHP_CodeSniffer (phpcs) is run to identify and report on any remaining deviations from the coding style.

PHP_CodeSniffer configuration files are in dev-tools/CodeStandard. For more information on these see PHP_CodeSniffer documentation and files:

* [Coding Standard Tutorial](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Coding-Standard-Tutorial)
* [Annotated ruleset.xml](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Annotated-ruleset.xml)
* [Built-in coding standards](https://github.com/squizlabs/PHP_CodeSniffer/tree/master/CodeSniffer/Standards)

---

## Tests

[PHPUnit](https://phpunit.de/) is used as an automated test framework.

PHPUnit is installed automatically by Composer:

    $ ./vendor/bin/phpunit --version
    PHPUnit 4.5.0 by Sebastian Bergmann and contributors.

TODO - provide information on configuring and writing tests, and any manual tests (e.g. of deployment).

---

## Concepts and database schema

Equivalent URIs are conceptually stored in a *bundle*. A bundle is a set of URIs referring to resources which are considered to be equivalent, in a given context. A URI can exist in at most one bundle within a linked data set exposed by a sameAs Lite instance.

One URI in each bundle is nominated to be a canonical identifier, or *canon*, for that bundle. The canon represents a *preferred URI* for the set of duplicates. 

An application that wishes to use data from multiple sources as if they were a single resource can process results by looking up URIs within sameAs Lite and replacing these with their canons on the fly. This reduces the multiplicity of identifiers to a single definitive URI.

sameAs Lite stores equivalent URIs within a single database table which associates an URI with its canon. The schema of this table is as follows:

For MySQL:

    +--------+--------------+------+-----+---------+-------+
    | Field  | Type         | Null | Key | Default | Extra |
    +--------+--------------+------+-----+---------+-------+
    | canon  | varchar(256) | YES  | MUL | NULL    |       |
    | symbol | varchar(256) | NO   | PRI |         |       |
    +--------+--------------+------+-----+---------+-------+

For SQLite:

    +--------+------+-----+
    | Field  | Type | Key |
    +--------+------+-----+
    | canon  | TEXT |     |
    | symbol | TEXT | PRI |
    +--------+---- -+-----+

A database index is created on canon.

For more information about the concepts underpinning sameAs Lite, see Glaser, H., Jaffri, A. and Millard, I. C. (2009) [Managing Co-reference on the Semantic Web](http://eprints.soton.ac.uk/267587/). In: Linked Data on the Web (LDOW2009), April 2009, Madrid, Spain.
