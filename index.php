<?php

define ('SITE_ROOT', realpath(dirname(__FILE__)));

// Turn on errors.  Disable on launch or set to only show up in staging.
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

// Previously in common.php
include("includes/framework/config.php");
include("includes/framework/functions.php");
include("includes/framework/session.php");


// Removes the domain name from the URL
function getCurrentUri()	 {
	$basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
	$uri = substr($_SERVER['REQUEST_URI'], strlen($basepath));
	if (strstr($uri, '?')) $uri = substr($uri, 0, strpos($uri, '?'));
	$uri = '/' . trim($uri, '/');
	return $uri;
}

// Returns the subdomain for the URL.  Ex, returns "comp" in "comp.busyknights.com".
function getSubdomain () {
	$domainAr = explode(".", $_SERVER['HTTP_HOST']);
	return $domainAr[0];
}

$base_url = getCurrentUri();

// Set up routes array
$routes = array();
$routes = explode('/', $base_url);

// Get users associated with this subdomain
$subdomain = getSubdomain();
$companySQL = sprintf("SELECT companies.*, users.username, users.password, users.id as userId FROM companies LEFT JOIN users ON companies.id = users.company WHERE `customer_subdomain` = '%s'", $subdomain);
$companyAr = getDataFromTable("$companySQL");

// Password protect environment	
$valid_passwords = array();
foreach ($companyAr as $company) {
	$valid_passwords[$company["username"]] = $company["password"];
}

$valid_users = array_keys($valid_passwords);

if (isset($_SERVER['PHP_AUTH_USER'])) {
	$user = $_SERVER['PHP_AUTH_USER'];
} else {
	$user = "";
}
if (isset($_SERVER['PHP_AUTH_PW'])) {
	$passInput = $_SERVER['PHP_AUTH_PW'];
	$hash = $valid_passwords[$user];
	$pass = password_verify($passInput, $hash);
} else {
	$pass = "";
}

$validated = (in_array($user, $valid_users)) && ($pass == true);

if (!$validated) {
	header('WWW-Authenticate: Basic realm="Password Protected Area"');
	header('HTTP/1.0 401 Unauthorized');
	die ("You are not authorized to view this content.");
} else {
	// Log in this user
	$userSQL = sprintf("SELECT * FROM users WHERE username = '%s'", $user);	
	$userAr = getDataFromTable($userSQL);

	// Store user information
	$_SESSION["loggedIn"] = true;
	$_SESSION["user"] = $userAr[0];
	
	// Store company information
	$companySQL = sprintf("SELECT * FROM companies WHERE id = '%s'", $_SESSION["user"]["company"]);
	$companies = getDataFromTable($companySQL);
	$_SESSION["company"] = $companies[0];
}




// Get page to display
$folderName = "";

if ($routes[1] == "") {
	$pageName = "home.php";
} else {
	$folderName = $routes[1];
	if (!isset($routes[2])) {
		$pageName = "index.php";
	} else {
		$pageName = $routes[2]. ".php";
	}
	// $pageName = $routes[1] . ".php";
}
$filePath = $folderName . "/" . $pageName;

// Load page
if (file_exists("pages/".$filePath)) {
	include("pages/".$filePath);
} else {
	include("pages/404.php");
	// include("/pages/search/index.php?q=".$routes[1]);
	// header( 'Location: /search?q='.$routes[1] ) ;
}


?>