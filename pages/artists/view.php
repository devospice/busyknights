<?php

	/* /artists/view */

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
		$artistId = $routes[3];
		
		$artistSQL = sprintf("SELECT 
			artists.*, contacts.first_name, contacts.last_name, contacts.id as contact
			FROM artists
			LEFT JOIN contacts ON artists.contact = contacts.id
			WHERE artists.id = '%s'", $artistId);
		$artists = getDataFromTable($artistSQL, $cdb);
		if ($artists) {
			$artist = $artists[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this artist's information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No artist was found.</p>";
	}


	if (isset($_POST["submit"])) {
		
		// Create new account
		if ($_POST["submit"] == "Add Pre-Allocation") {
			include("includes/framework/code-snippets/add-pre-allocation.php");
		}
		
		// Create new account
		if ($_POST["submit"] == "Update Pre-Allocation") {
			include("includes/framework/code-snippets/update-pre-allocation.php");
		}
		
	}
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
			<?php
				// include("includes/template/searches/artists.php");
			?>
			<h2><?php printf("%s", $artist["name"]); ?></h2>

			<?php
				include("includes/template/subnavs/artists.php");
			?>            


			<div class="left-half">
				<h4>Web Site</h4>
				<p>
				<?php 
					if ($artist["web_site"] != "") {
						printf("URL: <a href=\"%s\" target=\"_blank\">%s</a><br>", $artist["web_site"], $artist["web_site"]); 
					}

				?>
				</p>

				<h4>Notes</h4>
				<p>
				<?php 
					if ($artist["notes"] != "") {
						echo $artist["notes"]; 
					}

				?>
				</p>
				<p>Contact: <?php printf("<a href=\"/contacts/view/%s\">%s %s</a>", $artist["contact"], $artist["first_name"], $artist["last_name"]);  ?></p>
			</div>
			
			<div class="right-half">
				<h4>Pre-Allocations</h4>
				
				<table cellpadding="0" cellspacing="0" class="allocations-table">
					<thead>
						<th>Account</th>
						<th>Percent</th>
						<th></th>
						<th></th>
					</thead>
					
				<?php
					$paSQL = sprintf("SELECT 
									pre_allocations.*, %s.name, %s.id as accountId
									FROM pre_allocations 
									LEFT JOIN %s ON %s.id = pre_allocations.account
									WHERE artist = '%s'", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"], $artist["id"]);
					$preAllocations = getDataFromTable($paSQL, $cdb);
				
					foreach ($preAllocations as $allocation) {
						printf("<tr>
									<td><a href=\"/accounts/view/%s\"><strong>%s</strong></a></td>
									<td>%s</td>
									<td class=\"edit\"><a href=# onclick=\"editPreallocation('%s', '%s', '%s');\">&nbsp;</a></td>
									<td class=\"delete\"><a href=\"javascript:deletePreallocation('%s');\" onClick=\"return confirm('WARNING: Are you sure you want to delete this pre-allocation?');\">/</a></td>
								</tr>", $allocation["accountId"], $allocation["name"], $allocation["percent"], $allocation["id"], $allocation["percent"], $allocation["account"], $allocation["id"]);
					}
				
				?>
					
				</table>
				
				<div class="section-nav">
					<a href="#" class="button" onClick="openNewAllocationOverlay();">New Pre-Allocation</a>
				</div>
				
			</div>


			<div class="section-nav">
				<a href="/artists/edit/<?php echo $artist["id"] ?>" class="button">Edit this Artist</a>
				
			</div>
				
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");