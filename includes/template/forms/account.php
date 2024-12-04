            	<div class="left-half">
                	<label for="name">Account Name:</label>
                	<input type="text" name="name" value="<?php if (isset($account)) { echo $account["name"]; } ?>">
                </div>
				<div class="right-half">
                	<label for="starting_balance">Starting balance:</label>
                	<input type="text" name="starting_balance" placeholder="0.00" value="<?php if (isset($account)) { echo $account["starting_balance"]; } ?>">
				</div>
            	<div class="left-half">
                 	<label for="type">Account Type:</label>
					<select name="type" onChange="updateAccountCategories(this);">
						<?php
							$typesSQL = "SELECT * FROM account_type ORDER BY sort_order";
							$types = getDataFromTable($typesSQL, $cdb);
							foreach ($types as $type) {
								$selected = "";
								if (isset($account)) {
									if ($account["type"] == $type["id"]) {
										$selected = "selected";
									}
								} else {
									if (isset($routes[3])) {
										if ($routes[3] == $type["type"]) {
											$selected = "selected";
										}
									}
								}
								printf("<option value=\"%s\" %s>%s</option>", $type["id"], $selected, $type["type"]);
							}
						?>
					</select>
               </div>
                <div class="right-half">
					<label for="category">Account Category:</label>
					<select name="category" id="account_category">
						<option value="0">--== NONE ==--</option>
						<?php
							$categorySQL = sprintf("SELECT * FROM account_category WHERE applies_to = '%s' ORDER BY name", $account["type"]);
							$categories = getDataFromTable($categorySQL, $cdb);
							foreach ($categories as $category) {
								$selected = "";
								if (isset($account)) {
									if ($account["category"] == $category["id"]) {
										$selected = "selected";
									}
								} 
								printf("<option value=\"%s\" %s>%s</option>", $category["id"], $selected, $category["name"]);
							}
						?>
					</select>
                </div>
            	<div class="left-half">
                	<label for="contact">Contact:</label>
					<select name="contact">
						<option value="0">--none--</option>
						<?php
							$contactSQL = "SELECT first_name, last_name, id FROM contacts ORDER BY first_name, last_name";
							$contacts = getDataFromTable($contactSQL, $cdb);
							foreach ($contacts as $contact) {
								$selected = "";
								if ($account["contact"] == $contact["id"]) {
									$selected = "selected";
								}
								printf("<option value=\"%s\" %s>%s %s</option>", $contact["id"], $selected, $contact["first_name"], $contact["last_name"]);
							}
						?>
					</select>
                </div>
                <div class="right-half">
                </div>
                <div class="left-half">
                    <label for="company">Company:</label>
					<select name="company">
						<option value="0">--none--</option>
						<?php
							$companySQL = "SELECT name, id FROM companies ORDER BY name";
							$companies = getDataFromTable($companySQL, $cdb);
							foreach ($companies as $company) {
								$selected = "";
								if ($account["company"] == $company["id"]) {
									$selected = "selected";
								}
								printf("<option value=\"%s\" %s>%s</option>", $company["id"], $selected, $company["name"]);
							}
						?>
					</select>
                </div>
 
             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if (isset($account)) { echo $account["notes"]; } ?></textarea>
                </div>
               