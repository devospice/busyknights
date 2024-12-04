<?php

// Start or resume the session.
session_start();
 
/*global $loggedIn;
// Start off assuming the user is not logged in.
if(!isset($_SESSION["loggedIn"])) {
	$loggedIn = 0;
}else{
	$loggedIn = 1;
	if($_SESSION['loggedIn'] == 1){
		header('location: logout.php');
		exit();
	}
}*/

if (!isset($_SESSION["loggedIn"])) {
	$_SESSION["loggedIn"] = false;
	$_SESSION["user"] = 0;
	$_SESSION["company"] = 0;
}

function get_db () {
	
	static $db;
	
	if (!$db) {
		$db = new mysqli("mysql.fidim.com", KNIGHT_USERNAME, KNIGHT_PASSWORD, "busy_knights");
		if ($db->connect_errno) {
			echo "Error: Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
		}
	}
	
	return $db;
	
}
$db = get_db();



function get_cdb () {
	
	static $cdb = false;
	
	if ($_SESSION["loggedIn"] == true) {
		if (!$cdb) {
			$cdb = new mysqli("mysql.fidim.com", KNIGHT_USERNAME, KNIGHT_PASSWORD, $_SESSION["company"]["customer_database"]);
			if ($cdb->connect_errno) {
				echo "Error: Failed to connect to MySQL: (" . $cdb->connect_errno . ") " . $cdb->connect_error;
			}
		}
	}
	
	return $cdb;
	
}
$cdb = get_cdb();


// var_dump($db);


// Set the default time zone to EST
date_default_timezone_set ("America/New_York");


// Set current year
global $accountsTable;
global $transactionsTable;
global $entriesTable;

if (!isset($_SESSION["activeYear"])) {
    setActiveYear(date("Y"));
}
if (!isset($accountsTable)) {
    $accountsTable = $_SESSION["accountsTable"];
}
if (!isset($transactionsTable)) {
    $transactionsTable = $_SESSION["transactionsTable"];
}
if (!isset($entriesTable)) {
    $entriesTable = $_SESSION["entriesTable"];
}



?>