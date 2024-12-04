<?php

	// Redirect to /app.  Previous home page is below.
	header('Location: /app');

	$pageTitle = "Busy Knights";
	$description = "Busy Knights - Accounting software for small businesses.";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "home";
	
	include("includes/template/page_top.php");
?>

<div id="container" class="splash">

	<h1 class="splash">Busy Knights - Accounting software for small businesses</h1>
		
	<div id="splash-container">
    	
        <div class="left-half">
        	<img src="/assets/images/logos/busy-knights.png" id="busy-knights-logo">
        	<img src="/assets/images/logos/busy-knights-mobile.png" id="busy-knights-logo-mobile">
        </div>
        
        <div class="right-half">
        	<p>Small business accounting software, featuring:</p> 
            <ul>
                <li><span>double-entry accounting</span></li>
                <li><span>automatic royalty distributions</span></li>
                <li><span>secure, online, access from anywhere</span></li>
            </ul>
            
            <p>Free, 3-month trial.  No credit card required.
            Export your data at any time.  Sign up now.</p>
            
            <p class="center"><a href="/about" class="button" id="more-info">More Info</a></p>
        </div>
        
        <div class="left-half">
        	<?php include("includes/template/login-form.php"); ?>
        </div>
        
        <div class="right-half">
        	<h2>Register Now</h2>
             <form id="registration-form" class="splash" action="/register" method="post" onSubmit="return validateRegistrationForm();">
			 	
				<input type="hidden" name="message" value="">
			 
            	<label for="email">Email Address:</label>
                <input type="email" name="email">
            	<label for="password">Password:</label>
                <input type="password" name="password">
             	<label for="company">Company Name:</label>
                <input type="text" name="company">
               	<input type="submit" name="submit" value="Sign Up">
            </form>
			<p id="registration-error" class="error"></p>
       </div>
        
    </div>
					
	
<?php include("includes/template/page_bottom.php");