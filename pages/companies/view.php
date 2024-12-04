<?php

	/* /companies/view */

	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Companies";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$contactId = $routes[3];
		
		$contactSQL = sprintf("SELECT * FROM companies WHERE ID = '%s'", $contactId);
		$contacts = getDataFromTable($contactSQL, $cdb);
		if ($contacts) {
			$contact = $contacts[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this company information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No company was found.</p>";
	}
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				include("includes/template/searches/companies.php");
			?>
            <h2><?php printf("%s", $contact["name"]); ?></h2>
            
			<?php
				include("includes/template/subnavs/companies.php");
			?>            
            
            <h4>Address</h4>
            <?php
				$address2 = "";
				if ($contact["address2"] != "") {
					$address2 = "<br>" . $contact["address2"];
				}
				echo "<p>";
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
			
			?>
            </p>

            <h4>Phone</h4>
            <p>
            <?php 
				if ($contact["phone_office"] != "") {
					printf("Office: %s<br>", $contact["phone_office"]); 
				}
				if ($contact["phone_alt"] != "") {
					printf("Alt: %s<br>", $contact["phone_alt"]); 
				}
			
			?>
            </p>

            <h4>Web Site</h4>
            <p>
            <?php 
				if ($contact["web_site"] != "") {
					printf("URL: <a href=\"%s\" target=\"_blank\">%s</a><br>", $contact["web_site"], $contact["web_site"]); 
				}
			
			?>
            </p>

            <h4>Notes</h4>
            <p>
            <?php 
				if ($contact["notes"] != "") {
					echo $contact["notes"]; 
				}
			
			?>
            </p>
			<p>Company ID: <?php echo $contact["id"]; ?></p>


			<div class="section-nav">
				<a href="/companies/edit/<?php echo $contact["id"] ?>" class="button">Edit this Company</a>
            </div>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");