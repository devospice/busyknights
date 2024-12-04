<?php
	// Delete entries first.
	$templateId = $cdb->real_escape_string($_POST["id"]);
	$msg = "";
	
	$deleteSQL1 = sprintf("DELETE FROM template_entries WHERE transaction_template = '%s'", $templateId);
	$result = runSQL($deleteSQL1, $cdb);
	if ($result == true) {
		$msg .= "All journal entries for this transaction template successfully deleted.<br>";
	} else {
		$msg .= sprintf("<p class=\"alert\">There was an error deleting one or more entry: %s</p>", $cdb->error);
	}

	// Now delete the transaction template.			
	$deleteSQL2 = sprintf("DELETE FROM transaction_templates WHERE id = '%s'", $templateId);
	$result = runSQL($deleteSQL2, $cdb);
	if ($result == true) {
		$msg .= "This template has been successfully deleted.";
	} else {
		$msg .= sprintf("<p class=\"alert\">There was an error deleting this template: %s</p>", $cdb->error);
	}
	
	
?>