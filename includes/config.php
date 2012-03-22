<?php
ob_start();

$db = mysql_connect("localhost", "root", "");

$sdb = mysql_select_db("usablex");

mysql_set_charset('utf8',$db);

?>