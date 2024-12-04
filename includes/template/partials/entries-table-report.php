		<table width="650" cellpadding="0" cellspacing="0" border="0">
			<thead style="background-color: #034625;">
				<th width="15"></th>
				<th width="70" style="font-family: arial; font-size: 16px; line-height: 22px; color: white; padding: 4px; text-align: left;">Date</th>
				<th width="234" style="font-family: arial; font-size: 16px; line-height: 22px; color: white; padding: 4px; text-align: left;">Description</th>
				<th width="229" style="font-family: arial; font-size: 16px; line-height: 22px; color: white; padding: 4px; text-align: left;">Notes</th>
				<th width="70" style="font-family: arial; font-size: 16px; line-height: 22px; color: white; padding: 4px; padding-right: 15px; text-align: right;">Amount</th>
			</thead>
				
			<?php
			if ($entries) {
				if (count($entries) > 0) {

					$alt = false;
					$prevId = -1;
					$net = 0;
					$prevTrans = -1;
					
					$fmt = new NumberFormatter( 'en', NumberFormatter::CURRENCY );

					foreach ($entries as $entry) {

						// Skip transactions that net to $0
						if (($entry["credit"] != "0.00") || ($entry["debit"] != "0.00")) {
						
							// Alternate row colors
							if ($entry["id"] != $prevId) {

								$prevId = $entry["id"];

								$class = "";
								if ($alt) {
									$class = "background-color: #e5ece9;";
								}
								$alt = !$alt;

							} 

							// Have to keep track of multiple entries per transaction
							if ($entry["transaction"] == $prevTrans) {
								$transIndex++;
							} else {
								$transIndex = 0;
							}

							// Entry row 
							printf("<tr style=\"%s\">", $class);
							
							// Empty cell
							echo "<td></td>";

							// Date
							$date = date("n/j/Y", strtotime($entry["date"]));
							printf("<td style=\"font-family: arial; font-size: 15px; line-height: 18px; padding: 4px;\">%s</td>", $date);

							// Description
							printf("<td style=\"font-family: arial; font-size: 15px; line-height: 18px; padding: 4px;\">%s</td>", $entry["itemName"]);

							// Notes
							if ($entry["itemName"] == "") {
								printf("<td style=\"font-family: arial; font-size: 15px; line-height: 18px; padding: 4px;\">%s</td>", $entry["notes"]);
							} else {
								echo "<td style=\"font-family: arial; font-size: 15px; line-height: 18px; padding: 4px;\"></td>";
							}
							

							// Amount
							if (($account["accountType"] == "Asset") || ($account["accountType"] == "Expense")) {
								// Debit in, credit out
								if ($entry["debit"] != "0.00") {
									$amount = $entry["debit"];
								} else {
									// $amount = number_format($entry["credit"] * -1, 2);
									$amount = $entry["credit"];
								}
							} else {
								// Credit in, debit out
								if  ($entry["credit"] != "0.00") {
									$amount = $entry["credit"];
								} else {
									// $amount = number_format($entry["debit"] * -1, 2);
									$amount = $entry["debit"];
								}
							}
							$amount = $fmt->formatCurrency($amount, "USD")."\n";
							printf("<td align=\"right\" style=\"font-family: arial; font-size: 15px; line-height: 18px; padding: 4px; padding-right: 15px;\">%s</td>", $amount);

							echo "</tr>";

							$prevTrans = $entry["transaction"];		
							
						}

					}

				} 
				
			}
			?>
			<tr>
				 <td colspan="5" bgcolor="#034625" width="650" height="3" style="mso-line-height-rule: exactly;"></td>
			</tr>
		</table>
