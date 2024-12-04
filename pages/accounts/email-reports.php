<?php

	include("includes/framework/login-check.php");
	$cdb = get_cdb();

	// Set up PHPMailer
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'includes/framework/PHPMailer/src/Exception.php';
	require 'includes/framework/PHPMailer/src/PHPMailer.php';
	require 'includes/framework/PHPMailer/src/SMTP.php';
	// require_once("includes/framework/PHPMailer/PHPMailerAutoload.php");
	$mail = new PHPMailer(true);
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->Host = "smtp.gmail.com";
	$mail->Port = "465";
	$mail->isHTML();
	$mail->Username = "fidiminteractive@gmail.com";
	$mail->Password = "jybhenbljimwvwqo"; /* Must use the App Password feature from th Google Account "FIDIMn@t2!"; */
	$mail->SetFrom("support@fidim.com", "FIDIM Interactive, LLC");
	$mail->addReplyTo("support@fidim.com", "FIDIM Interactive, LLC");
	

	// Get form data
	$startDate = $cdb->real_escape_string($_POST["startdate"]);
	$endDate = $cdb->real_escape_string($_POST["enddate"]);
	$emailText = $cdb->real_escape_string($_POST["email_content"]);


	// Get all liability accounts
	$liabialitySQL = sprintf("
		SELECT %s.*, account_type.type as accountType, contacts.email as email 
		FROM %s 
		LEFT JOIN account_type ON %s.type = account_type.id
		LEFT JOIN contacts ON %s.contact = contacts.id
		WHERE %s.type = '2'", 
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"]);
	//echo $liabialitySQL . "<br>";
	$accounts = getDataFromTable($liabialitySQL, $cdb);

	// Loop through each account
	foreach ($accounts as $account) {
		
		// if ($account["id"] == 50) { // Only do Devo's account
		
			// Get opening balance, closing balance, and transaction entries
			include("includes/framework/code-snippets/account-open-close-transactions.php");

			// Get contact email address
			/*$contactSQL = sprintf("SELECT email FROM contacts WHERE id = '%s'", $account["contact"]);
			$contacts = getDataFromTable($contactSQL, $cdb);
			$toEmail = $contacts[0]["email"];*/
			$mail->ClearAllRecipients(); // clear all previous emails so they don't just keep adding them
		
			$toEmail = $account["email"];
			$mail->AddAddress($toEmail);

			// Set up email
			// $subject = "FIDIM Interactive, LLC Statement - " . $endDate;
			$mail->Subject = "FIDIM Interactive, LLC Statement - " . $endDate;
			
			// Include text of email
			$mail->Body = "<html>
				<head></head><body>";
			$mail->Body .= $emailText;
			$mail->Body .= "<br><br>";

			// Include report
			ob_start();
			include("includes/framework/code-snippets/report-html.php");
			$mail->Body .= ob_get_clean();

			$mail->Body .= "</body></html>";

			// Send the email
			$mail->Send();
			if ($toEmail == "") {
				echo "No email address for " . $account["name"] . "<br>";				
			} else {
				echo "email will be sent to " . $toEmail . "<br>";				
			}

			
		// }
		
	}

	
?>


