# sameAs Lite Source Code Review

Mike Jackson, The Software Sustainability Institute / EPCC, The University of Edinburgh

## Introduction

[sameAs.org](http://sameas.org) is a search engine for linked data that, if given a URI, returns URIs that are co-referent, should any be known to it. The engine searches information harvested from a number of sources. sameAs.org is maintained by [Seme4 Limited](http://www.seme4.com). [sameAs Lite](http://github.com/seme4/sameas-lite) is a refactored, free open source, version of the software that powers sameAs.org.

sameAs Lite is implemented as two [PHP](http://php.net/) libraries, one which implements the core storage management functionality, and one which implements a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) web application. These depend upon a number of other libraries and [PHP Composer](https://getcomposer.org/) is used for dependency management. 

This document contains miscellaneous observations on the sameAs Lite source code.

---

## Document MySQL configuration needed if using exportToFile or loadFromFile

The following Store.php functions use MySQL's LOAD DATA INFILE and SELECT ... INTO OUTFILE:

    public function exportToFile($file = null)
    public function loadFromFile($file)

These dump tables into files located on the server that is running MySQL. The database user needs to have the FILE privilege. If these functions are to be used then any information for deployers needs to describe how to set, view and remove this e.g.:

    USE mysql;
    GRANT FILE ON *.* TO 'testuser'@'127.0.0.1';
    SELECT Host,User,File_priv FROM user;
    REVOKE FILE ON *.* FROM 'testuser'@'127.0.0.1';

This also grants FILE privilege:

    GRANT ALL PRIVILEGES ON *.* TO 'testuser'@'127.0.0.1';

See the MySQL [GRANT](http://dev.mysql.com/doc/refman/5.6/en/grant.html) and [REVOKE](http://dev.mysql.com/doc/refman/5.6/en/revoke.html) commands and [FILE](
http://dev.mysql.com/doc/refman/5.6/en/privileges-provided.html#priv_file) privilege for details.

---

## Beware inaccurate comments and inconsistent naming

dumpStore returns an array of symbols indexed by canons:

    public function dumpStore()

But, restoreStore is described as:

    /**
     * Takes the output of dumpStore and adds it into this store
     *
     * Overwrites any existing values, leaving the others intact.
     * Assumes the source data is valid.
     *
     * @param string $file The file name of the source data to be asserted
     */
    public function restoreStore($file)

However, the two functions are not complementary.

---

## Comment rationale for duplicated code

Duplicated code occurs in numerous Store.php functions:

    // skip if we've already connected
    if ($this->dbHandle == null) {
      $this->connect();
    }

This may be more performant than a function to check whether a database connection exists. The rationale for this duplication should be added to the comments stating this, so it isn't refactored into a function.

---

## Remove presentation-specific functionality from Store.php

Most of the functions in Store.php return PHP data structures. For example, the following all return arrays of strings:

    public function querySymbol($symbol)
    public function search($string)
    public function allCanons()
    public function dumpStore()
    public function getCanon($symbol)

The following returns a string:

    private function queryGetCanon($symbol)

However, there are some functions construct HTML, rather than return PHP data structures. For example the following functions return arrays of HTML strings:

    public function listStores()
    public function statistics()
    public function analyse()

These presentation aspects should be decoupled from Store.php, being handled by WebApp.php, or another class introduced for this purpose, turning Store.php into a library that is independent of any specific input/output format or presentation. Comments on each of these functions:

    * TODO - think this should return a structured array containing the data

Similarly, these functions assume semi-structured data (e.g. an array of TAB-separated strings, each of which represents a canon-symbol pair):

    public function assertPairs(array $data)
    public function restoreStore($file)

Decoupling would impose a performance hit, for example, populating a PHP data structure with the results, then traversing this to convert it into a presentation format. Profiling could determine the impact of this and whether it is acceptable.

---

## Make index.php configurable

As an alternative to editing index.php, consider using a configuration file to declare database configuration information. For example, in [INI](http://en.wikipedia.org/wiki/INI_file) format:

    [VIAF]
    ; Database
    dsn = 'mysql:host=127.0.0.1;port=3306;charset=utf8'
    db = testdb
    user = testuser
    password = testpass
    store = webdemo
    ; Web interface
    shortname = VIAF
    fullname = Virtual International Authority File
    contact = Joe Bloggs
    email = Joe.Bloggs@acme.org
    
    [test]
    ; Database
    dsn = 'mysql:host=127.0.0.1;port=3306;charset=utf8'
    db = table1
    user = testuser
    password = testpass
    store = testdb
    ; Web interface
    shortname = Test Store
    fullname = Test store used for SameAs Lite development
    contact = Joe Bloggs
    email = Joe.Bloggs@acme.org

PHP has a [parse_ini_file](http://php.net/manual/en/function.parse-ini-file.php) function that can parse this format:

    <?php
    $filename=$argv[1];
    $stores_array = parse_ini_file($filename, true);
    print_r($stores_array);
    ?>

Running this gives:

    $ php parse_ini.php stores.ini
    Array
    (
        [VIAF] => Array
            (
                [dsn] => mysql:host=127.0.0.1;port=3306;charset=utf8
                [db] => testdb
                [user] => testuser
                [password] => testpass
                [store] => webdemo
                [shortname] => VIAF
                [fullname] => Virtual International Authority File
                [contact] => Joe Bloggs
                [email] => Joe.Bloggs@acme.org
            )
        [test] => Array
            (
                [dsn] => mysql:host=127.0.0.1;port=3306;charset=utf8
                [db] => table1
                [user] => testuser
                [password] => testpass
                [store] => testdb
                [shortname] => Test Store
                [fullname] => Test store used for SameAs Lite development
                [contact] => Joe Bloggs
                [email] => Joe.Bloggs@acme.org
            )
    )

Reading this file on every request may have implications for performance.

---

## Document how to handle Unicode and other character encodings

Certain data from sameAs.org contains accented characters e.g.

    $ curl http://sameas.org/json?uri=http%3A%2F%2Fdbpedia.org%2Fresource%2FEdinburgh

      "http://dbpedia.org/resource/Dùn_Èideann",
      "http://dbpedia.org/resource/Dùn_Éideann",

Or Unicode:

      "http://ar.dbpedia.org/resource/\u0625\u062F\u0646\u0628\u0631\u0629",

Any database, web server, or in-code configuration needed to handle such URIs should be documented.

---

## Support internationalization

Wikipedia defines [Internationalization](http://en.wikipedia.org/wiki/Internationalization_and_localization) as "the process of designing a software application so that it can potentially be adapted to various languages and regions without engineering changes." It might increase the appeal of sameAs Lite if it supported internationalization which could be applied to URL components, status and error messages.

PHP supports internationalization via [gettext](http://php.net/manual/en/book.gettext.php). A [PHP internationalization with gettext tutorial](http://blog.lingohub.com/2013/07/php-internationalization-with-gettext-tutorial/) is also available.

---

## Consider splitting the repository in future

At present, sameAs Lite consists of three files, with the following number of lines:

      100 index.php
      998 src/Store.php
     1259 src/WebApp.php

A question that has been raised is whether to host Store.php, the core library, within the same Git repository as the user interface code, WebApp.php and index.php. Moving to two repositories would reduce the repository footprint for developers wishing to use Store.php within their own applications. It would also help contribute to promoting Store.php as a stand-alone library that is decoupled from any presentation-specific concerns. 

One downside is that the number of supporting files would increase. Each repository would need its own Composer files, Makefile, README.md and supporting documentation. 

Given the compactness of sameAs Lite at present, I'd recommend keeping them within one repository for now but ensuring that source code and test code is developed in a modular way so that Store.php (and any of its test classes) can be pulled into a new repository, without either them, or WebApp.php, having to be recoded in any way.

---

## Update deployer and developer documentation.

Some of these recommendations, if adopted, would require updates to be made to the deployer and developer documentation.

---
