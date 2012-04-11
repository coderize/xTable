<?php
ob_start();

$db = mysql_connect("localhost", "root", "testing450311");

$sdb = mysql_select_db("xtable");

mysql_set_charset('utf8',$db);

?>