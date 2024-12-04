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

// Reads the post id and deletes the transaction and entries.  Returns errors or alerts in $msg variable.
$formValues = getValuesFromForm($_POST, false);

$accountId = $cdb->real_escape_string($_POST["id"]);
$newBalance = $cdb->real_escape_string($_POST["starting_balance"]);


$updateSQL = sprintf("UPDATE %s SET starting_balance = '%s' WHERE id = '%s'", $_SESSION["accountsTable"], $newBalance, $accountId);
$result = runSQL($updateSQL, $cdb);

if ($result == true) {
	$msg = "Starting balance successfully updated." . $updateSQL;
} else {
	$msg = sprintf("<p class=\"alert\">There was an error updating your starting balance: %s</p>", $cdb->error);
}

echo $msg;

?>