# Database-agnostic design

Mike Jackson, The Software Sustainability Institute / EPCC, The University of Edinburgh

## Introduction

[sameAs.org](http://sameas.org) is a search engine for linked data that, if given a URI, returns URIs that are co-referent, should any be known to it. The engine searches information harvested from a number of sources. sameAs.org is maintained by [Seme4 Limited](http://www.seme4.com). [sameAs Lite](http://github.com/seme4/sameas-lite) is a refactored, free open source, version of the software that powers sameAs.org.

sameAs Lite is implemented as two [PHP](http://php.net/) libraries, one which implements the core storage management functionality, and one which implements a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) web application. These depend upon a number of other libraries and [PHP Composer](https://getcomposer.org/) is used for dependency management. 

It is intended that the core library can be used within other applications, outwith the REST web application. Originally the core library could be used as-is with [SQLite](http://www.sqlite.org/) but the core library currently only supports [MySQL](http://www.mysql.com).

A key non-functional requirement of the core library is that performance must be very good. As a result, a significant amount of performance analysis has been done with the core library on a variety of machines. Sample data for which the performance of the core library is known are available.

This document discusses issues around making the core library database-agnostic without degrading performance.

---

## Store.php and database products

src/Store.php contains code to manages a linked data store, represented as a table within a database. It contains one class \SameAsLite\Store. The constructor:

    public function __construct($dsn, $name, $user = null, $pass = null, $dbName = null)

takes in a data store name, or database connection URL, $dsn, e.g.

    mysql:host=127.0.0.1;port=3306;charset=utf8

    sqlite:/var/databases/sameasdb.sq3

It then parses this URL, splitting on ":", to get the database type, which is stored in a member variable, dbType. It checks that dbType is either mysql or sqlite, the database products that can be used with sameAs Lite.

The functions within Store use conditionals based on the database type as MySQL and SQLite, the database products that can be used with sameAs Lite, differ in a number of ways including the data types they support, the SQL commands they support and custom extensions specific to each product.

The following functions contain code that is product-specific (only relevant excerpts are shown):

    public function connect()

      // if mysql, we need to select the appropriate database
      if ($this->dbType == 'mysql') {
        $this->dbHandle->exec('USE ' . $this->dbName);
      }
      if ($this->dbType == 'sqlite') {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->storeName .
               ' (canon TEXT, symbol TEXT PRIMARY KEY)' .
               ' WITHOUT ROWID;' .
               ' CREATE INDEX IF NOT EXISTS ' . $this->storeName . '_idx' .
               ' ON ' . $this->storeName . ' (canon);';
      } else {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->storeName .
                ' (canon VARCHAR(256), symbol VARCHAR(256), PRIMARY KEY (symbol), INDEX(canon))' .
                ' ENGINE = MYISAM;';
      }

    public function deleteStore()

      $sql = 'DROP TABLE IF EXISTS ' . $this->storeName . ';';
      if ($this->dbType == 'sqlite') {
        $sql .= 'DROP INDEX IF EXISTS ' . $this->storeName . '_idx;';
      }

    public function emptyStore()

      if ($this->dbType === 'sqlite') {
        // SQLite doesn't have TRUNCATE
        $statement = $this->dbHandle->prepare("DELETE FROM $this->storeName;");
      } else {
        $statement = $this->dbHandle->prepare("TRUNCATE $this->storeName;");
      }

    public function exportToFile($file = null)

        if ($this->dbType == 'sqlite') {
          throw new \Exception('This function is only supported for MySQL databases');
        }
        if ($file == null) {
          $file = "sameAsLite_backup_{$this->storeName}.tsv";
        }
        $sql = "SELECT canon, symbol FROM $this->storeName INTO OUTFILE '$file' FIELDS TERMINATED BY '\t';";

    public function loadFromFile($file)
      if ($this->dbType == 'sqlite') {
        throw new \Exception('This function is only supported for MySQL databases');
       }
       $sql = "LOAD DATA INFILE '$file' INTO TABLE $this->storeName FIELDS TERMINATED BY '\t';";

    public function listStores()
      if ($this->dbType === 'sqlite') {
        // SQLite doesn't have SHOW TABLES"
        $statement = $this->dbHandle->prepare(
           "SELECT name FROM sqlite_master " .
           "WHERE type='table' ORDER BY name;"
        );
      } else {
        $statement = $this->dbHandle->prepare("SHOW TABLES");
      }
      $store = $row['name']; // TODO This doesn't work for mySQL, it's Array ([Tables_in_testdb] => webdemo)
      $statement = $this->dbHandle->prepare("SELECT COUNT(DISTINCT symbol) FROM $this->storeName;");
      $statement = $this->dbHandle->prepare("SELECT COUNT(DISTINCT canon) FROM $this->storeName ;");

    public function assertPairs(array $data)
      // TODO We can (also) have a version that uses LOAD DATA INFILE in mySQL

    public function restoreStore($file)
      // TODO - decide if this function is required. maybe for sqlite?

Other code within the class is database product-agnostic, compatible with both MySQL and SQLite. This includes code that executes these types of SQL statements:

    SELECT DISTINCT ... FROM ... AS ... WHERE ... AND ... ORDER BY ... ASC | DSC
    REPLACE INTO ... VALUES ...
    INSERT INTO ... VALUES ...
    UPDATE ... SET ... WHERE ...
    DELETE FROM ... WHERE ...
    SELECT COUNT(DISTINCT ...) FROM ...

### Create MySQL and SQLite sub-classes of Store

Store is not a cohesive class. It has multiple purposes, managing both MySQL and SQLite, rather than just one, a generic relational database.

Should a developer want to add support for a new database, they would have to track down and update every conditional within Store and add new conditions for their product. This would cause Store to grow ever more unwieldy.

Pulling out MySQL- and SQLite-specifics from Store into new sub-classes, \SameAsLite\MySqlStore and \SameAsLite\SqLite, and turning Store into an abstract super-class, addresses these concerns. If support is required for an additional database, then a new sub-class can be written without the need to change Store. Store can remain compact, implementing functionality common across all relational databases.

An example of this design is in the [dbsubclass](https://github.com/softwaresaved/sameas-lite/tree/dbsubclass) branch of https://github.com/softwaresaved/sameas-lite. The relevant files are:

* [Store.php](https://github.com/softwaresaved/sameas-lite/blob/dbsubclass/src/Store.php)
* [MySqlStore.php](https://github.com/softwaresaved/sameas-lite/blob/dbsubclass/src/MySqlStore.php)
* [SqLiteStore.php](https://github.com/softwaresaved/sameas-lite/blob/dbsubclass/src/SqLiteStore.php)
* [index.php](https://github.com/softwaresaved/sameas-lite/blob/dbsubclass/index.php) - updated to create MySqlStore instances for MySQL databases.

### Provide a factory class

One strength of Store was its ability to dynamically handle MySQL or SQLite at run-time, based upon the DSN it was given. A factory class for Store, \SameAsLite\StoreFactory would allow instances of Store's sub-classes to be created dynamically on the basis of a database DSN, should this functionality be needed. 

An example of a possible implementation of StoreFactory is in the dbsubclass branch. The file is:

* [StoreFactory.php](https://github.com/softwaresaved/sameas-lite/blob/dbsubclass/src/StoreFactory.php)

As an example of its use:

    require_once 'vendor/autoload.php';

    $store = \SameAsLite\StoreFactory::create('mysql:host=127.0.0.1;port=3306;charset=utf8', 'table1', 'testuser', 'testpass', 'testdb');
    print_r(get_class($store) . "\n");
    var_dump($store instanceof \SameAsLite\Store);

    $store = \SameAsLite\StoreFactory::create('sqlite:/var/databases/sameasdb.sq3','table1');
    print_r(get_class($store) . "\n");
    var_dump($store instanceof \SameAsLite\Store);

Running this gives:

    SameAsLite\MySqlStore
    bool(true)

    SameAsLite\SqLiteStore
    bool(true)

---

## Performance implications

This section looks at the performance implications of using sub-classes instead of conditionals.

### A simple benchmarking harness

A simple benchmarking harness was written. This is in the [profile_master](https://github.com/softwaresaved/sameas-lite/tree/profile_master) branch of https://github.com/softwaresaved/sameas-lite. The relevant files are in the profile/ directory.

[MySqlDataCreator.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/MySqlDataCreator.php) creates a MySQL database table then populates it with pseudo-random data. It generates N random canons. For each canon it generates N random symbols. Each canon-symbol pair, along with a canon-canon pair is inserted into the table. A seed is used so the same random data can be generated each time. For example, to create a table with 100 canons, and 100 symbols per canon, using [CreateMySqlData.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/CreateMySqlData.php) which is a command-line tool that uses MySqlDataCreator:

    $ php profile/CreateMySqlData.php 'mysql:host=127.0.0.1;port=3306;charset=utf8' table1 testuser testpass testdb 100

The database contents are as follows:

    mysql> select count(*) from table1;
    +----------+
    | count(*) |
    +----------+
    |    10100 |
    +----------+
    1 row in set (0.00 sec)

    mysql> select count(*) from table1 where canon='http.51011a3008ce7eceba27c629f6d0020c';
    +----------+
    | count(*) |
    +----------+
    |      101 |
    +----------+
    1 row in set (0.04 sec
    
    mysql> select * from table1 where symbol='http.51011a3008ce7eceba27c629f6d0020c';
    +---------------------------------------+---------------------------------------+
    | canon                                 | symbol                                |
    +---------------------------------------+---------------------------------------+
    | http.51011a3008ce7eceba27c629f6d0020c | http.51011a3008ce7eceba27c629f6d0020c |
    +---------------------------------------+---------------------------------------+
    1 row in set (0.00 sec)
    
    mysql> select * from table1 where canon='http.51011a3008ce7eceba27c629f6d0020c' LIMIT 10;
    +---------------------------------------+---------------------------------------+
    | canon                                 | symbol                                |
    +---------------------------------------+---------------------------------------+
    | http.51011a3008ce7eceba27c629f6d0020c | http.51011a3008ce7eceba27c629f6d0020c |
    | http.51011a3008ce7eceba27c629f6d0020c | http.0c50dd904347c71a74057d92d43fabfd |
    | http.51011a3008ce7eceba27c629f6d0020c | http.42cca9662c49459278ebb0e3b33aa7de |
    | http.51011a3008ce7eceba27c629f6d0020c | http.21da6d8b64c5fd26ab97c5bb6883fb22 |
    | http.51011a3008ce7eceba27c629f6d0020c | http.8c112bfdf052b37ef7b3d7669e876016 |
    | http.51011a3008ce7eceba27c629f6d0020c | http.4d4000cc34d85ed753b33a577dc5cc17 |
    | http.51011a3008ce7eceba27c629f6d0020c | http.44b0675c55963e5c4763826e6f085e4a |
    | http.51011a3008ce7eceba27c629f6d0020c | http.a8b3658223c079f02534583e7c352d78 |
    | http.51011a3008ce7eceba27c629f6d0020c | http.06d570c3ef88dd445002cb6350a07ae8 |
    | http.51011a3008ce7eceba27c629f6d0020c | http.f6b73caec1e59a47fba5f99a8f1c6c3c |
    +---------------------------------------+---------------------------------------+
    10 rows in set (0.02 sec)

[QuerySymbol.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/QuerySymbol.php) is a command-line tool that creates a Store then executes querySymbol to get the canons and symbols matching a given symbol:

    $ php profile/QuerySymbol.php 'mysql:host=127.0.0.1;port=3306;charset=utf8' table1 testuser testpass testdb http.51011a3008ce7eceba27c629f6d0020c
    http.005509ae59283ec9b3319b38b7b723f3
    http.0432782962991acd785fb48e53b2d792
    http.05884c546f6e21a59d42dcdef06b156b
    ...

[ShellTimer.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/ShellTimer.php) calculates the execution time of a shell command, executed using PHP [exec](http://php.net/manual/en/function.exec.php) and [microtime](http://php.net/manual/en/function.microtime.php). For example, using [Shell.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/Shell.php), which is a command-line tool that uses ShellTimer, the execution time of QuerySymbol.php can be calculated:

    $ php profile/Shell.php "php profile/QuerySymbol.php 'mysql:host=127.0.0.1;port=3306;charset=utf8' table1 testuser testpass testdb http.51011a3008ce7eceba27c629f6d0020c 2>&1"
    http.005509ae59283ec9b3319b38b7b723f3
    http.0432782962991acd785fb48e53b2d792
    http.05884c546f6e21a59d42dcdef06b156b
    ... 
    0.0453

[CurlTimer.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/CurlTimer.php) issues an HTTP GET request against a given URL and calculates the execution time. It uses PHP [curl](http://php.net/manual/en/book.curl.php) and microtime. For example, using [Curl.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/Curl.php), which is a command-line tool that uses CurlTimer:

    $ php profile/Curl.php http://127.0.0.1/sameas-lite/datasets/test/symbols/http.51011a3008ce7eceba27c629f6d0020c 
    <!DOCTYPE html>
    <html lang="en">
    ...
          <div class="container">
    <pre>http.005509ae59283ec9b3319b38b7b723f3
    http.0432782962991acd785fb48e53b2d792
    http.05884c546f6e21a59d42dcdef06b156b
    http.067bcc387a3fcc99ec9dd0c91bffea5b
    </html>
    0.0376

[Benchmark.php](https://github.com/softwaresaved/sameas-lite/blob/profile_master/profile/Benchmark.php) serves as a simple benchmarking harness. It works as follows:

* Populate MySQL table with pseudo-random data using \SameAsLite\MySqlDataCreator.
* Picks two canon-symbol pairs from the data.
* Invoke ShellTimer to time execution of QuerySymbol.php for each canon and symbol in the pairs (in the order pair1(canon, pair2(symbol, pair1(symbol), pair2(canon)). As each canon and symbol in each pair is requested N times, N * 4 times are collected.
* Invoke CurlTimer to time execution of an HTTP GET against the REST endpoint corresponding to Store->querySymbol, for each canon and symbol in the pairs.
* For each timer, calculate the sum, average, standard deviation, minimum and maximum of the times and print these.

For example, using a table of 100 canons with 100 symbols per canon, and iterating 100 times:

    $ php profile/Benchmark.php 'mysql:host=127.0.0.1;port=3306;charset=utf8' table1 testuser testpass testdb profile/QuerySymbol.php http://127.0.0.1/sameas-lite/datasets/test/symbols 100 100
    Average(s),StdDev(s),Total(s),Min(s),Max(s),Count,Run
    0.03216,0.00514,12.86281,0.02689,0.07603,400,shell
    0.02156,0.00486,8.62208,0.01736,0.06906,400,curl

The profile_master branch was merged into dbsubclass. The only change required was to [QuerySymbol.php](https://github.com/softwaresaved/sameas-lite/blob/dbsubclass/profile/QuerySymbol.php) which, in this branch, uses MySqlStore rather than Store.

### Benchmarking platform

The platform used was virtual machine image of [Ubuntu](http://www.ubuntu.com/) 14.04.1, 64-bit operating systems configured with 1 GB RAM and 20 GB hard disk. The images were run on a Dell Latitude E7440:

* 64-bit Intel Core i5-4310U CPU 2GHz, 2.60GHz 2 core.
* 8GB RAM.
* 185GB hard disk.
* Windows 7 Enterprise Service Pack 1.

The virtual machine image ran under [VMware Player](http://www.vmware.com/uk/products/player) 6.0.3. The host Dell was disconnected from the network and not in use for any other purpose during the benchmarking.

### Results

Benchmark.php was run in the profile_master branch, using the default Store, and the dbsubclass branch, using the MySqlStore sub-class (and its Store abstract super-class). The results were as follows:

ShellTimer:

| Branch | Average(s) | StdDev(s) | Total(s) | Min(s) | Max(s) | Count |
| ------ | ---------- | --------- | -------- | ------ | ------ | ----- |
| profile_master | 0.03105 | 0.00440 | 12.41844 | 0.02556 | 0.05302 | 400 |
| dbsubclass | 0.03120 | 0.00409 | 12.48185 | 0.02707 | 0.05759 | 400 |

CurlTimer:

| Branch | Average(s) | StdDev(s) | Total(s) | Min(s) | Max(s) | Count |
| ------ | ---------- | --------- | -------- | ------ | ------ | ----- |
| profile_master | 0.02104 | 0.00423 | 8.41461 | 0.01770 | 0.08079 | 400 |
| dbsubclass | 0.02123 | 0.00483 | 8.49046 | 0.01703 | 0.09137 | 400 |

As can be seen, the difference in performance is down at the sub-milli-second level. The impact of using sub-classes rather than conditionals is minimal.

Raw data is in the [data](./data) directory, in the .dat files.

### Profiling a stand-alone tool

[Xdebug](http://xdebug.org/) is a profiler and code analyser for PHP. It can be used to create data on the time spent in various PHP functions. Times are reported as 1,000,000-ths of a second.

Xdebug was enabled for PHP usage via the command-line. The following command was run, both within profile_master and dbsubclass branches, to provide profiling data on this tool that uses \SameAsLite\Store:

    $ php profile/QuerySymbol.php 'mysql:host=127.0.0.1;port=3306;charset=utf8' table1 testuser testpass testdb http.51011a3008ce7eceba27c629f6d0020c

Raw data is in the [data](./data) directory, in data/master/cachegrind.cli.out and data/dbsubclass/cachegrind.cli.out.

[KCachegrind](http://kcachegrind.sourceforge.net/html/Home.html) is an open source profile data visualization tool. It can visualise Xdebug profiling data. 

This [screen shot](./data/kcachegrind/QuerySymbol/querySymbol.jpg) shows the Callee Maps of the percentage of time spent within \SameAsLite\Store->querySymbol when running QuerySymbol.php. profile_master is on the left, dbclass on the right. For both, the dominant time is spent within PDO->construct and other PDO classes rather than Store-related code and the percentage of time is comparable across both branches.

However, looking at the total time to execute QuerySymbol.php, which is shown in this [screen shot](./data/kcachegrind/QuerySymbol/total.jpg), it can be seen that a far greater percentage of overall execution time is spent within:

    require_once::/var/www/html/sameaslite/vendor/autoload.php

One difference between the two branches is that profile_master contains 2 source files:

    $ ls -sh1 src/
    total 84K
    40K Store.php
    44K WebApp.php

whereas dbsubclass contains 5 source files, collectively larger:

    $ ls -sh1 src/
    total 100K
    8.0K MySqlStore.php
    8.0K SqLiteStore.php
    4.0K StoreFactory.php
     36K Store.php
     44K WebApp.php

In dbsubclass, SqLiteStore.php, StoreFactory.php and WebApp.php, which are unused by QuerySymbol.php were deleted and QuerySymbol.php re-run. Raw data is data/dbsubclass/cachegrind.cli.nounusedfiles.out. Looking again at the total time to execute QuerySymbol.php, which is shown in this [screen shot](./data/kcachegrind/QuerySymbol/total_minus_unecessary_source.jpg), it can be seen that, by removing unused files, the percentage of time occupied by autoload.php is far reduced.

### Profiling the web application

Xdebug was enabled for PHP usage via Apache 2. The following command was run, both within profile_master and dbsubclass branches, to provide profiling data on a sameAs Lite service that uses \SameAsLite\Store:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http.51011a3008ce7eceba27c629f6d0020c

Raw data is in the [data](./data) directory, in data/master/cachegrind.apache.out and data/dbsubclass/cachegrind.apache.out

Looking at the total time to service the request within Apache 2, which is shown in this [screen shot](./data/kcachegrind/Curl/total.jpg), it can be seen that, again, a far greater percentage of overall execution time is spent within:

    require_once::/var/www/html/sameaslite/vendor/autoload.php

Again, unused classes were removed and curl rerun. The raw data is in data/dbsubclass/cachegrind.apache.nounusedfiles.out. Looking again at the total time to service the request, which is shown in this [screen shot](./data/kcachegrind/Curl/total_minus_unecessary_source.jpg), it can be seen that the percentage of time occupied by autoload.php is again far reduced. In both cases, the percentage of time spent within autoload.php is exceeded that that spent within the web application as a whole.

Looking at the time spent within sameAs Lite-specific code, this [screen shot](./data/kcachegrind/Curl/sameas_classes.jpg) shows that the percentage of time spent within this code is comparable across profile_master (top left) and dbsubclass (bottom left). In addition, the time spent within Store is insignificant when set against the time spent within WebApp, notably the time taken to convert the output data to HTML (see for example, top right and bottom right).

### Conclusion

It can be concluded that there is very little performance impact upon using sub-classes of Store for database products instead of a single Store class with conditionals for each product. For standalone applications there may be an impact upon the time taken to load classes, but this may be outweighted by the impact of third-party application-specific classes. For web applications, any overheads even here are a fraction of those incurred by the web application-specific code itself. The fraction of time spent within Store is a small fraction of that required to prepare responses for a client, for example.

---

## Database-agnostic tests

### Do not hard-code test database configuration

tests/phpUnit/StoreTest.php contains tests for src/Store.php. The tests can only be run using SQLite. For example, there is a hard-coded data source name (DSN):

    const DSN = 'sqlite:test.sqlite';

The test database should not be hard-coded, but configurable, so developers do not need to edit PHP code if any changes are required to the database configuration used by the tests.

### Design test classes so they are database-agnostic

Design test classes that use a database in such a way that they can run on all databases supported by sameAs Lite.

### Have test classes populate tables with the data they need

If test classes populate the database with the data they need themselves, rather than assume it's already been created out-of-band, then this can help both to make the test classes more portable and to make automation of test execution easier.

### Use setUp and tearDown functions

When testing using databases, problems that can arise if one test function fails midway and leaves the database in a state that then causes other tests to fail, because the database is not in a state they expect (e.g. a test may find less or more rows in a table than expected, as the previously-executed test did not complete).

PHPUnit, like many test frameworks, suports setUp and tearDown functions. setUp is invoked prior to each test function and tearDown after each test function. When testing databases, these functions can help ensure that the database is in a known state prior to each test function. It also means that no assumptions need be made as to the order in which test functions in a class are run.

### Write tests that use the database

StoreTest.php defines 4 tests. These tests pass even if sqlite3 is not available:

    $ sqlite3
    -su: /usr/bin/sqlite3: No such file or directory
    $ sqlite
    The program 'sqlite' is currently not installed. You can install it by typing: apt-get install sqlite
    $ make tests
    # run tests
    vendor/bin/phpunit --bootstrap vendor/autoload.php tests/phpUnit/
    PHPUnit 4.6.2 by Sebastian Bergmann and contributors.

    ....

    Time: 32 ms, Memory: 3.00Mb

    OK (4 tests, 4 assertions)

Provide tests for Store.php that invoke operations that result in the database being used.

### Example

An example is in the [tests](https://github.com/softwaresaved/sameas-lite/tree/tests) branch of https://github.com/softwaresaved/sameas-lite. The relevant files are:

* [Makefile](https://github.com/softwaresaved/sameas-lite/blob/tests/Makefile)
* [test-sqlite-config.xml](https://github.com/softwaresaved/sameas-lite/blob/tests/tests/phpUnit/test-sqlite-config.xml)
* [test-mysql-config.xml](https://github.com/softwaresaved/sameas-lite/blob/tests/tests/phpUnit/test-mysql-config.xml)
* [StoreTest.php](https://github.com/softwaresaved/sameas-lite/blob/tests/tests/phpUnit/StoreTest.php)

Provision of database configuration via a configuration file is enabled using phpUnit's [XML Configuration File](https://phpunit.de/manual/current/en/appendixes.configuration.html). This supports [Setting PHP INI settings, Constants and Global Variables](https://phpunit.de/manual/current/en/appendixes.configuration.html#appendixes.configuration.php-ini-constants-variables). For example:

    $ cat tests/phpUnit/test-sqlite-config.xml
    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit>
      <php>
        <var name="DB_DSN" value="sqlite:test.sqlite"/>
      </php>
    </phpunit>

    $ cat tests/phpUnit/test-mysql-config.xml
    <?xml version="1.0" encoding="UTF-8"?>
    <phpunit>
      <php>
        <var name="DB_DSN" value="mysql:host=127.0.0.1;dbname=testdb;port=3306;charset=utf8"/>
        <var name="DB_NAME" value="testdb"/>
        <var name="DB_USER" value="testuser"/>
        <var name="DB_PASSWORD" value="testpass"/>
      </php>
    </phpunit>
    
The configuration file is specified via phpUnit's `--configuration` command-line option:

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration tests/phpUnit/test-sqlite-config.xml tests/phpUnit/

    $ vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration tests/phpUnit/test-mysql-config.xml tests/phpUnit/

The values can be accessed within test classes via a `$GLOBALS` array:

    $this->dsn = $GLOBALS['DB_DSN'];
    if (array_key_exists('DB_NAME', $GLOBALS)) {
        $this->db_name = $GLOBALS['DB_NAME'];
    }
    if (array_key_exists('DB_USER', $GLOBALS)) {
        $this->user = $GLOBALS['DB_USER'];
    }
    if (array_key_exists('DB_PASSWORD', $GLOBALS)) {
        $this->password = $GLOBALS['DB_PASSWORD'];
    }

Makefile has been updated to use test-sqlite-config.xml by default.

PHPUnit's [DBUnit](https://phpunit.de/manual/current/en/database.html) extension provides classes that can help implement test classes that are database-agnostic. To use this requires that test classes extend \PHPUnit_Extensions_Database_TestCase:

    class StoreTest extends \PHPUnit_Extensions_Database_TestCase

and, that they implement two functions from this class, one to create a database connection:

    public function getConnection()
    {
        $this->pdo = new \PDO($this->dsn, $this->user, $this->password);
        $this->connection = $this->createDefaultDBConnection($this->pdo, $this->db_name);
        return $this->connection;
    }

and, one to create a data set:

    public function getDataSet()
    {
        return new \PHPUnit_Extensions_Database_DataSet_DefaultDataSet();
    }

DBUnit needs to be added to the sameAs Lite dependencies in composer.json:

    "phpunit/dbunit": "*",

The table to be used in the test is created from the test class name:

    $this->store_name = str_replace("\\","_",get_class());

A tearDown function is used to drop this table after each test:

    public function tearDown()
    {
        $this->pdo->exec("DROP TABLE IF EXISTS " . $this->store_name . ";");
        parent::tearDown();
    }

As a result, the database is always in a known state prior to each subsequent test.

StoreTest.php also has a new function, testAssertPair, that adds a canon-symbol pair to the database then checks, using Store's functions, that the database is in the expected state:

    public function testAssertPair()
    {
        $s = new Store($this->dsn, $this->store_name, $this->user, $this->password, $this->db_name);
        $s->assertPair("a", "b");

        $canons = $s->allCanons();
        $this->assertEquals(1, count($canons));
        $this->assertTrue(in_array("a", $canons));

        $symbols = $s->querySymbol("a");
        $this->assertEquals(2, count($symbols));
        $this->assertTrue(in_array("a", $symbols));
        $this->assertTrue(in_array("b", $symbols));

        $symbols = $s->querySymbol("b");
        $this->assertEquals(2, count($symbols));
        $this->assertTrue(in_array("a", $symbols));
        $this->assertTrue(in_array("b", $symbols));

        $canon = $s->getCanon("a");
        $this->assertEquals(1, count($canon));
        $this->assertTrue(in_array("a", $canon));

        $canon = $s->getCanon("b");
        $this->assertEquals(1, count($canon));
        $this->assertTrue(in_array("a", $canon));
    }

The tests branch has been merged into the dbsubclass branch. As part of this merge, the tests were updated to use StoreFactory:

* [StoreTest.php](https://github.com/softwaresaved/sameas-lite/blob/tests/tests/phpUnit/StoreTest.php)
