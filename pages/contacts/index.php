<?php

	/* /contacts */
	$pageTitle = $_SESSION["company"]["name"] . " - Contacts";
	$description = $_SESSION["company"]["name"] . " - Contacts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	// Insert new Contact
	if (isset($_POST["submit"])) {
		if ($_POST["submit"] == "Add Contact") {
			
			$formValues = getValuesFromForm($_POST, false);
			$insertSQL = sprintf("INSERT INTO contacts (%s) VALUES (%s)", $formValues[0], $formValues[1]);
			$result = runSQL($insertSQL, $cdb);
					
			if ($result == true) {
				$msg = "Contact successfully created.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your contact: %s</p>", $cdb->error);
			}
			
		}
		
		// Update existing album
		if ($_POST["submit"] == "Update Contact") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE contacts %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Contact successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating your contact: %s</p>", $cdb->error);
			}
			
		}

		// Delete Contact
		if ($_POST["submit"] == "Delete Contact") {
			
			include("includes/framework/code-snippets/delete-contact.php");
			
		}


		// Import contacts
		if ($_POST["submit"] == "Import Contacts") {
			
			// Update main form values
			$uploadedFilePath = $_FILES["csv_file"]["tmp_name"];
			
			// Set up output variables
			$counter = 0;
			$errorCount = 0;
			$errorMsg = "";
			
			// Read the uploaded data
			$handle = fopen($uploadedFilePath, "r");
			
			while (($contact = fgetcsv($handle, 1000, ",")) !== FALSE) {					
					
				$insertSQL = sprintf("INSERT INTO contacts (first_name, last_name, address, address2, city, state, zip, country, email, email2, email3, email4, phone_home, phone_office, phone_cell, phone_alt, fax_home, fax_office, company) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $contact[0], $contact[1], $contact[2], $contact[3], $contact[4], $contact[5], $contact[6], $contact[7], $contact[8], $contact[9], $contact[10], $contact[11], $contact[12], $contact[13], $contact[14], $contact[15], $contact[16], $contact[17], $contact[18]);
				$result = runSQL($insertSQL, $cdb);
						
				if ($result == true) {
					$counter++;
				} else {
					$errorCount++;
					$errorMsg .= $cdb->error . "<br>";
				}
	
				
			}
			
			fclose($handle);
			
			$msg = sprintf("%s contacts successfully imported.  %s errors.  %s", $counter, $errorCount, $errorMsg);


		}



	}
	
	$contactsSQL = "SELECT * FROM contacts ORDER BY last_name";
	$contacts = getDataFromTable($contactsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/contact.php");
			?>
            <h2>Contacts</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/contacts.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="twenty">Last Name</th>
                	<th class="twenty">First Name</th>
                	<!--<th class="mobile-hide">Company</th>-->
                	<th class="twenty mobile-hide">Email Address</th>
                	<th class="fifteen mobile-hide">Phone (Cell)</th>
                	<th class="eight info">More</th>
                	<th class="eight edit">Edit</th>
                	<th class="eight edit">Delete</th>
                </thead>
                <?php
					if (count($contacts) > 0) {

						$alt = false;
						foreach ($contacts as $contact) {
							$class = "";
							if ($alt) {
								$class = "alt";
							}
							$alt = !$alt;
							
							printf("<tr class=\"%s\">", $class);
							printf("<td class=\"lastname\">%s</td>", $contact["last_name"]);
							printf("<td class=\"firstname\">%s</td>", $contact["first_name"]);
							// printf("<td class=\"company mobile-hide\">%s</td>", $contact["company"]);
							printf("<td class=\"email mobile-hide\"><a href=\"mailto:%s\">%s</a></td>", $contact["email"], $contact["email"]);
							printf("<td class=\"phone mobile-hide\">%s</td>", $contact["phone_cell"]);
							printf("<td class=\"info\"><a href=\"contacts/view/%s\">i</a></td>", $contact["id"]);
							printf("<td class=\"edit\"><a href=\"contacts/edit/%s\">&nbsp;</a></td>", $contact["id"]);
							printf("<td class=\"delete\"><a href=\"javascript:deleteContact('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this contact?');\">/</a></td>", $contact["id"]);
							echo "</tr>";
							
						}
						
					} else {
						echo "<tr>"; 
                		echo "<td colspan=\"6\"><p>You have no contacts in your address book.  <a href=\"/contacts/add\">Add a contact now.</a></p></td>";
						echo "</tr>"; 
					}
				?>
            </table>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>