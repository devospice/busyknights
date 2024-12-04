<?php

	/* /transactions/view */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Accounts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");


	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$transactionID = $routes[3];
		/*$transactionSQL = sprintf("SELECT %s.*, entries.*, %s.name as accountName FROM `%s` LEFT JOIN entries ON %s.id = entries.transaction LEFT JOIN %s ON entries.account = %s.id WHERE %s.ID = '%s' ORDER BY entries.entry_num", $_SESSION["transactionsTable"], $_SESSION["accountsTable"], $_SESSION["transactionsTable"], $_SESSION["transactionsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["transactionsTable"], $transactionID);*/
		$transactionSQL = sprintf("SELECT %s.*, expense_categories.type
									FROM %s
									LEFT JOIN expense_categories ON %s.category = expense_categories.id
									WHERE %s.id = '%s'", 
								  $_SESSION["transactionsTable"], $_SESSION["transactionsTable"], $_SESSION["transactionsTable"], $_SESSION["transactionsTable"], $transactionID);
		$transactions = getDataFromTable($transactionSQL, $cdb);
		if ($transactions) {
			$transaction = $transactions[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this transaction information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No transaction was found.</p>";
	}
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/transactions.php");
			?>
            <h2>Transaction Details</h2>
			<p>Date: <?php echo $transaction["date"]; ?></p>
			
			<?php
				if ($transaction["date"] != "0") {
					printf("<p>Category: %s</p>", $transaction["type"]);
				}
			?>
            
			<?php
				// include("includes/template/subnavs/accounts.php");
			?>          
            
            <div class="section-nav">
				<a href="/transactions/edit/<?php echo $transaction["id"] ?>" class="button">Edit this Transaction</a>
            </div>  
            
            <h4>Notes</h4>
            <p>
            <?php 
				if ($transaction["notes"] != "") {
					echo $transaction["notes"]; 
				}
			?>
            </p>            
            
            <h4>Entries</h4>
			<?php
				include("includes/template/partials/transactions-table.php");
			?>            


			<div class="section-nav">
				<a href="/transactions/edit/<?php echo $transaction["id"] ?>" class="button">Edit this Transaction</a>
            </div>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");