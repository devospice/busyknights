<?php

	/* /logout */

	include("includes/template/page_top.php");

	$_SESSION["loggedIn"] = false;
	$_SESSION["user"] = 0;
	$_SESSION["company"] = 0;

	echo "<meta http-equiv=\"refresh\" content=\"0;url=/\">";
	die();
	

?>