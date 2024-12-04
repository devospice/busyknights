<?php
	$accountsSQL = sprintf("SELECT * FROM %s ORDER BY name", $_SESSION["accountsTable"]);
	$allAccounts = getDataFromTable($accountsSQL, $cdb);
?>

            	<div>
                	<label for="account">Account:</label>
                    <?php
						if ($routes[2] == "edit") {
							$disabled = "disabled";
						} else {
							$disabled = "";
						}
					?>
                	<select name="account" <?php echo $disabled; ?>>
                    	<option value="0">--== Select an account ==--</option>
                        <?php
							foreach ($allAccounts as $account) {
								$selected = "";
								if (isset($routes[3])) {
									if (($info["account"] == $account["id"]) || ($routes[3] == $account["id"])) {
										$selected = "selected";
									}
								}
								printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
							}
						?>
                    </select>
                </div>
                <div>
                	<label for="method">Payment method:</label>
                    <?php
						if ($routes[2] == "edit") {
							$disabled = "disabled";
						} else {
							$disabled = "";
						}
					?>
                  	<select name="method" class="toggle-select" id="payment-method-select" <?php echo $disabled; ?>>
						<option value="0" data-toggle="reset">--== SELECT ==--</option>
                  	<?php
						$methodsSQL = "SELECT * FROM payment_methods ORDER BY method";
						$methods = getDataFromTable($methodsSQL, $cdb);
						foreach ($methods as $method) {
							$selected = "";
							if (isset($routes[3])) {
								if ($info["method"] == $method["id"]) {
									$selected = "selected";
								}
							}
							$toggle = $method["method"] . "-form";
							printf("<option value=\"%s\" data-toggle=\"%s\" %s>%s</option>", $method["id"], $toggle, $selected, $method["method"]);
						}
					?>
                    </select>
                </div>
             	<div>
                	<label for="instructions">Notes or special instructions:</label>
                    <textarea name="instructions"><?php if (isset($info)) { echo $info["instructions"]; } ?></textarea>
                </div>
                
                <?php 
					$hidClass = "initiallyHidden";
					if (isset($routes[3])) {
						if (isset($info)) {
							if ($info["method"] == "2") {
								$hidClass = "";
							} 
						}
					}
				?>
                <div id="Check-form" class="toggle-group <?php echo $hidClass; ?>">
                	<h3>Check Information</h3>
                    <div>
                        <label for="pay_to">Pay to:</label>
                        <input type="text" name="pay_to" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["pay_to"]; } ?>">
                    </div>
                    <div>
                        <label for="mail_to">Mail to:</label>
                        <input type="text" name="mail_to" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["mail_to"]; } ?>">
                    </div>
                    <div class="left-half">
                        <label for="address">Address:</label>
                        <input type="text" name="address" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["address"]; } ?>">
                    </div>
                    <div class="right-half">
                        <label for="address2">Address 2:</label>
                        <input type="text" name="address2" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["address2"]; } ?>">
                    </div>
                    <div class="left-half">
                        <label for="city">City:</label>
                        <input type="text" name="city" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["city"]; } ?>">
                    </div>
                    <div class="right-half">
                        <label for="state">State:</label>
                        <input type="text" name="state" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["state"]; } ?>">
                    </div>
                    <div class="left-half">
                        <label for="zip">Postal code:</label>
                        <input type="text" name="zip" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["zip"]; } ?>">
                    </div>
                    <div class="right-half">
                        <label for="country">Country:</label>
                        <input type="text" name="country" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["country"]; } ?>">
                    </div>
        
                    <div class="left-half">
                        <label for="phone">Phone:</label>
                        <input type="tel" name="phone" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["phone"]; } ?>">
                    </div>
                </div>
                
                <?php 
					$hidClass = "initiallyHidden";
					if (isset($routes[3])) {
						if (isset($info)) {
							if ($info["method"] == "1") {
								$hidClass = "";
							} 
						}
					}
				?>
                <div id="PayPal-form" class="toggle-group <?php echo $hidClass; ?>">
                	<h3>PayPal Information</h3>
                    <div>
                        <label for="email">PayPal email account:</label>
                        <input type="email" name="email" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["email"]; } ?>">
                    </div>
                </div>

				<?php 
					$hidClass = "initiallyHidden";
					if (isset($routes[3])) {
						if (isset($info)) {
							if ($info["method"] == "4") {
								$hidClass = "";
							} 
						}
					}
				?>
                <div id="Venmo-form" class="toggle-group <?php echo $hidClass; ?>">
                	<h3>Venmo Information</h3>
                    <div>
                        <label for="handle">Venmo handle:</label>
                        <input type="text" name="handle" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["handle"]; } ?>">
                    </div>
                </div>
                
                <?php 
					$hidClass = "initiallyHidden";
					if (isset($routes[3])) {
						if (isset($info)) {
							if ($info["method"] == "3") {
								$hidClass = "";
							} 
						}
					}
				?>
                 <div id="Web Site-form" class="toggle-group <?php echo $hidClass; ?>">
                	<h3>Web Site Information</h3>
                    <div>
                        <label for="url">URL:</label>
                        <input type="text" name="url" placeholder="http://" value="<?php if (isset($paymentInfo)) { echo $paymentInfo["url"]; } ?>">
                    </div>
                </div>

				<div>
					<?php
						$checked = "checked";  // Assume checked since most will be
						if (isset($routes[3])) {
							if (isset($info)) {
								if ($info["is_preferred"] == false) {
									$checked = "";
								}
							}
						} 
					?>
					<input type="checkbox" name="is_preferred" <?php echo $checked; ?>><label for="is_preferred" class="inline">Is preferred</label>
				</div>
              
