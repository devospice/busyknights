<?php

	/* /sale-items/add-stock */
	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
	$description = $_SESSION["company"]["name"] . " - Add to Stock for this Item";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "sale items";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
		
	$itemsSQL = "SELECT * FROM sale_items ORDER BY name";
	$items = getDataFromTable($itemsSQL, $cdb);

	$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
			
			<?php
				if (isset($msg)) {
					if ($msg != "") {
						printf("<p>%s</p>", $msg);
					}
				}
			?>
			
            <h2>Add to stock</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
			<div class="left-half">
            	<p>Fill out the form below to add stock for this item.</p>
			</div>
			<div class="right-half">
				<p>Or select from a saved template:</p>
				<?php
					$disabled = "";
					if (count($templates) == 0) {
						$disabled = "disabled";
					}
				?>
				<select name="template-list" <?php echo $disabled; ?> onChange="getValuesFromTemplate(this);">
					<option value="0">--== Template ==--</option>
					<?php
						foreach ($templates as $template) {
							printf("<option value=\"%s\">%s</option>", $template["id"], $template["name"]);
						}
					?>
				</select>
			</div>


            <form action="/transactions" method="post" id="transaction-form">
			
				<div class="left-half">
					<label for="sale_item">Item:</label>
					<select name="sale_item">
						<option value="0">--== Select Sale Item ==--</option>
						<?php
							foreach ($items as $item) {
								$selected = "";
								if (isset($routes[3])) {
									if ($item["id"] == $routes[3]) {
										$selected = "selected";
									}
								}
								printf("<option value=\"%s\" %s>%s</option>", $item["id"], $selected, $item["name"]);
							}
						?>
					</select>
				</div>
				<div class="right-half">
					<label for="quantity">Quantity to Add: </label>
					<input type="number" name="quantity" value="1">
				</div>
            
                <?php
					include("includes/template/forms/transaction.php");
				?>
				
				<div class="left-half">
                	<input type="submit" name="submit" value="Add Stock">
				</div>
				<div class="right-half">
					<!--<div class="callout">
						<label for="name">Name:</label>
						<input type="text" name="name">
						<input type="submit" name="submit" value="Save as Template">
					</div>-->
				</div>

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php"); ?>