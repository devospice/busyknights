<?php
	if (isset($_POST["submit"])) {
		if ($_POST["submit"] == "Set Logo") {
			
			$target_dir = "assets/images/client_logos/";
			$target_file = $target_dir . basename($_FILES["logo"]["name"]);
			
			// Move the uploaded file in place
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
				$msg = "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
				
				$db = get_db();
				
				// Associate file with account
				$logoSQL = sprintf("UPDATE companies SET logo = '%s' WHERE id = '%s'", basename($_FILES["logo"]["name"]), $_SESSION["company"]["id"]);
				$result = runSQL($logoSQL, $db);
				if ($result == true) {
					$msg .= " Logo associated with account.";
					
					// Refresh session
					$companySQL = sprintf("SELECT * FROM companies WHERE id = '%s'", $_SESSION["company"]["id"]);
					$companies = getDataFromTable($companySQL, $db);
					$_SESSION["company"] = $companies[0];
					
				} else {
					$msg = sprintf("<p class=\"alert\">There was an error associating your logo with your account: %s</p>", $cdb->error);
				}
				
			} else {
				$msg = "Sorry, there was an error uploading your file.";
			}		
		}
	}
?>

	<header>
    	<div id="company-logo">
        	<?php if ($_SESSION["company"]["logo"] == ""):  ?>
                <!--Upload logo form-->
                <form enctype="multipart/form-data" method="post" action="<?php echo $PHP_SELF; ?>">
                    <label for="logo">Select your company logo</label>
                    <input type="file" name="logo" accept=".jpg, .jpeg, .gif, .png">
                    <input type="submit" name="submit" value="Set Logo">
                </form>
            <?php else: ?>
            	<a href="/"><img src="/assets/images/client_logos/<?php echo $_SESSION["company"]["logo"]; ?>"></a>
            <?php endif; ?>
        </div>
    	<h1><?php printf($_SESSION["company"]["name"]); ?></h1>
        
        <?php if ($_SESSION["user"]["user_level"] == "1") { ?>
        	<a href="/admin" id="admin-link">Admin</a>
        <?php } ?>
        
        <a href="/logout" id="logout-link">Logout</a>
        
    </header>
