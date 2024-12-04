<?php

	/* /contacts/view */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Contacts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$contactId = $routes[3];
		
		$contactSQL = sprintf("SELECT * FROM contacts WHERE ID = '%s'", $contactId);
		$contacts = getDataFromTable($contactSQL, $cdb);
		if ($contacts) {
			$contact = $contacts[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving your contact: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No contact was found.</p>";
	}
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/contact.php");
			?>
            <h2>Contact Information</h2>
            
			<?php
				include("includes/template/subnavs/contacts.php");
			?>            
            
            <h4>Fill out the form below to edit this contact.</h4>
            <form action="/contacts" method="post">
            
            	<input type="hidden" name="id" value="<?php echo $contact["id"]; ?>">
				<?php
					include("includes/template/forms/contact.php");
				?>                
                <input type="submit" class="default" name="submit" value="Update Contact">
                <div class="vertical-divider"></div>
                <input type="submit" name="submit" class="red" value="Delete Contact" onClick="return confirm('Are you sure you want to delete this contact?');">


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");