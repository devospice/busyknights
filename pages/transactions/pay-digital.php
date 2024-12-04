<?php

	/* /transactions/add */
	$pageTitle = $_SESSION["company"]["name"] . " - Transactions";
	$description = $_SESSION["company"]["name"] . " - Pay off digital liability accounts (Paypal and Venmo)";
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
            <h2>Pay Digital Accounts</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
			<div>
            	<p>Pay off everyone whose balance is greater than $10 and who is paid digitally.</p>
			</div>
						
            <form action="/transactions/add" method="post" id="transaction-form">
            
                <?php
					include("includes/template/forms/pay-digital.php");
				?>
				
				<div class="left-half">
                	<input type="submit" name="submit" value="Generate Transaction">
				</div>

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>