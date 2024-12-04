<?php

	$account = $cdb->real_escape_string($_POST["account"]);
	$percent = $cdb->real_escape_string($_POST["percent"]);

	$updateSQL = sprintf("UPDATE pre_allocations SET account = '%s', percent = '%s' WHERE id = %s", $account, $percent, $_POST["id"]);
	// echo $updateSQL;

	$result = runSQL($updateSQL, $cdb);
			
	if ($result == true) {
		$msg = "Pre-allocation successfully created.";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error creating your pre-allocation: %s</p>", $cdb->error);
	}
?>