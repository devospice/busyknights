                        <?php
							$percentCheck = "checked";
							$amountCheck = "";
							if (isset($editRoyalty)) {
								if ($editRoyalty["use_percent"] == "0") {
									$amountCheck = "checked";
									$percentCheck = "";
								}
							}
						?>
                        
                        <div class="left-half">
                            <label for="percent"><input type="radio" name="use_percent" value="1" <?php echo $percentCheck; ?>> Percentage</label>
                            <input type="text" name="percent" value="<?php if (isset($editRoyalty)) { echo $editRoyalty["percent"]; } ?>">
                        </div>
                        <div class="right-half">
                            <label for="amount"><input type="radio" name="use_percent" value="0" <?php echo $amountCheck; ?>> Fixed amount</label>
                            <input type="text" name="amount" value="<?php if (isset($editRoyalty)) { echo $editRoyalty["amount"]; } ?>">
                        </div>
                        
                        <label for="account" class="inline">Pay to: </label>
                        <select name="credit_account">
                            <option value="0">--== Select Account ==--</option>
                            <?php
                                foreach ($creditAccounts as $account) {
									$selected = "";
									if (isset($editRoyalty)) {
										if ($account["id"] == $editRoyalty["credit_account"]) {
											$selected = "selected";
										}
									}
                                    printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
                                }
                            ?>
                        </select>
						
						<input type="hidden" name="debit_account" value="49">
                        <!--<label for="account">Record Expense Account (Debit)</label>
                        <select name="debit_account">
                            <option value="0">--== Select Account ==--</option>
                            <?php
                                foreach ($debitAccounts as $account) {
									$selected = "";
									if ($editRoyalty) {
										if ($account["id"] == $editRoyalty["debit_account"]) {
											$selected = "selected";
										}
									}
                                    printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
                                }
                            ?>
                        </select>-->
