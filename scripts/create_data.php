<?php

/**
 * sameAs Lite random data creator.
 *
 * Create SQL script to populate a table with randomly created
 * canons and symbols. A seed is used so the random values
 * created each time are the same. The SQL is written to standard
 * output.
 *
 * Usage:
 * <pre>
 * $ php create_data.php N TABLE [DATABASE]
 * </pre>
 * where:
 * - N - number of canons and symbols per canon.
 * - TABLE - table name.
 * - DATABASE - optional database name.
 * Example:
 * <pre>
 * $ php create_data.php 100 table1 testdb > mysql.sql
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

$count = $argv[1];
$table = $argv[2];
if (count($argv) > 3)
{
    $db = $argv[3];
    $sql = "USE " . $db . ";\n";
    print $sql;
}
mt_srand($count * $count);
for ($i=0; $i<$count; $i++)
{
    $canon = "http." . md5(mt_rand());
    $sql = "INSERT INTO " . $table . " VALUES('" .
        $canon . "', '" . $canon . "');\n";
    print $sql;
    for ($j=0; $j<$count; $j++)
    {
        $symbol = "http." . md5(mt_rand());
        $sql = "INSERT INTO " . $table . " VALUES('" .
            $canon . "', '" . $symbol . "');\n";
        print $sql;
    }
}
?>
