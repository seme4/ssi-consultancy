<?php

/**
 * sameAs Lite get symbol client.
 *
 * Invoke \SameAsLite\Store->querySymbol.
 *
 * Usage:
 * <pre>
 * $ php get_symbol.php SYMBOL
 * </pre>
 * where:
 * - SYMBOL - a symbol to request from the sameAs Lite data store.
 *
 * Edit this file to specify the sameAs Lite data store to use.
 *
 * Example:
 * <pre>
 * $ php get_symbol.php http.51011a3008ce7eceba27c629f6d0020c
 * <pre>
 *
 * Copyright 2015 The University of Edinburgh
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
 * implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once 'vendor/autoload.php';

$store = new \SameAsLite\Store(
    'mysql:host=127.0.0.1;port=3306;charset=utf8',
    'table1',
    'testuser',
    'testpass',
    'testdb'
);

$result = $store->querySymbol($argv[1]);
print_r($result);

?>
