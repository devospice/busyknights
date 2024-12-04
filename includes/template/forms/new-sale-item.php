            	<div class="left-half">
                    <label for="name">Item Name:</label>
                    <input type="text" name="name" value="<?php if ($item) { echo $item["name"]; } ?>">
                </div>
                <div class="right-half">
                	<label for="release_date">Release Date:</label>
                	<input type="date" name="release_date" value="<?php if ($item) { echo $item["release_date"]; } ?>">
                </div>
            	<div class="left-half">
                    <label for="catalog_number">Catalog Number:</label>
                    <input type="text" name="catalog_number" value="<?php if ($item) { echo $item["catalog_number"]; } ?>">
                </div>
                <div class="right-half">
                	<label for="bar_code">Bar Code:</label>
                	<input type="text" name="bar_code" value="<?php if ($item) { echo $item["bar_code"]; } ?>">
                </div>
            	<div class="left-half">
                    <label for="transaction_template">Use Transaction Template:</label>
					<?php
                        $disabled = "";
                        if (count($templates) == 0) {
                            $disabled = "disabled";
                        }
                    ?>
                    <select name="transaction_template" <?php echo $disabled; ?>>
                        <option value="0">--== Template ==--</option>
                        <?php
                            foreach ($templates as $template) {
                                printf("<option value=\"%s\">%s</option>", $template["id"], $template["name"]);
                            }
                        ?>
                    </select> <a class="button small" onClick="openNewTransactionTemplateOverlay();">New</a>
                </div>
                <div class="right-half">
                </div>
             	<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"><?php if ($item) { echo $item["notes"]; } ?></textarea>
                </div>
               