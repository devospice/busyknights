<?php

	/* /sales/new-item */

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
	$description = $_SESSION["company"]["name"] . " - Add a New Item";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	
	$cdb = get_cdb();
	
	$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Add a New Sale Item</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Fill out the form below to add a new sale item. Set up royalties after the item is set up.</p>

						
            <form action="/sales" method="post" id="sale-item-form">
            
                <?php
					include("includes/template/forms/new-sale-item.php");
				?>
				                
                <input type="submit" name="submit" value="Add Sale Item">

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");