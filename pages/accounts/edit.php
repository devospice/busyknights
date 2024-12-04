<?php

	/* /accounts/edit */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Edit an account";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	// Custom code for this page
	$cdb = get_cdb();
	
	$msg = "";
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$accountsSQL = sprintf("SELECT * FROM %s WHERE ID = '%s'", $_SESSION["accountsTable"], $id);
		$accounts = getDataFromTable($accountsSQL, $cdb);
		if ($accounts) {
			$account = $accounts[0];
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this account information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No account was found.</p>";
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
            <h2>Account Information</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Fill out the form below to edit this account.</p>
            <form action="/accounts/view/<?php echo $account["id"]; ?>" method="post">
            
            	<input type="hidden" name="id" value="<?php echo $account["id"]; ?>">
				<?php
					include("includes/template/forms/account.php");
				?>                
                <input type="submit" name="submit" value="Update Account">
                <!--<div class="vertical-divider"></div>
                <input type="submit" name="submit" value="Delete Account" class="delete" onClick="return confirm('Are you sure you want to delete this account?');">-->


            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");