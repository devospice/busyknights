<?php
	$formValues = getValuesFromForm($_POST, false);
	$insertSQL = sprintf("INSERT INTO %s (%s) VALUES (%s)", $_SESSION["accountsTable"], $formValues[0], $formValues[1]);
	$result = runSQL($insertSQL, $cdb);
			
	if ($result == true) {
		$msg = "Account successfully created.";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error creating your account: %s</p>", $cdb->error);
	}
?>