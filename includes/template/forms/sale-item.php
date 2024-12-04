            	<div class="left-half">
                    <label for="name">Item Name:</label>
                    <input type="text" name="name" value="<?php if (isset($item)) { echo $item["name"]; } ?>">
                </div>
                <div class="right-half">
                	<label for="artist">Artist:</label>
					<select name="artist">
						<option value="0">--none--</option>
						<?php
							$artistsSQL = "SELECT * FROM artists ORDER BY name";
							$artists = getDataFromTable($artistsSQL, $cdb);
							foreach ($artists as $artist) {
								$selected = "";
								if (isset($item)) {
									if ($item["artist"] == $artist["id"]) {
										$selected = "selected";
									}
								}
								printf("<option value=\"%s\" %s>%s</option>", $artist["id"], $selected, $artist["name"]);
							}
						?>
					</select>
                </div>
            	<div class="left-half">
					<label for="release_date">Release Date:</label>
                    <?php
						if (isset($item)) {
							$releaseDate = $item["release_date"];
						} else {
							$ts = strtotime(date("Y-m-d"));
							$releaseDate = date("Y-m-d", $ts);
						}
					?>
                	<input type="date" name="release_date" value="<?php { echo $releaseDate; } ?>">
                </div>
                <div class="right-half">
                    <label for="opening_stock">Opening Stock Quantity:</label>
					<input type="number" name="opening_stock" value="<?php if (isset($item)) { echo $item["opening_stock"]; } else { echo "0"; } ?>">
                </div>
            	<div class="left-half">
                    <label for="catalog_number">Catalog Number:</label>
                    <input type="text" name="catalog_number" value="<?php if (isset($item)) { echo $item["catalog_number"]; } ?>">
                </div>
                <div class="right-half">
                	<label for="bar_code">Bar Code:</label>
                	<input type="text" name="bar_code" value="<?php if (isset($item)) { echo $item["bar_code"]; } ?>">
                </div>
             	<div>
                	<label for="description">Description:</label>
                    <textarea name="description"><?php if (isset($item)) { echo $item["description"]; } ?></textarea>
                </div>
               