<?php

	/* /sale-items/view */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Sale Items";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");


	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	
	if (isset($_POST["submit"])) {
		
		// Create new item
		if ($_POST["submit"] == "Assign Royalty") {
			
			$formValues = getValuesFromForm($_POST, false);
			$insertSQL = sprintf("INSERT INTO royalties (%s) VALUES (%s)", $formValues[0], $formValues[1]);
			// echo $insertSQL;
			$result = runSQL($insertSQL, $cdb);
					
			if ($result == true) {
				$msg = "Royalties successfully assigned.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error assigning this royalty: %s</p>", $cdb->error);
			}
			
		}

	}
	
	
	
	
	
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$itemsSQL = sprintf("SELECT sale_items.*, transaction_templates.name AS template FROM sale_items LEFT JOIN transaction_templates ON sale_items.transaction_template = transaction_templates.id WHERE sale_items.id = '%s'", $id);
		$items = getDataFromTable($itemsSQL, $cdb);
		if ($items) {
			$item = $items[0];
			
			$royaltySQL = sprintf("SELECT royalties.*, %s.name as accountName FROM royalties LEFT JOIN %s ON royalties.account = %s.id WHERE sale_item = '%s'", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $item["id"]);
			$royalties = getDataFromTable($royaltySQL, $cdb);
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this item: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No item found.</p>";
	}
	
	
	$accountsSQL = sprintf("SELECT * FROM %s WHERE type='2' ORDER BY name", $_SESSION["accountsTable"]);
	$accounts = getDataFromTable($accountsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/contact.php");
			?>
            <h2><?php echo $item["name"]; ?></h2>
            
			<?php
				include("includes/template/subnavs/sale-items.php");
			?>            
			<div class="section-nav">
				<a href="/sale-items/edit/<?php echo $item["id"] ?>" class="button">Edit this Item</a>
            </div>
            
            <h4>Release Information</h4>
			
                <?php include("includes/template/partials/release-info.php"); ?>	

			<hr class="spacer">

            <h4>Royalties</h4>
 			<div class="left-half">

                <?php include("includes/template/partials/royalties-table.php"); ?>	
                
            </div>
            <div class="right-half">
            	<div class="callout">
            	<p>Assign royalties for this item:</p>
                    <form method="post" action="<?php echo $PHP_SELF; ?>">
                        <input type="hidden" name="sale_item" value="<?php echo $item["id"] ?>">
                        
                        <?php include("includes/template/forms/royalties.php"); ?>
                        
                        <input type="submit" name="submit" value="Assign Royalty">
                        
                    </form>
                </div>
            </div>

            
			<div class="section-nav">
				<a href="/sale-items/edit/<?php echo $item["id"] ?>" class="button">Edit this Item</a>
            </div>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");