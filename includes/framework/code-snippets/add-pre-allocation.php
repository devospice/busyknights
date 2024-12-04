<?php
	$formValues = getValuesFromForm($_POST, false);
	$insertSQL = sprintf("INSERT INTO pre_allocations (%s) VALUES (%s)", $formValues[0], $formValues[1]);
	$result = runSQL($insertSQL, $cdb);
			
	if ($result == true) {
		$msg = "Pre-allocation successfully created.";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error creating your pre-allocation: %s</p>", $cdb->error);
	}
?>