<?php

	/* /transactions/add */
	$pageTitle = $_SESSION["company"]["name"] . " - Transactions";
	$description = $_SESSION["company"]["name"] . " - Add a Transaction";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	
	$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);


	// User is trying to pay digital artists
	if (isset($_POST["submit"])) {
		
		// Generate a new transaction
		if ($_POST["submit"] == "Generate Transaction") {

			// Create dummy transaction
			$transaction = array();
			$transaction["date"] = date("Y-m-d");
			$transaction["notes"] = "";
			$transaction["sale_item"] = 0;
			$transaction["category"] = 0;
			$transaction["subscription_payment"] = 0;
			
			// Create empty entries array
			$entries = array();
			
			// Get all liability accounts
			$liabilitySQL = sprintf("SELECT * FROM %s WHERE type = '2' ORDER BY name", $_SESSION["accountsTable"]);
			$accounts = getDataFromTable($liabilitySQL, $cdb);

			// Get date range
			// $startDate = $cdb->real_escape_string($_POST["startdate"]);
			$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
			$endDate = $cdb->real_escape_string($_POST["enddate"]);
			$method = $cdb->real_escape_string($_POST["payment_method"]);
						
			$entryCounter = 1;
			
			foreach ($accounts as $account) {
				
				// Calculate balance for account.  Liability account: Debits are outflows.  Credits are inflows.
				/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);*/
				
				// Credit in, debit out
				/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);*/
				$balanceSQL = getBalanceSQL("credit", "debit", $startDate, $endDate, $account["id"]);

				// echo $balanceSQL . "<br>";
				$balances = getDataFromTable($balanceSQL, $cdb);
				$balance = $balances[0]["balance"];
				
				// Only deal with accounts above the payment threshold
				if ($balance >= 10) {
					
					// Need to get payment info from here for each account
					if ($method == "paypal") {
						$paymentSQL = sprintf("SELECT 
							payment_info.*, payment_info_paypal.email AS paypalEmail, payment_info_venmo.handle AS venmoHandle
							FROM payment_info 
							LEFT JOIN payment_info_paypal ON payment_info_paypal.id = payment_info.info
							LEFT JOIN payment_info_venmo ON payment_info_venmo.id = payment_info.info
							WHERE account = '%s' AND (payment_info.method = '1' OR payment_info.method = '4')", $account["id"]);
					} else if ($method == "check") {
						$paymentSQL = sprintf("SELECT 
							payment_info.*, payment_info_paypal.email AS paypalEmail, payment_info_venmo.handle AS venmoHandle
							FROM payment_info 
							LEFT JOIN payment_info_paypal ON payment_info_paypal.id = payment_info.info
							LEFT JOIN payment_info_venmo ON payment_info_venmo.id = payment_info.info
							WHERE account = '%s' AND payment_info.method = '2'", $account["id"]);
					}
					$paymentAr = getDataFromTable($paymentSQL, $cdb);

					$length = count($paymentAr);
					if ($length > 0) {
						$payment = $paymentAr[0];
					} else {
						$payment = false;
					}

					if ($payment) {
						// if (($payment["method"] == 4) || ($payment["method"] == 1)) {
						if ($payment["is_preferred"]) {
							// Create the entry for the expense; assume support@fidim.com
							$entry1 = array();
							$entry1["account"] = 8; // support@fidim.com
							$entry1["credit"] = $balance;
							$entry1["debit"] = "0.00";
							$entry1["entry_num"] = $entryCounter;
							$entryCounter++;

							// Add entry to entries array
							$entries[] = $entry1;

							// Create the entry for the artist payment
							$entry2 = array();
							$entry2["account"] = $account["id"];
							$entry2["credit"] = "0.00";
							$entry2["debit"] = $balance;
							$entry2["entry_num"] = $entryCounter;
							$entryCounter++;

							// Add entry to entries array
							$entries[] = $entry2;
						}
						// } 
					} 			
				}
			}			
		}
		
	}
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Add a Transaction</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
			<div class="left-half">
            	<p>Fill out the form below to add a new transaction.</p>
			</div>
			<div class="right-half">
				<p>Or select from a saved template:</p>
				<?php
					$disabled = "";
					if (count($templates) == 0) {
						$disabled = "disabled";
					}
				?>
				<select name="template-list" <?php echo $disabled; ?> onChange="getValuesFromTemplate(this);">
					<option value="0">--== Template ==--</option>
					<?php
						foreach ($templates as $template) {
							printf("<option value=\"%s\">%s</option>", $template["id"], $template["name"]);
						}
					?>
				</select>
				<p><a href="/transactions/templates">Edit Templates</a></p>
			</div>
						
            <form action="/transactions" method="post" id="transaction-form">
            
                <?php
					include("includes/template/forms/transaction.php");
				?>
				
				<div class="left-half">
                	<input type="submit" name="submit" value="Add Transaction">
				</div>
				<div class="right-half">
					<div class="callout">
						<label for="name">Name:</label>
						<input type="text" name="name">
						<input type="submit" name="submit" value="Save as Template">
						<div class="vertical-divider"></div>
						<a href="/transactions/templates">Edit Templates</a>
					</div>
				</div>

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>