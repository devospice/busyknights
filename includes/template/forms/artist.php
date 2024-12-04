            	<div class="left-half">
                	<label for="name">Name:</label>
                	<input type="text" name="name" value="<?php if (isset($artist)) { echo $artist["name"]; } ?>">
                </div>
            	<div class="right-half">
                	<label for="email">Web site:</label>
                	<input type="text" name="web_site" placeholder="http://" value="<?php if (isset($artist)) { echo $artist["web_site"]; } ?>">
                </div>

                <div>
					
					<?php
						$contactSQL = "SELECT * FROM contacts ORDER BY first_name, last_name";
						$contacts = getDataFromTable($contactSQL, $cdb);
					?>
					
                    <label for="email2">Contact:</label>
					<select name="contact">
						<option value="0">--none--</option>
						<?php 
							foreach ($contacts as $contact) {
								if ($contact["id"] == $artist["contact"]) {
									$selected = "selected";
								} else {
									$selected = "";
								}
								printf("<option value=\"%s\" %s>%s %s</option>", $contact["id"], $selected, $contact["first_name"], $contact["last_name"]);
							}
						?>
					</select>
                    
                </div>
 
             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if (isset($artist)) { echo $artist["notes"]; } ?></textarea>
                </div>

				<p class="small-text">Pre-allocations can be defined after the artist is created.</p>
               
