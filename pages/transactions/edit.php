<?php

	/* /transactions/edit */
	$pageTitle = $_SESSION["company"]["name"] . " - Transactions";
	$description = $_SESSION["company"]["name"] . " - Edit a Transaction";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();

	$msg = "";
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$transactionsSQL = sprintf("SELECT * FROM %s WHERE ID = '%s'", $_SESSION["transactionsTable"], $id);
		$transactions = getDataFromTable($transactionsSQL, $cdb);
		if ($transactions) {
			$transaction = $transactions[0];
			
			$entriesSQL = sprintf("SELECT * FROM %s WHERE transaction = '%s' ORDER BY entry_num", $_SESSION["entriesTable"], $transaction["id"]);
			$entries = getDataFromTable($entriesSQL, $cdb);
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this transaction information: %s</p>", $cdb->error);
		}
		
		
	} else {
		$msg = "<p class=\"alert\">Error: No account was found.</p>";
	}
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
				
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
				
			?>
            <h2>Edit a Transaction</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Fill out the form below to edit this transaction.</p>
            <form action="/transactions" method="post">
            
            	<input type="hidden" name="id" value="<?php echo $transaction["id"]; ?>">
                <?php
					include("includes/template/forms/transaction.php");
				?>
                <input type="submit" name="submit" value="Edit Transaction">
                <input type="button" name="submit" value="Cancel" onClick="window.history.go(-1);">
				<div class="vertical-divider"></div>
                <input type="submit" name="submit" value="Delete Transaction" onClick="return confirm('Are you sure you want to delete this transaction and all its journal entries?');">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");