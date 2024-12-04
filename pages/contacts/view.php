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
            <h2><?php printf("%s %s", $contact["first_name"], $contact["last_name"]); ?></h2>
            
			<?php
				include("includes/template/subnavs/contacts.php");
			?>            
            
            <h4>Name and Address</h4>
            <?php
				$address2 = "";
				if ($contact["address2"] != "") {
					$address2 = "<br>" . $contact["address2"];
				}
				echo "<p>";
					printf("%s %s<br>", $contact["first_name"], $contact["last_name"]);
					
					if ($contact["address"] != "") {
						printf("%s%s<br>", $contact["address"], $address2);
					}
					
					if ($contact["city"] != "") {
						printf("%s, ", $contact["city"]);
					}
					printf("%s %s<br>", $contact["state"], $contact["zip"]);
					
					if ($contact["country"] != "") {
						echo $contact["country"];
					}
				echo "</p>";
				
			?>
            
            <h4>Email</h4>
            <p>
            <?php 
				if ($contact["email"] != "") {
					printf("<a href=\"mailto:%s\">%s</a><br>", $contact["email"], $contact["email"]); 
				}
				if ($contact["email2"] != "") {
					printf("<a href=\"mailto:%s\">%s</a><br>", $contact["email2"], $contact["email2"]); 
				}
				if ($contact["email3"] != "") {
					printf("<a href=\"mailto:%s\">%s</a><br>", $contact["email3"], $contact["email3"]); 
				}
				if ($contact["email4"] != "") {
					printf("<a href=\"mailto:%s\">%s</a><br>", $contact["email4"], $contact["email4"]); 
				}
			
			?>
            </p>

            <h4>Phone</h4>
            <p>
            <?php 
				if ($contact["phone_cell"] != "") {
					printf("Cell: %s<br>", $contact["phone_cell"]); 
				}
				if ($contact["phone_office"] != "") {
					printf("Office: %s<br>", $contact["phone_office"]); 
				}
				if ($contact["phone_home"] != "") {
					printf("Home: %s<br>", $contact["phone_home"]); 
				}
				if ($contact["phone_alt"] != "") {
					printf("Alt: %s<br>", $contact["phone_alt"]); 
				}
			
			?>
            </p>

			<div class="section-nav">
				<a href="/contacts/edit/<?php echo $contact["id"] ?>" class="button">Edit this Contact</a>
            </div>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");