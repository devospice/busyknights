            	<div class="left-half">
                	<label for="first_name">First name:</label>
                	<input type="text" name="first_name" value="<?php if (isset($contact)) { echo $contact["first_name"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="last_name">Last name:</label>
                    <input type="text" name="last_name" value="<?php if (isset($contact)) { echo $contact["last_name"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="address">Address:</label>
                	<input type="text" name="address" value="<?php if (isset($contact)) { echo $contact["address"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="address2">Address 2:</label>
                    <input type="text" name="address2" value="<?php if (isset($contact)) { echo $contact["address2"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="city">City:</label>
                	<input type="text" name="city" value="<?php if (isset($contact)) { echo $contact["city"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="state">State:</label>
                    <input type="text" name="state" value="<?php if (isset($contact)) { echo $contact["state"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="zip">Postal code:</label>
                	<input type="text" name="zip" value="<?php if (isset($contact)) { echo $contact["zip"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="country">Country:</label>
                    <input type="text" name="country" value="<?php if (isset($contact)) { echo $contact["country"]; } ?>">
                </div>

            	<div class="left-half">
                	<label for="email">Email address:</label>
                	<input type="email" name="email" value="<?php if (isset($contact)) { echo $contact["email"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="email2">Alternate email address:</label>
                    <input type="email" name="email2" value="<?php if (isset($contact)) { echo $contact["email2"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="email3">Alternate email address:</label>
                	<input type="email" name="email3" value="<?php if (isset($contact)) { echo $contact["email3"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="email4">Alternate email address:</label>
                    <input type="email" name="email4" value="<?php if (isset($contact)) { echo $contact["email4"]; } ?>">
                </div>

            	<div class="left-half">
                	<label for="phone_cell">Phone (cell):</label>
                	<input type="tel" name="phone_cell" value="<?php if (isset($contact)) { echo $contact["phone_cell"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="phone_office">Phone (office):</label>
                    <input type="tel" name="phone_office" value="<?php if (isset($contact)) { echo $contact["phone_office"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="phone_home">Phone (home):</label>
                	<input type="tel" name="phone_home" value="<?php if (isset($contact)) { echo $contact["phone_home"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="phone_alt">Phone (alternate):</label>
                    <input type="tel" name="phone_alt" value="<?php if (isset($contact)) { echo $contact["phone_alt"]; } ?>">
                </div>

            	<div class="left-half">
                	<label for="fax_office">Fax (office):</label>
                	<input type="tel" name="fax_office" value="<?php if (isset($contact)) { echo $contact["fax_office"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="fax_home">Fax (home):</label>
                    <input type="tel" name="fax_home" value="<?php if (isset($contact)) { echo $contact["fax_home"]; } ?>">
                </div>
                
            	<div>
                	<label for="company">Company:</label>
                	<select name="company">
                    	<option value="0">--none--</option>
                        <?php 
							$companiesSQL = "SELECT * FROM companies ORDER BY name";
							$allCompanies = getDataFromTable($companiesSQL, $cdb);
							if (count($allCompanies) > 0) {
								foreach ($allCompanies as $company) {
									$selected = "";
									if ($contact["company"] == $company["id"]) {
										$selected = "selected";
									}
									printf("<option value=\"%s\" %s>%s</option>", $company["id"], $selected, $company["name"]);
								}
							}
						?>
                    </select>
                </div>
