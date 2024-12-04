<?php

	/* This doesn't work because of the rewrite rule.  */

	include("includes/framework/functions.php");

	$fileName = $routes[3];
	$downloadPath = "/downloads/" . $fileName;

	header('Content-Type: application/octet-stream');
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($downloadPath));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . fileSize($downloadPath));
	ob_clean();
	flush();
	readfile($downloadPath);
	exit;	
	

?>