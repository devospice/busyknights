<?php

	/* /contacts/add */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Contacts";
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
            <h2>Add Contact</h2>
            
			<?php
				include("includes/template/subnavs/contacts.php");
			?>            
            
            <h4>Fill out the form below to add a new contact.</h4>
            <form action="/contacts" method="post">
            
                <?php
					include("includes/template/forms/contact.php");
				?>
                <input type="submit" class="default" name="submit" value="Add Contact">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");