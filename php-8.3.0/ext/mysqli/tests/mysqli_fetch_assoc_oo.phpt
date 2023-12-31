--TEST--
mysqli_fetch_assoc()
--EXTENSIONS--
mysqli
--SKIPIF--
<?php
require_once 'skipifconnectfailure.inc';
?>
--FILE--
<?php
    // Note: no SQL type tests, internally the same function gets used as for mysqli_fetch_array() which does a lot of SQL type test
    require 'table.inc';
    $mysqli = $link;

    if (!$res = $mysqli->query("SELECT id, label FROM test ORDER BY id LIMIT 1")) {
        printf("[004] [%d] %s\n", $mysqli->errno, $mysqli->error);
    }

    print "[005]\n";
    var_dump($res->fetch_assoc());

    print "[006]\n";
    var_dump($res->fetch_assoc());

    $res->free_result();

    if (!$res = $mysqli->query("SELECT 1 AS a, 2 AS a, 3 AS c, 4 AS C, NULL AS d, true AS e")) {
        printf("[007] Cannot run query, [%d] %s\n", $mysqli->errno, $mysqli->error);
    }
    print "[008]\n";
    var_dump($res->fetch_assoc());

    $res->free_result();

    try {
        $res->fetch_assoc();
    } catch (Error $exception) {
        echo $exception->getMessage() . "\n";
    }

    mysqli_close($link);

    print "done!";
?>
--CLEAN--
<?php
    require_once 'clean_table.inc';
?>
--EXPECT--
[005]
array(2) {
  ["id"]=>
  string(1) "1"
  ["label"]=>
  string(1) "a"
}
[006]
NULL
[008]
array(5) {
  ["a"]=>
  string(1) "2"
  ["c"]=>
  string(1) "3"
  ["C"]=>
  string(1) "4"
  ["d"]=>
  NULL
  ["e"]=>
  string(1) "1"
}
mysqli_result object is already closed
done!
