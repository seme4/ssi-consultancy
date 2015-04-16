# sameAs Lite set up development environment

How to setup a development enviroment for sameAs Lite.

You should be familiar with the [Deployer's Guide](./DeployersGuide.md) and havve installed the software listed in it.

---

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

## Install Xdebug (optional)

[Xdebug](http://xdebug.org/) is a profiler and code analyser for PHP. It can be used with PHPUnit to create test coverage reports.

### Ubuntu 14.04

Install:

    $ apt-get install php5-dev php-pear
    $ pecl install xdebug

Find library:

    $ find / -name 'xdebug.so' 2> /dev/null
    /usr/lib/php5/20121212/xdebug.so

Edit /etc/php/apache2/php.ini and add in the following lines, replacing the path to the library if necessary:

    [xdebug]
    zend_extension="/usr/lib/php5/20121212/xdebug.so"

Edit /etc/php/cli/php.ini and, again, add in the above lines, replacing the path to the library if necessary.

Restart Apache:

    $ service apache restart

### Scientific Linux 7

Install:

    $ yum install php-devel php-pear
    $ pecl install xdebug

Find library:

    $ find / -name 'xdebug.so' 2> /dev/null
    /usr/lib/php5/20121212/xdebug.so

Find library:

    $ find / -name 'xdebug.so' 2> /dev/null
    /usr/lib64/php/modules/xdebug.so

Edit /etc/php.ini and add in the following lines, replacing the path to the library if necessary:

    [xdebug]
    zend_extension="/usr/lib64/php/modules/xdebug.so"

Restart Apache:

    $ systemctl restart httpd.service 

### Fedora 21

Install:

    $ yum install gcc gcc-c++ autoconf automake
    $ yum install php-devel php-pear
    $ pecl install xdebug

Find library:

    $ find / -name 'xdebug.so' 2> /dev/null
    /usr/lib64/php/modules/xdebug.so

Edit /etc/php.ini and add in the following lines, replacing the path to the library if necessary:

    [xdebug]
    zend_extension="/usr/lib64/php/modules/xdebug.so"

Restart Apache:

    $ apachectl restart

### Check Xdebug has been installed

Visit http://127.0.0.1/index.php, and scroll down and you should see:

    with Xdebug v2.3.2, Copyright (c) 2002-2015, by Derick Rethans

Scroll down and there should be an xdebug section and configuration tables.

Run:

    $ php /var/www/html/index.php | grep -in xdebug | more

and you should see xdebug-related configuration.

---

## Install KCachegrind (optional)

[KCachegrind](http://kcachegrind.sourceforge.net/html/Home.html) is an open source profile data visualization tool. It can visualise Xdebug profiling data.

### Ubuntu 14.04

    $ apt-get install kcachegrind
    $ kcachegrind -v
    Qt: 4.8.6
    KDE Development Platform: 4.13.3
    KCachegrind: 0.7.4kde

### Scientific Linux 7

    $ yum install kcachegrind
    $ kcachegrind -v
    Qt: 4.8.5
    KDE Development Platform: 4.10.5
    KCachegrind: 0.7.2kde

### Fedora 21

    $ yum install kcachegrind
    $ kcachegrind -v
    Qt: 4.8.6
    KDE Development Platform: 4.14.6
    KCachegrind: 0.7.4kde

---

## Install callgrind_annotate (optional)

[callgrind_annotate](http://valgrind.org/docs/manual/cl-manual.html#cl-manual.callgrind_annotate-options) can filter Xdebug profiling data. It is part of the [Valgrind](http://valgrind.org/) instrumentation framework.

### Ubuntu 14.04

If you have installed KCachegrind then valgrind will already be available. 

Alternatively:

    $ apt-get install valgrind
    $ valgrind --version
    valgrind-3.10.0.SVN
    $ callgrind_annotate --version
    callgrind_annotate-3.10.0.SVN

### Scientific Linux 7

    $ yum install valgrind
    $ valgrind --version
    valgrind-3.10.0
    $ callgrind_annotate --version
    callgrind_annotate-3.10.0

### Fedora 21

    $ yum install valgrind
    $ valgrind --version
    valgrind-3.10.1
    $ callgrind_annotate --version
    callgrind_annotate-3.10.1

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
