<?php
	// Delete entries first.
	$transactionId = $cdb->real_escape_string($_POST["id"]);
	$isCleared = $cdb->real_escape_string($_POST["cleared"]);
	$msg = "";

	if ($isCleared == true) {
		$newClearValue = "FALSE";
	} else {
		$newClearValue = "TRUE";
	}

	$clearSQL = sprintf("UPDATE %s SET cleared = %s WHERE id = '%s'", $_SESSION["transactionsTable"], $newClearValue, $transactionId);
	$result = runSQL($clearSQL, $cdb);
	if ($result == true) {
		$msg .= "Transaction is cleared.<br>";
	} else {
		$msg .= sprintf("<p class=\"alert\">There was an error clearing the transaction: %s</p>", $cdb->error);
	}

		
?>