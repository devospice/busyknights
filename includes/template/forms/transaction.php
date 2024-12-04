                <?php
					$accountsSQL = sprintf("SELECT * FROM %s ORDER BY name", $_SESSION["accountsTable"]);
					$accounts = getDataFromTable($accountsSQL, $cdb); 

					$categoriesSQL = "SELECT * FROM expense_categories ORDER BY type";
					$categories = getDataFromTable($categoriesSQL, $cdb); 
				?>
		<!--TRANSACTION INFO-->
                <div class="left-half">
                	<label class="inline" for="date">Date:</label>
                    <?php 
						if (isset($transaction)) {
							$date = $transaction["date"]; 
						} else {
							$date = date("Y-m-d");
						}
					?>
                    <input type="date" name="date" value="<?php echo $date; ?>">
                </div>
				<div class="right-half">
					<!--<label class="inline" for="category">Expense Category:</label>
					<select name="category">
						<option value="0">--== none ==--</option>
						<?php
							foreach ($categories as $category) {
								$selected = "";
								if (isset($transaction)) {
									if ($category["id"] == $transaction["category"]) {
										$selected = "selected";
									}
								} 
								printf("<option value=\"%s\" %s>%s</option>", $category["id"], $selected, $category["type"]);
							}
						?>
					</select>-->
				</div>


		<!--ENTRIES-->
                <h3>Entries</h3>
                
                <div id="transaction-entries">
                    <div class="entry">
                        <div>
                            <label for="account-1">Account:</label>
                            <select name="account-1">
								<option value="0">--== SELECT ACCOUNT ==--</option>
                                <?php
                                    foreach ($accounts as $account) {
                                        $selected = "";
										if (isset($entries)) {
											if ($account["id"] == $entries[0]["account"]) {
												$selected = "selected";
											}
										} else {
											if (isset($routes[3])) {
												if ($account["id"] == $routes[3]) {
													$selected = "selected";
												}
											}
										}
                                        printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
                                    }
                                ?>
                            </select> <a class="button small" onClick="openNewAccountOverlay(1);">New</a>
                        </div>
                        <div class="left-half">
                            <label for="debit-1">Debit:</label>
                            <input type="text" name="debit-1" value="<?php if (isset($transaction)) { echo $entries[0]["debit"]; } ?>">
                        </div>
                        <div class="right-half">
                            <label for="credit-1">Credit:</label>
                            <input type="text" name="credit-1" value="<?php if (isset($transaction)) { echo $entries[0]["credit"]; } ?>">
                        </div>
                        <a class="close-box entry-1" onClick="deleteEntry(1);">X</a>
                    </div>
                    
                    
                    <div class="entry">
                        <div>
                            <label for="account-2">Account:</label>
                            <select name="account-2">
								<option value="0">--== SELECT ACCOUNT ==--</option>
                                <?php
                                    foreach ($accounts as $account) {
                                        $selected = "";
                                        if ($account["id"] == $entries[1]["account"]) {
                                            $selected = "selected";
                                        }
                                        printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
                                    }
                                ?>
                            </select> <a class="button small" onClick="openNewAccountOverlay(2);">New</a>
                        </div>
                        <div class="left-half">
                            <label for="debit-2">Debit:</label>
                            <input type="text" name="debit-2" value="<?php if (isset($transaction)) { echo $entries[1]["debit"]; } ?>">
                        </div>
                        <div class="right-half">
                            <label for="credit-2">Credit:</label>
                            <input type="text" name="credit-2" value="<?php if (isset($transaction)) { echo $entries[1]["credit"]; } ?>">
                        </div>
                        <a class="close-box entry-2" onClick="deleteEntry(2);">X</a>
                    </div>
                    
                    <?php
						if (isset($entries)) {
							if (count($entries) > 2) {
								$index = 2; // start at 2 since the first 2 are done above
								$num = 3;
								do {
									?>
									<div class="entry">
										<div>
											<label for="account-<?php echo $num ?>">Account:</label>
											<select name="account-<?php echo $num ?>">
												<option value="0">---== SELECT ACCOUNT ==--</option>
												<?php
													foreach ($accounts as $account) {
														$selected = "";
														if ($account["id"] == $entries[$index]["account"]) {
															$selected = "selected";
														}
														printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
													}
												?>
											</select> <a class="button small" onClick="openNewAccountOverlay(<?php echo $num ?>);">New</a>
										</div>
										<div class="left-half">
											<label for="debit-<?php echo $num ?>">Debit:</label>
											<input type="text" name="debit-<?php echo $num ?>" value="<?php if (isset($transaction)) { echo $entries[$index]["debit"]; } ?>">
										</div>
										<div class="right-half">
											<label for="credit-<?php echo $num ?>">Credit:</label>
											<input type="text" name="credit-<?php echo $num ?>" value="<?php if (isset($transaction)) { echo $entries[$index]["credit"]; } ?>">
										</div>
										<a class="close-box entry-<?php echo $num ?>" onClick="deleteEntry(<?php echo $num ?>);">X</a>
									</div>
									<?php				
									$index++;
									$num++;
								} while ($index < count($entries));
							}
						}
					?>
                    
                
                </div>
                
                <div class="section-nav">
                	<a class="button" onClick="addEntry();">Add Another Entry</a>
                </div>

				<div>
					<input type="checkbox" name="amortize"><label for="amortize" class="inline">Amortize this payment over <input type="number" class="inline" name="amortize_months"> months.</label>
				</div>
 
             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if (isset($transaction)) { echo $transaction["notes"]; } ?></textarea>
                </div>

				<div>
					<?php
						/*$checked = "";
						if (isset($transaction)) {
							if ($transaction["subscription_payment"] == true) {
								$checked = "checked";
							}
						}*/
					?>
					<!--<input type="checkbox" name="subscription_payment" value="1" <?php echo $checked; ?>> <label for="subscription_payment" class="inline">This is a subscription payment.</label>-->
				</div>
               