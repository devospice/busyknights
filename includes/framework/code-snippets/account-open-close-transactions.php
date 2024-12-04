			<?php
			// Get opening balance
			$yearStart = sprintf("%s-01-01", $_SESSION["activeYear"]);
			if (($account["accountType"] == "Asset") || ($account["accountType"] == "Expense")) {
				// Debit in, credit out
				
				/*$openingBalanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date < '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $startDate);*/
				// $openingBalanceSQL = getBalanceSQL("debit", "credit", $startDate, $endDate, $account["id"]);
				$openingBalanceSQL = getBalanceSQL("debit", "credit", $yearStart, $startDate, $account["id"]);
				
			} else {
				// Credit in, debit out
				/*$openingBalanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date < '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $startDate);*/
				// $openingBalanceSQL = getBalanceSQL("credit", "debit", $startDate, $endDate, $account["id"]);
				$openingBalanceSQL = getBalanceSQL("credit", "debit", $yearStart, $startDate, $account["id"]);
			}
			// echo $openingBalanceSQL . "<br>";
			$openingBalances = getDataFromTable($openingBalanceSQL, $cdb);
			$openingBalance = $openingBalances[0]["balance"];
			if (!$openingBalance) {
				$openingBalance = "0.00";
			}

			$fmt = new NumberFormatter( 'en', NumberFormatter::CURRENCY );
			$openingBalance = $fmt->formatCurrency($openingBalance, "USD")."\n";

			// $openingBalance = money_format("%(n", $openingBalance);
			
			
			// Get transactions
			$entriesSQL = sprintf("
				SELECT 
				%s.*, %s.*, sale_items.name AS itemName 
				FROM `%s` 
				LEFT JOIN %s ON %s.id = %s.transaction
				LEFT JOIN sale_items ON %s.sale_item = sale_items.id
				WHERE %s.account = '%s' AND %s.date >= '%s' AND %s.date <= '%s' 
				ORDER BY %s.date", 
				$_SESSION["transactionsTable"], $_SESSION["entriesTable"], 
				$_SESSION["transactionsTable"], 
				$_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], 
				$_SESSION["transactionsTable"],
				$_SESSION["entriesTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate, $_SESSION["transactionsTable"]);
			$entries = getDataFromTable($entriesSQL, $cdb);
			
			
			// Get closing balance
			if (($account["accountType"] == "Asset") || ($account["accountType"] == "Expense")) {
				// Debit in, credit out
				
				/*$closingBalanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $endDate);*/
				$closingBalanceSQL = getBalanceSQL("debit", "credit", $yearStart, $endDate, $account["id"]);
				// echo $balanceSQL;
			} else {
				// Credit in, debit out
				/*$closingBalanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $yearStart, $_SESSION["entriesTable"], $endDate);*/
				$closingBalanceSQL = getBalanceSQL("credit", "debit", $yearStart, $endDate, $account["id"]);
			}
			// echo $closingBalanceSQL . "<br>";
			$closingBalances = getDataFromTable($closingBalanceSQL, $cdb);
			$closingBalance = $closingBalances[0]["balance"];
			if (!$closingBalance) {
				$closingBalance = "0.00";
			}
			if (isset($isInvoice)) {
				$closingBalance = abs($closingBalance);
			}
			// $closingBalance = money_format("%(n", $closingBalance);
			$closingBalance = $fmt->formatCurrency($closingBalance, "USD")."\n";
			?>