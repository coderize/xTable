<?php
error_reporting(E_ALL ^ E_NOTICE);

$client = $_GET['client'];
$project = $_GET['project'];
$rel = $_GET['rel'];
$client = str_replace(" ", "_",$client);
$project = str_replace(" ", "_", $project);
$client = str_replace("/", "_",$client);
$project = str_replace("/", "_", $project);




$wkhtml_loc = "C:\\wkhtmltopdf\\wkhtmltopdf.exe ";
$wkhtml_header = " --header-html http://localhost/usablex/header.php?rel={$rel} --margin-top 20 --header-spacing 0 -O Landscape "; 
$wkhtml_footer = "";
$page_to_convert = " http://localhost/usablex/exportwcss.php?rel={$rel} ";
$pdf_store_loc = "C:\\xampp\htdocs\\usablex\\pdf\\";
$pdf_name = $client . "-". $project. "-" . time() . ".pdf";
$pdf_view = "http://10.10.40.31/usablex/pdf/" . $pdf_name;

//echo $pdf_view . "\n";

echo "Genetrating PDF...<br />";

system($wkhtml_loc . $wkhtml_header . $page_to_convert . $pdf_store_loc . $pdf_name);

echo "Done...<br />";

echo "Loading PDF....<br />";

header("refresh:2;url=$pdf_view");

//wkhtmltopdf --header-html http://localhost/usablex/xtable/header.php --header-spacing 5 -O Landscape http://localhost/usablex/xtable/exportwcss.php?rel=262 c:\curl\testcases.pdf

























?>