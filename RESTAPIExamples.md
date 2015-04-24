# REST API examples

This page gives examples of invocations of sameAs Lite's REST API, using curl. The API can also be viewed, and invoked, via a web-based interface at http://127.0.0.1/sameas-lite/datasets/api.

Examples are given for every content-type supported by each REST endpoint. For HTML or JSON documents, only fragments relating specifically to the endpoint are shown.

---

## REST URLs

REST URLs are of the form:

    http://<host>[:<port>]/<path>/datasets/[<store>/<values>]

where:

* `<host>` is the domain name or IP address on which the web server hosting sameAs Lite is running e.g. 127.0.0.1
* `<port>` is the optional port upon which the web server allows connections.
* `<path>` is the path to the sameAs Lite web application e.g. `sameas-lite`.
* `<store>` is the name of the data store to use. This corresponds to the slug used to identify data stores e.g. "VIAF" or "test".
* `<values>` are values specific to the REST endpoint being targeted and the REST command being invoked.

---

## Service-wide operations

The following operations apply to the sameAs Lite service, not to individual data stores.

### Lists available datasets

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets
    <h1>[titleHeader]</h1>

    TODO
 
    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets
    ...as above...

---

## Data store-specific operations

### Delete an entire store

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test
    Store deleted

    $ curl -H "Accept: text/plain" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test
    ...as above...

    $ curl -H "Accept: text/html" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test
    <h1>[titleHeader]</h1>

    <h2>Success!</h2><p>Store deleted</p>

### Delete the contents of a store

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty
    <h1>[titleHeader]</h1>

    <h2>Success!</h2><p>Store emptied</p>

    $ curl -H "Accept: text/html" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty
    ...as above...

    $ curl -H "Accept: text/plain" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty
    Store emptied

### Restore a database backup

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore
    <h1>Error 500</h1>

    <h2>Missing argument 2 for SameAsLite\WebApp::restoreStore()</h2>

    <p><strong>/var/www/html/sameas-lite/src/WebApp.php</strong> &nbsp; +882</p><p>Please try returning to <a href="http://127.0.0.1/sameas-lite">the homepage</a>.</p>

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore
    ...as above...

    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore
    ...as above...

### Returns a list of all canons

If store is non-empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ["http:\/\/www.wikidata.org\/entity\/Q220966","http:\/\/www.wikidata.org\/entity\/Q23436","http:\/\/www.wikidata.org\/entity\/Q6940372"]

    $ curl -H "Accept: application/json" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ...as above...

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    <h1>All Canons in this dataset</h1>

    <ul>
        <li><a href="http://www.wikidata.org/entity/Q220966">http://www.wikidata.org/entity/Q220966</a></li>
        <li><a href="http://www.wikidata.org/entity/Q23436">http://www.wikidata.org/entity/Q23436</a></li>
        <li><a href="http://www.wikidata.org/entity/Q6940372">http://www.wikidata.org/entity/Q6940372</a></li>
    </ul>

    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    http://www.wikidata.org/entity/Q220966
    http://www.wikidata.org/entity/Q23436
    http://www.wikidata.org/entity/Q6940372

If store is empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    []

    $ curl -H "Accept: application/json" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ...as above...

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    <h1>All Canons in this dataset</h1>

    <p>No items found</p>

    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ...no output...

### Set the canon

If a matching canon:

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    <h1>[titleHeader]</h1>

    <h2>Success!</h2><p>Canon set to 'canonA'</p>

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    ...as above...

    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    Canon set to 'canonA'

If a matching symbol:

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/symbolA1
    <h1>[titleHeader]</h1>

    <h2>Success!</h2><p>Canon set to 'symbolA1'</p>

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/symbolA1
    ...as above...

    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/symbolA1
    Canon set to 'symbolA1'

If no match:

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonC
    <h1>[titleHeader]</h1>

    <h2>Success!</h2><p>Canon set to 'canonC'</p>

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonC
    ...as above...

    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/canonC
    Canon set to 'canonC'

### Get canon

If a matching canon:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    <h1>Canon for &ldquo;canonA&rdquo;</h1>

    <ul>
        <li>canonA</li>
    </ul>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    ...as above...

    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/canonA
    canonA

If a matching symbol:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/symbolA1
    <h1>Canon for &ldquo;symbolA1&rdquo;</h1>

    <ul>
        <li>canonA</li>
    </ul>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/symbolA1
    ...as above...

    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/symbolA1
    canonA

If no match:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nomatch
    <h1>Canon for &ldquo;nomatch&rdquo;</h1>

    <ul>
        <li>nomatch</li>
    </ul>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nomatch
    ...as above...

    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nomatch
    nomatch

### Export list of pairs

