<?php

	/* /artists */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Artists";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "artists";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	if (isset($_POST["submit"])) {
		
		// Insert new artist
		if ($_POST["submit"] == "Add Artist") {
			
			$formValues = getValuesFromForm($_POST, false);
			$insertSQL = sprintf("INSERT INTO artists (%s) VALUES (%s)", $formValues[0], $formValues[1]);
			$result = runSQL($insertSQL, $cdb);
					
			if ($result == true) {
				$msg = "Artist successfully created.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your artist: %s</p>", $cdb->error);
			}
			
		}
		
		
		// Delete artist
		if ($_POST["submit"] == "Delete Artist") {
			include("includes/framework/code-snippets/delete-artist.php");
		}
		
		
		// Import artists
		if ($_POST["submit"] == "Import Artists") {
			
			// Update main form values
			$uploadedFilePath = $_FILES["csv_file"]["tmp_name"];
			
			// Set up output variables
			$counter = 0;
			$errorCount = 0;
			$errorMsg = "";
			
			// Read the uploaded data
			$handle = fopen($uploadedFilePath, "r");
			
			while (($artist = fgetcsv($handle, 1000, ",")) !== FALSE) {					
				
			// Store values from this row
				$artistName = $artist[0];
				$artistEmail = $artist[1];
				$contactFirstName = $artist[2];
				$contactLastName = $artist[3];
				$contactAddress1 = $artist[4];
				$contactAddress2 = $artist[5];
				$contactCity = $artist[6];
				$contactState = $artist[7];
				$contactZip = $artist[8];
				$contactPhone = $artist[9];
				$contactEmail = $artist[10];
				$payByPaypal = $artist[11];
				$paypalEmail = $artist[12];
				$paypalDemomination = $artist[13];
				$checkPayTo = $artist[14];
				$checkAddress1 = $artist[15];
				$checkAddress2 = $artist[16];
				$checkCity = $artist[17];
				$checkState = $artist[18];
				$checkZip = $artist[19];
				$checkCountry = $artist[20];
				
			// See if contact already exists in database
				$contactSQL = sprintf("SELECT * FROM contacts WHERE first_name = '%s' AND last_name = '%s' LIMIT 1", $contactFirstName, $contactLastName);
				// echo $contactSQL . "<br>";
				$contacts = getDataFromTable($contactSQL, $cdb);
				// var_dump($contact);
				
				if (count($contacts) > 0) {
					// Existing contact found
					$contact = $contacts[0];
					//$msg .= "Contact found for " . $contact["email"] . "<br>";
				} else {
					// No contact found, create one
					$newContactSQL = sprintf("INSERT INTO contacts (first_name, last_name, address, address2, city, state, zip, country, email) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $contactFirstName, $contactLastName, $contactAddress1, $contactAddress2, $contactCity, $contactState, $contactZip, $checkCountry, $contactEmail);
					$result = runSQL($newContactSQL, $cdb);
					
					if ($result == true) {
						$lastId = $cdb->insert_id;
						$contactSQL = sprintf("SELECT * FROM contacts WHERE id = '%s'", $lastId);
						$contacts = getDataFromTable($contactSQL, $cdb);
						if (count($contacts) > 0) {
							// new contact found
							$contact = $contacts[0];
							//$msg .= "Contact created for " . $contact["email"] . "<br>";
						} else {
							$errorCount++;
							$errorMsg .= "Error inserting new contact into database: " . $cdb->error . "<br>";
						}
					} else {
						$errorCount++;
						$errorMsg .= $cdb->error . "<br>";
					}
				}
				
			// See if artist already exists
				$artistSQL = sprintf("SELECT * FROM artists WHERE name = '%s' LIMIT 1", $artistName);
				$artists = getDataFromTable($artistSQL, $cdb);
				
				if (count($artists) > 0) {
					// Existing artist found
					$artist = $artists[0];
					//$msg .= "Artist found for " . $artistName . "<br>";
					
					// Make sure contact matches
					if ($artist["contact"] != $contact["id"]) {
						$contactFixSQL = sprintf("UPDATE artists SET contact = '%s' WHERE id = '%s'", $contact["id"], $artist["id"]);
						$result = runSQL($contactFixSQL, $cdb);
						if ($result == true) {
							//$msg .= "Contact updated for " . $artistName . "<br>";
						} else {
							$errorCount++;
							$errorMsg .= "Unable to update contact for artist: " . $cdb->error . "<br>";
						}
					}
				} else {
					// No artist found, create one
					$newArtistSQL = sprintf("INSERT INTO artists (name, web_site, contact) VALUES ('%s', '%s', '%s')", $artistName, $artistEmail, $contact["id"]);
					$result = runSQL($newArtistSQL, $cdb);
					
					if ($result == true) {
						$lastId = $cdb->insert_id;
						$artistSQL = sprintf("SELECT * FROM artists WHERE id = '%s'", $lastId);
						$artists = getDataFromTable($artistSQL, $cdb);
						if (count($artists) > 0) {
							// new artist found
							$artist = $artists[0];
							//$msg .= "Artist created for " . $artistName . "<br>";
						} else {
							$errorCount++;
							$errorMsg .= "Error inserting new artist into database: " . $cdb->error . "<br>";
						}
					} else {
						$errorCount++;
						$errorMsg .= $cdb->error . "<br>";
					}
				}
				
			// See if an account already exists
				$accountSQL = sprintf("SELECT * FROM %s WHERE name = '%s' LIMIT 1", $_SESSION["accountsTable"], $artistName);
				$accounts = getDataFromTable($accountSQL, $cdb);
				
				if (count($accounts) > 0) {
					// Existing account found
					$account = $accounts[0];
					//$msg .= "Existing account found for " . $artistName . "<br>";
				} else {
					// No account found, create one
					$newAccountSQL = sprintf("INSERT INTO %s (name, contact, type) VALUES ('%s', '%s', '%s')", $_SESSION["accountsTable"], $artistName, $contact["id"], "2"); // 2 is a liability account
					
					$result = runSQL($newAccountSQL, $cdb);
					// echo $newAccountSQL . "<br>";
					
					if ($result == true) {
						$lastId = $cdb->insert_id;
						$accountSQL = sprintf("SELECT * FROM %s WHERE id = '%s'", $_SESSION["accountsTable"], $lastId);
						$accounts = getDataFromTable($accountSQL, $cdb);
						if (count($accounts) > 0) {
							// new account found
							$account = $accounts[0];
							//$msg .= "Account created for " . $artistName . "<br>";
						} else {
							$errorCount++;
							//$msg .= "Error finding newly created account for " . $artistName . "<br>";
							$errorMsg .= "Error inserting new account into database: " . $cdb->error . "<br>";
						}
					} else {
						//$msg .= "Error creating account for " . $artistName . "<br>";
						$errorCount++;
						$errorMsg .= $cdb->error . "<br>";
					}
					
				}
				
			// See if account has payment information
				$paymentSQL = sprintf("SELECT * FROM payment_info WHERE account = '%s'", $account["id"]);
				$payments = getDataFromTable($paymentSQL, $cdb);
				
				if (count($payments) > 0) {
					// Existing payment info found
					$paymentInfo = $payments[0];
					//$msg .= "Existing payment info found for " . $artistName . "<br>";
				} else {
					// No payment info found, create one
					if ($payByPaypal == "1") {
						$payMethod = "1";
						$paypalSQL = sprintf("INSERT INTO payment_info_paypal (email) VALUES ('%s')", $paypalEmail);
						$result = runSQL($paypalSQL, $cdb);
						if ($result == true) {
							$payId = $cdb->insert_id;
						} else {
							//$msg .= "Error creating paypal payment info for " . $artistName . "<br>";
							$errorCount++;
							$errorMsg .= $cdb->error . "<br>";
						}
					} else {
						$payMethod = "2";
						$payTo = $contactFirstName . " " . $contactLastName;
						$checkSQL = sprintf("INSERT INTO payment_info_check (pay_to, mail_to, address, address2, city, state, zip, country, phone) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $checkPayTo, $payTo, $checkAddress1, $checkAddress2, $checkCity, $checkState, $checkZip, $checkCountry, $contactPhone);
						$result = runSQL($checkSQL, $cdb);
						if ($result == true) {
							$payId = $cdb->insert_id;
						} else {
							// $msg .= "Error creating check payment info for " . $artistName . "<br>";
							$errorCount++;
							$errorMsg .= $cdb->error . "<br>";
						}
					}
					
					$paySQL = sprintf("INSERT INTO payment_info (account, method, info) VALUES ('%s', '%s', '%s')", $account["id"], $payMethod, $payId);
					$result = runSQL($paySQL, $cdb);
					if ($result == true) {
						// $msg .= "Payment info set up for " . $artistName . "<br>";
					} else {
						// $msg .= "Error creating payment info for " . $artistName . "<br>";
						$errorCount++;
						$errorMsg .= $cdb->error . "<br>";
					}
					
				}
				
			// See if artist has preallocations already set up
				$preAllocSQL = sprintf("SELECT * FROM pre_allocations WHERE artist = '%s'", $artist["id"]);
				$preAllocs = getDataFromTable($preAllocSQL, $cdb);
				
				if (count($preAllocs) > 0) {
					// Existing pre-allocation info found
					$preAlloc = $preAllocs[0];
					// $msg .= "Existing pre-allocation found for " . $artistName . "<br>";
				} else {
					// No existing pre-allocation found, set one up
					$newPreAllocSQL = sprintf("INSERT INTO pre_allocations (account, percent, artist) VALUES ('%s', '%s', '%s')", $account["id"], "85", $artist["id"]);
					$result = runSQL($newPreAllocSQL, $cdb);
					if ($result == true) {
						// $msg .= "Pre-allocation set up for " . $artistName . "<br>";
					} else {
						// $msg .= "Error creating pre-allocation for " . $artistName . "<br>";
						$errorCount++;
						$errorMsg .= $cdb->error . "<br>";
					}
				}
				

				$counter++;	
				
			}
			
			fclose($handle);
			
			$msg = sprintf("%s artists successfully imported.  %s errors.  %s", $counter, $errorCount, $errorMsg);
		}

		// Update existing artist
		if ($_POST["submit"] == "Update Artist") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE artists %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Artist successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating your artist: %s</p>", $cdb->error);
			}
			

		}


	}
	
	// $artistsSQL = "SELECT * FROM artists ORDER BY name";
	$artistsSQL = 	"SELECT 
					artists.*, contacts.first_name, contacts.last_name, contacts.email
					FROM artists
					LEFT JOIN contacts ON artists.contact = contacts.id
					ORDER BY artists.name";
	$artists = getDataFromTable($artistsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/artists.php");
			?>
            <h2>Artists</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/artists.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="forty">Name</th>
                	<th class="fifteen">Contact</th>
                	<th class="fifteen">Website</th>
                	<th class="eight info">More</th>
                	<th class="eight info">Edit</th>
                	<th class="eight info">Delete</th>
                </thead>
                <?php
				
					if (count($artists) > 0) {
						$alt = false;
						foreach ($artists as $artist) {
							$class = "";
							if ($alt) {
								$class = "alt";
							}
							$alt = !$alt;
							
							if ($artist["web_site"] == "") {
								$webLink = "";
							} else {
								$webLink = sprintf("<a href=\"%s\" target=\"_blank\">%s</a>", $artist["web_site"], $artist["web_site"]);
							}
							
							if (($artist["first_name"]) == "" && ($artist["last_name"] == "")) {
								if ($artist["email"] == "") {
									$contactString = "";
								} else {
									$contactString = sprintf("<a href=\"mailto:%s\">%s</a>", $artist["email"], $artist["email"]);
								}
								
							} else {
								if ($artist["email"] == "") {
									$contactString = sprintf("%s %s", $artist["first_name"], $artist["last_name"]);;
								} else {
									$contactString = sprintf("<a href=\"mailto:%s\">%s %s</a>", $artist["email"], $artist["first_name"], $artist["last_name"]);
								}
							}
							
							printf("<tr class=\"%s\">", $class);
							printf("<td class=\"name\"><a href=\"/artists/view/%s\">%s</a></td>", $artist["id"], $artist["name"]);
							printf("<td class=\"contact\">%s</td>", $contactString);
							printf("<td class=\"web\">%s</td>", $webLink);
							printf("<td class=\"info\"><a href=\"artists/view/%s\">i</a></td>", $artist["id"]);
							printf("<td class=\"edit\"><a href=\"artists/edit/%s\">&nbsp;</a></td>", $artist["id"]);
							printf("<td class=\"delete\"><a href=\"javascript:deleteArtist('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this artist?');\">/</a></td>", $artist["id"]);
							echo "</tr>"; 
						}
					} else {
						echo "<tr>"; 
                		echo "<td colspan=\"4\"><p>You have no artists in your address book.  <a href=\"/artists/add\">Add an artist now.</a></p></td>";
						echo "</tr>"; 
					}
				?>
            </table>
                        
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>