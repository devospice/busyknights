<?php

	/* /companies */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Companies";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "companies";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	if (isset($_POST["submit"])) {
		
		// Insert new company
		if ($_POST["submit"] == "Add Company") {
			
			$formValues = getValuesFromForm($_POST, false);
			$insertSQL = sprintf("INSERT INTO companies (%s) VALUES (%s)", $formValues[0], $formValues[1]);
			$result = runSQL($insertSQL, $cdb);
					
			if ($result == true) {
				$msg = "Company successfully created.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your company: %s</p>", $cdb->error);
			}
			
		}
		
		// Update existing company
		if ($_POST["submit"] == "Update Company") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE companies %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Company successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating your company: %s</p>", $cdb->error);
			}
			
		}

		// Delete company
		if ($_POST["submit"] == "Delete Company") {
			
			include("includes/framework/code-snippets/delete-company.php");
			
		}

		// Import companies
		if ($_POST["submit"] == "Import Companies") {
			
			// Update main form values
			$uploadedFilePath = $_FILES["csv_file"]["tmp_name"];
			
			// Set up output variables
			$counter = 0;
			$errorCount = 0;
			$errorMsg = "";
			
			// Read the uploaded data
			$handle = fopen($uploadedFilePath, "r");
			
			while (($company = fgetcsv($handle, 1000, ",")) !== FALSE) {					
					
				$insertSQL = sprintf("INSERT INTO companies (name, address, address2, city, state, zip, country, web_site, email, email2, phone_office, phone_alt, fax_office, notes) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", $company[0], $company[1], $company[2], $company[3], $company[4], $company[5], $company[6], $company[7], $company[8], $company[9], $company[10], $company[11], $company[12], $company[13]);
				$result = runSQL($insertSQL, $cdb);
						
				if ($result == true) {
					$counter++;
				} else {
					$errorCount++;
					$errorMsg .= $cdb->error . "<br>";
				}
	
				
			}
			
			fclose($handle);
			
			$msg = sprintf("%s companies successfully imported.  %s errors.  %s", $counter, $errorCount, $errorMsg);


		}


	}
	
	$companySQL = "SELECT * FROM companies ORDER BY name";
	$companies = getDataFromTable($companySQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/companies.php");
			?>
            <h2>Companies</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/companies.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="forty">Name</th>
                	<th class="fifteen">Email Address</th>
                	<th class="fifteen">Phone (Office)</th>
                	<th class="eight info">More</th>
                	<th class="eight info">Edit</th>
                	<th class="eight info">Delete</th>
                </thead>
                <?php
				
					if (count($companies) > 0) {
						$alt = false;
						foreach ($companies as $company) {
							$class = "";
							if ($alt) {
								$class = "alt";
							}
							$alt = !$alt;
							
							if ($company["web_site"] == "") {
								$webLink = "";
							} else {
								$webLink = sprintf("<a href=\"%s\" target=\"_blank\"><img src=\"/assets/images/button-icons/web-link-icon.png\" class=\"web-link-icon\"></a>", $company["web_site"]);
							}
							
							printf("<tr class=\"%s\">", $class);
							printf("<td class=\"name\"><a href=\"/companies/view/%s\">%s</a> %s</td>", $company["id"], $company["name"], $webLink);
							printf("<td class=\"email\"><a href=\"mailto:%s\">%s</a></td>", $company["email"], $company["email"]);
							printf("<td class=\"phone\">%s</td>", $company["phone_office"]);
							printf("<td class=\"info\"><a href=\"companies/view/%s\">i</a></td>", $company["id"]);
							printf("<td class=\"edit\"><a href=\"companies/edit/%s\">&nbsp;</a></td>", $company["id"]);
							printf("<td class=\"delete\"><a href=\"javascript:deleteCompany('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this company?');\">/</a></td>", $company["id"]);
							echo "</tr>"; 
						}
					} else {
						echo "<tr>"; 
                		echo "<td colspan=\"4\"><p>You have no companies in your address book.  <a href=\"/companies/add\">Add a company now.</a></p></td>";
						echo "</tr>"; 
					}
				?>
            </table>
                        
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>