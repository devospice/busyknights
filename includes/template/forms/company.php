            	<div>
                	<label for="name">Name:</label>
                	<input type="text" name="name" value="<?php if (isset($company)) { echo $company["name"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="address">Address:</label>
                	<input type="text" name="address" value="<?php if (isset($company)) { echo $company["address"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="address2">Address 2:</label>
                    <input type="text" name="address2" value="<?php if (isset($company)) { echo $company["address2"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="city">City:</label>
                	<input type="text" name="city" value="<?php if (isset($company)) { echo $company["city"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="state">State:</label>
                    <input type="text" name="state" value="<?php if (isset($company)) { echo $company["state"]; } ?>">
                </div>
            	<div class="left-half">
                	<label for="zip">Postal code:</label>
                	<input type="text" name="zip" value="<?php if (isset($company)) { echo $company["zip"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="country">Country:</label>
                    <input type="text" name="country" value="<?php if (isset($company)) { echo $company["country"]; } ?>">
                </div>

            	<div>
                	<label for="web_site">Web site:</label>
                	<input type="text" name="web_site" placeholder="http://" value="<?php if (isset($company)) { echo $company["web_site"]; } ?>">
                </div>

            	<div class="left-half">
                	<label for="email">Email address:</label>
                	<input type="email" name="email" value="<?php if (isset($company)) { echo $company["email"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="email2">Alternate email address:</label>
                    <input type="email" name="email2" value="<?php if (isset($company)) { echo $company["email2"]; } ?>">
                </div>

            	<div class="left-half">
                    <label for="phone_office">Phone (office):</label>
                    <input type="tel" name="phone_office" value="<?php if (isset($company)) { echo $company["phone_office"]; } ?>">
                </div>
                <div class="right-half">
                    <label for="phone_alt">Phone (alternate):</label>
                    <input type="tel" name="phone_alt" value="<?php if (isset($company)) { echo $company["phone_alt"]; } ?>">
                </div>

            	<div class="left-half">
                	<label for="fax_office">Fax (office):</label>
                	<input type="tel" name="fax_office" value="<?php if (isset($company)) { echo $company["fax_office"]; } ?>">
                </div>
                <div class="right-half">
                </div>
 
             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if (isset($company)) { echo $company["notes"]; } ?></textarea>
                </div>
               
            	<!--<div class="left-half">
                	<label for="fax_office">Company:</label>
                	<p><em>To come</em></p>
                </div>-->
