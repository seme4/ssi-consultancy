# sameAs Lite REST API review

Mike Jackson, The Software Sustainability Institute / EPCC, The University of Edinburgh

## Introduction

[sameAs.org](http://sameas.org) is a search engine for linked data that, if given a URI, returns URIs that are co-referent, should any be known to it. The engine searches information harvested from a number of sources. sameAs.org is maintained by [Seme4 Limited](http://www.seme4.com). [sameAs Lite](http://github.com/seme4/sameas-lite) is a refactored, free open source, version of the software that powers sameAs.org.

[REST API examples](./RESTAPIExamples.md) gives examples of invocations of sameAs Lite's REST API, using curl. The API can also be viewed, and invoked, via a web-based interface at http://127.0.0.1/sameas-lite/datasets/api.

This document summarises issues with the REST API were identified when documenting the examples.

---

## Design

### Return a 404 Not Found header if a resource does not exist

Issuing a GET request against a non-existent web application returns a 404 Not Found header:

    $ curl -i -X GET http://127.0.0.1/sameas
    HTTP/1.1 404 Not Found
    Date: Fri, 24 Apr 2015 15:16:08 GMT
    Server: Apache/2.4.7 (Ubuntu)
    Content-Length: 278
    Content-Type: text/html; charset=iso-8859-1
    
    <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
    <html><head>
    <title>404 Not Found</title>
    </head><body>
    <h1>Not Found</h1>
    <p>The requested URL /sameas was not found on this server.</p>
    <hr>
    <address>Apache/2.4.7 (Ubuntu) Server at 127.0.0.1 Port 80</address>
    </body></html>

However, issuing a GET request against a non-existent resource returns a 200 OK header:

    $ curl -i -X GET http://127.0.0.1/sameas-lite/datasets/test/symb
    HTTP/1.1 200 OK
    Date: Fri, 24 Apr 2015 15:17:48 GMT
    Server: Apache/2.4.7 (Ubuntu)
    X-Powered-By: PHP/5.5.9-1ubuntu4.9
    Vary: Accept-Encoding
    Content-Length: 2546
    Content-Type: text/html
    
    <!DOCTYPE html>
    <html lang="en">
    
        <title>SameAs Lite - Page not found</title>
    
          <div class="container">
            <h1>Error 404</h1>
          </div>
    
            <h2>Not Found</h2>

For the following non-existent resources, 200 OK headers are also returned:

    $ curl -i -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nomatch
    $ curl -i -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    $ curl -i -X GET http://127.0.0.1/sameas-lite/datasets/test/search/nomatch

As these resources do not exist, return 400 Not Found headers.

### Use nouns not verbs in URLs

Certain URLs contain verbs. A number of commentators recommend that REST URLs only consist of nouns (e.g. [1](http://www.restapitutorial.com/lessons/restfulresourcenaming.html), [2](http://blog.mwaysolutions.com/2014/06/05/10-best-practices-for-better-restful-api/), [3](https://blog.codecentric.de/en/2012/11/a-restful-learning-curve-nouns-verbs-hateoas-and-roca/)) as the HTTP operations (GET, PUT, DELETE, POST) serve as the verbs, the operations on these resources.

For /search:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/search/dinb

the verb could be avoided by treating this as an operation on /pairs. For example, returning all the /pairs resources which contain "dinb":

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs/dinb

For /analyse:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse

rename this to /analysis:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/analysis

### Use POST not PUT for update

A set of pairs can be inserted via a PUT request. For example, using pairs.txt is a file of pairs, one per line, each pair being TAB-separated:

    $ curl -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs

This appends the pairs to those already there. Since, in the context of collections, PUT is conventionally taken to mean replacing the collection, use a POST instead:

    $ curl -X POST --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs

PUT could be reimplemented so that it replaces the existing pairs with the new pairs. On which note...

### Use PUT not DELETE for 'empty'

To delete a store a DELETE request is used:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test

To empty the store a DELETE request is used against an /admin/empty resource:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty

As emptying the data store is equivalent to updating it with an empty set of pairs, consider using /pairs in conjunction with PUT:

    $ cat pairs.txt
    $ curl -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs

### Support DELETE on /canons

To delete symbols or canons a DELETE request is issued against /symbols:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbolA1

Consider supporting DELETE requests against /canons:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonA

to delete the canon and all its symbols.

---

## Clarify how to pass URIs as canons and symbols in URLs

It is unclear how to pass URIs as canons or symbols. None of these operations worked:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http%3A%2F%2Fdata.nytimes.com%2Fedinburgh_scotland_geo
    <h1>Error 404</h1>

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http\:\/\/data.nytimes.com\/edinburgh_scotland_geo
    <h1>Error 404</h1>

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http://data.nytimes.com/edinburgh_scotland_geo
    <h1>Error 404</h1>

This invocation:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http%253A%252F%252Fdata.nytimes.com%252Fedinburgh_scotland_geo

did not raise an error, but it returned no matches.

The sameAs.org service can handle symbols:

    $ curl http://sameas.org/json?uri=http%3A%2F%2Fdbpedia.org%2Fresource%2FEdinburgh

but these are passed via a query string, not as part of the URL path.

---

## Bugs

### Fix typos in web-based interface API descriptions

On http://127.0.0.1/sameas-lite/datasets/api:

* Search (GET http://127.0.0.1/sameas-lite/datasets/{store}/search/{symbol}), description has a typo: "Find symols".
* Delete symbol (DELETE http://127.0.0.1/sameas-lite/datasets/{store}/symbols/{symbol}) description is "TBC".

The typos are in src/WebApp.php line 310:

    $this->registerURL(
        'GET',
        '/datasets/:store/search/:string',
        'search',
        'Search',
        'Find symols which contain/match the search string/pattern'
    );

and src/WebApp.php line 326:

    $this->registerURL(
         'DELETE',
        '/datasets/:store/symbols/:symbol',
        'removeSymbol',
        'Delete symbol',
        'TBC',
        true,
        'text/html,text/plain'
    );

A fix is in the [typos](https://github.com/softwaresaved/sameas-lite/tree/typos) branch of https://github.com/softwaresaved/sameas-lite:

* [WebApp.php](https://github.com/softwaresaved/sameas-lite/blob/typos/src/WebApp.php)

This has been submitted to seme4/sameas-lite as [pull request 2](https://github.com/seme4/sameas-lite/pull/2).

### Fix Delete symbol bug

Delete symbol raises an error:

    $ curl -H "Accept: text/html"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    <h2>Undefined variable: result</h2>

    <p><strong>/var/www/html/sameas-lite/src/WebApp.php</strong> &nbsp; +1033</p><p>Please try returning to <a href="http://127.0.0.1/sameas-lite">the homepage</a>.</p>

Inspecting the database shows that the deletion does occur.

The bug is at src/WebApp.php line 1033:

    public function removeSymbol($store, $symbol)
    {
        $this->stores[$store]->removeSymbol($symbol);
        $this->outputSuccess($result);
    }

The first line of the function should be:

        $result = $this->stores[$store]->removeSymbol($symbol);

A fix is in the [fixdelete](https://github.com/softwaresaved/sameas-lite/tree/fixdelete) branch of https://github.com/softwaresaved/sameas-lite:

* [WebApp.php](https://github.com/softwaresaved/sameas-lite/blob/fixdelete/src/WebApp.php)

This has been submitted to seme4/sameas-lite as [pull request 3](https://github.com/seme4/sameas-lite/pull/3).

After applying this fix:

    $ curl -H "Accept: text/html"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    <h2>Success!</h2><p></p>

    $ curl -H "Accept: text/plain"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonB
    ...nothing....

### Fix Analyse contents of the store bug

If a store is non-empty, Analyse contents of the store raises an error:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    <h2>Undefined index: http://www.wikidata.org/entity/Q220966</h2>
    /var/www/html/sameas-lite/src/Store.php +823

If store is empty, then the bug does not arise:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    <pre><pre>

    Analysis of sameAs store 'table1' in Database 'testdb':
    Store is empty!</pre>

The bug is at src/Store.php line 823:

    $bundleSizes = array(); // An array of canon => bundle size

    foreach ($store as $row) {
        $s = $row['symbol'];
        $b = $row['canon'];
        $nSymbols++;
        $bundleSizes[$b]++;

$bundleSizes should be checked to see if it has a value for key $b before being incremented:

    foreach ($store as $row) {
        $s = $row['symbol'];
        $b = $row['canon'];
        $nSymbols++;
        if (array_key_exists($b, $bundleSizes)) {
            $bundleSizes[$b]++;
        } else {
           $bundleSizes[$b] = 0;
        }

A fix is in the [fixanalyse](https://github.com/softwaresaved/sameas-lite/tree/fixanalyse) branch of https://github.com/softwaresaved/sameas-lite:

* [Store.php](https://github.com/softwaresaved/sameas-lite/blob/fixanalyse/src/Store.php)

This has been submitted to seme4/sameas-lite as [pull request 4](https://github.com/seme4/sameas-lite/pull/4).

After applying this fix:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    <h1>[titleHeader]</h1>
    <pre><pre>

    Analysis of sameAs store 'table1' in Database 'testdb':
    =====================================================
    Basic numeric statistics:
    15 	symbols
    3 	bundles
    5.00	symbols per bundle
    4	bundle size median
    4	bundle size mode
    =====================================================
    Table of count of bundles for each bundle size
    Size	Bundle Count
    4	3
    =====================================================
    Symbols by type:
    15	HTTP symbols
    0	HTTPS symbols
    0	non-HTTP(S) symbols
    =====================================================
    URI(s) etc per domain - for http symbols, if any
    Count	Domain
    3	data.nytimes.com
    3	data.ordnancesurvey.co.uk
    3	dbpedia.org
    3	sws.geonames.org
    3	www.wikidata.org
    ------------------------
    Count	Base+TLD Domain
    3	nytimes.com
    3	co.uk
    3	dbpedia.org
    3	geonames.org
    3	wikidata.org
    ------------------------
    Count	TLD Domain
    3	com
    3	uk
    9	org
    =====================================================
    URI(s) etc per domain - for https symbols, if any
    =====================================================
    Things that might be considered errors:
    Singleton bundle symbols:
    =====================================================
    Errors:
    List of canons that are not also listed as symbols:
    http://www.wikidata.org/entity/Q220966
    http://www.wikidata.org/entity/Q23436
    http://www.wikidata.org/entity/Q6940372
    =====================================================
    </pre>
    </pre>

This seems to reveal a new bug. The above `List of canons that are not also listed as symbols` *are* listed as symbols:

    > select * from table1;
    +-----------------------------------------+---------------------------------------------------------+
    | canon                                   | symbol                                                  |
    +-----------------------------------------+---------------------------------------------------------+
    | http://www.wikidata.org/entity/Q23436   | http://www.wikidata.org/entity/Q23436                   |
    ...
    | http://www.wikidata.org/entity/Q220966  | http://www.wikidata.org/entity/Q220966                  |
    ...
    | http://www.wikidata.org/entity/Q6940372 | http://www.wikidata.org/entity/Q6940372                 |
    ...
    +-----------------------------------------+---------------------------------------------------------+
    15 rows in set (0.00 sec)

### Fix Get Canon so it does not return an ambiguous result

If Get Canon is called with a non-existent canon or symbol then that canon or symbol is returned:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nomatch
    <h1>Canon for &ldquo;nomatch&rdquo;</h1>
    <ul>
        <li>nomatch</li>
    </ul>

    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nomatch
    nomatch

The caller cannot tell whether there is one matching canon or symbol, called nomatch, or none.

---

## Input/output formats

### Make Assert multiple pairs and Export list of pairs complementary

Assert multiple pairs takes a list of TAB-separated pairs:

    $ curl -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs

However Export list of pairs returns JSON, HTML, or comma-separated values:

    $ curl -H "Accept: application/json" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs

As these are complementary operations, make them behave as such:

* Export list of pairs also returns a TAB-separated list of pairs if content-type text/plain is specified.
* Assert multiple pairs also accepts JSON and CSV files that are output from Export list of pairs.

### Be consistent when returning lists of data

If Search finds matching canons or symbols, it returns an HTML list:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/search/dinb
    <ul>
        <li><a href="http://data.nytimes.com/edinburgh_scotland_geo">http://data.nytimes.com/edinburgh_scotland_geo</a></li>
        <li><a href="http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482">http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482</a></li>
        <li><a href="http://dbpedia.org/resource/Embra">http://dbpedia.org/resource/Embra</a></li>
        <li><a href="http://sws.geonames.org/2650225/">http://sws.geonames.org/2650225/</a></li>
        <li><a href="http://www.wikidata.org/entity/Q23436">http://www.wikidata.org/entity/Q23436</a></li>
      </ul>

If it finds none, it returns a paragraph:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/search/nomatch
    <p>No items found</p>

It would be more consistent to return an empty list:

    <ul></ul>

The count of items could be added also:

    <p>3 items found:</p>
    <ul>
      <li>....</li>
      <li>....</li>
      <li>....</li>
    </ul>

    <p>0 items found:</p>
    <ul>
    </ul>

Similarly, Retrieve symbol returns its lists within pre blocks:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    <pre>canonA
    symbolA1
    symbolA2
    symbolA3</pre>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    <pre></pre>

For consistency, these should adopt the same list-based structured output as Search.

### Return status and analysis information as a table

Return status of the store returns its contents as a pre block:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/status
    <pre>Statistics for sameAs store table1:
    15    symbols
    3    bundles</pre>

As does Analyse contents of the store:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    <pre><pre>

    Analysis of sameAs store 'table1' in Database 'testdb':
    Store is empty!</pre>

These would be more readable, and consistent with other data returned as HTML, if represented as tables.

### Support additional content-types

Endpoints that return lists or tabular data could support all of text/html, application/json, text/plain, and text/csv. It should be ensured that the representation within each format is consistent (as described above).

---

## Implementation

### Implement Lists available datasets

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets

returns:

    TODO

### Fill in titleheader

A number of endpoints return a template header when text/html is requested:

    <h1>[titleHeader]</h1>

These include:

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets
    $ curl -H "Accept: text/html" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test
    $ curl -H "Accept: text/html" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty
    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    $ curl -H "Accept: text/html" -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs
    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/search/dinb
    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/status
    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse

### Implement authorisation

The username:password accepted by PUT and DELETE operations can be anything.

    $ curl -X PUT --user xxx:yyy http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    <h2>Success!</h2><p>Canon set to 'canonA'</p>

However, leaving it out results in an Access Denied error:

    $ curl -X PUT http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    <h1>Error 401</h1>
    <h2>Access Denied</h2>
    <p>You have failed to supply valid credentials, access to this resource is denied.</p><p>Please try returning to <a href="http://127.0.0.1/sameas-lite">the homepage</a>.</p>

Implement authorisation and/or describe how to configure it.

### Implement Restore a database backup

Restore a database backup currently raises an error:

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore
    <h1>Error 500</h1>
    <h2>Missing argument 2 for SameAsLite\WebApp::restoreStore()</h2>
    <p><strong>/var/www/html/sameas-lite/src/WebApp.php</strong> &nbsp; +882</p><p>Please try returning to <a href="http://127.0.0.1/sameas-lite">the homepage</a>.</p>

The API web page comments that "You can use this method to restore a previously downloaded database backup". 

src/Store.php has a function:

    public function dumpStore()

which implements /datasets/{store}/pairs. There is also a function:

    public function restoreStore($file)

which is commented as:

    * Takes the output of dumpStore and adds it into this store
    * Overwrites any existing values, leaving the others intact.
    * Assumes the source data is valid.
    * @param string $file The file name of the source data to be asserted

It seems to need a local file. This seems to be work-in-progress as src/WebApp.php has a complementary chunk of code commented-out:

    // $this->registerURL(
    // 'GET',
    // '/datasets/:store/admin/backup/',
    // 'backupStore',
    // 'Backup the database contents',
    // 'You can use this method to download a database backup file',
    // true,
    // 'text/html,text/plain'
    // );

When implementing this endpoint, it might be useful to return information about the restored back up e.g. the number of pairs inserted, the number of canons etc.

### Make Assert multiple pairs more robust

Assert multiple pairs works if no file is given:

    $ curl -H "Accept: text/plain" -X PUT --user username:password  http://127.0.0.1/sameas-lite/datasets/test/pairs
    Pairs asserted

Or if an invalid file is given:

    $ curl -H "Accept: text/plain" -X PUT --user username:password -T create_mysql_table.sql http://127.0.0.1/sameas-lite/datasets/test/pairs
    Pairs asserted

Return a count of the number of pairs asserted if the file format is valid. 

Raise an error if the file format is invalid.

---

## Update RESTAPIExamples.md

Once these issues are addressed, update the sample outputs in [RESTAPIExamples.md](./RESTAPIExamples.md).
