<?php

	$emailVal = "";
	if (isset($_POST["email"])) {
		$emailVal = $_POST["email"];
	}
	
	$passVal = "";
	if (isset($_POST["password"])) {
		$passVal = $_POST["password	"];
	}
	
	$returnVal = "";
	if (isset($_GET["returnURL"])) {
		$returnVal = $_GET["returnURL"];
	}
	
?>
        	<h2>Log In</h2>
            <form id="login-form" class="splash" action="/login" method="post" onSubmit="return validateLoginForm();">
 				<input type="hidden" name="message" value="">
 				<input type="hidden" name="return" value="<?php echo $returnVal; ?>">
	           	<label for="email">Email Address:</label>
                <input type="email" name="email">
            	<label for="password">Password:</label>
                <input type="password" name="password">
                <input type="submit" name="submit" value="Log In">
            </form>
			<p id="login-error" class="error"></p>
