
		<!--FORM TO SELECT START AND END DATE-->
                <div class="left-half">
                	<label class="inline" for="startdate">Start Date:</label>
                    <?php 
						// Assume start of the month
						$startdate = date("Y-m-01");
					?>
                    <input type="date" name="startdate" value="<?php echo $startdate; ?>">
               <!-- </div>
				<div class="right-half">-->
                	<label class="inline" for="enddate">End Date:</label>
                    <?php 
						// Assume last day of the month
						$enddate = date("Y-m-t");
					?>
                    <input type="date" name="enddate" value="<?php echo $enddate; ?>">
                </div>
               