<?php

	/* /accounts */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Accounts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	if (isset($_POST["submit"])) {
		
		// Create new account
		if ($_POST["submit"] == "Add Category") {
			
			$formValues = getValuesFromForm($_POST, false);
			$insertSQL = sprintf("INSERT INTO account_category (%s) VALUES (%s)", $formValues[0], $formValues[1]);
			$result = runSQL($insertSQL, $cdb);

			if ($result == true) {
				$msg = "Category successfully created.";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error creating your account category: %s</p>", $cdb->error);
			}
			
		}
		
		// Update existing account
		if ($_POST["submit"] == "Update Category") {
			
			$formValues = getValuesFromForm($_POST, true);
			$updateString = createUpdateSQL($formValues);
			
			// Update main form values
			$updateSQL = sprintf("UPDATE account_category %s WHERE id = %s", $updateString, $_POST["id"]);
			// echo $updateSQL;
			$result = runSQL($updateSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Category successfully updated.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error updating this category: %s</p>", $cdb->error);
			}
			
		}

		// Delete account
		if ($_POST["submit"] == "Delete Category") {
			include("includes/framework/code-snippets/delete-category.php");
		}
		

	}
	
	$categorySQL = "SELECT account_category.*, account_type.type FROM account_category LEFT JOIN account_type ON account_category.applies_to = account_type.id ORDER BY name";
	$categories = getDataFromTable($categorySQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Account Categories</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/account-categories.php");
			?>            
            
			<h3>Account Categories <a href="/accounts/add-category" class="button small right">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="thirty">Name</th>
                	<th class="fourty-six">Notes</th>
                	<th class="eight">Applies to</th>
                	<th class="eight edit">Edit</th>
                	<th class="eight edit">Delete</th>
                </thead>
                <?php
					if (count($categories) > 0) {
						
						$alt = false;
						foreach ($categories as $category) {
							
							if ($category["id"] != 0) {
							
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\"><strong>%s</strong></td>", $category["name"]);
								printf("<td>%s</td>", $category["notes"]);
								printf("<td class=\"%s\">%s</td>", $category["type"], $category["type"]);
								printf("<td class=\"edit\"><a href=\"/accounts/edit-category/%s\">&nbsp;</a></td>", $category["id"]);
								printf("<td class=\"delete\"><a href=\"javascript:deleteCategory('%s');\" onClick=\"return confirm('Are you sure you want to permanently delete this category?');\">/</a></td>", $category["id"]);
								echo "</tr>";
								
							}
						}
					} 
				?>
            </table>     
			
			<p><a href="/accounts/add-category" class="button">Add Category</a></p>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>