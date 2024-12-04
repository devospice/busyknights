<?php

	/* /transactions */
	$pageTitle = $_SESSION["company"]["name"] . " - Transactions";
	$description = $_SESSION["company"]["name"] . " - Transactions";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "transactions";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	// Transaction query defaults
	$selectLimit = 1000;
	$desc = "";

	if (isset($_POST["submit"])) {
		
		// Add a new transaction
		if ($_POST["submit"] == "Add Transaction") {
			
			if (isset($_POST["amortize"])) {
				$amortizeFor = $cdb->real_escape_string($_POST["amortize_months"]);
			} else {
				$amortizeFor = 1;
			}
			$date =  $cdb->real_escape_string($_POST["date"]);
			
			for ($i=0; $i<$amortizeFor; $i++) {
				
				// Insert the transaction first
				$notes =  $cdb->real_escape_string($_POST["notes"]);
				$category =  "0"; // PROBABLY NOT GOING TO BE USED HERE $cdb->real_escape_string($_POST["category"]);
				if (isset($_POST["subscription_payment"])) {
					$subscription =  $cdb->real_escape_string($_POST["subscription_payment"]);
				} else {
					$subscription = "0";
				}

				$insertSQL = sprintf("INSERT INTO %s (date, notes, category, subscription_payment) VALUES ('%s', '%s', '%s', '%s')", $_SESSION["transactionsTable"], $date, $notes, $category, $subscription);
				$result = runSQL($insertSQL, $cdb);
				if ($result == true) {
					$msg = "Transaction created successfully.";
				} else {
					$msg = sprintf("<p class=\"alert\">There was an error creating your transaction: %s</p>", $cdb->error);
				}

				$last_id = $cdb->insert_id;

				// Now create the entries
				$counter = 1;
				$complete = false;
				do {
					$accountSelectName = "account-" . $counter;
					if (isset($_POST[$accountSelectName])) {

						$account = $_POST[$accountSelectName];
						
						$fullDebit = $cdb->real_escape_string($_POST["debit-".$counter]);
						$debit = $fullDebit / $amortizeFor;
						
						$fullCredit = $cdb->real_escape_string($_POST["credit-".$counter]);
						$credit = $fullCredit / $amortizeFor;

						$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $account, $debit, $credit, $date, $last_id, $counter);
						$result = runSQL($insertSQL, $cdb);
						if ($result == true) {
							// $msg .= "Entry for ". $account ." created successfully.";
						} else {
							$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
						}

						$counter++;	

					} else {
						$complete = true;
					}
					
				} while ($complete == false);
				
				// Update date for next month
				$thisMonthTS = strtotime($date);
				$nextMonthTS = mktime(0, 0, 0, date("m", $thisMonthTS)+1, date("d", $thisMonthTS), date("Y", $thisMonthTS));
				$date = date("Y-m-d", $nextMonthTS);
				
				// Navigate to latest transaction
				$url = sprintf("/transactions/view/%s", $last_id);
				printf("<script type=\"text/javascript\">console.log('%s'); document.location = '%s'</script>;", $url, $url);
				
			}
				
			
		}
		
		
		// Distribute subscription revenue
		if ($_POST["submit"] == "Distribute Subscription Revenue") {
			
			$date =  $cdb->real_escape_string($_POST["date"]);
						
			// Insert the transaction first
			$notes =  $cdb->real_escape_string($_POST["notes"]);
			$category =  "0"; // PROBABLY NOT GOING TO BE USED HERE $cdb->real_escape_string($_POST["category"]);
			$subscription = "0";
			$shareAmount =  $cdb->real_escape_string($_POST["amount"]);

			$insertSQL = sprintf("INSERT INTO %s (date, notes, category, subscription_payment) VALUES ('%s', '%s', '%s', '%s')", $_SESSION["transactionsTable"], $date, $notes, $category, $subscription);
			$result = runSQL($insertSQL, $cdb);
			// echo $insertSQL . "<br>";
			if ($result == true) {
				$msg = "Transaction created successfully.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your transaction: %s</p>", $cdb->error);
			}

			$last_id = $cdb->insert_id;

			// Now create the entries
			$counter = 1;
			$entryCounter = 1;
			$complete = false;
			do {
				$accountSelectName = "account-" . $counter;
				if (isset($_POST[$accountSelectName])) {

					$account = $_POST[$accountSelectName];
					$numShares =  $cdb->real_escape_string($_POST["numshares-".$counter]);

					$credit = $numShares * $shareAmount;
					$debit = $credit;
					
					// Credit the artist's account
					$insertSQL1 = sprintf("INSERT INTO entries (account, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s')", $account, $credit, $date, $last_id, $entryCounter);
					$result = runSQL($insertSQL1, $cdb);
					// echo $insertSQL1 . "<br>";
					if ($result == true) {
						// $msg .= "Entry for ". $account ." created successfully.";
					} else {
						$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}
					$entryCounter++;
					
					// Debit the royalties account; NOTE: Assumes royalties account is ID 49
					$insertSQL2 = sprintf("INSERT INTO entries (account, debit, date, transaction, entry_num) VALUES ('49', '%s', '%s', '%s', '%s')", $debit, $date, $last_id, $entryCounter);
					$result = runSQL($insertSQL2, $cdb);
					// echo $insertSQL2 . "<br>";
					if ($result == true) {
						// $msg .= "Entry for ". $account ." created successfully.";
					} else {
						$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}
					$entryCounter++;
					
					

					$counter++;	

				} else {
					$complete = true;
				}

			} while ($complete == false);								
			
		}

		// Record a Sale
		if ($_POST["submit"] == "Record Sale") {
			
			$quantityCounter = 0;
			$quantity = $cdb->real_escape_string($_POST["quantity"]);
			
			$assetAccountSQL = sprintf("SELECT id FROM %s WHERE type = '1'", $_SESSION["accountsTable"]);
			$assetAccounts = getDataFromTable($assetAccountSQL, $cdb);
			
			do {
			
				// Insert the transaction first
				$date =  $cdb->real_escape_string($_POST["date"]);
				$notes =  $cdb->real_escape_string($_POST["notes"]);
				$sale_item =  $cdb->real_escape_string($_POST["sale_item"]);
				
				$insertSQL = sprintf("INSERT INTO %s (date, notes, sale_item) VALUES ('%s', '%s', '%s')", $_SESSION["transactionsTable"], $date, $notes, $sale_item);
				$result = runSQL($insertSQL, $cdb);
				if ($result == true) {
					$msg = "Transaction created successfully.";
				} else {
					$msg = sprintf("<p class=\"alert\">There was an error creating your transaction: %s</p>", $cdb->error);
				}
				
				$last_id = $cdb->insert_id;
				
				// Now create the entries
				$counter = 1;
				$complete = false;
				$royaltyTally = 0;
				
				do {
					$accountSelectName = "account-" . $counter;
					if (isset($_POST[$accountSelectName])) {
						
						$account = $_POST[$accountSelectName];
						if (isset($_POST["debit-".$counter])) {
							$debit = $cdb->real_escape_string($_POST["debit-".$counter]);
						} else {
							$debit = 0;
						}
						if (isset($_POST["credit-".$counter])) {
							$credit = $cdb->real_escape_string($_POST["credit-".$counter]);
						} else {
							$credit = 0;
						}
						
						
						
						$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $account, $debit, $credit, $date, $last_id, $counter);
						$result = runSQL($insertSQL, $cdb);
						if ($result == true) {
							$msg .= "Entry for ". $account ." created successfully.";
						} else {
							$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
						}
						
						$counter++;	
						
						// Tally royalty
						$pos = array_search($account, array_column($assetAccounts, 'id'));  // Checks to see if the account is an asset account.  Returns the key position or false.
						if ($pos !== false) {
							$royaltyTally += $debit;
							$royaltyTally -= $credit;
						}
						
					} else {
						$complete = true;
					}
					
					
				} while ($complete == false);
				
				// Assign royalties to other accounts
				$royaltiesSQL = sprintf("SELECT * FROM royalties WHERE sale_item = '%s'", $sale_item);
				$royalties = getDataFromTable($royaltiesSQL, $cdb);
				
				foreach ($royalties as $royalty) {
					
					if ($royalty["use_percent"] == "1") {
						$percent = $royalty["percent"] / 100;
						$amount = $royaltyTally * $percent;
					} else {
						$amount = $royalty["amount"];
					}
					
					// Credit the artist's account
					$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $royalty["credit_account"], "0.00", $amount, $date, $last_id, $counter);
					$result = runSQL($insertSQL, $cdb);
					if ($result == true) {
						$msg .= "Entry for ". $account ." created successfully.";
					} else {
						$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}

					$counter++;

					// Debit the expense account
					$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $royalty["debit_account"], $amount, "0.00", $date, $last_id, $counter);
					$result = runSQL($insertSQL, $cdb);
					if ($result == true) {
						$msg .= "Entry for ". $account ." created successfully.";
					} else {
						$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}

					$counter++;

				}
			
				$quantityCounter++;
			
			} while ($quantityCounter < $quantity);
			
		}
		
		// Import Sales Report
		if ($_POST["submit"] == "Import Sales Report") {
			 
			// Update main form values
			$uploadedFilePath = $_FILES["csv_file"]["tmp_name"];
			
			// Set up output variables
			$errorCount = 0;
			$errorMsg = "";
			$itemCount = 0; 
			
			// Read the uploaded data
			$handle = fopen($uploadedFilePath, "r");
			
			while (($item = fgetcsv($handle, 1000, ",")) !== FALSE) {					
				
				// Sale Date, Item Name, Artist, Sale price
				
				// Format date to yyyy-mm-dd just in case it's not
				$rawDate = $item[0];
				$dateTS = strtotime($rawDate);
				$date = date("Y-m-d", $dateTS);
				
				
				// Get amount
				$saleAmount = $item[3];
				
				// Account for some old entries that mislabel artist as "Various Artists" or "The Funny Music Project"
				if (($item[2] == "Various Artists") || ($item[2] == "The Funny Music Project")) {
					
					// Find the sale item to correct the data
					// echo "checking with " . $item[2] . "<br>";
					
					// Check for dashes in the title
					$dashPos = strpos($item[1], "-");
					if ($dashPos === false) {
						$searchTitle = $item[1];
					} else {
						$searchTitle = substr($item[1], 0, $dashPos-1);
					}
					
					// Now check for parentheses in the title
					$parPos = strpos($searchTitle, "(");
					if ($parPos === false) {
						$searchTitle = $searchTitle;
					} else {
						$searchTitle = substr($searchTitle, 0, $parPos-1);
					}
					
					$itemSQL = sprintf("SELECT sale_items.*, artists.name as artistName FROM sale_items LEFT JOIN artists ON sale_items.artist = artists.id WHERE sale_items.name LIKE '%%%s%%'", addslashes($searchTitle));
					// echo $itemSQL . "<br>";
					$foundItems = getDataFromTable($itemSQL, $cdb);
					// var_dump($foundItems);
					// echo "<br>";
					
					if ($foundItems) {
						// Assign corrected values
						// echo "Item found:<br>";
						// var_dump($item); 
						// echo "<br>";
						$foundItem = $foundItems[0];
						$item[1] = $foundItem["name"];
						$item[2] = $foundItem["artistName"];
					} else {
						// Just continue as-is.  Entry will likely error out.
					}
					
				}
				
				// Get the artist info
				$artistSQL = sprintf("SELECT * FROM artists WHERE name = '%s'", addslashes($item[2]));
				$artists = getDataFromTable($artistSQL, $cdb);
				if ($artists) {
					$artist = $artists[0];
					
					// Find the sale item
					$saleItemSQL = sprintf("SELECT * FROM sale_items WHERE name='%s' AND artist = '%s'", addslashes($item[1]), $artist["id"]);
					// echo $saleItemSQL;
					$saleItems = getDataFromTable($saleItemSQL, $cdb);
					if ($saleItems) {
						
						$saleItem = $saleItems[0];
						$sale_item = $saleItem["id"];
						
						
					} else {
						/*$errorCount++;
						$errorMsg .= sprintf("<p class=\"alert\">Unable to find item: %s by %s</p>", $item[1], $item[2]);*/
						
						// Unable to find sale item.  Create it.
						$artistId = $artist["id"];
						
						// Create the sale item
						$insertSQL = sprintf("INSERT INTO sale_items (name, artist) VALUES ('%s', '%s')", addslashes($item[1]), $artistId);

						// echo $insertSQL . "<br>";

						$result = runSQL($insertSQL, $cdb);

						if ($result == true) {
							// $msg .= "Sale item successfully created.<br>";
							// $counter++;

							// Assign default royalties
							include("includes/framework/code-snippets/assign-default-royalties.php");

						} else {
							$errorCount++;
							$errorMsg .= sprintf("<p class=\"alert\">Unable to find item: %s by %s.  Unable to create item: %s</p>", $item[1], $item[2], $cdb->error);
						}
						
						// Now that it's been created, retrieve it
						$saleItemSQL = sprintf("SELECT * FROM sale_items WHERE name='%s' AND artist = '%s'", addslashes($item[1]), $artist["id"]);
						// echo $saleItemSQL;
						$saleItems = getDataFromTable($saleItemSQL, $cdb);
						if ($saleItems) {
							$saleItem = $saleItems[0];
							$sale_item = $saleItem["id"];
						} else {
							$errorCount++;
							$errorMsg .= sprintf("<p class=\"alert\">Unable to find newly created item: %s by %s</p>", $item[1], $item[2]);
							
						}
						
						
					}
					
					// Now that we have or created the sale item, work with it.
					
					// Set note to name of sale item
					$notes =  addslashes($saleItem["name"]);

					// Insert the transaction first
					$insertSQL = sprintf("INSERT INTO %s (date, notes, sale_item) VALUES ('%s', '%s', '%s')", $_SESSION["transactionsTable"], $date, $notes, $sale_item);
					$result = runSQL($insertSQL, $cdb);
					if ($result == true) {
						$msg = "Transaction created successfully.";
					} else {
						$errorCount++;
						$errorMsg .= sprintf("<p class=\"alert\">There was an error creating your transaction: %s</p>", $cdb->error);
					}

					$last_id = $cdb->insert_id;

					// Now create the entries


					$debitAccount = $_POST["account-1"];
					$creditAccount = $_POST["account-2"];
					$counter = 1;

					$insertDebitSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '0.00', '%s', '%s', '%s')", $debitAccount, $saleAmount, $date, $last_id, $counter);

					$result = runSQL($insertDebitSQL, $cdb);
					if ($result == true) {
						$msg .= "Entry for ". $debitAccount ." created successfully.";
					} else {
						$errorCount++;
						$errorMsg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}

					$counter++;

					$insertCreditSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '0.00', '%s', '%s', '%s', '%s')", $creditAccount, $saleAmount, $date, $last_id, $counter);

					$result = runSQL($insertCreditSQL, $cdb);
					if ($result == true) {
						$msg .= "Entry for ". $creditAccount ." created successfully.";
					} else {
						$errorCount++;
						$errorMsg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}

					$counter++;


					// Tally royalty
					$royaltyTally = $saleAmount;

					// Assign royalties to other accounts
					$royaltiesSQL = sprintf("SELECT * FROM royalties WHERE sale_item = '%s'", $sale_item);
					$royalties = getDataFromTable($royaltiesSQL, $cdb);

					foreach ($royalties as $royalty) {

						if ($royalty["use_percent"] == "1") {
							$percent = $royalty["percent"] / 100;
							$amount = $royaltyTally * $percent;
						} else {
							$amount = $royalty["amount"];
						}

						// Credit the artist's account
						$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $royalty["credit_account"], "0.00", $amount, $date, $last_id, $counter);
						$result = runSQL($insertSQL, $cdb);
						if ($result == true) {
							$msg .= "Entry for ". $royalty["credit_account"] ." created successfully.";
						} else {
							$errorCount++;
							$errorMsg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
						}

						$counter++;

						// Debit the expense account
						$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $royalty["debit_account"], $amount, "0.00", $date, $last_id, $counter);
						$result = runSQL($insertSQL, $cdb);
						if ($result == true) {
							$msg .= "Entry for ". $royalty["debit_account"] ." created successfully.";
						} else {
							$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
						}

						$counter++;

					}
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
				} else {
					$errorCount++;
					$errorMsg .= sprintf("<p class=\"alert\">Unable to find artist %s for title %s</p>", $item[2], $item[1]);
				}
				
				$itemCount++;
				
			}
			
			fclose($handle);
			
			$msg = sprintf("%s items successfully imported.  %s errors. <br>%s", $itemCount, $errorCount, $errorMsg);


		}
		
		
		// Add Stock
		if ($_POST["submit"] == "Add Stock") {
			
			$quantity = $cdb->real_escape_string($_POST["quantity"]);
			
			// Insert the transaction first
			$date =  $cdb->real_escape_string($_POST["date"]);
			$notes =  $cdb->real_escape_string($_POST["notes"]);
			$sale_item =  $cdb->real_escape_string($_POST["sale_item"]);
			
			$insertSQL = sprintf("INSERT INTO %s (date, notes, sale_item) VALUES ('%s', '%s', '%s')", $_SESSION["transactionsTable"], $date, $notes, $sale_item);
			$result = runSQL($insertSQL, $cdb);
			if ($result == true) {
				$msg = "Transaction created successfully.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your transaction: %s</p>", $cdb->error);
			}
			
			$last_id = $cdb->insert_id;
			
			// Now create the entries
			$counter = 1;
			$complete = false;
			
			do {
				$accountSelectName = "account-" . $counter;
				if (isset($_POST[$accountSelectName])) {
					
					$account = $_POST[$accountSelectName];
					$debit = $cdb->real_escape_string($_POST["debit-".$counter]);
					$credit = $cdb->real_escape_string($_POST["credit-".$counter]);
					
					$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $account, $debit, $credit, $date, $last_id, $counter);
					$result = runSQL($insertSQL, $cdb);
					if ($result == true) {
						$msg .= "Entry for ". $account ." created successfully.";
					} else {
						$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}
					
					$counter++;	
										
				} else {
					$complete = true;
				}
				
				
			} while ($complete == false);
			
			// Update the quantity
			$inventorySQL = sprintf("INSERT INTO inventory (sale_item, quantity_in, transaction) VALUES ('%s', '%s', '%s')", $sale_item, $quantity, $last_id);	
			
			$result = runSQL($inventorySQL, $cdb);
			if ($result == true) {
				$msg .= "Inventory updated successfully.";
			} else {
				$msg .= sprintf("<p class=\"alert\">There was an error creating the inventory entry: %s</p>", $cdb->error);
			}
			
		}
		
		// Edit transaction
		if ($_POST["submit"] == "Edit Transaction") {
			
			// Edit the transaction first
			$date =  $cdb->real_escape_string($_POST["date"]);
			$notes =  $cdb->real_escape_string($_POST["notes"]);
			$category =  "0"; // NOT USED HERE ANYMORE $cdb->real_escape_string($_POST["category"]);
			$transactionId = $cdb->real_escape_string($_POST["id"]);
			if (isset($_POST["subscription_payment"])) {
				$subscripton = $cdb->real_escape_string($_POST["subscription_payment"]);
			} else {
				$subscripton = 0;
			}
			
			$updateSQL = sprintf("UPDATE %s SET date='%s', notes='%s', category='%s', subscription_payment = '%s' WHERE id = '%s'", $_SESSION["transactionsTable"], $date, $notes, $category, $subscripton, $transactionId);
			$result = runSQL($updateSQL, $cdb);
			if ($result == true) {
				$msg = "Transaction updated successfully.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating your transaction: %s</p>", $cdb->error);
			}
						
			// Now update the entries
			$counter = 1;
			$complete = false;
			do {
				$accountSelectName = "account-" . $counter;
				if (isset($_POST[$accountSelectName])) {
					
					// See if these entries exist in the database.  If so, update their values.  If not, create them.
					$account = $_POST[$accountSelectName];
					$debit = $cdb->real_escape_string($_POST["debit-".$counter]);
					$credit = $cdb->real_escape_string($_POST["credit-".$counter]);
					
					// This is not the most elegant way to do this.  Update it later.
					$testSQL = sprintf("SELECT id FROM entries WHERE transaction = '%s' AND entry_num = '%s'", $transactionId, $counter);
					$testEntries = getDataFromTable($testSQL, $cdb);
					if (count($testEntries) > 0) {
					
						// Update existing entry.
						$updateSQL = sprintf("UPDATE entries SET account='%s', debit='%s', credit='%s', date='%s' WHERE transaction = '%s' AND entry_num = '%s'", $account, $debit, $credit, $date, $transactionId, $counter);
						$result = runSQL($updateSQL, $cdb);
						if ($result == true) {
							$msg .= "<br>Entry for ". $account ." updated successfully.";
						} else {
							$msg .= sprintf("<p class=\"alert\">There was an error updating the entry: %s</p>", $cdb->error);
						}
					
					} else {
						
						// Add a new entry
						$insertSQL = sprintf("INSERT INTO entries (account, debit, credit, date, transaction, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')", $account, $debit, $credit, $date, $transactionId, $counter);
						$result = runSQL($insertSQL, $cdb);
						if ($result == true) {
							$msg .= "Entry for ". $account ." updated successfully.";
						} else {
							$msg .= sprintf("<p class=\"alert\">There was an error updating the entry: %s</p>", $cdb->error);
						}
						
					}
					
					$counter++;	
					
				} else {
					
					// No more entries in the form.  Make sure there aren't any left in the database.
					$testSQL = sprintf("SELECT id FROM entries WHERE transaction = '%s' AND entry_num = '%s'", $transactionId, $counter);
					$testEntries = getDataFromTable($testSQL, $cdb);
					if (count($testEntries) > 0) {
						// Delete excess entries
						$deleteSQL = sprintf("DELETE FROM entries WHERE transaction = '%s' AND entry_num = '%s'", $transactionId, $counter);
						$result = runSQL($deleteSQL, $cdb);
						if ($result != true) {
							$msg .= sprintf("<p class=\"alert\">There was an error updating the entry: %s</p>", $cdb->error);
						}
					} else {					
						$complete = true;
					}
					
					$counter++;	
					
				}
			} while ($complete == false);
			
		}

		// Delete transaction
		if ($_POST["submit"] == "Delete Transaction") {

			include("includes/framework/code-snippets/delete-transaction.php");

		}


		// Add a new Transaction Template
		if ($_POST["submit"] == "Save as Template") {
			
			// Insert the transaction template first
			$name =  $cdb->real_escape_string($_POST["name"]);
			$notes =  $cdb->real_escape_string($_POST["notes"]);
			
			$insertSQL = sprintf("INSERT INTO transaction_templates (name, notes) VALUES ('%s', '%s')", $name, $notes);
			$result = runSQL($insertSQL, $cdb);
			if ($result == true) {
				$msg = "Transaction Template created successfully.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your transaction template: %s</p>", $cdb->error);
			}
			
			$last_id = $cdb->insert_id;
			
			// Now create the entries
			$counter = 1;
			$complete = false;
			do {
				$accountSelectName = "account-" . $counter;
				if (isset($_POST[$accountSelectName])) {
					
					$account = $_POST[$accountSelectName];
					$debit = $cdb->real_escape_string($_POST["debit-".$counter]);
					$credit = $cdb->real_escape_string($_POST["credit-".$counter]);
					
					$insertSQL = sprintf("INSERT INTO template_entries (account, debit, credit, transaction_template, entry_num) VALUES ('%s', '%s', '%s', '%s', '%s')", $account, $debit, $credit, $last_id, $counter);
					$result = runSQL($insertSQL, $cdb);
					if ($result == true) {
						$msg .= "Entry for ". $account ." created successfully.";
					} else {
						$msg .= sprintf("<p class=\"alert\">There was an error creating the entry: %s</p>", $cdb->error);
					}
					
					$counter++;	
					
				} else {
					$complete = true;
				}
			} while ($complete == false);
			
		}


	}
	
	/*$transactionsSQL = sprintf(
        "SELECT 
			%s.*, entries.*, 
			%s.name as accountName, 
			%s.type as accountType,
			SUM(COALESCE(entries.debit,0) - COALESCE(entries.credit,0)) as net 
			FROM `%s` 
			LEFT JOIN entries ON %s.id = entries.transaction 
			LEFT JOIN %s ON entries.account = %s.id 
			GROUP BY entries.id 
			ORDER BY %s.date DESC, %s.id DESC LIMIT 100", 
        $_SESSION["transactionsTable"], 
        $_SESSION["accountsTable"], 
		$_SESSION["accountsTable"], 
        $_SESSION["transactionsTable"], 
        $_SESSION["transactionsTable"], 
        $_SESSION["accountsTable"], 
        $_SESSION["accountsTable"], 
        $_SESSION["transactionsTable"],
        $_SESSION["transactionsTable"]);*/

	if (isset($_GET["ts"])) {
		$ts = $_GET["ts"];
	} else {
		$ts = strtotime("today");
	}
		
	$startDate = date("Y-m-01", $ts);
	$endDate = date("Y-m-t", $ts);
	$monthString = date("F Y", $ts);

	$lastmonth = mktime(0, 0, 0, date("m", $ts)-1, date("d", $ts), date("Y", $ts));
	$nextmonth = mktime(0, 0, 0, date("m", $ts)+1, date("d", $ts), date("Y", $ts));

	if (isset($_POST["submit"])) {
		if ($_POST["submit"] != "Add Transaction") {
			$transactionsSQL = sprintf("SELECT * FROM `%s` WHERE date >= '%s' AND date <= '%s' ORDER BY date %s LIMIT %s", $_SESSION["transactionsTable"], $startDate, $endDate, $desc, $selectLimit);
			// echo $transactionsSQL; 
			$transactions = getDataFromTable($transactionsSQL, $cdb);
		}
	} else {
		$transactionsSQL = sprintf("SELECT * FROM `%s` WHERE date >= '%s' AND date <= '%s' ORDER BY date %s LIMIT %s", $_SESSION["transactionsTable"], $startDate, $endDate, $desc, $selectLimit);
		// echo $transactionsSQL; 
		$transactions = getDataFromTable($transactionsSQL, $cdb);
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
            <h2>Transactions</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/transactions.php");
			?>            
            
			<h3 class="transactions-header">
				<span><?php echo $monthString; ?></span>
				<!--<span class="nav">&#9664; <a href="/transactions?ts=<?php echo $lastmonth; ?>">Previous Month</a> | <a href="/transactions?ts=<?php echo $nextmonth; ?>">Next Month</a> &#9654;</span>-->
			</h3>
			<?php
				include("includes/template/partials/transactions-table.php");
			?>            
          
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>