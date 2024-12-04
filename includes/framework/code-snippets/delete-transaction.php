<?php
	// Delete entries first.
	$transactionId = $cdb->real_escape_string($_POST["id"]);
	$msg = "";
	
	$deleteSQL1 = sprintf("DELETE FROM %s WHERE transaction = '%s'", $_SESSION["entriesTable"], $transactionId);
	$result = runSQL($deleteSQL1, $cdb);
	if ($result == true) {
		$msg .= "All journal entries for this transaction successfully deleted.<br>";
	} else {
		$msg .= sprintf("<p class=\"alert\">There was an error deleting one or more entry: %s</p>", $cdb->error);
	}

	// Now delete the transaction.			
	$deleteSQL2 = sprintf("DELETE FROM %s WHERE id = '%s'", $_SESSION["transactionsTable"], $transactionId);
	$result = runSQL($deleteSQL2, $cdb);
	if ($result == true) {
		$msg .= "This transaction has been successfully deleted.";
	} else {
		$msg .= sprintf("<p class=\"alert\">There was an error deleting this transaction: %s</p>", $cdb->error);
	}
	
	// Now delete any inventory transactions
	$deleteSQL3 = sprintf("DELETE FROM inventory WHERE transaction = '%s'", $transactionId);
	$result = runSQL($deleteSQL3, $cdb);
	if ($result == true) {
		$msg .= "Inventory transaction has been successfully deleted.";
	} else {
		$msg .= sprintf("<p class=\"alert\">There was an error deleting this inventory transaction: %s</p>", $cdb->error);
	}
	
?>