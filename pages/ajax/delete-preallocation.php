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
include("includes/framework/code-snippets/delete-preallocation.php");

echo $msg;

?>