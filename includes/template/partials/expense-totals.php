<?php

/* --- SUPPLIES - 1 --- */

	$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
	$endDate = sprintf("%s-12-31", $_SESSION["activeYear"]);

	$expSQL1 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 1 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$expenses1 = getDataFromTable($expSQL1, $cdb);
	$expense1 = $expenses1[0]["balance"];

/* --- COMMUNICATION - 2 --- */

	$expSQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 2 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses2 = getDataFromTable($expSQL2, $cdb);
	$expense2 = $expenses2[0]["balance"];

/* --- TAXES - 7 --- */

	$expSQL7 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 7 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses7 = getDataFromTable($expSQL7, $cdb);
	$expense7 = $expenses7[0]["balance"];

/* --- ADVERTISING - 8 --- */

	$expSQL8 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 8 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses8 = getDataFromTable($expSQL8, $cdb);
	$expense8 = $expenses8[0]["balance"];

/* --- BUSINESS TRAVEL - 9 --- */

	$expSQL9 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 9 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses9 = getDataFromTable($expSQL9, $cdb);
	$expense9 = $expenses9[0]["balance"];

/* --- MEALS AND ENTERTAINMENT - 10 --- */

	$expSQL10 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 10 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses10 = getDataFromTable($expSQL10, $cdb);
	$expense10 = $expenses10[0]["balance"];

/* --- EQUIPMENT RENTAL - 11 --- */

	$expSQL11 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 11 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses11 = getDataFromTable($expSQL11, $cdb);
	$expense11 = $expenses11[0]["balance"];

/* --- LEGAL AND PROFESSIONAL FEES - 12 --- */

	$expSQL12 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 12 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses12 = getDataFromTable($expSQL12, $cdb);
	$expense12 = $expenses12[0]["balance"];


/* --- COMMISSIONS - 13 --- */

	$expSQL13 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 13 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses13 = getDataFromTable($expSQL13, $cdb);
	$expense13 = $expenses13[0]["balance"];

/* --- CONTRACT LABOR - 14 --- */

	$expSQL14 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 14 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses14 = getDataFromTable($expSQL14, $cdb);
	$expense14 = $expenses14[0]["balance"];

/* --- OTHER OFFICE EXPENSES - 15 --- */

	$expSQL15 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 15 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses15 = getDataFromTable($expSQL15, $cdb);
	$expense15 = $expenses15[0]["balance"];

/* --- MISCELLANEOUS/POSTAGE - 16 --- */

	$expSQL16 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 16 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $_SESSION["entriesTable"], $endDate);	
	$expenses16 = getDataFromTable($expSQL16, $cdb);
	$expense16 = $expenses16[0]["balance"];


?>