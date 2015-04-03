# sameAs Lite Deployer's Guide

This page describes how to deploy sameAs Lite and configure it to expose linked data stores.

The instructions have been written with reference to three 64-bit operating systems:

* [Ubuntu](http://www.ubuntu.com/) 14.04.1.
* [Scientific Linux](https://www.scientificlinux.org/) 7.0 (Nitrogen).
* [Fedora](https://getfedora.org/) workstation 21. 

Other operating systems, or versions of these, may differ in how packages are installed, the versions of these packages available from package managers etc. Consult the relevant documentation for your operating system and the products concerned.

These assume you have sudo access to install and configure access and that you have created a root shell using:

    $ sudo su -

---

## Install Apache 2

* Apache 2 is a popular web server.
* http://httpd.apache.org/

**Note:** These instructions assume the use of Apache 2.4 web server. Other versions of Apache 2, particularly Apache 2.2, differ in how they are installed, configured and managed. Consult the relevant documentation for your version of Apache 2.

### Ubuntu 14.04

Install:

    $ apt-get install apache2
    $ apache2 -v
    Server version: Apache/2.4.7 (Ubuntu)
    Server built:   Mar 10 2015 13:05:59

Visit http://127.0.0.1. You should see:

    Apache2 Ubuntu Default Page 

Install apache-utils, for htpasswd and other tools:

    $ apt-get install apache2-utils

### Scientific Linux 7

Apache is already provided:

    $ /usr/sbin/httpd -v
    Server version: Apache/2.4.6 (Scientific Linux)
    Server built:   Jul 23 2014 05:03:32

Start Apache and configure it to start automatically when the system is rebooted:

    $ systemctl restart httpd.service
    $ systemctl status httpd.service
    $ systemctl enable httpd.service

### Fedora 21

Apache is already provided:

    $ /usr/sbin/httpd -v
    Server version: Apache/2.4.10 (Fedora)
    Server built:   Sep  3 2014 14:49:30

Start Apache and configure it to start automatically when the system is rebooted:

    $ systemctl restart httpd.service
    $ systemctl status httpd.service
    $ systemctl enable httpd.service

---

## Install PHP

* PHP Hypertext Preprocessor executes code on a web server which generates HTML which is then sent to the client.
* http://php.net/ 

### Ubuntu 14.04

Install:

    $ apt-get install php5-common libapache2-mod-php5 php5-cli
    $ php --version
    PHP 5.5.9-1ubuntu4.7 (cli) (built: Mar 16 2015 20:47:39) 

### Scientific Linux 7

PHP is already provided:

    $ php --version
    PHP 5.4.16 (cli) (built: Sep 30 2014 05:06:36) 

### Fedora 21

Install:

    $ yum install php
    $ php --version
    PHP 5.6.7 (cli) (built: Mar 20 2015 06:12:07) 

### Check that PHP has installed correctly

Create /var/www/html/index.php:

    <html>
     <head>
      <title>PHP Test</title>
     </head>
     <body>
      <?php echo '<p>Hello World</p>'; ?> 
     </body>
    </html>

Visit http://127.0.0.1/index.php. You should see:

    Hello World

Add, within `<body>`:

    <?php phpinfo(); ?>

Refresh browser. You should see

    Hello World

followed by lots of configuration information.

---

## Install PHP modules

### Ubuntu 14.04

Install:

    $ apt-get install php5-xsl

### Scientific Linux 7 / Fedora 21

Install:

    $ yum install php-xml php-mbstring php-pdo

Restart Apache:

    $ systemctl restart httpd.service

---

## Install PHP Composer

* PHP Composer is a dependency manager for PHP.
* It is needed to install sameAs Lite PHP dependencies.
* https://getcomposer.org/ 

Install:

    $ php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin

The installation directory specified above is that assumed by sameAs Lite's Makefile:

* If you wish to use a different directory then provide a different value to --install-dir. 
* If you wish to use the current directory then leave out -- --install-dir=/usr/bin entirely.

Check it has installed:

    $ /usr/bin/composer.phar --version
    Composer version 1.0-dev (829199c0530ea131262c804924f921447c71d4e8) 2015-03-16 13:11:02

---

## Install curl

* Command line tool and library for interacting over HTTP(S).
* Useful for testing sameAs Lite deployments.

### Ubuntu 14.04

Install:

    $ apt-get install curl
    $ curl --version
    curl 7.35.0 (x86_64-pc-linux-gnu) libcurl/7.35.0 OpenSSL/1.0.1f zlib/1.2.8 libidn/1.28 librtmp/2.3

### Scientific Linux 7

curl is already provided:

    $ curl --version
    curl 7.29.0 (x86_64-redhat-linux-gnu) libcurl/7.29.0 NSS/3.15.4 zlib/1.2.7 libidn/1.28 libssh2/1.4.3

### Fedora 21

curl is already provided:

    $ curl --version
    curl 7.37.0 (x86_64-redhat-linux-gnu) libcurl/7.37.0 NSS/3.17.2 Basic ECC zlib/1.2.8 libidn/1.28 libssh2/1.4.3

---

## Install Git 

* Git is a popular distributed version control system.
* It is needed to get the sameAs Lite source code and install sameAs Lite PHP depencies.
* http://git-scm.com/

### Ubuntu 14.04

Install:

    $ apt-get install git
    $ git --version
    git version 1.9.1

### Scientific Linux 7

Git is already provided:

    $ git --version
    git version 1.8.3.1

### Fedora 21

Git is already provided:

    $ git --version
    git version 2.1.0

---

## Get sameAs Lite source code

* https://github.com/seme4/sameas-lite

Get source code:

    $ cd /var/www/html
    $ git clone https://github.com/seme4/sameas-lite
    $ cd sameas-lite

sameAs Lite assumes Composer is installed in /usr/bin/composer.phar. If you have installed Composer in another directory, then edit Makefile and update the value of C:

    C=/usr/bin/composer.phar

Install PHP runtime dependencies by running:

    $ make install
    # install libraries required to run
    /usr/bin/composer.phar update --no-dev
    Loading composer repositories with package information
    Updating dependencies
      - Installing ptlis/conneg (v3.0.0)
      - Installing slim/slim (2.6.2)
      - Installing slim/views (0.1.3)
      - Installing twig/twig (v1.18.0)
    Writing lock file
    Generating autoload files

---

## Configure .htaccess authentication

* .htaccess is a simple text file-based authentication for directory and file access.
* http://httpd.apache.org/docs/current/howto/htaccess.html

Add youself as a user to auth.htpasswd:

    $ htpasswd auth.htpasswd YOU
    New password: PASSWORD
    Re-type new password: PASSWORD

Edit .htaccess and change:

    AuthUserFile auth.htpasswd

to:

    AuthUserFile /var/www/html/sameas-lite/auth.htpasswd

Allow Apache to read these files:

    $ chmod 0644 .htaccess
    $ chmod 0644 auth.htpasswd

### Ubuntu 14.04

Edit /etc/apache2/sites-enabled/000-default.conf and add under:

    DocumentRoot /var/www/html

the following:

    <Directory "/var/www/html">
      AllowOverride All
    </Directory>

Enable rewriting, which is disabled by default in Apache 2 under Ubuntu:

    $ a2enmod rewrite

Restart Apache:

    $ service apache2 restart

### Scientific Linux 7 / Fedora 21

Edit /etc/httpd/conf/httpd.conf and, within:

    <Directory "/var/www/html">
      AllowOverride All
    </Directory>

Change:

      AllowOverride None

to:

      AllowOverride All

Restart Apache:

    $ systemctl restart httpd.service

### Check .htaccess is configured correctly

    $ cd /var/www/html/sameas-lite/
    $ cp .htaccess ..
    $ cd ..
    $ mkdir data

Create data/data.html:

    <html> 
     <head> 
      <title>.htaccess Test</title> 
     </head> 
     <body>This is a .htaccess test</body> 
    </html> 

</p>

    $ cp data/data.html .

Check expected behaviour of .htaccess by visiting these URLs:

| URL | Expected page |
| --- | ------------- |
| http://127.0.0.1/data.html | data.html |
| http://127.0.0.1/index.php | index.php |
| http://127.0.0.1/data/ | index.php |
| http://127.0.0.1/data/data.html | data/data.html |
| http://127.0.0.1/nodirectory | index.php |
| http://127.0.0.1/nofile.php | index.php |
| http://127.0.0.1/config.ttl | user name/password prompt then index.php |

Clean up:

    $ rm .htaccess
    $ rm data.html
    $ rm -rf data/

**Troubleshooting - Could not open password file**

If /var/log/apache2/error.log shows:

    [Thu Mar 19 09:24:28.947228 2015] [authn_file:error] [pid 20993]
    (2)No such file or directory: [client 127.0.0.1:59950] AH01620: Could
    not open password file: /etc/apache2/auth.htpasswd

Then it may be that you did not:

* Set the .htaccess and auth.htpasswd file permissions
* Update .htaccess to specify the absolute path to auth.htpasswd

---

## Check sameAs Lite is available

Visit http://127.0.0.1/sameas-lite/. You should see the sameAs Lite user interface.

Visit http://127.0.0.1/sameas-lite/config.ttl:

* You should be prompted for user name and password then redirected to index.php.
* If not then clear your browser cache and try again.

---

## Install SQLite 3.8.2+

* http://www.sqlite.org/ 

### Ubuntu 14.04

Install:

    $ apt-get install sqlite3
    $ sqlite3 --version
    3.8.2 2013-12-06 14:53:30 27392118af4c38c5203a04b8013e1afdb1cebd0d

Install PHP SQLite module:

    $ apt-get install php5-sqlite

Restart Apache:

    $ service apache2 restart

### Scientific Linux 7

**Note:** the default version of SQLite 3, 3.7.17, cannot be used with sameAs Lite. sameAs Lite uses a [WITHOUT ROWID](https://www.sqlite.org/withoutrowid.html) optimisation which is only available in SQLite 3.8.2 and beyond/

    $ sqlite3 --version
    3.7.17 2013-05-20 00:56:22 118a3b35693b134d56ebd780123b7fd6f1497668

### Fedora 21

SQLite 3.8.2 and its PHP module are already provided: 

    $ sqlite3 --version
    3.8.7 2014-10-17 11:24:17 e4ab094f8afce0817f4074e823fabe59fc29ebb4

---

## Install MySQL

* MySQL is a popular database management system.
* http://www.mysql.com 
* MariaDB is a fork of MySQL.
* https://mariadb.org/

## Ubuntu 14.04

Install:

    $ apt-get install mysql-server 

You will be prompted for a root password for the MySQL server.

    $ mysql --version
    mysql  Ver 14.14 Distrib 5.5.41, for debian-linux-gnu (x86_64) using readline 6.3

Complete installation:

     $ mysql_install_db
     $ /usr/bin/mysql_secure_installation

When prompted, provide the following responses:

     Enter current password for root (enter for none): PASSWORD
     Change the root password? [Y/n] n
     Remove anonymous users? [Y/n] y
     Disallow root login remotely? [Y/n] y
     Remove test database and access to it? [Y/n] y
     Reload privilege tables now? [Y/n] y

Check status:

    $ service mysql status
    mysql start/running, process 38506

Install PHP MySQL module:

    $ apt-get install php5-mysql

Restart Apache:

    $ service apache2 restart

## Scientific Linux 7 / Fedora 21

Install:

    $ yum install mariadb-server mariadb

You will be prompted for a root password for the MySQL server.

    $ mysql --version
    mysql  Ver 15.1 Distrib 5.5.41-MariaDB, for Linux (x86_64) using readline 5.1

Complete installation:

    $ mysql_install_db
    $ systemctl start mariadb
    $ systemctl status mariadb
    $ /usr/bin/mysql_secure_installation
    $ /usr/bin/mysql_secure_installation

When prompted, provide the following responses:

     Enter current password for root (enter for none): PASSWORD
     Change the root password? [Y/n] n
     Remove anonymous users? [Y/n] y
     Disallow root login remotely? [Y/n] y
     Remove test database and access to it? [Y/n] y
     Reload privilege tables now? [Y/n] y

Check status:

    $ systemctl status mariadb

Install PHP MySQL module:

    $ yum install php-mysql

Restart Apache:

    $ systemctl restart httpd.service

Allow Apache services to connect to the database management system:

    $ setsebool -P httpd_can_network_connect_db=1

---

## Create a sample data store

Here we describe how to set up a small sample data store you can use to check your sameAs Lite deployment.

### Populate MySQL with sample data

Create a file, create_mysql_db.sql, with SQL commands to create a database, user and password:

    create database testdb;
    create user 'testuser'@'127.0.0.1' identified by 'testpass';
    grant all privileges on *.* to 'testuser'@'127.0.0.1';
    flush privileges;

This corresponds to a test data store already specified in index.php.

Execute these SQL statements in MySQL:

    $ mysql -u root -p < create_mysql_db.sql

Create a file, create_mysql_table.sql, with SQL commands to create a table of sample data:

    use testdb;
    create table if not exists table1 (canon VARCHAR(256), symbol VARCHAR(256), PRIMARY KEY (symbol), INDEX(canon)) ENGINE = MYISAM;
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://www.wikidata.org/entity/Q23436");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://dbpedia.org/resource/Embra");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://data.nytimes.com/edinburgh_scotland_geo");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://sws.geonames.org/2650225/");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482");

    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://www.wikidata.org/entity/Q220966");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://dbpedia.org/resource/Soton");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://data.nytimes.com/southampton_england_geo");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://data.ordnancesurvey.co.uk/id/50kGazetteer/218013");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://sws.geonames.org/1831142/");

    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://www.wikidata.org/entity/Q6940372");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://dbpedia.org/resource/Manc");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://data.nytimes.com/manchester_england_geo");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://data.ordnancesurvey.co.uk/id/50kGazetteer/155254");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://sws.geonames.org/524894/");

Execute these SQL statements in MySQL:

    $ mysql -u root -p < create_mysql_table.sql 

### Populate SQLite with sample data

Create a file, create_sqlite_table.sql, with SQL commands to create a table of sample data:

    create table if not exists table1 (canon TEXT, symbol TEXT PRIMARY KEY) WITHOUT ROWID;
    create index if not exists table1_idx on table1 (canon);
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://www.wikidata.org/entity/Q23436");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://dbpedia.org/resource/Embra");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://data.nytimes.com/edinburgh_scotland_geo");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://sws.geonames.org/2650225/");
    insert into table1 values("http://www.wikidata.org/entity/Q23436", "http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482");

    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://www.wikidata.org/entity/Q220966");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://dbpedia.org/resource/Soton");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://data.nytimes.com/southampton_england_geo");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://data.ordnancesurvey.co.uk/id/50kGazetteer/218013");
    insert into table1 values("http://www.wikidata.org/entity/Q220966", "http://sws.geonames.org/1831142/");

    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://www.wikidata.org/entity/Q6940372");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://dbpedia.org/resource/Manc");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://data.nytimes.com/manchester_england_geo");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://data.ordnancesurvey.co.uk/id/50kGazetteer/155254");
    insert into table1 values("http://www.wikidata.org/entity/Q6940372", "http://sws.geonames.org/524894/");

Execute these SQL statements in SQLite. If necessary, replace /var/www/sameasdb.sq3 with a path and file name that is consistent with your file system.

    $ sqlite3 /var/www/sameasdb.sq3 < create_sqlite_table.sql 

---

## Expose a data store

index.php specifies data stores. For each data store, there is both database management system information and user interface information. 

Database management system information includes:

* Connection URL e.g. 
  - mysql:host=127.0.0.1;port=3306;charset=utf8
  - sqlite:/var/www/sameasdb.sq3
* Data store name - used for tables e.g. webdemo
* User e.g. testuser. Optional for databases that don't support users e.g. SQLite.
* Password e.g. testpass. Optional for databases that don't support users e.g. SQLite.
* Database name e.g. testdb. This may be empty for database management systems that only support a single database e.g. SQLite.

User interface information:

* Slug, or nickname e.g. VIAF. This must be unique within your sameAs Lite deployment.
* ShortName e.g. => VIAF
* FullName e.g. => Virtual International Authority File
* Contact e.g. => Joe Bloggs
* Email e.g. => Joe.Bloggs@acme.org

### Expose a MySQL data store

You can skip this step if using the sample MySQL data store.

Edit index.php and add a new entry for your MySQL database e.g.:

    $app->addDataset(
        new \SameAsLite\Store(
            'mysql:host=127.0.0.1;port=3306;charset=utf8',
            'table1',
            'testuser',
            'testpass',
            'testdb'
        ),
        array(
            'slug'      => 'test',
            'shortName' => 'Test Store',
            'fullName'  => 'Test store used for SameAs Lite development',
            'contact' => 'Joe Bloggs',
            'email'   => 'Joe.Bloggs@acme.org'
        )
    );

Update all the values to be consistent with your MySQL deployment.

Make sure the slug is unique. There should be no other data stores in index.php with the same slug.

### Expose an SQLite data store

Edit index.php and add a new entry for your SQLite database e.g.:

    $app->addDataset(
        new \SameAsLite\Store(
            'sqlite:/var/www/sameasdb.sq3',
            'table1'
        ),
        array(
            'slug'      => 'testsqlite',
            'shortName' => 'Test SQLite Store',
            'fullName'  => 'Test SQLite store used for SameAs Lite development',
            'contact' => 'Joe Bloggs',
            'email'   => 'Joe.Bloggs@acme.org'
        )
    );

Update all the values to be consistent with your SQLite deployment.

The path specified in:

    'sqlite:/var/www/sameasdb.sq3',

must be an absolute path to a directory. sameAs Lite will create the database file (e.g. sameasdb.sq3) if it does not already exist.

Make sure the slug is unique. There should be no other data stores in index.php with the same slug.

**Ubuntu 14.04**

Ensure that the Apache user, www-data, is able to read and write files in the directory which holds the database file. One way of doing this is to make www-data the owner of this directory e.g.:

    $ chown www-data:www-data /var/www/

**Scientific Linux 7 / Fedora 21**

Ensure that the Apache user, apache, is able to read and write files in the directory which holds the database file. One way of doing this is to make apache the owner of this directory e.g.:

    $ chown apache:apache /var/www/

---

## Check a data store has been deployed

Visit http://127.0.0.1/sameas-lite/.

Click DATASETS. You should see the short name of your data store listed.

Visit http://127.0.0.1/sameas-lite/datasets/SLUG/status?_METHOD=GET&store=test, where SLUG is the slug associated with your data store. You should see a summary page like:

    Statistics for sameAs store TABLE:
    N    symbols
    M    bundles

For example, if using the MySQL or SQLite sample data stores then visit:

* MySQL, http://127.0.0.1/sameas-lite/datasets/test/status?_METHOD=GET&store=test
* SQLite, http://127.0.0.1/sameas-lite/datasets/testsqlite/status?_METHOD=GET&store=test 

You should see:

    Statistics for sameAs store table1:
    15   symbols
    3    bundles

**Troubleshooting - Can't connect to MySQL server on '127.0.0.1'**

If the user interface shows a message like:

    SQLSTATE[HY000] [2003] Can't connect to MySQL server on '127.0.0.1' (111)

then check:

* Database management system is running.
* index.php specifies a valid connection URL, database, username and password.
* For Scientific Linux 7 / Fedora 21 Apache services are allowed to connect to networked databases (you have run setsebool). See StackOverflow, [php can't connect to mysql with error 13 (but command line can)](http://stackoverflow.com/questions/4078205/php-cant-connect-to-mysql-with-error-13-but-command-line-can).

**Troubleshooting - Unable to to connect to mysql could not find driver**

If the user interface shows a message like:

    Unable to to connect to mysql
     could not find driver

then you need to install php5-mysql or php-mysql and also restart Apache. 

**Troubleshooting - Unable to to connect to sqlite**

If the user interface shows a message like:

    SQLSTATE[HY000] [14] unable to open database file

then check that:

* Apache user, www-data or apache, has read/write access to the directory holding the database file.
* index.php specifies a valid directory and file path.

---

## Check the REST API

### List the canons

Run the following, where SLUG is the slug associated with your data store:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/SLUG/canons

You should see a list of the canons in your data store. For example, for the MySQL and SQLite sample data stores:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ["http:\/\/www.wikidata.org\/entity\/Q220966","http:\/\/www.wikidata.org\/entity\/Q23436","http:\/\/www.wikidata.org\/entity\/Q6940372"]

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/testsqlite/canons
    ...

### List the URI pairs

Run the following, where SLUG is the slug associated with your data store:

    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/SLUG/pairs

You should see a list of all the URI pairs in your data store. For example, for the MySQL and SQLite sample data stores: 

    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    canon,symbol
    http://www.wikidata.org/entity/Q220966,http://data.nytimes.com/southampton_england_geo
    http://www.wikidata.org/entity/Q220966,http://data.ordnancesurvey.co.uk/id/50kGazetteer/218013
    http://www.wikidata.org/entity/Q220966,http://dbpedia.org/resource/Soton
    http://www.wikidata.org/entity/Q220966,http://sws.geonames.org/1831142/
    http://www.wikidata.org/entity/Q220966,http://www.wikidata.org/entity/Q220966
    http://www.wikidata.org/entity/Q23436,http://data.nytimes.com/edinburgh_scotland_geo
    ...

    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/testsqlite/pairs
    ...

### Search for URI pairs

Run the following, where SLUG is the slug associated with your data store, and PATTERN is a text fragment you know at least one of your URIs in your data store matches:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/SLUG/canons

You should see an HTML page with a list of the matching URIs in your data store. For example, for the MySQL and SQLite sample data stores:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/search/embra

    <ul>
        <li><a href="http://data.nytimes.com/edinburgh_scotland_geo">http://data.nytimes.com/edinburgh_scotland_geo</a></li>
        <li><a href="http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482">http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482</a></li>
        <li><a href="http://dbpedia.org/resource/Embra">http://dbpedia.org/resource/Embra</a></li>
        <li><a href="http://sws.geonames.org/2650225/">http://sws.geonames.org/2650225/</a></li>
        <li><a href="http://www.wikidata.org/entity/Q23436">http://www.wikidata.org/entity/Q23436</a></li>
    </ul>

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/testsqlite/search/embra
    ...
