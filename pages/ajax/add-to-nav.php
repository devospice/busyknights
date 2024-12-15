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

// Update main form values
$updateSQL = sprintf("UPDATE %s SET list_on_left = TRUE WHERE id = %s", $_SESSION["accountsTable"], $_POST["id"]);
$result = runSQL($updateSQL, $cdb);

if ($result == true) {
	$msg = "<p class=\"alert\">Account added to left.</p>";
} else {
	$msg = sprintf("<p class=\"alert\">There was an error editing your account: %s</p>", $cdb->error);
}

echo $msg;

?>