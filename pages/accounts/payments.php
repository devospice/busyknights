<?php

	/* /transactions/add */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Pay off liability accounts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	
	/*$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);*/
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Account Payments</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>
			
			<h3>Generate Paypal Mass-Payment File</h3>
            <form action="/accounts/mass-payment-file" method="post" target="_blank">

				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				
				<div class="right-half">
                	<input type="submit" name="submit" value="Generate Mass Payment File">
				</div>
				
			</form>
			
			<hr>
			
			<h3>Mark Paypal as Paid</h3>
            <form action="/transactions/add" method="post" id="transaction-form">
				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				
				<div class="right-half">
					<input type="hidden" name="payment_method" value="paypal">
                	<input type="submit" name="submit" value="Generate Transaction">
				</div>
				
			</form>
			
			<hr>
			
			<h3>Generate Payment Info for Checks</h3>
            <form action="/accounts/payment-by-check" method="post" target="_blank">
				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				
				<div class="right-half">
                	<input type="submit" name="submit" value="Generate Check Payment Info">
				</div>
				
			</form>
			
			<hr>
			
			<h3>Mark Checks Paid</h3>
            <form action="/transactions/add" method="post" id="transaction-form">
				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				
				<div class="right-half">
					<input type="hidden" name="payment_method" value="check">
                	<input type="submit" name="submit" value="Generate Transaction">
				</div>
				
			</form>
			
			<hr>
			
			<h3>Email Reports to All Liability Accounts</h3>
            <form action="/accounts/email-reports" method="post" target="_blank" id="transaction-form">
				<div>
					<textarea name="email_content" placeholder="Email content"></textarea>
				</div>
				<?php 
					include("includes/template/forms/start-date-end-date.php");
				?>
				
				<div class="right-half">
                	<input type="submit" name="submit" value="Email Reports">
				</div>
				
			</form>
			<!--<form action="/ajax/email-all-reports" method="post" id="transaction-form" onSubmit="return validateForm(this);" novalidate>
				<div>
					<textarea name="email_content" placeholder="Email content"></textarea>
				</div>
				<?php 
					// include("includes/template/forms/start-date-end-date.php");
				?>
				<input type="hidden" name="successCallback" value="showReportResult">
				
				<div class="right-half">
                	<input type="submit" name="submit" value="Email All Reports">
				</div>
				
			</form>
			<div id="report-result"></div>-->
			
			
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>