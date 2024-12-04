<?php

	/* /companies/add */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Companies";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	
	$company = null;

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/companies.php");
			?>
            <h2>Add Company</h2>
            
			<?php
				include("includes/template/subnavs/companies.php");
			?>            
            
            <h4>Fill out the form below to add a new company.</h4>
            <form action="/companies" method="post">
            
                <?php
					include("includes/template/forms/company.php");
				?>
                <input type="submit" class="default" name="submit" value="Add Company">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");