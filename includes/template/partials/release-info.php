            <div class="left-half">
            	<?php
					$ts = strtotime($item["release_date"]);
					$date = date("F j, Y", $ts);
				?>
            	<p><strong>Release Date:</strong> <?php echo $date; ?></p>
            </div>
            <div class="right-half">
            	<p><strong>Bar Code:</strong> <?php if (isset($item["bar_code"])) { echo $item["bar_code"]; } ?></p>
            </div>
            <div class="left-half">
            	<p><strong>Catalog Number:</strong> <?php if (isset($item["catalog_number"])) { echo $item["catalog_number"]; } ?></p>
            </div>
            <div class="right-half">
            	<p><strong>Transaction Template:</strong> <?php if (isset($item["template"])) { echo $item["template"]; } ?></p>
            </div>
            <div class="left-half">
            	<p><strong>Quantity in Stock:</strong> <?php echo $inventory[0]["stock"] ?></p>
            </div>
            <div class="right-half">
            </div>
