--TEST--
phpiredis reader feed and parse
--SKIPIF--
<?php include 'skipif.inc'; ?>
--FILE--
<?php
$reader = phpiredis_reader_create();
phpiredis_reader_feed($reader, "+OK\r\n");
phpiredis_reader_feed($reader, "-Error\r\n");
var_dump(phpiredis_reader_get_reply($reader));
var_dump(phpiredis_reader_get_reply($reader));
var_dump(phpiredis_reader_get_reply($reader)); // extra read
phpiredis_reader_feed($reader, ":123\r\n");
phpiredis_reader_feed($reader, "$3\r\nSET\r\n");
phpiredis_reader_feed($reader, "*3\r\n$3\r\nSET\r\n$1\r\na\r\n$2\r\nAS\r\n");
phpiredis_reader_feed($reader, "nSET\r\n");
var_dump(phpiredis_reader_get_reply($reader));
var_dump(phpiredis_reader_get_reply($reader));
var_dump(phpiredis_reader_get_reply($reader));
var_dump(phpiredis_reader_get_reply($reader));
?>
--EXPECTF--
string(2) "OK"
NULL
bool(false)
int(123)
string(3) "SET"
array(3) {
  [0]=>
  string(3) "SET"
  [1]=>
  string(1) "a"
  [2]=>
  string(2) "AS"
}
bool(false)
