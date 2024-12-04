<?php

	/* /companies/add */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Artists";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "artists";
	
	$artist = null;

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
            <h2>Add Artist</h2>
            
			<?php
				include("includes/template/subnavs/artists.php");
			?>            
            
            <h4>Fill out the form below to add a new artist.</h4>
            <form action="/artists" method="post">
            
                <?php
					include("includes/template/forms/artist.php");
				?>
                <input type="submit" class="default" name="submit" value="Add Artist">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");