--TEST--
Phar: copy-on-write test 20 [cache_list]
--INI--
default_charset=UTF-8
phar.cache_list={PWD}/copyonwrite20.phar.php
phar.readonly=0
--EXTENSIONS--
phar
--FILE_EXTERNAL--
files/write20.phar
--EXPECT--
string(2) "hi"
NULL
ok
