<?php 
date_default_timezone_set('America/New_York');




$a = "00:00:00 12/19/2011";

$b = "09:00:00 12/22/2011";


echo $c = strtotime($a);

echo "<BR />";


echo $d = strtotime($b);

echo "<BR />";


echo date("m d Y h:i:s", $c);

echo "<BR />";

echo date("m d Y h:i:s", $d);







?>