<?php

$db = mysql_connect("localhost", "root", "testing") or die("Could not connect to DB");
$sdb = mysql_select_db("xtable") or die ("Could not select database");

mysql_set_charset('utf8');


?>
