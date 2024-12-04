<?php

	include("includes/framework/login-check.php");
	$cdb = get_cdb();

	// Get form data
	$startDate = $cdb->real_escape_string($_POST["startdate"]);
	$endDate = $cdb->real_escape_string($_POST["enddate"]);
	$accountId = $cdb->real_escape_string($_POST["accountId"]);
	$invoiceNum = $cdb->real_escape_string($_POST["invoiceNum"]);

	// Get account info
	$accountSQL = sprintf("SELECT %s.*, account_type.type as accountType, account_category.name as accountCategory FROM %s LEFT JOIN account_type ON %s.type = account_type.id LEFT JOIN account_category ON %s.category = account_category.id WHERE %s.ID = '%s'", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $accountId);
		$accounts = getDataFromTable($accountSQL, $cdb);
		if ($accounts) {
			$account = $accounts[0];
			
			// Get opening balance, closing balance, and transaction entries
			$isInvoice = true;
			include("includes/framework/code-snippets/account-open-close-transactions.php");
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this account information: %s</p>", $cdb->error);
		}

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Account Invoice</title>
</head>

<body style="margin: 0;">
	
<?php
	include("includes/framework/code-snippets/invoice-html.php");
?>

</body>
</html>