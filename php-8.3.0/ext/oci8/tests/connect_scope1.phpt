--TEST--
Test oci_connect end-of-scope when statement returned
--EXTENSIONS--
oci8
--SKIPIF--
<?php
require_once 'skipifconnectfailure.inc';
?>
--FILE--
<?php

require __DIR__.'/details.inc';

// Initialization

$stmtarray = array(
    "drop table connect_scope1_tab",
    "create table connect_scope1_tab (c1 number)",
);

if (!empty($dbase))
    $c1 = oci_new_connect($user,$password,$dbase);
else
    $c1 = oci_new_connect($user,$password);

oci8_test_sql_execute($c1, $stmtarray);

// Run Test

echo "Test 1 - oci_connect\n";

function f()
{
    global $user, $password, $dbase;

    if (!empty($dbase))
        $c = oci_connect($user,$password,$dbase);
    else
        $c = oci_connect($user,$password);
    $s = oci_parse($c, "insert into connect_scope1_tab values (1)");
    oci_execute($s, OCI_DEFAULT);  // no commit
    return($s); // this keeps the connection refcount positive so the connection isn't closed
}

$s2 = f();

// Check nothing committed yet

$s1 = oci_parse($c1, "select * from connect_scope1_tab");
oci_execute($s1, OCI_DEFAULT);
oci_fetch_all($s1, $r);
var_dump($r);

// insert 2nd row on returned statement, committing both rows
oci_execute($s2);

// Verify data was committed

$s1 = oci_parse($c1, "select * from connect_scope1_tab");
oci_execute($s1);
oci_fetch_all($s1, $r);
var_dump($r);

// Cleanup

$stmtarray = array(
    "drop table connect_scope1_tab"
);

oci8_test_sql_execute($c1, $stmtarray);

echo "Done\n";

?>
--EXPECT--
Test 1 - oci_connect
array(1) {
  ["C1"]=>
  array(0) {
  }
}
array(1) {
  ["C1"]=>
  array(2) {
    [0]=>
    string(1) "1"
    [1]=>
    string(1) "1"
  }
}
Done
