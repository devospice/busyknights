<?php

	/* /accounts */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Accounts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
	if ($_SESSION["activeYear"] == date("Y")) {
		// This year, stop today
		$endDate = sprintf("%s-%s-%s", $_SESSION["activeYear"], date("m"), date("d"));
	} else {
		// Prior year, stop on 12/31
		$endDate = sprintf("%s-12-31", $_SESSION["activeYear"]);
	}

	include("includes/framework/code-snippets/account-editing-code.php");
		
	$showBalances = false;
	if (isset($routes[3])) {
		if ($routes[3] == "balances") {
			$showBalances = true;
		}
	}	
		
	
	$accountsSQL = sprintf("SELECT %s.*, account_type.type as accountType FROM %s LEFT JOIN account_type ON %s.type = account_type.id ORDER BY name", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"]);
	$accounts = getDataFromTable($accountsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/accounts.php");
			?>
            <h2>Accounts</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/accounts.php");
			?>            
			
				
  			<h3>Equity Accounts  <a href="/accounts/view-equity/balances" class="button small">Show Balances</a> | <a href="/accounts/add/Equity" class="button small">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="sixty">Name</th>
					<?php if ($showBalances == true): ?>
						<th class="sixteen right">Balance</th>
					<?php endif; ?>
                	<th class="eight info">View</th>
                	<th class="eight edit">Edit</th>
                	<th class="eight edit">Delete</th>
                </thead>
                <?php
					if (count($accounts) > 0) {
						
						$alt = false;
						foreach ($accounts as $account) {
							
							if ($account["accountType"] == "Equity") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								if ($showBalances == true) {
									// Calculate balance for account.  Equity account: Debits are outflows.  Credits are inflows.
									/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
														  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);*/
									$balanceSQL = getBalanceSQL("credit", "debit", $yearStart, $endDate, $account["id"]);

									$balances = getDataFromTable($balanceSQL, $cdb);
									$balance = $balances[0]["balance"];
									if (!$balance) {
										$balance = "0.00";
									}
								}

								
								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\"><a href=\"/accounts/view/%s\">%s</a></td>", $account["id"], $account["name"]);
								if ($showBalances == true) {
									printf("<td class=\"balance\">$%s</td>", $balance); 
								}
								printf("<td class=\"info\"><a href=\"/accounts/view/%s\">i</a></td>", $account["id"]);
								printf("<td class=\"edit\"><a href=\"/accounts/edit/%s\">&nbsp;</a></td>", $account["id"]);
								printf("<td class=\"delete\"><a href=\"javascript:deleteAccount('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this account?');\">/</a></td>", $account["id"]);
								echo "</tr>";
							}
						}
					} 
				?>
			</table>
 
          
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>