<?php

header("Content-type: text/html; charset=utf-8");  
error_reporting(E_ALL ^ E_NOTICE);
require "includes/config.php"; 
require "includes/sess.php";
session_start();

$client = $_GET['client'];
$project = $_GET['project'];
$rel = $_GET['rel'];


$client = str_replace(" ", "_",$client);
$project = str_replace(" ", "_", $project);

$client = preg_replace("/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:\<\>,\.\?\\\]/", "", $client);
$project = preg_replace("/[\'\/~`\!@#\$%\^&\*\(\)\-\+=\{\}\[\]\|;:\<\>,\.\?\\\]/", "", $project);


$wkhtml_loc = "/opt/wkhtmltopdf/bin/wkhtmltopdf";
$wkhtml_header = " --header-html https://xtable.4usable.net/xtable/header.php?rel={$rel} --margin-top 20 --header-spacing 0 -O Landscape "; 
$wkhtml_footer = "";
$page_to_convert = "https://xtable.4usable.net/xtable/exportwcss.php?rel={$rel} ";
$pdf_store_loc = "/var/www/html/xtable/pdf/";
$pdf_name = $client . "-". $project . "-" . time() . ".pdf";
$pdf_view = "https://xtable.4usable.net/xtable/pdf/" . $pdf_name;

//echo $pdf_view . "\n";

echo "Genetrating PDF...<br />";

system($wkhtml_loc . " " . $wkhtml_header . " " . $page_to_convert . " " . $pdf_store_loc . $pdf_name);

//system("/opt/wkhtmltopdf/bin/wkhtmltopdf http://www.google.com /var/www/html/xtable/pdf/google.pdf");

echo "Done...<br />";

echo "Loading PDF....<br />";

header("refresh:2;url=$pdf_view");
//header("refresh:2;url='https://xtable.4usable.net/xtable/pdf/google.pdf'");

//wkhtmltopdf --header-html http://localhost/usablex/xtable/header.php --header-spacing 5 -O Landscape http://localhost/usablex/xtable/exportwcss.php?rel=262 c:\curl\testcases.pdf

?>