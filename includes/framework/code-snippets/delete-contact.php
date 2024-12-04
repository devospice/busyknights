<?php
	// Update main form values
	$deleteSQL = sprintf("DELETE FROM contacts WHERE id = %s", $_POST["id"]);
	$result = runSQL($deleteSQL, $cdb);
			
	if ($result == true) {
		$msg = "Contact successfully deleted.";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error deleting your account: %s</p>", $cdb->error);
	}
?>