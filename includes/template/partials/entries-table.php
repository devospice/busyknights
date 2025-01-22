            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="ten">Date</th>
                	<th class="thirty">Account</th>
					<th class="thirty">Notes</th>
					<th class="six debit">Debit</th>
                	<th class="six credit">Credit</th>
                	<th class="six cleared">Cleared</th>
                	<th class="six info">View</th>
                	<th class="six edit">Edit</th>
                	<th class="six edit">Delete</th>
                </thead>
				
                <?php
					if (count($entries) > 0) {
						
						$alt = false;
						$prevId = -1;
						$net = 0;
						$prevTrans = -1;
						
						foreach ($entries as $entry) {
							
							// Alternate row colors
							if ($entry["id"] != $prevId) {

								$prevId = $entry["id"];
								
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;
								
							} 
							
							// Have to keep track of multiple entries per transaction
							if ($entry["transaction"] == $prevTrans) {
								$transIndex++;
							} else {
								$transIndex = 0;
							}
							
							// Find the account name of the other account for this entry
							if ($entry["debit"] == "0.00") {
								$otherSQL = sprintf("SELECT
									%s.name as other_account, %s.id as other_id
									FROM %s
									LEFT JOIN %s on %s.account = %s.id
									WHERE %s.transaction = %s 
									AND %s.account != %s 
									AND %s.debit = '%s'",
									$_SESSION["accountsTable"], $_SESSION["accountsTable"], 
									$_SESSION["entriesTable"], 
									$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $entry["transaction"], 
									$_SESSION["entriesTable"], $entry["account"], 
									$_SESSION["entriesTable"], $entry["credit"]);
							} else {
								$otherSQL = sprintf("SELECT
									%s.name as other_account, %s.id as other_id
									FROM %s
									LEFT JOIN %s on %s.account = %s.id
									WHERE %s.transaction = %s 
									AND %s.account != %s 
									AND %s.credit = '%s'",
									$_SESSION["accountsTable"], $_SESSION["accountsTable"], 
									$_SESSION["entriesTable"], 
									$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $entry["transaction"], 
									$_SESSION["entriesTable"], $entry["account"], 
									$_SESSION["entriesTable"], $entry["debit"]);
							}
							
							/*SELECT 
								accounts_23.name as other_account, accounts_23.id as other_id 
								FROM entries_23 
								LEFT JOIN accounts_23 on entries_23.account = accounts_23.id 
								WHERE entries_23.transaction = entries_23 AND 658101.account != entries_23 AND 125.debit = '0.01'
							
							SELECT 
								accounts_23.name as other_account, accounts_23.id as other_id 
								FROM entries_23 
								LEFT JOIN accounts_23 on entries_23.account = accounts_23.id 
								WHERE entries_23.transaction = 658101 AND entries_23.account != entries_23 AND 125.debit = '0.01'
								
								*/

							// echo $otherSQL . "<br>";
							$others = getDataFromTable($otherSQL, $cdb);
							if ($others) {
								if (count($others) > 0) {
									$otherAccount = $others[0]["other_account"];
									$otherAccountId = $others[0]["other_id"];
								} else {
									$otherAccount = "";
									$otherAccountId = 0;
								}
							} else {
								$otherAccount = "";
								$otherAccountId = 0;
							}
							
							
							// Entry row 
							printf("<tr class=\"%s\">", $class);

							// $expand = "<div class=\"expand-table-button\" onClick=\"showThisRow(this);\"></div>";
							$date = date("n/j/Y", strtotime($entry["date"]));
							printf("<td class=\"date\">%s</td>", $date);
							
							if ($otherAccountId == 0) {
								echo "<td class=\"account\"></td>";
							} else {
								printf("<td class=\"account\"><a href=\"/accounts/view/%s\">%s</a></td>", $otherAccountId, $otherAccount);								
							}


							printf("<td class=\"notes\">%s</td>", $entry["notes"]);


							if ($entry["debit"] != "0.00") {
								printf("<td class=\"debit\">%s</td>", $entry["debit"]);
							} else {
								echo "<td class=\"debit\"></td>";
							}

							if  ($entry["credit"] != "0.00") {
								printf("<td class=\"credit\">%s</td>", $entry["credit"]);
							} else {
								echo "<td class=\"credit\"></td>";
							}

							$clearClass = "";
							$hasCleared = 0;
							if ($entry["cleared"] == true) {
								$clearClass = "hasCleared";
								$hasCleared = 1;
							}
							printf("<td class=\"cleared %s\"><a href=\"javascript:clearTransaction('%s', '%s');\">&nbsp;</a></td>", $clearClass, $entry["transaction"], $hasCleared);
							
							printf("<td class=\"info\"><a href=\"/transactions/view/%s\">i</a></td>", $entry["transaction"]);
							printf("<td class=\"edit\"><a href=\"/transactions/edit/%s\">&nbsp;</a></td>", $entry["transaction"]);
							printf("<td class=\"delete\"><a href=\"javascript:deleteTransaction('%s');\" onClick=\"return confirm('WARNING: Deleting this transaction will delete all associated entries on this and other accounts.  Are you sure you want to proceed?');\">/</a></td>", $entry["transaction"]);

							echo "</tr>";
							
							$prevTrans = $entry["transaction"];				
							
						}
						
						
					} 
				?>
            </table>
