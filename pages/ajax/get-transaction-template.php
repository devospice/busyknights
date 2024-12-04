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

$id = $_POST["id"];

$transactionsSQL = sprintf("SELECT * FROM transaction_templates WHERE ID = '%s'", $id);
$transactions = getDataFromTable($transactionsSQL, $cdb);
if ($transactions) {
	$transaction = $transactions[0];
	
	$entriesSQL = sprintf("SELECT * FROM template_entries WHERE transaction_template = '%s' ORDER BY entry_num", $transaction["id"]);
	$entries = getDataFromTable($entriesSQL, $cdb);
	
	$returnArray = array(
		"transaction"=>$transaction,
		"entries"=>$entries
	);
	
} else {
	$returnArray = array("error"=>"There was an error retrieving this transaction template information.");
}

returnJSON($returnArray);

?>