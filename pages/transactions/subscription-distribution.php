<?php

	/* /transactions/add */
	$pageTitle = $_SESSION["company"]["name"] . " - Transactions";
	$description = $_SESSION["company"]["name"] . " - Distribute Subscription Revenue";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "transactions";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	
	/*$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);*/
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Distribute Subscription Revenue</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
			<div>
            	<p>Fill out the form below to distribute subscription revenue.</p>
			</div>
						
            <form action="/transactions" method="post" id="transaction-form">
            
                <?php
					include("includes/template/forms/subscription-distribution.php");
				?>
				
				<div class="left-half">
                	<input type="submit" name="submit" value="Distribute Subscription Revenue">
				</div>

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>