<?php		

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
			

?>