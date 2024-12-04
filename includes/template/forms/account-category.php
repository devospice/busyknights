<?php
	$accountTypeSQL = "SELECT * FROM account_type ORDER BY type";
	$accountTypes = getDataFromTable($accountTypeSQL, $cdb);
?>
				<div class="left-half">
                	<label for="name">Category Name:</label>
                	<input type="text" name="name" value="<?php if (isset($category)) { echo $category["name"]; } ?>">
                </div>
				<div class="right-half">
                	<label for="applies_to">Applies to Account Type:</label>
                	<select name="applies_to">
						<option value="0">--== NONE ==--</option>
						<?php
							foreach($accountTypes as $accountType) {
								$selected = "";
								if ($category["applies_to"] == $accountType["id"]) {
									$selected = "selected";
								}
								printf("<option value=\"%s\" %s>%s</option>", $accountType["id"], $selected, $accountType["type"]);
							}
						?>
					</select>
                </div>
             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if (isset($category)) { echo $category["notes"]; } ?></textarea>
                </div>
               