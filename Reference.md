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

## Linux

Package management

| Task | Ubuntu | Scientific Linux / Fedora |
| ---- | ------ | ------------------------- |
| Search for a package | apt-get search PACKAGE | yum search PACKAGE |
| Install package | apt-get install PACKAGE | yum install PACKAGE |
| Remove package and configuration | apt-get purge PACKAGE | yum remove PACKAGE |
| List available packages | apt-cache dumpavail | yum list available |
| List installed packages | dpkg --list | yum list installed |
| Show information about a package | apt-cache show PACKAGE | yum info PACKAGE |
| Show dependencies | apt-cache depends | rpm -qR PACKAGE |

---

## Apache 2.4

| Task    | Ubuntu | Scientific Linux / Fedora |
| ------- | ------ | ------------------------- |
| Start   | service apache2 start       | apachectl start |
|         |                             | systemctl start httpd.service |
|         | /etc/init.d/apache2 start   | /sbin/service httpd start |
| Stop    | service apache2 stop        | apachectl stop |
|         |                             | systemctl stop httpd.service |
|         | /etc/init.d/apache2 stop    | /sbin/service httpd stop |
| Restart | service apache2 restart     | apachectl restart |
|         |                             | systemctl restart httpd.service |
|         | /etc/init.d/apache2 restart | /sbin/service httpd restart |
| List modules   | apache2ctl -M   | |
| Enable module  | a2enmod MODULE  | |
| Disable module | a2dismod MODULE | |

Files:

| File    | Ubuntu | Scientific Linux / Fedora |
| ------- | ------ | ------------------------- |
| Default document root | /var/www/html/ | /var/www/html/ |
| Configuration files | /etc/apache2/ | /etc/httpd/ |
| Default site configuration | /etc/apache2/sites-enabled/000-default.conf | /etc/httpd/conf/httpd.conf |
| Configuration file | /etc/apache2/apache2.conf | /etc/httpd/conf/httpd.conf |
| Log files directory | /var/logs/apache2/ | /var/log/httpd/ |

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
* Path must match pattern and substition# sameAs Lite Deployer and Developer Reference
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

| Task    | Ubuntu | Scientific Linux / Fedora |
| ------- | ------ | ------------------------- |
| Start   | service mysql start       | systemctl start mariadb |
|         | /etc/init.d/mysql start   | /sbin/service mariadb start |
| Stop    | service mysql stop        | systemctl stop mariadb |
|         | /etc/init.d/mysql stop    | /sbin/service mariadb stop |
| Restart | service mysql restart     | systemctl restart mariadb |
|         | /etc/init.d/mysql restart | /sbin/service mariadb restart |

Files:

| File    | Ubuntu | Scientific Linux / Fedora |
| ------- | ------ | ------------------------- |
| Log files | /var/log/          | /etc/log/mariadb/ |
|           | /var/log/mysql.log | |
|           | /var/log/error.log | |
| Configuration files | /etc/mysql/    | /etc/my.cnf |
|                     | /etc/my.cnf.d/ | |

---

## PHP

PHP packages:

| Description | Ubuntu | Scientific Linux / Fedora |
| ----------- | ------ | ------------------------- |
| Common files | php5-common | php-common |
| Command-line interpreter | php5-cli | php-cli |
| General package | - | php |
| Apache 2 module | libapache2-mod-php5 | mod_php included in php |
| XSL module | php5-xsl | XSL support included in php-xml |
| XML module | xml included in libapache2-mod-php5 and php5-cli | php-xml |
| Database abstraction module | - | php-pdo |
| SQLite module | php5-sqlite | Included in php-pdo |
| MySQL module | php5-mysql | php-mysql (php-mysqlnd on Fedora) |
| Multi-byte string module | mbstring included in libapache2-mod-php5 and php5-cli | php-mbstring |

Changes made to Apache, /etc/apache2/, by Ubuntu apt-get install of php5-common libapache2-mod-php5 php5-cli:

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
