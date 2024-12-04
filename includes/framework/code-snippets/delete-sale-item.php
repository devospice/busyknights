<?php
	$deleteSQL = sprintf("DELETE FROM sale_items WHERE id = %s", $_POST["id"]);
	$result = runSQL($deleteSQL, $cdb);
			
	if ($result == true) {
		$msg = "<p class=\"alert\">Item successfully deleted.</p>";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error deleting this item: %s</p>", $cdb->error);
	}
?>