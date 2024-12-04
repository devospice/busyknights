<?php

	/* /login */

	$pageTitle = "Busy Knights";
	$description = "Busy Knights - Login";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "register";
	
	include("includes/template/page_top.php");
		
	$db = get_db();
	if (isset($_GET["loginError"])) {
		$userMsg = "<p>You must be logged in to access this page.</p>";
	} else {
		$userMsg = "";
	}
	
	if (isset($_POST["submit"])) {
		
		$email = $db->real_escape_string($_POST["email"]);
		$password = $db->real_escape_string($_POST["password"]);
		$pwHash = password_hash($password, PASSWORD_DEFAULT);
	
		$loginSQL = sprintf("SELECT * FROM users WHERE email = '%s'", $email);	
		$userAr = getDataFromTable($loginSQL);
		
		if (count($userAr) > 0) {
			
			if (password_verify($password, $userAr[0]["password"])) {
				$userMsg .= "<p>Successfully logged in.</p>";
				
				// Store user information
				$_SESSION["loggedIn"] = true;
				$_SESSION["user"] = $userAr[0];
				
				// Store company information
				$companySQL = sprintf("SELECT * FROM companies WHERE id = '%s'", $_SESSION["user"]["company"]);
				$companies = getDataFromTable($companySQL);
				$_SESSION["company"] = $companies[0];
				
				if ($_POST["return"] == "") {
					echo "<meta http-equiv=\"refresh\" content=\"0;url=/app\">";
				} else {
					printf("<meta http-equiv=\"refresh\" content=\"0;url=%s\">", $_POST["return"]);
				}
				die();
				
			} else {
				$userMsg .= "<p>The password you entered is incorrect.  Please check your information and try again.</p>";
			}
			
		} else {
			$userMsg .= "<p>That email address was not found in our system.  Please check your information and try again.</p>";
		}
	
	}
	
?>

<div id="container">

	<?php include("includes/template/busy_knights_header.php"); ?>	
    
    <div id="content-container" class="default">
    	                
        <div id="content-area">
        	
            <!--<h2>Log In</h2>-->
            
            <?php 
				echo $userMsg; 
        		include("includes/template/login-form.php");
			?>
			            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");