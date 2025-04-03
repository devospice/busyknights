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
	$mail->Password = "ytfdnhnexjcsoind"; /* Must use the App Password feature from the Google Account fidiminteractive@gmail.com */
	$mail->SetFrom("support@fidim.com", "FIDIM Interactive, LLC");
	$mail->addReplyTo("support@fidim.com", "FIDIM Interactive, LLC");
	

	// Get form data
	$startDate = $cdb->real_escape_string($_POST["startdate"]);
	$endDate = $cdb->real_escape_string($_POST["enddate"]);
	$emailText = $cdb->real_escape_string($_POST["email_content"]);
	$emailText = stripslashes($emailText);
	$startBatch = $cdb->real_escape_string($_POST["startbatch"]);
	$endBatch = 50;

	// Get all liability accounts
	$liabialitySQL = sprintf("
		SELECT %s.*, account_type.type as accountType, contacts.email as email 
		FROM %s 
		LEFT JOIN account_type ON %s.type = account_type.id
		LEFT JOIN contacts ON %s.contact = contacts.id
		WHERE %s.type = '2'
		LIMIT %s,%s", 
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$_SESSION["accountsTable"],
			$startBatch, $endBatch);
	// echo $liabialitySQL . "<br>";
	$accounts = getDataFromTable($liabialitySQL, $cdb);
	/*$accounts = yeildDataFromTable($liabialitySQL, $cdb);*/

	$counter = $startBatch;

	foreach ($accounts as $account) {

		// Get opening balance, closing balance, and transaction entries
		include("includes/framework/code-snippets/account-open-close-transactions.php");

		$mail->ClearAllRecipients(); // clear all previous emails so they don't just keep adding them

		// Set recipient
		$toEmail = $account["email"];
		// $toEmail = "devospice@gmail.com"; // Send to me only for testing 

		if ($toEmail != "") {
			$mail->AddAddress($toEmail);

			// Set up email
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
			echo $counter . ") Email will be sent to " . $toEmail . " (" . $account["name"] . ")" . "<br>";

		} else {
			echo $counter . ") No email address found.  Contact missing for account " . $account["name"] . "<br>";
		}
		
		$counter++;

	}

	
?>


