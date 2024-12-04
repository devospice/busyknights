            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="ten">Date</th>
                	<th class="thirty">Account</th>
					<th class="thirty">Notes</th>
					<th class="six">Debit</th>
                	<th class="six">Credit</th>
                	<!--<th class="six">Net</th>-->
                	<th class="six info">View</th>
                	<th class="six edit">Edit</th>
                	<th class="six edit">Delete</th>
                </thead>
				
                <?php
					if (count($transactions) > 0) {
						
						$alt = false;
						$prevId = -1;
						$net = 0;
						
						foreach ($transactions as $transaction) {
							
							// Alternate row colors
							if ($transaction["id"] != $prevId) {

								$prevId = $transaction["id"];
								
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;
								
							} 
							
							// Get entries for this transaction
							$entrySQL = sprintf(
							"SELECT 
								%s.*, %s.*, 
								%s.name as accountName, 
								%s.type as accountType,
								SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)) as net 
								FROM `%s` 
								LEFT JOIN %s ON %s.id = %s.transaction 
								LEFT JOIN %s ON %s.account = %s.id 
								WHERE %s.id = '%s'
								GROUP BY %s.id 
								ORDER BY %s.date DESC, %s.id DESC", 
							$_SESSION["transactionsTable"], $_SESSION["entriesTable"],
							$_SESSION["accountsTable"], // accountName
							$_SESSION["accountsTable"], // accountType
								$_SESSION["entriesTable"], $_SESSION["entriesTable"], // net
							$_SESSION["transactionsTable"], // from
								$_SESSION["entriesTable"], $_SESSION["transactionsTable"], $_SESSION["entriesTable"], // left join 1
								$_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], // left join 2
							$_SESSION["transactionsTable"], $transaction["id"],	// Where
								$_SESSION["entriesTable"], // group by
							$_SESSION["transactionsTable"],	$_SESSION["transactionsTable"]); // order by

							
							$entries = getDataFromTable($entrySQL, $cdb);
							// echo "<br>" . $entrySQL . "<br>";
							// var_dump($entries);
							
							// Summary row 
							$topRow = true;							
							
							foreach ($entries as $entry) {
								printf("<tr class=\"%s\">", $class);

								if ($topRow == true) {
									$date = date("n/j/Y", strtotime($transaction["date"]));
									printf("<td class=\"date\">%s</td>", $date);
								} else {
									echo "<td class=\"date\"></td>";
								}

								printf("<td class=\"account\"><a href=\"/accounts/view/%s\">%s</a></td>", $entry["account"], $entry["accountName"]);
								
								if ($topRow == true) {
									printf("<td class=\"notes\">%s</td>", $transaction["notes"]);
								} else {
									echo "<td class=\"notes\"></td>";
								}

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
								
								if ($topRow == true) {
									printf("<td class=\"info\"><a href=\"/transactions/view/%s\">i</a></td>", $transaction["id"]);
									printf("<td class=\"edit\"><a href=\"/transactions/edit/%s\">&nbsp;</a></td>", $transaction["id"]);
									printf("<td class=\"delete\"><a href=\"javascript:deleteTransaction('%s');\" onClick=\"return confirm('WARNING: Deleting this transaction will delete all associated entries on this and other accounts.  Are you sure you want to proceed?');\">/</a></td>", $transaction["id"]);
								} else {
									echo "<td class=\"info\"></td>";
									echo "<td class=\"edit\"></td>";
									echo "<td class=\"delete\"></td>";
								}

								echo "</tr>";
								
								$topRow = false;
								
							}
							
						}
						
						
					} 
				?>
            </table>
