<?php

	/* /payments/edit */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Payment Information";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	$cdb = get_cdb();

	$msg = "";
	if (isset($routes[3])) {
		$id = $routes[3];
		
		$infoSQL = sprintf("SELECT payment_info.*, payment_methods.use_table as use_table, payment_methods.method as method_name FROM `payment_info` LEFT JOIN payment_methods ON payment_info.method = payment_methods.id WHERE payment_info.id = '%s' ORDER BY method", $id);
		$infos = getDataFromTable($infoSQL, $cdb);
		if ($infos) {
			$info = $infos[0];
			
			$paymentSQL = sprintf("SELECT * FROM %s WHERE id = '%s'", $info["use_table"], $info["info"]);
			$payments = getDataFromTable($paymentSQL, $cdb);
			$paymentInfo = $payments[0];
			
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this account information: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No payment information was found.</p>";
	}

	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/contact.php");
			?>
            <h2>Edit Payment Information</h2>
            
			<?php
				include("includes/template/subnavs/accounts.php");
			?>            
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
            <p>Fill out the form below to edit this payment information.</p>
            <form action="/accounts" method="post" novalidate>
            	<input type="hidden" name="id" value="<?php echo $id; ?>">
                <?php
					include("includes/template/forms/payment-info.php");
				?>
                <input type="submit" name="submit" value="Edit Payment Info">
                <input type="submit" name="submit" value="Delete Payment Info" onClick="return confirm('Are you sure you want to delete this payment information?');">
                <input type="submit" name="submit" value="Cancel">

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");