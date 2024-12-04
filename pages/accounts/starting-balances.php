<?php

	/* /accounts */
	$pageTitle = $_SESSION["company"]["name"] . " - Accounts";
	$description = $_SESSION["company"]["name"] . " - Accounts";
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
	
	$accountsSQL = sprintf("SELECT %s.*, account_type.type as accountType FROM %s LEFT JOIN account_type ON %s.type = account_type.id ORDER BY name", $_SESSION["accountsTable"], $_SESSION["accountsTable"], $_SESSION["accountsTable"]);
	$accounts = getDataFromTable($accountsSQL, $cdb);
	
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Account Starting Balances</h2>
            
            <?php
				if ($msg != "") {
					printf("<p>%s</p>", $msg);
				}
			?>
            
			<?php
				include("includes/template/subnavs/accounts.php");
			?>            
            
			<h3>Asset Accounts <a href="/accounts/add/Asset" class="button small right">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="seventy">Name</th>
                	<th class="thirty center">Starting Balance</th>
                </thead>
                <?php
					if (count($accounts) > 0) {
						
						$alt = false;
						foreach ($accounts as $account) {
							
							if ($account["accountType"] == "Asset") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;
								
								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\">%s</td>", $account["name"]);
								printf("<td class=\"balance\">
									<form class=\"in-table\" id=\"%s\" onSubmit=\"return updateStartingBalance(this);\">
									$<input type=\"text\" name=\"starting_balance\" value=\"%s\"> 
									<input type=\"submit\" name=\"Update\" value=\"Update\" class=\"button small\">
									</form>
									</td>", 
									   $account["id"],
									   $account["starting_balance"]); 
								echo "</tr>";
							}
						}
					} 
				?>
            </table>
			
			
				
				
			
			
			
 			<h3>Liability Accounts <a href="/accounts/add/Liability" class="button small right">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="seventy">Name</th>
                	<th class="thirty center">Starting Balance</th>
                </thead>
                <?php
					if (count($accounts) > 0) {
						
						$alt = false;
						foreach ($accounts as $account) {
							
							if ($account["accountType"] == "Liability") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\">%s</td>", $account["name"]);
								printf("<td class=\"balance\">
									<form class=\"in-table\" id=\"%s\" onSubmit=\"return updateStartingBalance(this);\">
									$<input type=\"text\" name=\"starting_balance\" value=\"%s\"> 
									<input type=\"submit\" name=\"Update\" value=\"Update\" class=\"button small\">
									</form>
									</td>", 
									   $account["id"],
									   $account["starting_balance"]); 
								echo "</tr>";
							}
						}
					} 
				?>
            </table>
			
			

			<h3>Expense Accounts <a href="/accounts/add/Expense" class="button small right">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="seventy">Name</th>
                	<th class="thirty center">Starting Balance</th>
                </thead>
                <?php
					if (count($accounts) > 0) {
						
						$alt = false;
						foreach ($accounts as $account) {
							
							if ($account["accountType"] == "Expense") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\">%s</td>", $account["name"]);
								printf("<td class=\"balance\">
									<form class=\"in-table\" id=\"%s\" onSubmit=\"return updateStartingBalance(this);\">
									$<input type=\"text\" name=\"starting_balance\" value=\"%s\"> 
									<input type=\"submit\" name=\"Update\" value=\"Update\" class=\"button small\">
									</form>
									</td>", 
									   $account["id"],
									   $account["starting_balance"]); 
								echo "</tr>";
							}
						}
					} 
				?>
            </table>
 
  			<h3>Revenue Accounts <a href="/accounts/add/Revenue" class="button small right">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="seventy">Name</th>
                	<th class="thirty center">Starting Balance</th>
                </thead>
                <?php
					if (count($accounts) > 0) {
						
						$alt = false;
						foreach ($accounts as $account) {
							
							if ($account["accountType"] == "Revenue") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\">%s</td>", $account["name"]);
								printf("<td class=\"balance\">
									<form class=\"in-table\" id=\"%s\" onSubmit=\"return updateStartingBalance(this);\">
									$<input type=\"text\" name=\"starting_balance\" value=\"%s\"> 
									<input type=\"submit\" name=\"Update\" value=\"Update\" class=\"button small\">
									</form>
									</td>", 
									   $account["id"],
									   $account["starting_balance"]); 
								echo "</tr>";
							}
						}
					} 
				?>
			</table>
			
				
  			<h3>Equity Accounts <a href="/accounts/add/Equity" class="button small right">New</a></h3>
            <table cellpadding="0" cellspacing="0" border="0">
            	<thead>
                	<th class="seventy">Name</th>
                	<th class="thirty center">Starting Balance</th>
                </thead>
                <?php
					if (count($accounts) > 0) {
						
						$alt = false;
						foreach ($accounts as $account) {
							
							if ($account["accountType"] == "Equity") {
								$class = "";
								if ($alt) {
									$class = "alt";
								}
								$alt = !$alt;

								printf("<tr class=\"%s\">", $class);
								printf("<td class=\"name\">%s</td>", $account["name"]);
								printf("<td class=\"balance\">
									<form class=\"in-table\" id=\"%s\" onSubmit=\"return updateStartingBalance(this);\">
									$<input type=\"text\" name=\"starting_balance\" value=\"%s\"> 
									<input type=\"submit\" name=\"Update\" value=\"Update\" class=\"button small\">
									</form>
									</td>", 
									   $account["id"],
									   $account["starting_balance"]); 
								echo "</tr>";
							}
						}
					} 
				?>
			</table>
 
          
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");  ?>