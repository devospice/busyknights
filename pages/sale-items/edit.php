<?php

	/* /sales/new-item */
	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
	$description = $_SESSION["company"]["name"] . " - Edit a New Item";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	
	$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);

	if (isset($routes[3])) {
		$id = $routes[3];
		
		$itemsSQL = sprintf("SELECT * FROM sale_items WHERE ID = '%s'", $id);
		$items = getDataFromTable($itemsSQL, $cdb);
		if ($items) {
			$item = $items[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this item's information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No item found.</p>";
	}
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Edit Sale Item</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Fill out the form below to edit this sale item.</p>

						
            <form action="/sale-items" method="post" id="sale-item-form">
            
            	<input type="hidden" name="id" value="<?php echo $item["id"]; ?>">
                <?php
					include("includes/template/forms/sale-item.php");
				?>
				                
                <input type="submit" name="submit" value="Update Sale Item">
                <input type="button" name="submit" value="Cancel" onClick="window.history.go(-1);">
				<div class="vertical-divider"></div>
                <input type="submit" name="submit" value="Delete Sale Item" onClick="return confirm('Are you sure you want to delete this sale item?');">
                
            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");