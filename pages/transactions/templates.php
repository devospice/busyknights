<?php

	/* /transactions */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Transactions";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "transactions";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	if (isset($_POST["submit"])) {
				
		if ($_POST["submit"] == "Update Template") {
			
			// First delete the existing entries and templates
			include("includes/framework/code-snippets/delete-transaction-template.php");
			// id stored as $templateId
			
			// Now set up a new template
			include("includes/framework/code-snippets/add-transaction-template.php");
			
		}
		
		/*// Insert new artist
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
			

		}*/


	}
	
	$templatesSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templatesSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/artists.php");
			?>
            <h2>Transaction Templates</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/transactions.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="eighty">Name</th>
                	<th class="ten info">Edit</th>
                	<th class="ten info">Delete</th>
                </thead>
                <?php
				
					if (count($templates) > 0) {
						$alt = false;
						foreach ($templates as $template) {
							$class = "";
							if ($alt) {
								$class = "alt";
							}
							$alt = !$alt;

							printf("<tr class=\"%s\">", $class);
							printf("<td class=\"name\">%s</td>", $template["name"]);
							printf("<td class=\"edit\"><a href=\"/transactions/edit-template/%s\">&nbsp;</a></td>", $template["id"]);
							printf("<td class=\"delete\"><a href=\"javascript:deleteTemplate('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this transaction tempalte?');\">/</a></td>", $template["id"]);
							echo "</tr>"; 
						}
					} else {
						echo "<tr>"; 
                		echo "<td colspan=\"4\"><p>You have no templates set up.  <a href=\"/transactions\">Create one on the Transactions page.</a></p></td>";
						echo "</tr>"; 
					}
				?>
            </table>
                        
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>