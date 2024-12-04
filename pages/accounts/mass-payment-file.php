<?php

	include("includes/framework/login-check.php");
	$cdb = get_cdb();

	/*
	Column A - Add recipient's contact info like email, mobile number, or PayPal PayerID. If sending Venmo payouts, you must use a mobile number.

	Column B - The payment amount should be formatted specific to the sender's country or region.

	Column C - You can enter only one 3-letter currency code type per payment file.

	Column D - Unique identifier for individual recipients with a maximum of a 63-character limit (optional).

	Column E - Custom messaging (max. 1000 characters). Mandatory when sending to Venmo recipients. Optional when sending to PayPal recipients.

	Column F - Choose either a PayPal or Venmo wallet to send payments. If no wallet is specified, it will default to PayPal.
	*/

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
		
		/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $endDate);*/
		$balanceSQL = getBalanceSQL("credit", "debit", $yearStart, $endDate, $account["id"]);

		// echo $balanceSQL . "<br>";
		$balances = getDataFromTable($balanceSQL, $cdb);
		$balance = $balances[0]["balance"];
		
		if ($balance >= 10) {
			
			// Need to get payment info from here for each account
			$paymentSQL = sprintf("SELECT 
				payment_info.*, payment_info_paypal.email AS paypalEmail, payment_info_venmo.handle AS venmoHandle
				FROM payment_info 
				LEFT JOIN payment_info_paypal ON payment_info_paypal.id = payment_info.info
				LEFT JOIN payment_info_venmo ON payment_info_venmo.id = payment_info.info
				WHERE account = '%s' AND (payment_info.method = '1' OR payment_info.method = '4')", $account["id"]);
			$paymentAr = getDataFromTable($paymentSQL, $cdb);
			
			$length = count($paymentAr);
			if ($length > 0) {
				$payment = $paymentAr[0];
			} else {
				$payment = false;
			}
			
			if ($payment) {
				if (($payment["method"] == 4) && ($payment["is_preferred"] == true)) {
					// Venmo
					printf("%s,%s,USD,Payment for FuMP royalties,Venmo<br>", $payment["venmoHandle"], $balance);
				} else if (($payment["method"] == 1) && ($payment["is_preferred"] == true)) {
					// Paypal
					// printf("%s<br>", $account["name"]);
					printf("%s,%s,USD,Payment for FuMP royalties,PayPal<br>", $payment["paypalEmail"], $balance);
				}
			} /*else {
				printf("No payment info found for account %s<br>", $account["name"]);
				echo $paymentSQL . "<br>";
			}*/
		}
		
		
	}

?>
