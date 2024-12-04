<?php
	// Update main form values
	$deleteSQL = sprintf("DELETE FROM %s WHERE id = %s", $_SESSION["accountsTable"], $_POST["id"]);
	$result = runSQL($deleteSQL, $cdb);
			
	if ($result == true) {
		$msg = "<p class=\"alert\">Account successfully deleted.</p>";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error deleting your account: %s</p>", $cdb->error);
	}
?>