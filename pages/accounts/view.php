<?php

	/* /accounts/view */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Accounts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();

	$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
	if ($_SESSION["activeYear"] == date("Y")) {
		// This year, stop today
		$endDate = sprintf("%s-%s-%s", $_SESSION["activeYear"], date("m"), date("d"));
	} else {
		// Prior year, stop on 12/31
		$endDate = sprintf("%s-12-31", $_SESSION["activeYear"]);
	}
	$endYear = sprintf("%s-12-31", $_SESSION["activeYear"]);

	include("includes/framework/code-snippets/account-editing-code.php");
	
	$msg = "";
	if (isset($routes[3])) {
		$accountId = $routes[3];
		$accountSQL = sprintf("
			SELECT %s.*, account_type.type as accountType, account_category.name as accountCategory,
				contacts.first_name as firstName, contacts.last_name as lastName, contacts.id as contactId
			FROM %s 
			LEFT JOIN account_type ON %s.type = account_type.id 
			LEFT JOIN account_category ON %s.category = account_category.id 
			LEFT JOIN contacts ON %s.contact = contacts.id
			WHERE %s.ID = '%s'", 
				$_SESSION["accountsTable"], 
				$_SESSION["accountsTable"], 
				$_SESSION["accountsTable"], 
				$_SESSION["accountsTable"],
				$_SESSION["accountsTable"], 
				$_SESSION["accountsTable"], $accountId);
		// echo $accountSQL . "<br>";
		$accounts = getDataFromTable($accountSQL, $cdb);
		if ($accounts) {
			$account = $accounts[0];
			
			if (($account["accountType"] == "Asset") || ($account["accountType"] == "Expense")) {
				// Debit in, credit out
				/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);*/
				/*$balanceSQL = sprintf("
					SELECT a.starting_balance + COALESCE(e.balance_change, 0) as balance 
						FROM `%s` a
					LEFT JOIN (
						SELECT account, SUM(COALESCE(debit, 0) - COALESCE(credit, 0)) as balance_change
						FROM `%s`
						WHERE date >= '%s' AND date <= '%s'
						GROUP BY account ) e
					ON a.id = e.account
					WHERE
					a.id = '%s'", 
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $endDate, $account["id"]);*/
				$balanceSQL = getBalanceSQL("debit", "credit", $startDate, $endDate, $account["id"]);
				
				$ytdSQL = sprintf("SELECT COALESCE(SUM(COALESCE(%s.credit,0)),0) as total FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endYear);
				// echo $ytdSQL;
				
			} else {
				// Credit in, debit out
				/*$balanceSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);*/
				
				/*  // Old version.  This doesn't work if there are no entries.
				SELECT accounts_24.starting_balance + COALESCE(SUM(COALESCE(entries_24.credit,0) - COALESCE(entries_24.debit,0)),0) as balance FROM `accounts_24` LEFT JOIN entries_24 ON accounts_24.id = entries_24.account WHERE accounts_24.id = '548' AND entries_24.date >= '2024-01-01' AND entries_24.date <= '2024-01-02' 
				*/
				
				// New version.
				/*$balanceSQL = sprintf("
					SELECT a.starting_balance + COALESCE(e.balance_change, 0) as balance 
						FROM `%s` a
					LEFT JOIN (
						SELECT account, SUM(COALESCE(credit, 0) - COALESCE(debit, 0)) as balance_change
						FROM `%s`
						WHERE date >= '%s' AND date <= '%s'
						GROUP BY account ) e
					ON a.id = e.account
					WHERE
					a.id = '%s'", 
					$_SESSION["accountsTable"], $_SESSION["entriesTable"],
					$startDate, $endDate, $account["id"]);*/
				$balanceSQL = getBalanceSQL("credit", "debit", $startDate, $endDate, $account["id"]);
				/*
				SELECT
				a.starting_balance + COALESCE(e.balance_change, 0) as balance
				FROM
				`accounts_24` a
				LEFT JOIN (
				SELECT
				account,
				SUM(COALESCE(credit, 0) - COALESCE(debit, 0)) as balance_change
				FROM
				`entries_24`
				WHERE
				date >= '2024-01-01' AND date <= '2024-01-02'
				GROUP BY
				account
				) e ON a.id = e.account
				WHERE
				a.id = '548';
				*/
				
				$ytdSQL = sprintf("SELECT COALESCE(SUM(COALESCE(%s.debit,0)),0) as total FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.id = '%s' AND %s.date >= '%s' AND %s.date <= '%s'", 
									  $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $account["id"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endYear);
				// echo $ytdSQL . "<br>";
			}
            
			// echo $balanceSQL;
			$balances = getDataFromTable($balanceSQL, $cdb);
			$balance = $balances[0]["balance"];
			if (!$balance) {
				$balance = "0.00";
			}
			$fmt = new NumberFormatter( 'en', NumberFormatter::CURRENCY );
			$balance = $fmt->formatCurrency($balance, "USD")."\n";
			// $balance = money_format("%(n", $balance);
			
			$yearTotals = getDataFromTable($ytdSQL, $cdb);
			$yearTotal = $yearTotals[0]["total"];
			if (!$yearTotal) {
				$yearTotal = "0.00";
			}
			$fmt = new NumberFormatter( 'en', NumberFormatter::CURRENCY );
			$yearTotal = $fmt->formatCurrency($yearTotal, "USD")."\n";
			// $yearTotal = money_format("%(n", $yearTotal);
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this account information: %s</p>", $cdb->error);
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
        	
            <?php // include("includes/template/searches/accounts.php"); ?>

            <h2><?php printf("%s", $account["name"]); ?></h2>
            
			<?php include("includes/template/subnavs/single-account.php");  ?>          
            
            <div class="left-half">
                <p>Account type: <strong><?php echo $account["accountType"]; ?></strong></p>
				<p>Contact: <strong><?php printf("<a href=\"/contacts/view/%s\">%s %s</a>", $account["contactId"], $account["firstName"], $account["lastName"]); ?></strong></p>
                <p>Category: <strong><?php echo $account["accountCategory"]; ?></strong></p>
                <p>Current balance: <strong><?php echo $balance; ?></strong></p>
                <p>Total payout for year: <strong><?php echo $yearTotal; ?></strong></p>
                
                
                <!--<div class="section-nav">
                    <a href="/accounts/edit/<?php echo $account["id"]; ?>" class="button">Edit this Account</a>
                </div> --> 
            </div>
            
            <div class="right-half">
            
            <h4>Notes</h4>
                <p>
                <?php 
                    if ($account["notes"] != "") {
                        echo $account["notes"]; 
                    }
                
                ?>
                </p>
            
            </div>
			<hr>
			
			<h4>Generate Report</h4>
			<form action="/accounts/report" method="post" target="_blank">
				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				<input type="hidden" name="accountId" value="<?php echo $account["id"]; ?>">

				<div class="right-half">
					<input type="submit" name="submit" class="small" value="Generate Report">
				</div>
				
			</form>
			
			<h4>Email Report</h4>
			<form action="/ajax/email-report" method="post" target="_blank" onSubmit="return validateForm(this);" novalidate>
				
				<div class="left-half">
					<label for="email">Email: </label>
					<input type="email" name="email" required data-validate="email">
					<p class="form-error" id="email-error">Please enter a valid email address.</p>
				</div>
				
				<div>
					<input type="hidden" name="accountId" value="<?php echo $account["id"]; ?>">
					<input type="hidden" name="successCallback" value="showReportResult">
					<input type="hidden" name="email_content" value="">
					
					<?php 
						include("includes/template/forms/start-date-end-date.php");
					?>

					<div class="right-half">
						<input type="submit" name="submit" class="small" value="Email Report">
					</div>
				
				</div>
				
				<div id="report-result"></div>

			</form>
			
			
			<h4>Generate Invoice</h4>
			<form action="/accounts/invoice" method="post" target="_blank">
				<label>Invoice Number:</label>
				<input type="text" name="invoiceNum" value="<?php echo date("Ymd"); ?>">
				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				<input type="hidden" name="accountId" value="<?php echo $account["id"]; ?>">

				<div class="right-half">
					<input type="submit" name="submit" class="small" value="Generate Invoice">
				</div>

			</form>
			<hr class="spacer">

			
            <h4>Payment Info</h4>
            	
            <?php
				$infoSQL = sprintf("SELECT payment_info.*, payment_methods.use_table as use_table, payment_methods.method as method_name FROM `payment_info` LEFT JOIN payment_methods ON payment_info.method = payment_methods.id WHERE payment_info.account = '%s' ORDER BY method", $accountId);
				// echo $infoSQL . "<br>";
				$infos = getDataFromTable($infoSQL, $cdb);
				// var_dump($infos);
				$counter = 1;
				
				if (count($infos) > 0) {
					echo "<div class=\"callout\">";
				
					foreach ($infos as $info) {
						printf("<h5>%s</h5>", $info["method_name"]);
						
						$paymentSQL = sprintf("SELECT * FROM %s WHERE id = '%s'", $info["use_table"], $info["info"]);
						$payments = getDataFromTable($paymentSQL, $cdb);
						$paymentInfo = $payments[0];
						
						if ($info["method"] == "1") {
							// Paypal
							$preferred = "";
							if ($info["is_preferred"] == "1") {
								$preferred = "<img src=\"/assets/images/button-icons/check-mark.png\" title=\"Preferred payment method\" class=\"preferred\">";
							}
							printf("<p>Paypal to: %s <a href=\"/payments/edit/%s\" class=\"edit\"></a>%s</p>", $paymentInfo["email"], $info["id"], $preferred);
							if ($counter < count($infos)) {
								echo "<hr>";
								$counter++;
							}
						} else if ($info["method"] == "2") {
							// Check
							$preferred = "";
							if ($info["is_preferred"] == "1") {
								$preferred = "<img src=\"/assets/images/button-icons/check-mark.png\" title=\"Preferred payment method\" class=\"preferred\">";
							}
							printf("<p>Mail checks to: <a href=\"/payments/edit/%s\" class=\"edit\"></a>%s<br>", $info["id"], $preferred);
							$mailTo = $paymentInfo["mail_to"];
							if ($mailTo == "") {
								$mailTo = $paymentInfo["pay_to"];
							}
							echo $mailTo . "<br>";
							if ($paymentInfo["address"] != "") {
								echo $paymentInfo["address"] . "<br>";
							}
							if ($paymentInfo["address2"] != "") {
								echo $paymentInfo["address2"] . "<br>";
							}
							if ($paymentInfo["city"] != "") {
								echo $paymentInfo["city"] . ", ";
							}
							if ($paymentInfo["state"] != "") {
								echo $paymentInfo["state"] . " ";
							}
							if ($paymentInfo["zip"] != "") {
								echo $paymentInfo["zip"];
							}
							echo "</p>";
							
							printf("<p>Make checks payable to: %s</p>", $paymentInfo["pay_to"]);
							if ($counter < count($infos)) {
								echo "<hr>";
								$counter++;
							}
						} else if ($info["method"] == "3") {
							// Web site
							$preferred = "";
							if ($info["is_preferred"] == "1") {
								$preferred = "<img src=\"/assets/images/button-icons/check-mark.png\" title=\"Preferred payment method\" class=\"preferred\">";
							}
							printf("<p>Pay online at: <a href=\"%s\" target=_blank>%s</a> <a href=\"/payments/edit/%s\" class=\"edit\"></a>%s</p>", $paymentInfo["url"], $paymentInfo["url"], $info["id"], $preferred);
							if ($counter < count($infos)) {
								echo "<hr>";
								$counter++;
							}
						} else if ($info["method"] == "4") {
							// Venmo
							$preferred = "";
							if ($info["is_preferred"] == "1") {
								$preferred = "<img src=\"/assets/images/button-icons/check-mark.png\" title=\"Preferred payment method\" class=\"preferred\">";
							}
							printf("<p>Venmo to: %s <a href=\"/payments/edit/%s\" class=\"edit\"></a>%s</p>", $paymentInfo["handle"], $info["id"], $preferred);
							if ($counter < count($infos)) {
								echo "<hr>";
								$counter++;
							}
						}
					}
				echo "</div>";
				} else {
					?>
					<div class="section-nav">
						<a href="/payments/add/<?php echo $account["id"] ?>" class="button">Add Payment Info</a>
					</div>
                    <?php
				}
				
			?>
            <hr class="spacer">
            
            <h4>Recent Entries</h4>
			<?php
				// This call gets all the data on the target account.
				/*$transactionsSQL = sprintf("SELECT %s.*, entries.*, %s.name as accountName, %s.id as accountID FROM `%s` LEFT JOIN entries ON %s.id = entries.transaction LEFT JOIN %s ON entries.account = %s.id WHERE entries.account = '%s' ORDER BY %s.date DESC", $_SESSION["transactionsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["transactionsTable"], $_SESSION["transactionsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $accountId, $_SESSION["transactionsTable"]);*/
				$entriesSQL = sprintf("SELECT %s.*, %s.* FROM `%s` LEFT JOIN %s ON %s.id = %s.transaction WHERE %s.account = '%s' ORDER BY %s.date DESC LIMIT 100", 
									  $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $accountId, $_SESSION["transactionsTable"]);
				// echo $entriesSQL . "<br>";

				// This call gets all the transactions that were triggered by this account, but returns the entries for the other account
				/*$transactionsSQL = sprintf("SELECT DISTINCT e1.*, transactions.date as date, accounts.name as accountName 
					FROM entries e1 
					LEFT JOIN transactions on e1.transaction = transactions.id 
					LEFT JOIN accounts ON e1.account = accounts.id 
					LEFT JOIN entries e2 ON e1.transaction = e2.transaction 
					WHERE e2.account = '%s' AND e2.credit = e1.debit
					ORDER BY date DESC, e1.id DESC", $accountId);*/
				/*$transactionsSQL = sprintf("SELECT DISTINCT 
					e1.*, 
					transactions.date as date, 
					accounts.name as accountName 
					FROM entries e1 
					LEFT JOIN transactions on e1.transaction = transactions.id 
					LEFT JOIN accounts ON e1.account = accounts.id 
					LEFT JOIN entries e2 ON e1.transaction = e2.transaction 
					WHERE e1.account <> '%s'  
					ORDER BY date DESC, e1.id DESC", $accountId);*/
				$entries = getDataFromTable($entriesSQL, $cdb);
				// print_r($entries);
				
				include("includes/template/partials/entries-table.php");
			?>            


			<!--<div class="section-nav">
				<a href="/accounts/edit/<?php // echo $account["id"] ?>" class="button">Edit this Account</a>
            </div>-->
			<?php include("includes/template/subnavs/single-account.php");  ?> 
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");