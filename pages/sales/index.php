<?php

	/* /accounts */

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
	$description = $_SESSION["company"]["name"] . " - Sale Items";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	if (isset($_POST["submit"])) {
		
		// Create new account
		/*if ($_POST["submit"] == "Add Account") {
			
			include("includes/framework/code-snippets/add-account.php");
			
		}
		
		// Update existing account
		if ($_POST["submit"] == "Update Account") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE accounts %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Account successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating this accounts: %s</p>", $cdb->error);
			}
			
		}

		// Delete account
		if ($_POST["submit"] == "Delete Account") {
	
			include("includes/framework/code-snippets/delete-account.php");
			
		}
		
		
		// Create a new payment method
		if ($_POST["submit"] == "Add Payment Info") {
			
			$method = $cdb->real_escape_string($_POST["method"]);
			
			// Set up the payment info first.
			if ($method == "1") {
				// Paypal
				$email = $cdb->real_escape_string($_POST["email"]);
				$insertSQL = sprintf("INSERT INTO payment_info_paypal (email) VALUES ('%s')", $email);
			} else if ($method == "2") {
				// Check
				$pay_to = $cdb->real_escape_string($_POST["pay_to"]);
				$mail_to = $cdb->real_escape_string($_POST["mail_to"]);
				$address = $cdb->real_escape_string($_POST["address"]);
				$address2 = $cdb->real_escape_string($_POST["address2"]);
				$city = $cdb->real_escape_string($_POST["city"]);
				$state = $cdb->real_escape_string($_POST["state"]);
				$zip = $cdb->real_escape_string($_POST["zip"]);
				$country = $cdb->real_escape_string($_POST["country"]);
				$phone = $cdb->real_escape_string($_POST["phone"]);
				$insertSQL = sprintf("INSERT INTO payment_info_check (pay_to, mail_to, address, address2, city, state, zip, country, phone) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $pay_to, $mail_to, $address, $address2, $city, $state, $zip, $country, $phone);
			} else if ($method == "3") {
				// Web
				$url = $cdb->real_escape_string($_POST["url"]);
				$insertSQL = sprintf("INSERT INTO payment_info_web (url) VALUES ('%s')", $url);
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error setting up the payment method: %s</p>", $cdb->error);
				exit;
			}
			
			$result = runSQL($insertSQL, $cdb);
			if ($result == true) {
				$msg = "<p class=\"alert\">Payment information successfully created.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating this payment information: %s</p>", $cdb->error);
			}
			
			// Now associate the payment info with the account
			$last_id = $cdb->insert_id;
			$account = $cdb->real_escape_string($_POST["account"]);
			$instructions = $cdb->real_escape_string($_POST["instructions"]);
			
			$infoSQL = sprintf("INSERT INTO payment_info (instructions, account, method, info) VALUES ('%s', '%s', '%s', '%s')", $instructions, $account, $method, $last_id);
			
			$result = runSQL($infoSQL, $cdb);
			if ($result == true) {
				$msg .= "<p class=\"alert\">Payment information associated with account.</p>";
				printf("<script type=\"text/javascript\">document.location = \"/accounts/view/%s\"</script>", $account);
			} else {
				$msg .= sprintf("<p class=\"alert\">There was an error associating this payment information with this account: %s</p>", $cdb->error);
			}

			
		}
		
		
		// Edit a payment method
		if ($_POST["submit"] == "Edit Payment Info") {
			
			// Update instructions (only thing that user can edit)
			$instructions = $cdb->real_escape_string($_POST["instructions"]);
			$methodId = $cdb->real_escape_string($_POST["id"]);
			
			$updateInfoSQL = sprintf("UPDATE payment_info SET instructions = '%s' WHERE id = '%s'", $instructions, $methodId);
			$result = runSQL($updateInfoSQL, $cdb);
			if ($result == true) {
				$msg .= "<p class=\"alert\">Payment information has been updated.</p>";
			} else {
				$msg .= sprintf("<p class=\"alert\">There was an error updating this payment information: %s</p>", $cdb->error);
			}
			
			$account = $cdb->real_escape_string($_POST["account"]);
			
			$infoSQL = sprintf("SELECT payment_info.*, payment_methods.use_table as use_table, payment_methods.method as method_name FROM `payment_info` LEFT JOIN payment_methods ON payment_info.method = payment_methods.id WHERE payment_info.id = '%s' ORDER BY method", $methodId);
			// echo $infoSQL . "<br>";
			$infos = getDataFromTable($infoSQL, $cdb);
			$info = $infos[0];
			
			$payment_info_id = $info["info"];
			$account = $info["account"];
		
			if ($info["method"] == "1") {
				// Paypal
				$email = $cdb->real_escape_string($_POST["email"]);
				$updateSQL = sprintf("UPDATE %s SET email='%s' WHERE ID = '%s'", $info["use_table"], $email, $payment_info_id);
			} else if ($info["method"] == "2") {
				// Check
				$pay_to = $cdb->real_escape_string($_POST["pay_to"]);
				$mail_to = $cdb->real_escape_string($_POST["mail_to"]);
				$address = $cdb->real_escape_string($_POST["address"]);
				$address2 = $cdb->real_escape_string($_POST["address2"]);
				$city = $cdb->real_escape_string($_POST["city"]);
				$state = $cdb->real_escape_string($_POST["state"]);
				$zip = $cdb->real_escape_string($_POST["zip"]);
				$country = $cdb->real_escape_string($_POST["country"]);
				$phone = $cdb->real_escape_string($_POST["phone"]);
				$updateSQL = sprintf("UPDATE %s SET pay_to='%s', mail_to='%s', address='%s', address2='%s', city='%s', state='%s', zip='%s', country='%s', phone='%s' WHERE ID = '%s'", $info["use_table"], $pay_to, $mail_to, $address, $address2, $city, $state, $zip, $country, $phone, $payment_info_id);
			} else if ($info["method"] == "3") {
				// Web
				$url = $cdb->real_escape_string($_POST["url"]);
				$updateSQL = sprintf("UPDATE %s SET url='%s' WHERE ID = '%s'", $info["use_table"], $url, $payment_info_id);
			} else {
				$msg = "<p class=\"alert\">There was an error updating this payment information.</p>";
			}
			// echo $updateSQL . "<br>";
			$result = runSQL($updateSQL, $cdb);
			if ($result == true) {
				$msg .= "<p class=\"alert\">Payment information has been updated.</p>";
				printf("<script type=\"text/javascript\">document.location = \"/accounts/view/%s\"</script>", $account);
			} else {
				$msg .= sprintf("<p class=\"alert\">There was an error updating this payment information: %s</p>", $cdb->error);
			}

			
		}

		// Delete a payment method
		if ($_POST["submit"] == "Delete Payment Info") {
			
			$methodId = $cdb->real_escape_string($_POST["id"]);
			$infoSQL = sprintf("SELECT payment_info.*, payment_methods.use_table as use_table FROM `payment_info` LEFT JOIN payment_methods ON payment_info.method = payment_methods.id WHERE payment_info.id = '%s' ORDER BY method", $methodId);
			// echo $infoSQL . "<br>";
			$infos = getDataFromTable($infoSQL, $cdb);
			$info = $infos[0];
			
			$account = $info["account"];

			// Delete the payment info details first
			$deleteSQL = sprintf("DELETE FROM %s WHERE id = '%s'", $info["use_table"], $info["info"]);
			echo $deleteSQL . "<br>";
			
			$result = runSQL($deleteSQL, $cdb);
			if ($result == true) {
				$msg = "<p class=\"alert\">Payment information has been deleted.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error deleting this payment information: %s</p>", $cdb->error);
			}
			
			// Now delete the payment info
			$deleteSQL2 = sprintf("DELETE FROM payment_info WHERE id = '%s'", $methodId);
			echo $deleteSQL2 . "<br>";
			$result2 = runSQL($deleteSQL2, $cdb);
			if ($result2 == true) {
				$msg .= "<p class=\"alert\">Payment information has been deleted.</p>";
				printf("<script type=\"text/javascript\">document.location = \"/accounts/view/%s\"</script>", $account);
			} else {
				$msg .= sprintf("<p class=\"alert\">There was an error deleting this payment information: %s</p>", $cdb->error);
			}
			
		}*/



	}
	
	$itemsSQL = "SELECT * FROM sale_items ORDER BY name";
	$items = getDataFromTable($itemsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/accounts.php");
			?>
            <h2>Sale Items</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/sale-items.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="sixty">Name</th>
                	<th class="sixteen">Catalog #</th>
                	<th class="eight info">View</th>
                	<th class="eight edit">Edit</th>
                	<th class="eight edit">Delete</th>
                </thead>
                <?php
					if (count($items) > 0) {
						
						$alt = false;
						foreach ($items as $item) {
							
							if ($account["accountType"] == "Asset") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;
								
								// Calculate balance for account.  Asset account: Debits are inflows.  Credits are outflows.
								$balanceSQL = sprintf("SELECT accounts.starting_balance + SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)) as balance FROM `accounts` LEFT JOIN %s ON accounts.id = %s.account WHERE accounts.id = '%s'", 
													  $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $account["id"]);
								$balances = getDataFromTable($balanceSQL, $cdb);
								$balance = $balances[0]["balance"];
								if (!$balance) {
									$balance = "0.00";
								}
								
								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\"><a href=\"/accounts/view/%s\">%s</a></td>", $account["id"], $account["name"]);
								printf("<td class=\"balance\">$%s</td>", $balance); 
								printf("<td class=\"info\"><a href=\"accounts/view/%s\">i</a></td>", $account["id"]);
								printf("<td class=\"edit\"><a href=\"accounts/edit/%s\">&nbsp;</a></td>", $account["id"]);
								printf("<td class=\"delete\"><a href=\"javascript:deleteAccount('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this account?');\">/</a></td>", $account["id"]);
								echo "</tr>";
							} else {
								
							}
						}
					} else {
						echo "<tr><td colspan=\"5\">You have not defined any sale items.  <a href=\"/sale-items/add\">Add a new item.</a></td></tr>";
					}
				?>
            </table>
			
			
          
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>