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

$selectID = $_POST["id"];

$lastSQL = sprintf("SELECT MAX(id) as lastId FROM %s", $_SESSION["accountsTable"]);
$lastAr = getDataFromTable($lastSQL, $cdb);
$lastInsertID = $lastAr[0]["lastId"];

$accountsSQL = sprintf("SELECT * FROM %s ORDER BY name", $_SESSION["accountsTable"]);
$accounts = getDataFromTable($accountsSQL, $cdb);

foreach ($accounts as $account) {
	$selected = "";
	if ($account["id"] == $lastInsertID) {
		$selected = "selected";
	}
	printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
}

?>