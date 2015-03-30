# sameAs Lite Deployer's Guide

How to deploy sameAs Lite and configure it to expose linked data stores.

**Note:** These instructions apply to a deployment of sameAs Lite on Ubuntu 14.10. Other operating systems may differ in how packages are installed, the versions of these packages. Consult the relevant documentation for your operating system.

---

## Install Apache 2

* Apache 2 is a popular web server.
* http://httpd.apache.org/

**Note:** These instructions assume the use of Apache 2.4 web server. Other versions of Apache 2, particularly Apache 2.2, differ in how they are installed, configured and managed. Consult the relevant documentation for your version of Apache 2.

Install:

    $ sudo apt-get install apache2
    $ apache2 -v
    Server version: Apache/2.4.7 (Ubuntu)
    Server built:   Mar 10 2015 13:05:59

Visit http://127.0.0.1 and you should see:

    Apache2 Ubuntu Default Page 

Install apache-utils, for htpasswd and other tools:

    $ sudo apt-get install apache2-utils

---

## Install PHP

* PHP Hypertext Preprocessor executes code on a web server which generates HTML which is then sent to the client.
* http://php.net/ 

Install:

    $ sudo apt-get install php5-common libapache2-mod-php5 php5-cli

To check that PHP is installed, create /var/www/html/index.php:

    <html>
     <head>
      <title>PHP Test</title>
     </head>
     <body>
      <?php echo '<p>Hello World</p>'; ?> 
     </body>
    </html>

Visit http://127.0.0.1/index.php and you should see:

    Hello World

Add, within `<body>`:

    <?php phpinfo(); ?>

Refresh browser and you should see:

    Hello World
    PHP Version 5.5.9-1ubuntu4.7
    ...

---

## Install PHP modules

Install XSL module:

    $ apt-get install php5-xsl

---

## Install PHP Composer

* PHP Composer is a dependency manager for PHP.
* It is needed to install sameAs Lite PHP dependencies.
* https://getcomposer.org/ 

Install:

    $ php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin

The installation directory specified above is that assumed by sameAs Lite's Makefile:

* If you wish to use a different directory then provide a different value to `--install-dir`. 
* If you wish to use the current directory then leave out `-- --install-dir=/usr/bin` entirely.

Check it has installed:

    $ /usr/bin/composer.phar --version
    Composer version 1.0-dev (829199c0530ea131262c804924f921447c71d4e8) 2015-03-16 13:11:02

---

## Install curl

* Command line tool and library for interacting over HTTP(S).
* Useful for testing sameAs Lite deployments.

Install:

    $ apt-get install curl
    $ curl --version
    curl 7.35.0 (x86_64-pc-linux-gnu) libcurl/7.35.0 OpenSSL/1.0.1f zlib/1.2.8 libidn/1.28 librtmp/2.3

---

## Install Git 

* Git is a popular distributed version control system.
* It is needed to get the sameAs Lite source code and install sameAs Lite PHP depencies.
* http://git-scm.com/

Install:

    $ sudo apt-get install git
    $ git --version
    git version 1.9.1

---

## Get sameAs Lite source code

* https://github.com/seme4/sameas-lite

Get source code:

    $ cd /var/www/html
    $ git clone https://github.com/seme4/sameas-lite
    $ cd sameas-lite

sameAs Lite assumes Composer is installed in `/usr/bin/composer.phar`. If you have installed Composer in another directory, then edit Makefile and update the value of C:

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

To check that .htaccess authentication is set up correctly, set up some sample files, and use the sameAs Lite htaccess files:

    $ sudo su -
    $ cp .htaccess ..
    $ cp auth.htpasswd ..
    $ cd ..
    $ mkdir data
    $ cp index.html data/data.html

Add a new user to auth.htpasswd:

    $ htpasswd auth.htpasswd YOU
    New password: PASSWORD
    Re-type new password: PASSWORD

Edit .htaccess and change:

    AuthUserFile auth.htpasswd

to:

    AuthUserFile /var/www/html/auth.htpasswd

Allow Apache to read these files:

    $ chmod 0644 .htaccess
    $ chmod 0644 auth.htpasswd

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

Check expected behaviour of .htaccess by visiting these URLs:

