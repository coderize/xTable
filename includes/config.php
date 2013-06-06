<?php

$dbhost = 'localhost';
$dbusr  = 'root';
$dbpassword = 'testing';
$dbtable = 'xtable';


$db = mysql_connect($dbhost, $dbusr, $dbpassword) or die("DB Connection: Failed");
$sdb = mysql_select_db($dbtable) or die ("DB Table Selection: Failed");

mysql_set_charset('utf8');


?>
