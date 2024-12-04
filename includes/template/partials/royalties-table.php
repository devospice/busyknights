                <table cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <th class="sixty">Account</th>
                        <th class="twenty">Amount</th>
                        <th class="ten edit">Edit</th>
                        <th class="ten edit">Delete</th>
                    </thead>
					<?php
						$totalPercent = 0;
						$totalAmount = 0;
						$alt = false;
						
						if (count($royalties) > 0) {
							
                            foreach ($royalties as $royalty) {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"account\">%s</td>", $royalty["accountName"]);
								
								if ($royalty["use_percent"] == "1") {
									$amount = sprintf("%s%%", $royalty["percent"]);
									$totalPercent = $totalPercent + $royalty["percent"];
								} else {
									$amount = sprintf("$%s", $royalty["amount"]);
									$totalAmount = $totalAmount + $royalty["amount"];
								}    
								
								printf("<td class=\"amount\">%s</td>", $amount);
								printf("<td class=\"edit\"><a href=\"/sale-items/view/%s/%s\">&nbsp;</a></td>", $item["id"], $royalty["id"]);
								printf("<td class=\"delete\"><a href=\"javascript:deleteRoyalty('%s');\" onClick=\"return confirm('WARNING: Are you sure you want to delete this royalty assignment?');\">/</a></td>", $royalty["id"]);
								echo "</tr>";
                            }
                        }
                    ?>
                </table>
                <p><strong>Total allocated royalties:</strong><br>
				<?php printf("Percent: %s%%;<br>Flat amount: $%s", $totalPercent, $totalAmount); ?></p>
