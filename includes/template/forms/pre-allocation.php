            	<div>
                	<label for="artist">Artist:</label>
					<h4><?php echo $artist["name"]; ?></h4>
					<input type="hidden" name="artist" value="<?php echo $artist["id"]; ?>">
                </div>
            	<div class="left-half">
                	<label for="percentage">Percentage:</label>
                	<input type="text" name="percent" value="">
                </div>
            	<div>
                	<label for="account">Account:</label>
                	<select name="account">
						<option value="0">--none--</option>
						<?php
							$accountsSQL = sprintf("SELECT * FROM %s WHERE type = '2' ORDER BY name", $_SESSION["accountsTable"]);
							$accounts = getDataFromTable($accountsSQL, $cdb);
						
							foreach ($accounts as $account) {
								printf("<option value=\"%s\">%s</option>", $account["id"], $account["name"]);
							}
						?>
					</select>
                </div>

 
