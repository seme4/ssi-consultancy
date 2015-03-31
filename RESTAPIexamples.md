# REST API examples

After deploying sameAs Lite, visit http://127.0.0.1/sameas-lite/datasets/api. This page shows REST endpoints, descriptions, example curl commands, output formats, and also allows them to be invoked.

They take a {store} argument which corresponds to the slug used to identify data stores in index.php e.g. "VIAF" or "test"

Below are examples of invoking the REST endpoints. The names correspond to the API descriptions on the page above. The default content-type of each endpoint is shown in brackets.

TODO update when a better sample dataset is found

TODO For most it would be useful to serve as text/plain and application/json too

TODO username:password are not, or do not seem to be, used, but ommiting them gives, for example:

    $ curl -X DELETE http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol1
    Access Denied
    You have failed to supply valid credentials, access to this resource is denied. 
    Please try returning to the homepage

## Lists available datasets (text/html)

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets
    TODO

TODO this function needs implemented

## Delete an entire store (text/html)

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test
    ...
    $ curl -H "Accept: text/plain" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test
    Store deleted

## Delete the contents of a store (text/html)

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty
    ...
    $ curl -H "Accept: text/plain" -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/empty
    Store emptied

## Restore a database backup (???):

    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore
    Missing argument 2 for SameAsLite\WebApp::restoreStore()
    /var/www/html/sameas-lite/src/WebApp.php +882
    #0 /var/www/html/sameas-lite/src/WebApp.php(882): Slim\Slim::handleErrors(2, 'Missing argumen...', '/var/www/html/s...', 882, Array)
    #1 [internal function]: SameAsLite\WebApp->restoreStore('test')
    #2 /var/www/html/sameas-lite/vendor/slim/slim/Slim/Route.php(468): call_user_func_array(Array, Array)

TODO implement this functionality...

The API web page comments that "You can use this method to restore a previously downloaded database backup". src/Store.php has a function:

    public function dumpStore()

which implements /datasets/:store/pairs. There is also a function:

    public function restoreStore($file)

which is commented as:

    * Takes the output of dumpStore and adds it into this store
    * Overwrites any existing values, leaving the others intact.
    * Assumes the source data is valid.
    * @param string $file The file name of the source data to be asserted

It seems to need a local file. This seems to be work-in-progress as src/WebApp.php has a complementary:

    // $this->registerURL(
    // 'GET',
    // '/datasets/:store/admin/backup/',
    // 'backupStore',
    // 'Backup the database contents',
    // 'You can use this method to download a database backup file',
    // true,
    // 'text/html,text/plain'
    // );

TODO It would be useful if the input formats and output formats (from export, for example) were complementary.

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore

TODO

    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/admin/restore

TODO

TODO It would be useful if the input formats and output formats (from export, for example) were complementary.

## Returns a list of all canons (application/json)

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ...
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    ["canon1","canon2"]
    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons
    canon1
    canon2

## Set the canon (text/html)

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/symbol4
    ...
    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/canons/symbol4
    Canon set to 'symbol5'

## Get canon (text/html)

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/symbol1
    ...
    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/symbol1
    canon1
    $ curl -H "Accept: text/plain" -X GET http://127.0.0.1/sameas-lite/datasets/test/canons/nosuchcanon
    nosuchcanon

TODO is this expected?

## Export list of pairs (application/json)

    $ curl -H "Accept: text/html" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    ...
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    [{"canon":"canon1","symbol":"symbol1"},{"canon":"canon1","symbol":"symbol2"},{"canon":"canon2","symbol":"symbol3"}]
    $ curl -H "Accept: text/csv" -X GET http://127.0.0.1/sameas-lite/datasets/test/pairs
    canon,symbol
    canon1,symbol1
    canon1,symbol2
    canon2,symbol3

### Assert multiple pairs (text/html)

Create a file pairs.txt, where each line contains a TAB-separated pair e.g.

    canonA symbolA
    canonB symbolB	

