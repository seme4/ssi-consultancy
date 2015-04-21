#!/bin/bash

# Copyright 2015 The University of Edinburgh
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#   http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
# implied.
# See the License for the specific language governing permissions and
# limitations under the License.

function run_profile {
    DIR=profiles/$1
    SCRIPT=$2
    COUNT=$3
    rm -rf $DIR
    mkdir -p $DIR
    echo "---Profile $1 - $SCRIPT----"
    ./profile.sh $SCRIPT $COUNT 2> $DIR/get_time.txt
    mv get.log $DIR/
    echo "---Profile $1 - curl---"
    ./profile.sh curly $COUNT 2> $DIR/curly_time.txt
    mv curly.log $DIR/
    grep TIME $DIR/curly.log | awk -F"CURL TIME: " 'NR > 0 { print $2 }' > $DIR/curly_curl_times.txt
}

if [ $# -gt 0 ]; then
  N=$1
else
  N=1
fi

echo "---Create data----"
mysql -u root -pubuntu -e "USE testdb; TRUNCATE table1;"
mysql -u root -pubuntu -e "USE testdb; SELECT COUNT(*) FROM table1;"
php create_data.php 100 table1 testdb > mysql.sql
mysql -u root -pubuntu < mysql.sql 
mysql -u root -pubuntu -e "USE testdb; SELECT COUNT(*) FROM table1;"
echo "Check present: http.51011a3008ce7eceba27c629f6d0020c http.f9070a2d98db3c376dcd2d4d8c0cd220"
mysql -u root -pubuntu -e "USE testdb; SELECT * FROM table1 where symbol='http.f9070a2d98db3c376dcd2d4d8c0cd220';"
echo "Check present: http.e5e8c7e32278573b20b15d7349a895d1 http.f26aff24a6fd831094b2520a8a5197a3"
mysql -u root -pubuntu -e "USE testdb; SELECT * FROM table1 where symbol='http.f26aff24a6fd831094b2520a8a5197a3';"

git checkout master
run_profile master get_symbol $N
git checkout db_class
run_profile db_class get_symbol_subclass $N
git checkout master
