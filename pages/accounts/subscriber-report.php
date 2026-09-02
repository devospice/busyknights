<?php

	/* /accounts */
	$pageTitle = $_SESSION["company"]["name"] . " - Subscriber Reports";
	$description = $_SESSION["company"]["name"] . " - Subscriber Reports";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "accounts";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");
	
	// Custom code for this page
	$cdb = get_cdb();
	$msg = "";

	if (isset($_POST["submit"])) {
		
		// Create new account
		if ($_POST["submit"] == "Add Account") {
			
			// include("includes/framework/code-snippets/add-account.php");
			
		}


	}
	
	/*$accountsSQL = sprintf("SELECT %s.*, account_type.type as accountType FROM %s LEFT JOIN account_type ON %s.type = account_type.id ORDER BY name", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"]);*/
	$reportSQL = sprintf("SELECT 
			a.id,
			a.name,
			e.date AS last_payment_date,
			e.credit AS last_payment_amount
		FROM %s a
		INNER JOIN %s e ON a.id = e.account
		INNER JOIN (
			SELECT account, MAX(date) AS max_date
			FROM %s
			WHERE credit > 0
			GROUP BY account
		) latest ON e.account = latest.account AND e.date = latest.max_date
		WHERE a.category = 18
			AND e.credit > 0
		ORDER BY e.date DESC", $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"]);
	$reportData = getDataFromTable($reportSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Subscriber Accounts Report</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/accounts.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="sixty">Name</th>
                	<th class="twenty center">Last Payment</th>
                	<th class="twenty right">Amount</th>
                </thead>
                <?php
					if (count($reportData) > 0) {
						
						$alt = false;
						foreach ($reportData as $report) {
										
							$class = "";
							if ($alt) {
								$class = "alt";
							}
							$alt = !$alt;

							printf("<tr class=\"%s\">", $class);
							printf("<td class=\"name\"><a href='/accounts/view/%s'>%s</a></td>", $report["id"], $report["name"]);
							printf("<td class=\"date center\">%s</td>", $report["last_payment_date"]);
							printf("<td class=\"balance center\">%s</td>", $report["last_payment_amount"]);
							echo "</tr>";
							
						}
					} else {
						echo "reportData is empty";
					}
				?>
            </table>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>