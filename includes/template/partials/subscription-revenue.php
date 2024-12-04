<?php

/* --- PERIOD 1 --- */

	$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
	$ts = mktime(0, 0, 0, 1, 1, $_SESSION["activeYear"]);
	$leap = date("L", $ts);
	if ($leap == true) {
		$endDate = sprintf("%s-02-29", $_SESSION["activeYear"]);
	} else {
		$endDate = sprintf("%s-02-28", $_SESSION["activeYear"]);
	}

	// Get net subscription revenue
	$p1SQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 18 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p1Subs2 = getDataFromTable($p1SQL2, $cdb);
	$p1Sub2Net = $p1Subs2[0]["balance"];

	// Get subscription fees
	$p1SQL2a = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS feetotal
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.id = 493 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p1Subs2a = getDataFromTable($p1SQL2a, $cdb);
	$p1Sub2Fee = $p1Subs2a[0]["feetotal"];

	// Get total subscription revenue
	$p1Sub2 = $p1Sub2Net - $p1Sub2Fee;

/* --- PERIOD 2 --- */

	$startDate = sprintf("%s-03-01", $_SESSION["activeYear"]);
	$endDate = sprintf("%s-04-30", $_SESSION["activeYear"]);

	// Get net subscription revenue
	$p2SQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 18 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);

	$p2Subs2 = getDataFromTable($p2SQL2, $cdb);
	$p2Sub2Net = $p2Subs2[0]["balance"];


	// Get subscription fees
	$p2SQL2a = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS feetotal
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.id = 493 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p2Subs2a = getDataFromTable($p2SQL2a, $cdb);
	$p2Sub2Fee = $p2Subs2a[0]["feetotal"];

	// Get total subscription revenue
	$p2Sub2 = $p2Sub2Net - $p2Sub2Fee;


/* --- PERIOD 3 --- */

	$startDate = sprintf("%s-05-01", $_SESSION["activeYear"]);
	$endDate = sprintf("%s-06-30", $_SESSION["activeYear"]);

	// Get net subscription revenue
	$p3SQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 18 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	$p3Subs2 = getDataFromTable($p3SQL2, $cdb);
	$p3Sub2Net = $p3Subs2[0]["balance"];

	// Get subscription fees
	$p3SQL2a = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS feetotal
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.id = 493 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p3Subs2a = getDataFromTable($p3SQL2a, $cdb);
	$p3Sub2Fee = $p3Subs2a[0]["feetotal"];

	// Get total subscription revenue
	$p3Sub2 = $p3Sub2Net - $p3Sub2Fee;


/* --- PERIOD 4 --- */

	$startDate = sprintf("%s-07-01", $_SESSION["activeYear"]);
	$endDate = sprintf("%s-08-31", $_SESSION["activeYear"]);

	// Get net subscription revenue
	$p4SQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 18 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	$p4Subs2 = getDataFromTable($p4SQL2, $cdb);
	$p4Sub2Net = $p4Subs2[0]["balance"];


	// Get subscription fees
	$p4SQL2a = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS feetotal
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.id = 493 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p4Subs2a = getDataFromTable($p4SQL2a, $cdb);
	$p4Sub2Fee = $p4Subs2a[0]["feetotal"];

	// Get total subscription revenue
	$p4Sub2 = $p4Sub2Net - $p4Sub2Fee;


/* --- PERIOD 5 --- */

	$startDate = sprintf("%s-09-01", $_SESSION["activeYear"]);
	$endDate = sprintf("%s-10-31", $_SESSION["activeYear"]);

	// Get net subscription revenue
	$p5SQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 18 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	$p5Subs2 = getDataFromTable($p5SQL2, $cdb);
	$p5Sub2Net = $p5Subs2[0]["balance"];

	// Get subscription fees
	$p5SQL2a = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS feetotal
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.id = 493 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p5Subs2a = getDataFromTable($p5SQL2a, $cdb);
	$p5Sub2Fee = $p5Subs2a[0]["feetotal"];

	// Get total subscription revenue
	$p5Sub2 = $p5Sub2Net - $p5Sub2Fee;

/* --- PERIOD 6 --- */

	$startDate = sprintf("%s-11-01", $_SESSION["activeYear"]);
	$endDate = sprintf("%s-12-31", $_SESSION["activeYear"]);

	// Get net subscription revenue
	$p6SQL2 = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) AS balance
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.category = 18 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	$p6Subs2 = getDataFromTable($p6SQL2, $cdb);
	$p6Sub2Net = $p6Subs2[0]["balance"];

	// Get subscription fees
	$p6SQL2a = sprintf("SELECT %s.*,
		COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) AS feetotal
		FROM %s 
		LEFT JOIN %s ON %s.transaction = %s.id
		LEFT JOIN %s ON %s.account = %s.id
		WHERE %s.id = 493 AND %s.date >= '%s' AND %s.date <= '%s'", 
					$_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"],
					$_SESSION["accountsTable"], $_SESSION["entriesTable"], 
					$startDate, $_SESSION["entriesTable"], $endDate);
	
	$p6Subs2a = getDataFromTable($p6SQL2a, $cdb);
	$p6Sub2Fee = $p6Subs2a[0]["feetotal"];

	// Get total subscription revenue
	$p6Sub2 = $p6Sub2Net - $p6Sub2Fee;


?>