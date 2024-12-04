<?php

	/* /companies/view */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Artists";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "artists";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$artistSQL = sprintf("SELECT * FROM artists WHERE ID = '%s'", $id);
		$artists = getDataFromTable($artistSQL, $cdb);
		if ($artists) {
			$artist = $artists[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this artist's information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No artist was found.</p>";
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
            <h2>Artist Information</h2>
            
			<?php
				include("includes/template/subnavs/artists.php");
			?>            
            
            <h4>Fill out the form below to edit this artist.</h4>
            <form action="/artists" method="post">
            
            	<input type="hidden" name="id" value="<?php echo $artist["id"]; ?>">
				<?php
					include("includes/template/forms/artist.php");
				?>                
                <input type="submit" class="default" name="submit" value="Update Artist">
                <input type="submit" class="red" name="submit" value="Delete Artist" onClick="return confirm('Are you sure you want to delete this artist?');">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");