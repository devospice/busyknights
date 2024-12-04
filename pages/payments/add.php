<?php

	/* /payments/add */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Payment Information";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/contact.php");
			?>
            <h2>Add Payment Information</h2>
            
			<?php
				include("includes/template/subnavs/accounts.php");
			?>            
            
            <p>Fill out the form below to add payment information.</p>
            <form action="/accounts" method="post">
            
                <?php
					include("includes/template/forms/payment-info.php");
				?>
                <input type="submit" name="submit" value="Add Payment Info">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");