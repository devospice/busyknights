<?php

	$allocationId = $cdb->real_escape_string($_POST["id"]);
	
	$deleteSQL = sprintf("DELETE FROM pre_allocations WHERE id = '%s'", $allocationId);
	$result = runSQL($deleteSQL, $cdb);
	if ($result == true) {
		$msg = "Pre-allocation successfully deleted.<br>" . $deleteSQL;
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error deleting this pre-allocation: %s</p>", $cdb->error);
	}
	
?>