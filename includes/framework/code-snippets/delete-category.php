<?php
	// Update main form values
	$deleteSQL = sprintf("DELETE FROM account_category WHERE id = %s", $_POST["id"]);
	$result = runSQL($deleteSQL, $cdb);

	if ($result == true) {
		$msg = "<p class=\"alert\">Category successfully deleted.</p>";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error deleting your category: %s</p>", $cdb->error);
	}
?>