<?php

	/* /companies/view */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Companies";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "companies";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$companySQL = sprintf("SELECT * FROM companies WHERE ID = '%s'", $id);
		$companies = getDataFromTable($companySQL, $cdb);
		if ($companies) {
			$company = $companies[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this company information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No company was found.</p>";
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
            <h2>Company Information</h2>
            
			<?php
				include("includes/template/subnavs/companies.php");
			?>            
            
            <h4>Fill out the form below to edit this company.</h4>
            <form action="/companies" method="post">
            
            	<input type="hidden" name="id" value="<?php echo $company["id"]; ?>">
				<?php
					include("includes/template/forms/company.php");
				?>                
                <input type="submit" class="default" name="submit" value="Update Company">
                <input type="submit" class="red" name="submit" value="Delete Company" onClick="return confirm('Are you sure you want to delete this company?');">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");