<p/>

    $ curl -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs
    ...
    $ curl -H "Accept: text/plain" -X PUT --user username:password -T "pairs.txt" http://127.0.0.1/sameas-lite/datasets/test/pairs
    Pairs asserted!

TODO "Pairs asserted!" is always returned regardless of what the file contains, or even if no file is specified. It would be better to return a count of the number of pairs asserted, and an error if the file format is invalid.
TODO It would be useful if the input formats and output formats (from export, for example) were complementary.

## Assert single pair (application/json)

    $ curl -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/a/b
    {"ok":"The pair (a, b) has been asserted"}r
    $ curl -H "Accept: text/plain" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/c/d
    The pair (c, d) has been asserted
    $ curl -H "Accept: text/html" -X PUT --user username:password http://127.0.0.1/sameas-lite/datasets/test/pairs/e/f

Multiple invocations of the same pair succeed.

## Search (text/html)

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/search/sym
    symbol3
    symbol1
    symbol1
    symbol2
    symbol2
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/search/xxx
    No items found

TODO Description on http://127.0.0.1/sameas-lite/api has a typo: "Find symols"

## Retrieve symbol (text/html)

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol1
    symbol1 symbol2
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol2
    symbol1 symbol2
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol3
    symbol3

TODO how to do this if symbol is a URL? These do not work:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http%3A%2F%2Fdata.nytimes.com%2Fedinburgh_scotland_geo
    <h1>Error 404</h1>
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http\:\/\/data.nytimes.com\/edinburgh_scotland_geo
    <h1>Error 404</h1>
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http://data.nytimes.com/edinburgh_scotland_geo
    <h1>Error 404</h1>
    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/symbols/http%253A%252F%252Fdata.nytimes.com%252Fedinburgh_scotland_geo
    <h1>[titleHeader]</h1>
    ... but no matches...       

TODO what to provide in relevant form inhttp://127.0.0.1/sameas-lite/datasets/test/api, likewise?

* http://stackoverflow.com/questions/3235219/urlencoded-forward-slash-is-breaking-url suggests [AllowEncodedSlashes](http://httpd.apache.org/docs/2.2/mod/core.html#allowencodedslashes).
* http://www.freeformatter.com/url-encoder.html#ad-output

## Delete symbol (???)

    $ curl -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol1
    Undefined variable: result
    /var/www/html/sameas-lite/src/WebApp.php +1033
    ...
    #0 /var/www/html/sameas-lite/src/WebApp.php(1033): Slim\Slim::handleErrors(8, 'Undefined varia...', '/var/www/html/s...', 1033, Array)
    #1 [internal function]: SameAsLite\WebApp->removeSymbol('test', 'symbol1')
    #2 /var/www/html/sameas-lite/vendor/slim/slim/Slim/Route.php(468): call_user_func_array(Array, Array)

TODO investigate

    $ curl -H "Accept: text/html"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol1

TODO get output

    $ curl -H "Accept: text/plain"  -X DELETE --user username:password http://127.0.0.1/sameas-lite/datasets/test/symbols/symbol1

TODO get output

TODO Description on http://127.0.0.1/sameas-lite/api is "TBC"

## Returns status of the store (text/html)

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/status
    Statistics for sameAs store table1:
    3    symbols
    2    bundles

## Analyse contents of the store (text/html)

If store is non-empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    Undefined index: canon1
    /var/www/html/sameas-lite/src/Store.php +823
    ...
    #0 /var/www/html/sameas-lite/src/Store.php(823): Slim\Slim::handleErrors(8, 'Undefined index...', '/var/www/html/s...', 823, Array)
    #1 /var/www/html/sameas-lite/src/WebApp.php(1072): SameAsLite\Store->analyse()
    ...

TODO investigate

If store is empty:

    $ curl -X GET http://127.0.0.1/sameas-lite/datasets/test/analyse
    Analysis of sameAs store 'table1' in Database 'testdb':
    Store is empty!
