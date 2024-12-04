<?php

	/* /app */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Overview";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "overview";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");


    // Handle update year
	if (isset($_POST["submit"])) {
		if ($_POST["submit"] == "Set Year") {
            
			setActiveYear($_POST["selected_year"]);
			
			$year2 = substr($_POST["selected_year"], 2);
			$accountsTable = "accounts_" . $year2;
			$transactionsTable = "transactions_" . $year2;
						
		}
	}


	// Calculate year-to-date revenue
	$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
	if ($_SESSION["activeYear"] == date("Y")) {
		// This year, stop today
		$endDate = sprintf("%s-%s-%s", $_SESSION["activeYear"], date("m"), date("d"));
	} else {
		// Prior year, stop on 12/31
		$endDate = sprintf("%s-12-31", $_SESSION["activeYear"]);
	}

	// Credit in, debit out
	$revenueSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.credit,0) - COALESCE(%s.debit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.type = '5' AND %s.date >= '%s' AND %s.date <= '%s'", 
						  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);
	// echo $balanceSQL;
	$revenue = getDataFromTable($revenueSQL, $cdb);
	$yearToDateRevenue = $revenue[0]["balance"];

	// Debit in, credit out
	$expenseSQL = sprintf("SELECT %s.starting_balance + COALESCE(SUM(COALESCE(%s.debit,0) - COALESCE(%s.credit,0)),0) as balance FROM `%s` LEFT JOIN %s ON %s.id = %s.account WHERE %s.type = '4' AND %s.date >= '%s' AND %s.date <= '%s'", 
						  $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $_SESSION["accountsTable"], $_SESSION["entriesTable"], $startDate, $_SESSION["entriesTable"], $endDate);
	$expense = getDataFromTable($expenseSQL, $cdb);
	$yearToDateExpenses = $expense[0]["balance"];

	$balance = $yearToDateRevenue - $yearToDateExpenses;

	// Calculate subscription revenue per period
	include("includes/template/partials/subscription-revenue.php");

	// Calculate expenses by category
	include("includes/template/partials/expense-totals.php");

?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <!--<form id="search">
            	<input type="text" name="query">
                <input type="submit" name="submit" value="Search">
            </form>-->
			
			
			<div class="left-half">
				<h2>Overview</h2>
				
				<table cellpadding="0" cellspacing="0" border="0">
					<thead>
						<th>Balance Sheet</th>
						<th></th>
					</thead>
					<tr>
						<td>Year to date revenue:</td>
						<td class="debit">$<?php echo $yearToDateRevenue; ?></td>
					</tr>
					<tr class="alt">
						<td>Year to date expenses:</td>
						<td class="credit">$<?php echo $yearToDateExpenses; ?></td>
					</tr>
					<tr>
						<td><strong>Balance</strong></td>
						<td class="credit"><strong>$<?php echo $balance; ?></strong></td>
					</tr>
				</table>
            
			</div>
           	<div class="right-half">
            	<h2>Active Year - <?php echo $_SESSION["activeYear"]; ?></h2>
				<form action = "/app" method="post">
					<label for="year">Active year:</label>
					<select name="selected_year">
						<?php
							$year4 = date("Y");
							do {
								printf("<option value=\"%s\">%s</option>", $year4, $year4);
								$year4--;
							} while ($year4 > 2018);
						?>
					</select>
					<input type="submit" name="submit" value="Set Year">
				</form>
			</div>
						
			<div class="left-half">
				<table cellpadding="0" cellspacing="0" border="0">
					<thead>
						<th>Subscription Revenue by Period</th>
						<th></th>
					</thead>
					<tr>
						<td>January - February</td>
						<td class="debit">$<?php echo $p1Sub2; ?></td>
					</tr>
					<tr class="alt">
						<td>March - April</td>
						<td class="debit">$<?php echo $p2Sub2; ?></td>
					</tr>
					<tr>
						<td>May - June</td>
						<td class="debit">$<?php echo $p3Sub2; ?></td>
					</tr>
					<tr class="alt">
						<td>July - August</td>
						<td class="debit">$<?php echo $p4Sub2; ?></td>
					</tr>
					<tr>
						<td>September - October</td>
						<td class="debit">$<?php echo $p5Sub2; ?></td>
					</tr>
					<tr class="alt">
						<td>November - December</td>
						<td class="debit">$<?php echo $p6Sub2; ?></td>
					</tr>
				</table>	
				
				<p><?php // echo $expSQL12; ?></p>
			</div>
			
			<div class="right-half">
				<table cellpadding="0" cellspacing="0" border="0">
					<thead>
						<th>Expenses by Category*</th>
						<th></th>
					</thead>
					<tr>
						<td>Supplies</td>
						<td class="debit">$<?php echo $expense1; ?></td>
					</tr>
					<tr class="alt">
						<td>Communication</td>
						<td class="debit">$<?php echo $expense2; ?></td>
					</tr>
					<tr>
						<td>Taxes</td>
						<td class="debit">$<?php echo $expense7; ?></td>
					</tr>
					<tr class="alt">
						<td>Advertising</td>
						<td class="debit">$<?php echo $expense8; ?></td>
					</tr>
					<tr>
						<td>Business Travel</td>
						<td class="debit">$<?php echo $expense9; ?></td>
					</tr>
					<tr class="alt">
						<td>Meals and Entertainment</td>
						<td class="debit">$<?php echo $expense10; ?></td>
					</tr>
					<tr class="">
						<td>Equipment Rental</td>
						<td class="debit">$<?php echo $expense11; ?></td>
					</tr>
					<tr class="alt">
						<td>Legal and Professional Fees</td>
						<td class="debit">$<?php echo $expense12; ?></td>
					</tr>
					<tr class="">
						<td>Commissions</td>
						<td class="debit">$<?php echo $expense13; ?></td>
					</tr>
					<tr class="alt">
						<td>Contract Labor</td>
						<td class="debit">$<?php echo $expense14; ?></td>
					</tr>
					<tr class="">
						<td>Other Office Expenses</td>
						<td class="debit">$<?php echo $expense15; ?></td>
					</tr>
					<tr class="alt">
						<td>Miscellaneous/Postage</td>
						<td class="debit">$<?php echo $expense16; ?></td>
					</tr>
				</table>	
				<p class="small-text">*May include future expenses.</p>
			</div>
			
			<p><?php // echo $expSQL12; ?></p>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");