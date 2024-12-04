<?php

	include("includes/framework/login-check.php");
	$cdb = get_cdb();	

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

	// Begin javascript output
	echo "<script type=\"text/javascript\">\r\n";
	echo "var accounts = [";

	// Loop through each account
	foreach ($accounts as $account) {
		printf("{\"email\":\"%s\", \"acccountId\":\"%s\", \"startDate\":\"%s\", \"endDate\":\"%s\", \"emailText\":\"%s\"},\r\n", $account["email"], $account["id"], $startDate, $endDate, $emailText);		
	}

	// End javascript output
	echo "];";

	
?>

<!--<script type="text/javascript">-->

function emailEveryone(accounts) {
// Loop through all the accounts and send the data
for (var i=0; i<accounts.length; i++) {
	
	var thisAccount = accounts[i];
	console.log(thisAccount);
	
	// Send to email-report
	var chAJAX = create_ajax();
	
	// Set up form data
	var newFormData = new FormData();
	newFormData.append(startdate, thisAccount.startDate);
	newFormData.append(enddate, thisAccount.endDate);
	newFormData.append(email, thisAccount.email);
	newFormData.append(email_content, thisAccount.emailText);
	newFormData.append(accountId, thisAccount.accountId);

	chAJAX.open("POST", "/ajax/email-report", false);
	chAJAX.send(newFormData);

	chAJAX.onreadystatechange = function (e) {
		if (chAJAX.readyState == 4) {
			console.log("Form submitted:", chAJAX.responseText);
			// showThankYou();
			window[callback](chAJAX.responseText);
		}
	};
	
}
	
document.write("Done sending emails.");
	
/* Creates an AJAX object */
function create_ajax () 
{
	if (window.XMLHttpRequest) {
		var xmlhttp = new XMLHttpRequest(); // code for IE7+, Firefox, Chrome, Opera, Safari
	} else {
	  	var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); // code for IE6, IE5
	}
	
	return xmlhttp;
	
}	

</script>

