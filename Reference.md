# sameAs Lite Deployer and Developer Reference

This page summarises short-cuts, commands, and information of use to sameAs Lite deployers and developers.

All commands assume sudo access.

---

## LAMP

* Linux
* Apache
* MySQL
* PHP

---

## Apache 2.4

Manage Apache:

    $ service apache2 stop
    $ service apache2 start
    $ service apache2 restart

    $ /etc/init.d/apache2 stop
    $ /etc/init.d/apache2 start
    $ /etc/init.d/apache2 restart

List, enable and disable modules:

    $ apache2ctl -M
    $ a2enmod [module]
    $ a2dismod [module]

Apache files:

* Default document root: /var/www/html/
* Default site configuration: sites-enabled/000-default.conf 
* Configurations: /etc/apache2/
* Configuration file: /etc/apache2/apache2.conf
* Logs: /var/logs/apache2/

---

## PHP

PHP packages:

* php5-common - common files for packages built from the php5 source 
* libapache2-mod-php5 - Apache 2 module
* php5-cli - command-line interpreter

Search for PHP packages:

    $ apt-cache search php5
    $ apt-get install php5-mysql php5-curl

Changes made to Apache, /etc/apache2/, by PHP apt-get install of php5-common libapache2-mod-php5 php5-cli:

* Files added:
  - mods-available/php5.conf
  - mods-available/php5.load
  - mods-enabled/mpm_prefork.conf
  - mods-enabled/mpm_prefork.load
  - mods-enabled/php5.conf
  - mods-enabled/php5.load
* Files removed:
  - mods-enabled/mpm_event.conf
  - mods-enabled/mpm_event.load

Versions:

* PHP 5.6.6 is the latest on source [download](http://php.net/downloads.php).
* apt-get installs PHP Version 5.5.9-1ubuntu4.7.

Documentation:

* [Your first PHP-enabled page](http://php.net/manual/en/tutorial.firstpage.php)
* [Debian GNU/Linux installation notes](http://php.net/manual/en/install.unix.debian.php)

---

## htpasswd files

* [htpasswd](http://httpd.apache.org/docs/current/programs/htpasswd.html)

Example contents:

    fred:rt589nrv
    julie:j58vgj894

Create new file with single user:

    $ htpasswd -c .htpasswd fred

Add new user:

    $ htpasswd .htpasswd julie

Allow Apache to read (rw-r--r--):

    $ chmod 0644 .htaccess
    $ chmod 0644 .htpasswd

---

## .htaccess files

* [.htaccess files](http://httpd.apache.org/docs/current/howto/htaccess.html)
* Simple text file
* Rules and configuration directives enforced on its directory and sub-directories

Chunked example with explanation:

    RewriteEngine On
    
    RewriteRule ^index\.php$ - [L]
    
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule . index.php [QSA,L]
    
[RewriteEngine](http://httpd.apache.org/docs/current/mod/mod_rewrite.html#rewriteengine):

* Enable/disable rewriting engine

[RewriteCond](http://httpd.apache.org/docs/current/mod/mod_rewrite.html#rewritecond):

* Rule condition that determines if following rule is applied
* URI must match pattern and conditions must hold
* `%{REQUEST_FILENAME}` - full local file system path to file
* `!-f` - not a regular file

[RewriteRule](http://httpd.apache.org/docs/current/mod/mod_rewrite.html#rewriterule)

* If used within Directory and htaccess context, pattern is matched against file system path, after removing prefix that led server to this rule
* Path must match pattern and substition is then applied
* `last|L` - stop rewriting process immediately
* `qsappend|QSA` - append any query string from original URL to new URL
* First rule stops if an exact match on index.php is found.
* Second rule rewrites any non-file path to index.php

<p/>

    ServerSignature Off

[ServerSignature](http://httpd.apache.org/docs/current/mod/core.html#serversignature):

* Trailing footer line under server-generated documents.

<p/>

    Options -Indexes
    
[Options](http://httpd.apache.org/docs/current/mod/core.html#options):

* Server features available in a particular directory
* `-Indexes` - disable directory browsing

<p/>

    <Files config.ttl>
      Order deny,allow
      AuthType Basic
      AuthName "Authentication Required"
      AuthUserFile auth.htpasswd
      Require valid-user
    </Files>

    <Files .htaccess>
      Order Allow,Deny
      Deny from all
    </Files>
    
    <Files auth.htpasswd>
      Order Allow,Deny
      Deny from all
    </Files>

[Files](http://httpd.apache.org/docs/current/mod/core.html#files):

* Directives that apply to matched file names

[AuthType](http://httpd.apache.org/docs/current/mod/mod_authn_core.html#authtype):

* `Basic` - simple but widely used authentication

[AuthName](http://httpd.apache.org/docs/current/mod/mod_authn_core.html#authname):

* Collective title of the documents that are protected
* Usually appears in authentication window shown to client

[AuthUserFile](http://httpd.apache.org/docs/current/mod/mod_authn_file.html#authuserfile):

* Path to file with with username/password pairs
* Either absolute path or relative to ServerRoot

[Require](http://httpd.apache.org/docs/current/mod/mod_authz_core.html#require):

* Which users/groups are able to access the protected content
* `valid-user` - anyone in AuthUserFile

[Order](http://httpd.apache.org/docs/2.4/mod/mod_access_compat.html#order):

* `Allow,Deny`
  - All Allow directives are evaluated. At least one must match, or the request is rejected.
  - All Deny directives are evaluated. If any matches, the request is rejected.
  - Any requests which do not match an Allow or a Deny directive are denied by default.
* `Deny,Allow`
  - All Deny directives are evaluated. If any match, the request is denied unless it also matches an Allow directive. 
  - Any requests which do not match any Allow or Deny directives are permitted.

---

## MySQL

Manage MySQL:

    $ service mysql stop
    $ service mysql start
    $ service mysql restart

    $ /etc/init.d/mysql stop
    $ /etc/init.d/mysql start
    $ /etc/init.d/mysql restart

MySQL files:

* Configurations: /etc/mysql/
* Logs: /var/log/mysql/, /var/log/mysql.log, /var/log/mysql/error.log
