--TEST--
PDO SQLite Bug #33841 (rowCount() does not work on prepared statements)
--EXTENSIONS--
pdo_sqlite
--FILE--
<?php
require __DIR__ . '/../../../ext/pdo/tests/pdo_test.inc';
$db = PDOTest::test_factory(__DIR__ . '/common.phpt');

$db->exec('CREATE TABLE test_33841 (text)');

$stmt = $db->prepare("INSERT INTO test_33841 VALUES ( :text )");
$stmt->bindParam(':text', $name);
$name = 'test1';
var_dump($stmt->execute(), $stmt->rowCount());

$stmt = $db->prepare("UPDATE test_33841 SET text = :text ");
$stmt->bindParam(':text', $name);
$name = 'test2';
var_dump($stmt->execute(), $stmt->rowCount());
?>
--CLEAN--
<?php
require __DIR__ . '/../../../ext/pdo/tests/pdo_test.inc';
$db = PDOTest::test_factory(__DIR__ . '/common.phpt');
$db->exec('DROP TABLE IF EXISTS test_33841');
?>
--EXPECT--
bool(true)
int(1)
bool(true)
int(1)
