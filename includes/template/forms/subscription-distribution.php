                <?php
					$accountsSQL = sprintf("SELECT * FROM %s WHERE type = '2' ORDER BY name", $_SESSION["accountsTable"]);
					$accounts = getDataFromTable($accountsSQL, $cdb); 
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
					<label class="inline" for="amount">Share Amount: $ </label>
					<input type="number" step="0.01" class="large" name="amount">
				</div>


		<!--ENTRIES-->
                <h3>Artists</h3>
                
                <div id="transaction-entries">
                    <div class="entry">
                        <div class="left-half">
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
                        <div class="right-half">
                            <label for="numshares-1" class="inline"><br>Number of shares:</label>
                            <input type="number" step="0.01" name="numshares-1" value="<?php if (isset($transaction)) { echo $entries[0]["numshares"]; } ?>">
                        </div>
                        <a class="close-box entry-1" onClick="deleteArtistShare(1);">X</a>
                    </div>
                    
                    
                    <div class="entry">
                        <div class="left-half">
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
                        <div class="right-half">
                            <label for="numshares-2" class="inline"><br>Number of shares:</label>
                            <input type="number" step="0.01" name="numshares-2" value="<?php if (isset($transaction)) { echo $entries[1]["numshares"]; } ?>">
                        </div>
                        <a class="close-box entry-2" onClick="deleteArtistShare(2);">X</a>
                    </div>
                    
                    <?php
						if (isset($entries)) {
							if (count($entries) > 2) {
								$index = 2; // start at 2 since the first 2 are done above
								$num = 3;
								do {
									?>
									<div class="entry">
										<div class="left-half">
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
										<div class="right-half">
											<label for="numshares-<?php echo $num ?>" class="inline"><br>Number of shares:</label>
											<input type="number" step="0.01" name="numshares-<?php echo $num ?>" value="<?php if (isset($transaction)) { echo $entries[$index]["numshares"]; } ?>">
										</div>
										<a class="close-box entry-<?php echo $num ?>" onClick="deleteArtistShare(<?php echo $num ?>);">X</a>
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
                	<a class="button" onClick="addArtistShare();">Add Another Artist Share</a>
                </div>

             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if (isset($transaction)) { echo $transaction["notes"]; } ?></textarea>
                </div>

               