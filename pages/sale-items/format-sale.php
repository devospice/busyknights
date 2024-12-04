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

	
	if (isset($routes[3])) {
		$id = $routes[3];
		
		// Get item information
		$itemsSQL = sprintf("SELECT * FROM sale_items WHERE sale_items.id = '%s'", $id);
		$items = getDataFromTable($itemsSQL, $cdb);
		
		$saleString = "";
		if ($items) {
			$item = $items[0];
			
			// Format string for sale:
			// Sale Date,Item Name,Artist,Sale Price
			$today = date("Y-m-d");
			
			$artistNameSQL = sprintf("SELECT name FROM artists WHERE id = %s", $item["artist"]);
			$artistNames = getDataFromTable($artistNameSQL, $cdb);
			$artistName = $artistNames[0]["name"];
			
			$saleString = sprintf("%s,%s,%s,9.99", $today, $item["name"], $artistName);
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this item: %s</p>", $cdb->error);
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
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
        	
            <?php
				// include("includes/template/searches/contact.php");
			?>
            <h2>Sales String for CSV</h2>
            
			<p>
            <?php
				echo $saleString;
			?>
            </p>
		            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");