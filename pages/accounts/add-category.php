<?php

	/* /accounts/add */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Add an account";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/account.php");
			?>
            <h2>Add a Category</h2>
            
			<?php
				include("includes/template/subnavs/accounts.php");
			?>            
            
            <p>Fill out the form below to add a new account category.</p>
            <form action="/accounts/edit-categories" method="post">
            
                <?php
					include("includes/template/forms/account-category.php");
				?>
                <input type="submit" name="submit" value="Add Category">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");