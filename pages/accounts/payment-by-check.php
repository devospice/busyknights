<?php

	include("includes/framework/login-check.php");
	$cdb = get_cdb();

	// Get all liability accounts
	$liabilitySQL = sprintf("SELECT * FROM %s WHERE type = '2' ORDER BY name", $_SESSION["accountsTable"]);
	$accounts = getDataFromTable($liabilitySQL, $cdb);

	// Get date range
	$startDate = $cdb->real_escape_string($_POST["startdate"]);
	$endDate = $cdb->real_escape_string($_POST["enddate"]);
	$yearStart = sprintf("%s-01-01", $_SESSION["activeYear"]);

	foreach ($accounts as $account) {
		
		// Calculate balance for account.  Liability account: Debits are outflows.  Credits are inflows.
		/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
							  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);*/
		
		/*$openingBalanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $endDate);*/
		/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
							  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $endDate);*/
		$balanceSQL = getBalanceSQL("credit", "debit", $yearStart, $endDate, $account["id"]);

		
		// echo $balanceSQL . "<br>";
		$balances = getDataFromTable($balanceSQL, $cdb);
		$balance = $balances[0]["balance"];
		// echo "balance: " . $balance . "<br>";
		
		if ($balance >= 10) {
			
			// Need to get payment info from here for each account
			$paymentSQL = sprintf("SELECT 
				payment_info.*, payment_info_paypal.email AS paypalEmail, payment_info_venmo.handle AS venmoHandle
				FROM payment_info 
				LEFT JOIN payment_info_paypal ON payment_info_paypal.id = payment_info.info
				LEFT JOIN payment_info_venmo ON payment_info_venmo.id = payment_info.info
				WHERE account = '%s' AND payment_info.method = '2'", $account["id"]);
			$paymentAr = getDataFromTable($paymentSQL, $cdb);
			
			$length = count($paymentAr);
			if ($length > 0) {
				$payment = $paymentAr[0];
			} else {
				$payment = false;
			}
			
			if ($payment) {
				
				if ($payment["is_preferred"] == true) {
					
					// Get payment info data
					$paymentInfoSQL = sprintf("SELECT * FROM payment_info_check WHERE id = '%s'", $payment["info"]);
					$paymentInfoAr = getDataFromTable($paymentInfoSQL, $cdb);
					$paymentInfo = $paymentInfoAr[0];

					// Display payment information
					printf("Account: %s<br>", $account["name"]);
					printf("Balance: %s<br>", $balance);
					printf("Payable to: %s<br><br>", $paymentInfo["pay_to"]);
					echo "Mail to:<br>";
					printf("%s<br>", $paymentInfo["mail_to"]);
					printf("%s<br>", $paymentInfo["address"]);
					printf("%s<br>", $paymentInfo["address2"]);
					printf("%s, %s %s<br>", $paymentInfo["city"], $paymentInfo["state"], $paymentInfo["zip"]);
					if ($paymentInfo["country"] != "USA") {
						printf("%s<br>", $paymentInfo["country"]);
					}
					echo "----------<br><br>";
					
				}
				
			} 
			
		}
		
		
	}

?>
