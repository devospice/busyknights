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
		
		// Update existing royalty
		if ($_POST["submit"] == "Update Royalty") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE royalties %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Royalty successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating this royalty: %s</p>", $cdb->error);
			}
			
		}
		
		// Calculate royalties from list of artists and tracks
		if ($_POST["submit"] == "Calculate Royalties") {
			
			$artists = $_POST["artist"];
			$songNums = $_POST["tracks"];
			
			var_dump($_POST);
			//var_dump($songNums);
			
		}
		
		// Import royalty distribution CSV
		if ($_POST["submit"] == "Import Royalty Distribution") {
			
			// Update main form values
			$uploadedFilePath = $_FILES["csv_file"]["tmp_name"];
			
			// Set up output variables
			$errorCount = 0;
			$errorMsg = "";
			
			// Read the uploaded data
			$handle = fopen($uploadedFilePath, "r");
			
			// Loop through each line and store the data in an array
			$artistData = array();
			
			while (($artist = fgetcsv($handle, 1000, ",")) !== FALSE) {	
				
			// Store values from this row
				$artistName = $artist[0];
				$numTracks = $artist[1];
				
				if ($numTracks > 0) {
					
					$thisArtist = array("name" => $artistName, "tracks"=>$numTracks);
					$artistData[] = $thisArtist;
					
				}
				
			}
				
			
			fclose($handle);
			
			// $msg = sprintf("%s artists successfully imported.  %s errors.  %s", $counter, $errorCount, $errorMsg);
			
			// Get the total number of tracks
			$totalTracks = 0;
			for ($i=0; $i<count($artistData); $i++) {
				$totalTracks += $artistData[$i]["tracks"];
			}
			// echo "Total tracks: " . $totalTracks . "<br>";
			
			// Get percentage per track
			$percent = 100 / $totalTracks; // Since we're using pre-allocations
			$percent = round($percent, 2);
			// echo "Percent per track: " . $percent . "<br>";
			
			// Get the sale item
			$saleItem = $cdb->real_escape_string($_POST["sale_item"]);
			
			// Now loop through the array and assign the royalties
			for ($j=0; $j<count($artistData); $j++) {
				
				// Find the artist's account
				$artistSQL = sprintf("SELECT * FROM artists WHERE name = '%s'", addslashes($artistData[$j]["name"]));
				// echo $artistAccountSQL . "<br>";
				$artists = getDataFromTable($artistSQL, $cdb);
				if ($artists != false) {
					$artist = $artists[0];
					
					// Get pre-allocations for this artist
					$preAllocSQL = sprintf("SELECT * FROM pre_allocations WHERE artist = '%s'", $artist["id"]);
					// echo $preAllocSQL . "<br>";
					$preAllocations = getDataFromTable($preAllocSQL, $cdb);
					
					if ($preAllocations != false) {
						// Loop through the pre-allocations and assign allocation to percentage
						for ($k=0; $k<count($preAllocations); $k++) {
							// Get this artist's total share
							$percentTotal = ($preAllocations[$k]["percent"] / 100) * ($percent * $artistData[$j]["tracks"]);
							
							// Allocate this artist's royalties
							$insertSQL = sprintf("INSERT INTO royalties (sale_item, credit_account, debit_account, percent) VALUES ('%s', '%s', '49', '%s')", $saleItem, $preAllocations[$k]["account"], $percentTotal);
							// echo $insertSQL . "<br>";
							$result = runSQL($insertSQL, $cdb);

							if ($result == true) {
								$msg .= "Royalties successfully assigned for " . $artistData[$j]["name"] . ".<br>";
							} else {
								$errorCount++;
								$errorMsg .= sprintf("<p class=\"alert\">There was an error assigning royalties for %s: %s</p>", $artistData[$j]["name"], $cdb->error);
							}
							
						}
						
					} else {
						$errorCount++;
						$errorMsg = $errorMsg . "Unable to find pre-allocation for " . $artist["name"] . "<br>";
					}
					
					
				} else {
					$errorCount++;
					$errorMsg = $errorMsg . "Unable to find artist " . $artistData[$j]["name"] . "<br>";
				}
				
				
			}
						
			$msg = $msg . "<br><br>" . $errorMsg;
			
		}

	}
	
	
	
	
	
	if (isset($routes[3])) {
		$id = $routes[3];
		
		// Get item information
		$itemsSQL = sprintf("SELECT * FROM sale_items WHERE sale_items.id = '%s'", $id);
		$items = getDataFromTable($itemsSQL, $cdb);
		if ($items) {
			$item = $items[0];
			
			// Get royalty information
			$royaltySQL = sprintf("SELECT royalties.*, %s.name as accountName FROM royalties LEFT JOIN %s ON royalties.credit_account = %s.id WHERE sale_item = '%s'", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $item["id"]);
			$royalties = getDataFromTable($royaltySQL, $cdb);
			
			if (isset($routes[4])) {
				
				$thisRoyaltySQL = sprintf("SELECT * FROM royalties WHERE id = '%s'", $routes[4]);
				$thisRoyalties = getDataFromTable($thisRoyaltySQL, $cdb);
				$editRoyalty = $thisRoyalties[0];
				
			}
			
			// Get inventory
			// $inventorySQL = sprintf("SELECT * FROM inventory WHERE sale_item = '%s'", $item["id"]);
			$inventorySQL = sprintf("SELECT sale_items.opening_stock + SUM(COALESCE(inventory.quantity_in,0) - COALESCE(inventory.quantity_out,0)) as stock FROM `sale_items` LEFT JOIN inventory ON sale_items.id = inventory.sale_item WHERE sale_items.id = '%s'", $item["id"]);
			$inventory = getDataFromTable($inventorySQL, $cdb);
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this item: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No item found.</p>";
	}
	
	
	$creditAccountsSQL = sprintf("SELECT * FROM %s WHERE type='2' ORDER BY name", $_SESSION["accountsTable"]);
	$creditAccounts = getDataFromTable($creditAccountsSQL, $cdb);

	$debitAccountsSQL = sprintf("SELECT * FROM %s WHERE type='4' ORDER BY name", $_SESSION["accountsTable"]);
	$debitAccounts = getDataFromTable($debitAccountsSQL, $cdb);
	
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
            <h2><?php echo $item["name"]; ?></h2>
            
			<?php
				// include("includes/template/subnavs/sale-items.php");
			?>            
            <?php
				include("includes/template/subnavs/sale-item.php");
			?>
            
            <h4>Release Information</h4>
			
                <?php include("includes/template/partials/release-info.php"); ?>	

			<hr class="spacer">

            <h4>Royalties</h4>
 			<div class="left-half">
				
                <?php include("includes/template/partials/royalties-table.php"); ?>
                                
            </div>
            <div class="right-half">
				<div class="callout">
					<p><strong>Import Royalty CSV</strong></p>
					<p>One entry per line in the format "artist, num" where num is the number of tracks on the release.  Entries with 0 will be ignored.</p>
					<p class="small-text">Example:<br>
						Devo Spice,1<br>
						Rob Balder,0<br>
						Worm Quartet,0<br>
						Steve Goodie,3
					</p>
					
					<form method="post" id="import-royalties-form" enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
						<input type="hidden" name="sale_item" value="<?php echo $item["id"] ?>">
						<?php include("includes/template/forms/import-royalty-distribution.php"); ?>
						<input type="submit" name="submit" value="Import Royalty Distribution">
					</form>
				</div>
				
				<!--<div class="callout">
					<p><strong>Royalties by Tracks</strong></p>
					<p>Add artists to this release to calculate royalties:</p>
					<p><strong>THIS FORM IS NOT YET WORKING</strong></p>
					
					<form method="post" id="calculate-royalties-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
						<input type="hidden" name="sale_item" value="<?php echo $item["id"] ?>">
						<?php include("includes/template/forms/calculate-royalties.php"); ?>
						<input type="submit" name="submit" value="Calculate Royalties">
					</form>
				</div>-->
				
            	<div class="callout">
					<p><strong>Manual Royalties</strong></p>
            		<p>Manually assign royalties for this item:</p>
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <input type="hidden" name="sale_item" value="<?php echo $item["id"] ?>">

                        <?php include("includes/template/forms/royalties.php"); ?>
                        
                        <?php 
							if (isset($routes[4])) {
                        		printf("<input type=\"hidden\" name=\"id\" value=\"%s\">", $editRoyalty["id"]);
                        		echo "<input type=\"submit\" name=\"submit\" value=\"Update Royalty\">";
							} else {
                        		echo "<input type=\"submit\" name=\"submit\" value=\"Assign Royalty\">";
							}
						?>
                        
                    </form>
                </div>
            </div>

            <?php
				include("includes/template/subnavs/sale-item.php");
			?>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");