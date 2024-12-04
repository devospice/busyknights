<?php

	/* /accounts/edit */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Edit an account category";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$categorySQL = sprintf("SELECT * FROM account_category WHERE ID = '%s'", $id);
		$categories = getDataFromTable($categorySQL, $cdb);
		if ($categories) {
			$category = $categories[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this category information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No category was found.</p>";
	}
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/companies.php");
			?>
            <h2>Edit Category</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Fill out the form below to edit this category.</p>
            <form action="/accounts/edit-categories" method="post">
            
            	<input type="hidden" name="id" value="<?php echo $category["id"]; ?>">
				<?php
					include("includes/template/forms/account-category.php");
				?>                
                <input type="submit" name="submit" value="Update Category">
                <div class="vertical-divider"></div>
                <input type="submit" name="submit" class="delete" value="Delete Category" onClick="return confirm('Are you sure you want to permanently delete this account category?');">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");