If store is non-empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    [{"canon":"http:\/\/www.wikidata.org\/entity\/Q220966","symbol":"http:\/\/data.nytimes.com\/southampton_england_geo"},
     {"canon":"http:\/\/www.wikidata.org\/entity\/Q220966","symbol":"http:\/\/data.ordnancesurvey.co.uk\/id\/50kGazetteer\/218013"},
    ...
    {"canon":"http:\/\/www.wikidata.org\/entity\/Q23436","symbol":"http:\/\/data.nytimes.com\/edinburgh_scotland_geo"},...]

    $ curl -H "Accept: application/json" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    ...as above...

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    <h1>Contents of the store:</h1>

    <table class="table">  <thead>   
    <tr>      <th>canon</th>      <th>symbol</th>    </tr>  </thead>  <tbody>
    <tr>      <td><a href="http://www.wikidata.org/entity/Q220966">http://www.wikidata.org/entity/Q220966</a></td>     
    <td><a href="http://data.nytimes.com/southampton_england_geo">http://data.nytimes.com/southampton_england_geo</a></td>    </tr>    
    <tr>     <td><a href="http://www.wikidata.org/entity/Q220966">http://www.wikidata.org/entity/Q220966</a></td>      
    <td><a href="http://data.ordnancesurvey.co.uk/id/50kGazetteer/218013">http://data.ordnancesurvey.co.uk/id/50kGazetteer/218013</a></td>    </tr>   
    ...
    <tr>      <td><a href="http://www.wikidata.org/entity/Q23436">http://www.wikidata.org/entity/Q23436</a></td>      
    <td><a href="http://data.nytimes.com/edinburgh_scotland_geo">http://data.nytimes.com/edinburgh_scotland_geo</a></td>    </tr>    
    ...
    </tbody></table>

    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    canon,symbol
    http://www.wikidata.org/entity/Q220966,http://data.nytimes.com/southampton_england_geo
    http://www.wikidata.org/entity/Q220966,http://data.ordnancesurvey.co.uk/id/50kGazetteer/218013
    ...
    http://www.wikidata.org/entity/Q23436,http://data.nytimes.com/edinburgh_scotland_geo
    ...

If store is empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    []

    $ curl -H "Accept: application/json" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    ...as above...

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    <h1>Contents of the store:</h1>

    <table class="table">  <thead>   
    <tr>      <th>canon</th>      <th>symbol</th>    </tr>  
    </thead>  <tbody>  </tbody></table>

    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    canon,symbol

### Assert multiple pairs

Assume pairs.txt is a set of pairs, each pair being TAB-separated:

    $ cat pairs.txt 
    canonA symbolA4
    canonC symbolC1

    $ curl -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs
    <h1>[titleHeader]</h1>

    <h2>Success!</h2><p>Pairs asserted</p>

    $ curl -H "Accept: text/html" -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs
    ...as above...
 
    $ curl -H "Accept: text/plain" -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs
    Pairs asserted

### Assert single pair

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/canonA/symbolA4
    {"ok":"The pair (canonA, symbolA4) has been asserted"}

    $ curl -H "Accept: application/json" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/canonA/symbolA4
    ...as above...

    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/canonA/symbolA4
    The pair (canonA, symbolA4) has been asserted

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/canonA/symbolA4
    <h1>Pair asserted</h1>

    <h2>Success!</h2><p>The pair (canonA, symbolA4) has been asserted</p>

### Search

If a match:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/search/dinb
    <h1>[titleHeader]</h1>

    <ul>
        <li><a href="http://data.nytimes.com/edinburgh_scotland_geo">http://data.nytimes.com/edinburgh_scotland_geo</a></li>
        <li><a href="http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482">http://data.ordnancesurvey.co.uk/id/50kGazetteer/81482</a></li>
        <li><a href="http://dbpedia.org/resource/Embra">http://dbpedia.org/resource/Embra</a></li>
        <li><a href="http://sws.geonames.org/2650225/">http://sws.geonames.org/2650225/</a></li>
        <li><a href="http://www.wikidata.org/entity/Q23436">http://www.wikidata.org/entity/Q23436</a></li>
      </ul>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/search/dinb
    ...as above...

If no match:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/search/nomatch
    <h1>[titleHeader]</h1>

    <p>No items found</p>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/search/nomatch
    ...as above...

### Retrieve symbol

If a matching canon:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    <h1>[titleHeader]</h1>

    <pre>canonA
    symbolA1
    symbolA2
    symbolA3</pre>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    ...as above...

If a matching symbol:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/symbolA1
    <h1>[titleHeader]</h1>

    <pre>canonA
    symbolA1
    symbolA2
    symbolA3</pre>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/symbolA1
    ...as above...

If no match:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    <h1>[titleHeader]</h1>

    <pre></pre>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    ...as above...

### Delete symbol

If a matching canon:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    <h2>Undefined variable: result</h2>

    <p><strong>/var/www/html/sameas-lite/src/WebApp.php</strong> &nbsp; +1033</p><p>Please try returning to <a href="http://127.0.0.1/sameas-lite">the homepage</a>.</p>

    $ curl -H "Accept: text/html"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    ...as above...

    $ curl -H "Accept: text/plain"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/canonA
    ...as above...

If a matching symbol:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbolA1
    ...as above...

    $ curl -H "Accept: text/html"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbolA1
    ...as above...

    $ curl -H "Accept: text/plain"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbolA1
    ...as above...

If no match:

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    ...as above...

    $ curl -H "Accept: text/html"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    ...as above...

    $ curl -H "Accept: text/plain"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/nomatch
    ...as above...

### Returns status of the store

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/status
    <h1>[titleHeader]</h1>

    <pre>Statistics for sameAs store table1:
    15    symbols
    3    bundles</pre>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/status
    ...as above...

### Analyse contents of the store

If store is non-empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    <h2>Undefined index: http://www.wikidata.org/entity/Q220966</h2>
    /var/www/html/sameas-lite/src/Store.php +823

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    ...as above...

If store is empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    <h1>[titleHeader]</h1>

    <pre><pre>

    Analysis of sameAs store 'table1' in Database 'testdb':
    Store is empty!</pre>

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    ...as above...