| URL | Expected page |
| --- | ------------- |
| http://127.0.0.1/index.html | index.html |
| http://127.0.0.1/index.php | index.php |
| http://127.0.0.1/data/ | index.php |
| http://127.0.0.1/data/data.html | data/data.html |
| http://127.0.0.1/nodirectory | index.php |
| http://127.0.0.1/nofile.php | index.php |
| http://127.0.0.1/config.ttl | user name/password prompt then index.php |

Clean up:

    $ rm .htaccess
    $ rm auth.htpasswd
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

## Configure sameAs Lite for Apache

    $ cd /var/www/html/sameas-lite

Edit .htaccess and change:

    AuthUserFile auth.htpasswd

to:

    AuthUserFile /var/www/html/sameas-lite/auth.htpasswd

Visit http://127.0.0.1/sameas-lite/ and you should see the sameAs Lite user interface.

Visit http://127.0.0.1/sameas-lite/config.ttl:

* You should be prompted for user name and password then redirected to index.php.
* If not then clear your browser cache and try again.

---

## Install SQLite

* http://www.sqlite.org/ 

Install:

    $ apt-get install sqlite3

Install PHP SQLite module:

    $ apt-get install php5-sqlite

TODO describe how to install/configure sameAs Lite to use SQLite.

---

## Install MySQL

* MySQL is a popular database management system.
* http://www.mysql.com 

Install:

    $ apt-get install mysql-server 

You will be prompted for a root password for the MySQL server.

    $ mysql --version
    mysql  Ver 14.14 Distrib 5.5.41, for debian-linux-gnu (x86_64) using readline 6.3

Complete installation:

     $ mysql_install_db
     $ sudo /usr/bin/mysql_secure_installation

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

---

## Configure sameAs Lite to expose a sample linked data store in MySQL

index.php specifies datasets. For each dataset, there is both database information and user interface information.

Database management system information, passed to \SameAsLite\Store_construct (in src/Store.php):

* URL e.g. mysql:host=127.0.0.1;port=3306;charset=utf8
* Data store name - used for tables e.g. webdemo
* User e.g. testuser
* Password e.g. testpass
* Database name e.g. testdb. This may be empty for database management systems that only support a single database.

User interface information, passed as an array to to \SameAsLite\WebApp->addDataset (in src/WebApp.php):

* Slug e.g. VIAF
* ShortName e.g. => VIAF
* FullName e.g. => Virtual International Authority File
* Contact e.g. => Joe Bloggs
* Email e.g. => Joe.Bloggs@acme.or

TODO remove the PHP class information.

Create a file, create_mysql_testdb.sql, with SQL commands to create a test database and user:

    create database testdb;
    create user 'testuser'@'localhost' identified by 'testpass';
    grant all privileges on *.* to 'testuser'@'localhost';
    flush privileges;

This corresponds to a data store specified in index.php.

Execute these SQL statements in MySQL:

    $ mysql -u root -p < create_mysql_testdb.sql

Create a file, create_mysql_testtable.sql, with SQL commands to create a table of sample data:

    use testdb;
    create table if not exists table1 (canon VARCHAR(256), symbol VARCHAR(256), PRIMARY KEY (symbol), INDEX(canon)) ENGINE = MYISAM;
    insert into table1 values("canon1","symbol1");
    insert into table1 values("canon1","symbol2");
    insert into table1 values("canon2","symbol3");

Execute these SQL statements in MySQL:

    $ mysql -u root -p < create_mysql_testtable.sql 

TODO come up with a better data set!

Visit http://127.0.0.1/sameas-lite/datasets/test/status?_METHOD=GET&store=test and you should see:

    Statistics for sameAs store table1:
    3    symbols
    2    bundles

TODO add what to look for in user interface to check deployment.

**Troubleshooting - Can't connect to MySQL server on '127.0.0.1'**

If the user interface shows a message like:

    SQLSTATE[HY000] [2003] Can't connect to MySQL server on '127.0.0.1' (111)

then check:

* Database management system is running.
* index.php specifies a valid connection URL, database, username and password.

**Troubleshooting - Unable to to connect to mysql could not find driver**

If the user interface shows a message like:

    Unable to to connect to mysql
     could not find driver

then you need to install php5-mysql.

---

## Configure sameAs Lite to expose a sample linked data store in SQLite

TODO describe how to install/configure sameAs Lite to use SQLite.

---
