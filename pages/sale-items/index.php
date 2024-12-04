<?php

	/* /accounts */
	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
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
		if ($_POST["submit"] == "Add Sale Item") {
			
			// Create the sale item
			$formValues = getValuesFromForm($_POST, false);
			$insertSQL = sprintf("INSERT INTO sale_items (%s) VALUES (%s)", $formValues[0], $formValues[1]);
			
			$result = runSQL($insertSQL, $cdb);
					
			if ($result == true) {
				$msg = "Sale item successfully created.<br>";
				
				// Assign default royalties
				$artistId = $cdb->real_escape_string($_POST["artist"]);
				include("includes/framework/code-snippets/assign-default-royalties.php");
				
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your sale item: %s</p>", $cdb->error);
			}
			
		}
		
		// Update existing item
		if ($_POST["submit"] == "Update Sale Item") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE sale_items %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Item successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating this item: %s</p>", $cdb->error);
			}
			
		}

		// Delete item
		if ($_POST["submit"] == "Delete Sale Item") {
	
			include("includes/framework/code-snippets/delete-sale-item.php");
			
		}
		
		
		// Import items
		if ($_POST["submit"] == "Import Sale Items") {
			
			// Update main form values
			$uploadedFilePath = $_FILES["csv_file"]["tmp_name"];
			
			// Set up output variables
			$counter = 0;
			$errorCount = 0;
			$errorMsg = "";
			
			// Read the uploaded data
			$handle = fopen($uploadedFilePath, "r");
			
			while (($item = fgetcsv($handle, 1000, ",")) !== FALSE) {					
				
				// echo $item[0] . "<br>";
				
				// Get the artist ID
				$artistIdSQL = sprintf("SELECT id FROM artists WHERE name = '%s'", $item[1]);
				$artistIds = getDataFromTable($artistIdSQL, $cdb);
				
				if ($artistIds) {
					
					$artistIdAr = $artistIds[0];
					$artistId = $artistIdAr["id"];
					
					// Create the sale item
					$insertSQL = sprintf("INSERT INTO sale_items (name, artist, release_date, catalog_number, bar_code) VALUES ('%s', '%s', '%s', '%s', '%s')", $item[0], $artistId, $item[2], $item[3], $item[4]);

					// echo $insertSQL . "<br>";
					
					$result = runSQL($insertSQL, $cdb);

					if ($result == true) {
						// $msg .= "Sale item successfully created.<br>";
						$counter++;
						
						// Assign default royalties
						include("includes/framework/code-snippets/assign-default-royalties.php");

					} else {
						$errorCount++;
						$errorMsg .= sprintf("<p class=\"alert\">There was an error creating your sale item: %s</p>", $cdb->error);
					}
					
				} else {
					$errorCount++;
					$errorMsg .= sprintf("<p class=\"alert\">Unable to find artist %s.  %s not added.</p>", $item[1], $item[0]);
				}
					
				
			}
			
			fclose($handle);
			
			$msg .= sprintf("%s items successfully imported.  %s errors. <br>%s", $counter, $errorCount, $errorMsg);


		}




	}
	
	$itemsSQL = "SELECT sale_items.*, artists.name AS artistName FROM sale_items LEFT JOIN artists ON sale_items.artist = artists.id ORDER BY name";
	$items = getDataFromTable($itemsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/accounts.php");
			?>
            <h2>Sale Items</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/sale-items.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="sixty">Title</th>
                	<th class="sixteen">Artist</th>
                	<th class="eight info">View</th>
                	<th class="eight edit">Edit</th>
                	<th class="eight edit">Sale</th>
                	<th class="eight edit">Delete</th>
                </thead>
                <?php
					if (count($items) > 0) {
						
						$alt = false;
						foreach ($items as $item) {

							$class = "";
							if ($alt) {
								$class = "alt";
							}
							$alt = !$alt;
															
							printf("<tr class=\"%s\">", $class);
							printf("<td class=\"name\"><a href=\"/sale-items/view/%s\">%s</a></td>", $item["id"], $item["name"]);
							printf("<td class=\"catalog\">%s</td>", $item["artistName"]); 
							printf("<td class=\"info\"><a href=\"/sale-items/view/%s\">i</a></td>", $item["id"]);
							printf("<td class=\"edit\"><a href=\"/sale-items/edit/%s\">&nbsp;</a></td>", $item["id"]);
							printf("<td class=\"sale\"><a href=\"/sale-items/format-sale/%s\" target=\"_blank\">-,-</a></td>", $item["id"]);
							printf("<td class=\"delete\"><a href=\"javascript:deleteSaleItem('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this item?');\">/</a></td>", $item["id"]);
							echo "</tr>";

						}
					} else {
						echo "<tr><td colspan=\"5\">You have not defined any sale items.  <a href=\"/sale-items/add\">Add a new item.</a></td></tr>";
					}
				?>
            </table>
			
			
          
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>