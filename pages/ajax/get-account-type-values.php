<?php

/* This page is only called via AJAX */

// Only allow calls from busyknights.com
$http_origin = $_SERVER['HTTP_ORIGIN'];

if (
	$http_origin == "http://stage.busyknights.com" || 
	$http_origin == "http://busyknights.com" || 
	$http_origin == "http://www.busyknights.com" || 
	$http_origin == "https://stage.busyknights.com" || 
	$http_origin == "https://busyknights.com" || 
	$http_origin == "https://www.busyknights.com" )
{  
    header("Access-Control-Allow-Origin: $http_origin");
}

include("includes/common.php");
$cdb = get_cdb();

$newType = $_POST["newType"];

$categorySQL = sprintf("SELECT * FROM account_category WHERE applies_to = '%s' ORDER BY name", $newType);
$categories = getDataFromTable($categorySQL, $cdb);
print("<option value=\"0\">--== NONE ==--</option>");
foreach ($categories as $category) {
	if ($category["id"] == "0") {
		printf("<option value=\"%s\">--== NONE ==--</option>", $category["id"]);
	} else {
		printf("<option value=\"%s\">%s</option>", $category["id"], $category["name"]);
	}
}

?>