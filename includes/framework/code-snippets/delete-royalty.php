<?php
	$deleteSQL = sprintf("DELETE FROM royalties WHERE id = '%s'", $_POST["id"]);
	$result = runSQL($deleteSQL, $cdb);
			
	if ($result == true) {
		$msg = "<p class=\"alert\">Royalty successfully deleted.</p>";
	} else {
		$msg = sprintf("<p class=\"alert\">There was an error deleting this royalty: %s</p>", $cdb->error);
	}

?>