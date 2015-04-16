# sameAs Lite day-to-day development

How to do day-to-day sameAs Lite development.

You should be familiar with the [Deployer's Guide](./DeployersGuide.md) and havve installed the software listed in it and in [Set up development environment](./SetupDevelopment.md).

---

## Run tests

[PHPUnit](https://phpunit.de/) is used as an automated test framework.

PHPUnit is installed automatically by Composer:

    $ ./vendor/bin/phpunit --version
    PHPUnit 4.5.0 by Sebastian Bergmann and contributors.

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

### Create a JUnit XML test report

[JUnit](http://junit.org) is a popular unit test framework for Java. There are a number of applications that can be used with PHP and which can process JUnit test reports. 

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

Test reports can also be generated in JSON, [TAP](https://testanything.org/) (Test Anything Protocol) format and text- and HTML-based agile documentation. For details see PHPUnit [Logging](https://phpunit.de/manual/current/en/logging.html) or run:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --help

### Create a code coverage report

If you have installed Xdebug, then PHPUnit can create code coverage reports which summarises which lines of the sameAs Lite code have been executed as a side-effect of running the tests.

Run:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --coverage-text tests/phpUnit/

### Create a Clover code coverage report

[Clover](https://www.atlassian.com/software/clover) is a popular code coverage framework for Java and there are a number of applications that can be used with PHP and which can process Clover code coverage reports.

Run:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --coverage-clover clover.xml tests/phpUnit/
    $ cat clover.xml
    <?xml version="1.0" encoding="UTF-8"?>
    <coverage generated="1428578447">
      <project timestamp="1428578447">
        <package name="SameAsLite">
          <file name="/var/www/html/sameas-lite/src/Store.php">
            <class name="Store" namespace="SameAsLite">
              <metrics methods="23" coveredmethods="1" conditionals="0" coveredconditionals="0"
                       statements="449" coveredstatements="47" elements="472" coveredelements="48"/>
            </class>
            <line num="81" type="method" name="__construct" crap="10.10" count="4"/>
            <line num="85" type="stmt" count="4"/>
            <line num="86" type="stmt" count="4"/>
            ...

### Create code coverage reports in other formats

Code coverage reports can also be generated in [Crap4J](http://www.crap4j.org/) (Change Risk Analysis and Predictions), HTML, PHPUnit XML and as a PHP_CodeCoverage object. For details see PHPUnit [Code Coverage Analysis](https://phpunit.de/manual/current/en/code-coverage-analysis.html) or run:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --help

**Troubleshooting - The Xdebug extension is not loaded. **

If you see:

    The Xdebug extension is not loaded. No code coverage will be generated.

Then you need to install Xdebug.

---

## Create API documentation

[phpDocumentor](http://www.phpdoc.org/) comments and tags are used to document PHP source code. 

phpDocumentor is installed automatically by Composer:

    $ ./vendor/bin/phpdoc --version
    phpDocumentor version 2.8.2

Run:

    $ make docs

The documentation is placed in docs/ and can be browsed via docs/index.html.

**Troubleshooting - Unable to find the `dot` command**

If you see:

    Unable to find the `dot` command of the GraphViz package. Is GraphViz correctly installed and present in your path? 

Then you need to install GraphViz.

---

## Run coding standards check

[PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) is used as a style checker. 

PHP_CodeSniffer's tools are installed automatically by Composer:

    $ ./vendor/bin/phpcbf --version
    PHP_CodeSniffer version 2.3.0 (stable) by Squiz (http://www.squiz.net)
    $ ./vendor/bin/phpcs --version
    PHP_CodeSniffer version 2.3.0 (stable) by Squiz (http://www.squiz.net)

Run:

    $ make checks

The results of the check will be displayed.

**Troubleshooting - Error 1 (ignored)**

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

[Checkstyle](http://checkstyle.sourceforge.net/) is a popular style checking tool for Java and there are a number of applications that can be used with PHP and which can process Checkstyle reports.

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

### How style checking works

When `make checks` is run, two passes are done:

1. PHP Code Beautifier and Fixer (phpcbf) is run to identify deviations from the coding style, and to fix these if possible.
2. PHP_CodeSniffer (phpcs) is run to identify and report on any remaining deviations from the coding style.

PHP_CodeSniffer configuration files are in dev-tools/CodeStandard. For more information on these see PHP_CodeSniffer documentation and files:

* [Coding Standard Tutorial](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Coding-Standard-Tutorial)
* [Annotated ruleset.xml](https://github.com/squizlabs/PHP_CodeSniffer/wiki/Annotated-ruleset.xml)
* [Built-in coding standards](https://github.com/squizlabs/PHP_CodeSniffer/tree/master/CodeSniffer/Standards)

---

## Profiling

Xdebug has a built-in [profiler](http://www.xdebug.org/docs/profiler). This outputs files in [Callgrind format](http://kcachegrind.sourceforge.net/html/CallgrindFormat.html), part of the [Valgrind](http://valgrind.org/) tool suite. These files can be analysed by many tools including [KCachegrind](http://kcachegrind.sourceforge.net) and [callgrind_annotate](http://valgrind.org/docs/manual/cl-manual.html#cl-manual.callgrind_annotate-options). 

### Enable Xdebug profiler

Edit php.ini:

* Ubuntu 14.04:
  - For profiling PHP run under Apache2, edit /etc/php5/apache2/php.ini
  - For profiling PHP run at the command-line, edit /etc/php5/cli/php.ini
* Scientific Linux 7:
  - Edit /etc/php.ini
* Fedora 21:
  - Edit /etc/php.ini

After:

    [xdebug]
    zend_extension="/usr/lib/php5/20121212/xdebug.so"

Add:

    xdebug.profiler_enable=1
    xdebug.profiler_output_dir=/tmp/
    xdebug.profiler_output_name=cachegrind.out.%r

xdebug.profiler_output_name specifies that file names of form `cachegrind.out.RANDOM_NUMBER` are created. For other options see [xdebug.trace_output_name](http://www.xdebug.org/docs/all_settings#trace_output_name).

Restart Apache:

* Ubuntu 14.04:

<p/>

    $ service apache2 restart

* Scientific Linux 7:

<p/>

    $ systemctl restart httpd.service 

* Fedora 21:

<p/>

    $ apachectl restart

Check Apache profiling:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets

* Ubuntu 14.04:

<p/>

    $ ls /tmp/
    cachegrind.out.01bb5c  

* Scientific Linux 7:
  - The sub-directory of /tmp may differ.

<p/>

    $ ls -l /tmp/systemd-private-BhZSgg/tmp/
    cachegrind.out.01bb5c  

* Fedora 21:
  - The sub-directory of /tmp may differ.

<p/>

    $ ls /tmp/systemd-private-f092465403634da79a6ab044ec4846e6-httpd.service-0UqNQv/tmp
    cachegrind.out.01bb5c  

Check command-line profiling:

    $ php src/Store.php
    $ ls /tmp
    cachegrind.out.01bb5c  
   
### Configure Xdebug profiler to run in Apache only when triggered

The Xdebug profiler can be configured to run in Apache only when explicitly triggered by using a GET/POST or COOKIE variable called XDEBUG_PROFILE e.g.

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets?XDEBUG_PROFILE

Edit php.ini:

* Ubuntu 14.04:
  - Edit /etc/php5/apache2/php.ini
* Scientific Linux 7:
  - Edit /etc/php.ini
* Fedora 21:
  - Edit /etc/php.ini

Edit:

    xdebug.profiler_enable=0

Add:

    xdebug.profiler_enable_trigger=1

Restart Apache:

* Ubuntu 14.04:

<p/>

    $ service apache2 restart

* Scientific Linux 7:

<p/>

    $ systemctl restart httpd.service 

* Fedora 21:

<p/>

    $ apachectl restart

Check trigger-only Apache profiling:

* Ubuntu 14.04:

<p/>

    $ rm /tmp/cachegrind.*
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets
    $ ls /tmp/
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets?XDEBUG_PROFILE
    $ ls /tmp/

* Scientific Linux 7:

<p/>

    $ rm /tmp/systemd-private-BhZSgg/cachegrind.*
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets
    $ ls /tmp/systemd-private-BhZSgg/
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets?XDEBUG_PROFILE
    $ ls /tmp/systemd-private-BhZSgg/

* Fedora 21:

<p/>

    $ rm /tmp/systemd-private-f092465403634da79a6ab044ec4846e6-httpd.service-0UqNQv/tmp/cachegrind.*
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets
    $ ls /tmp/systemd-private-f092465403634da79a6ab044ec4846e6-httpd.service-0UqNQv/tmp/
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets?XDEBUG_PROFILE
    $ ls /tmp/systemd-private-f092465403634da79a6ab044ec4846e6-httpd.service-0UqNQv/tmp/

### View profile data using KCachegrind

    $ kcachegrind cachegrind.out.01bb5c  

See [KCachegrind](http://kcachegrind.sourceforge.net/html/Home.html) for information on use.

**Troubleshooting - Session management error**

If you get:

    Qt: Session management error: None of the authentication protocols specified are supported
    kcachegrind(33818)/kdeui (KIconLoader): Error: standard icon theme "oxygen" not found! 

Then this can happen if you are running as `su` but not as the root user. Either run `kcachegrind` as a user or, if you have permission, run:

    $ su -

## View profile data using callgrind_annotate

View functions ranked in order of time spent in those functions, inclusive of time spent in child functions:

    $ callgrind_annotate --inclusive=yes cachegrind.out.01bb5c  
    --------------------------------------------------------------------------------
    Profile data file 'cachegrind.out.01bb5c' (creator: xdebug 2.3.2)
    --------------------------------------------------------------------------------
    Profiled target:  /var/www/html/sameas-lite/index.php
    Events recorded:  Time
    Events shown:     Time
    Event sort order: Time
    Thresholds:       99
    Include dirs:     
    User annotated:   
    Auto-annotation:  off
    
    --------------------------------------------------------------------------------
       Time 
    --------------------------------------------------------------------------------
    143,891  PROGRAM TOTALS
    
    --------------------------------------------------------------------------------
     Time  file:function
    --------------------------------------------------------------------------------
    9,916  vendor/composer/ClassLoader.php:Composer\Autoload\ClassLoader->findFileWithExtension
    9,877  vendor/twig/twig/lib/Twig/NodeTraverser.php:Twig_NodeTraverser->traverseForVisitor
    8,318  vendor/composer/ClassLoader.php:Composer\Autoload\ClassLoader->findFile
    8,085  vendor/slim/slim/Slim/Http/Request.php:Slim\Http\Request->__construct
    5,064  vendor/slim/slim/Slim/Helper/Set.php:Slim\Helper\Set->get
    4,521  vendor/slim/slim/Slim/Http/Headers.php:Slim\Http\Headers::extract
    3,715  vendor/composer/ClassLoader.php:Composer\Autoload\includeFile
    3,335  vendor/twig/twig/lib/Twig/Parser.php:Twig_Parser->subparse

View SameAsLite-only functions ranked in order of time spent in those functions, and including time spent in their child functions:

    $ callgrind_annotate --inclusive=yes cachegrind.out.01bb5c | grep SameAsLite
    107,802  /var/www/html/sameas-lite/src/WebApp.php:SameAsLite\WebApp->run
    107,790  src/WebApp.php:SameAsLite\WebApp->run
     86,729  /var/www/html/sameas-lite/src/WebApp.php:SameAsLite\WebApp->querySymbol
     86,727  src/WebApp.php:SameAsLite\WebApp->querySymbol
     85,978  /var/www/html/sameas-lite/src/WebApp.php:SameAsLite\WebApp->outputHTML
     85,968  src/WebApp.php:SameAsLite\WebApp->outputHTML
     33,637  /var/www/html/sameas-lite/src/WebApp.php:SameAsLite\WebApp->__construct
     33,630  src/WebApp.php:SameAsLite\WebApp->__construct
     10,997  /var/www/html/sameas-lite/src/WebApp.php:SameAsLite\WebApp->registerURL
     10,900  src/WebApp.php:SameAsLite\WebApp->registerURL
      6,686  /var/www/html/sameas-lite/src/WebApp.php:SameAsLite\WebApp->callbackCheckFormats
      6,676  src/WebApp.php:SameAsLite\WebApp->callbackCheckFormats

View SameAsLite-only functions ranked in order of time spent exclusively in those functions, not including time spent in child functions:

        $ callgrind_annotate cachegrind.out.01bb5c | grep WebApp
    3,034  src/WebApp.php:SameAsLite\WebApp->registerURL
      648  src/WebApp.php:SameAsLite\WebApp->run
      245  src/WebApp.php:SameAsLite\WebApp->__construct
      175  src/WebApp.php:SameAsLite\WebApp->callbackCheckFormats
      164  src/WebApp.php:SameAsLite\WebApp->outputHTML
      142  src/Store.php:SameAsLite\Store->__destruct
       78  src/Store.php:SameAsLite\Store->__construct
       66  src/Store.php:SameAsLite\Store->connect
       60  src/Store.php:SameAsLite\Store->querySymbol
       51  src/WebApp.php:SameAsLite\WebApp->querySymbol
       51  src/WebApp.php:SameAsLite\WebApp->callbackCheckDataset
       34  src/WebApp.php:SameAsLite\WebApp->addDataset
        4  src/WebApp.php:SameAsLite\WebApp->initialiseServerParameters

See [callgrind_annotate](http://valgrind.org/docs/manual/cl-manual.html#cl-manual.callgrind_annotate-options) for command-line options, or run:

    $ callgrind_annotate -h
