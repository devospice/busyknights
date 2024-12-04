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
		
		
		
	
	/*$accountsSQL = sprintf("SELECT %s.*, account_type.type as accountType FROM %s LEFT JOIN account_type ON %s.type = account_type.id ORDER BY name", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"]);
	$accounts = getDataFromTable($accountsSQL, $cdb);*/
	
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
            
			<h3>View Accounts by Type</h3>
			
			<p><a href="/accounts/view-asset">Asset Accounts</a> - Accounts that hold money or value</p>
			<p><a href="/accounts/view-equity">Equity Accounts</a> - Equity holding in the company</p>
			<p><a href="/accounts/view-expense">Expense Accounts</a> - Accounts used to track expenses</p>
			<p><a href="/accounts/view-liability">Liability Accounts</a> - Money owed to third parties</p>
			<p><a href="/accounts/view-revenue">Revenue Accounts</a> - Accounts used to track revenue</p>
			<p><a href="/accounts/view-all">All Accounts</a> - May take a while to load</p>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>