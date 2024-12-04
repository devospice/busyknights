<?php
	$pageTitle = "Busy Knights";
	$description = "Busy Knights - Registration.";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "register";
	
	include("includes/template/page_top.php");
	
	/* 
	
	- Check to see if this company already exists
		- if not
			- create the company
			- register the user
			- associate user with company
			- email validation to user
		- if so
			- email notification to admin with edit link
			- notify user on screen
	
	*/
	
	$db = get_db();
	$userMsg = "";
	
	$email = $db->real_escape_string($_POST["email"]);
	$password = $db->real_escape_string($_POST["password"]);
	$pwHash = password_hash($password, PASSWORD_DEFAULT);
	$company = $db->real_escape_string($_POST["company"]);

	// Make sure email isn't already in use
	$emailSQL = sprintf("SELECT * FROM users WHERE email = '%s'", $email);
	$allUsers = getDataFromTable($emailSQL);
	if (count($allUsers) == 0) {
	
		// See if the company exists already
		$companySQL = sprintf("SELECT * FROM companies WHERE name = '%s'", $company);
		$companies = getDataFromTable($companySQL);
		
		if (count($companies) == 0) {
			
			// Create the company
			$companyInsert = sprintf("INSERT INTO companies (name) VALUES ('%s')", $company);
			$created = runSQL($companyInsert);
			if ($created == true) {
				$userMsg .= sprintf("<h3>Thank you for registering with Busy Knights!</h3><p>A new company, %s, has been set up in our database.</p>", $company);
			} else {
				$userMsg .= "<p>There was an error setting up your new company.  Please contact support for assistance.</p>";
			}
			
			// Create the user
			$companyId = getLastID();
			$userSQL = sprintf("INSERT INTO users (email, password, company, user_level) VALUES ('%s', '%s', '%s', '1')", $email, $pwHash, $companyId);
			$result = runSQL($userSQL);
			
			if ($result == true) {
				$userMsg .= sprintf("<p>Your account has been set up and we are currently setting up your database and subdomain.  When that is ready you will receive an email at %s.  You will need to verify your email address before logging in.  This account will be the default administrator account for this company.  This can be changed later if needed.</p>", $email);
			} else {
				$err = $db->error;
				$userMsg .= sprintf("<p>There was an error setting up your user account.  Please contact support for assistance.  (%s)</p>", $err);
			}
			
		} else {
			$userMsg .= sprintf("<p>The company name you selected, %s, is already in use.</p><p>If you work for this company please contact your administrator about having an account set up for you.</p>", $company);
			$userMsg .= "<p>If you happened to select a company name that was already in use by another company please edit your entry to make it unique.</p>";
		}
		
	} else {
		$userMsg .= "<p>That email address is already in use in our database.  Please go back and try a different address.  If you require assistance please contact us.</p>";
	}
	
	
	
?>

<div id="container">

	<?php include("includes/template/busy_knights_header.php"); ?>	
    
    <div id="content-container" class="default">
    	                
        <div id="content-area">
        	
            <h2>Registration</h2>
            
            <?php echo $userMsg; ?>
			            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");