<?php

	/* /sale-items/sale */
	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
	$description = $_SESSION["company"]["name"] . " - Add a Transaction for this Item";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "sale items";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	
	//$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	//$templates = getDataFromTable($templateSQL, $cdb);

	/*if (isset($routes[3])) {
		$id = $routes[3];
		
		$itemsSQL = sprintf("SELECT sale_items.*, transaction_templates.name AS template FROM sale_items LEFT JOIN transaction_templates ON sale_items.transaction_template = transaction_templates.id WHERE sale_items.id = '%s'", $id);
		$items = getDataFromTable($itemsSQL, $cdb);
		if ($items) {
			$item = $items[0];
			
			// $royaltySQL = sprintf("SELECT royalties.*, accounts.name as accountName FROM royalties LEFT JOIN accounts ON royalties.account = accounts.id WHERE sale_item = '%s'",$item["id"]);
			// $royalties = getDataFromTable($royaltySQL, $cdb);
						
		} else {
			$msg = sprintf("<p class=\"alert\">There was an error retrieving this item: %s</p>", $cdb->error);
		}
		
	} else {
		$msg = "<p class=\"alert\">Error: No item found.</p>";
	}*/
	
	$itemsSQL = "SELECT * FROM sale_items ORDER BY name";
	$items = getDataFromTable($itemsSQL, $cdb);
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
			
			<?php
				if ((isset($msg)) && ($msg != "")) {
					printf("<p>%s</p>", $msg);
				}
			?>
			
            <h2>Record a Sale</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
			<div>
            	<p>Fill out the form below to record a sale.</p>
			</div>
						
            <form action="/transactions" method="post" id="transaction-form">
			
				<div class="left-three-quarters">
					<label for="sale_item">Item Sold:</label>
					<select name="sale_item">
						<option value="0">--== Select Sale Item ==--</option>
						<?php
							foreach ($items as $item) {
								$selected = "";
								if (isset($routes[3])) {
									if ($item["id"] == $routes[3]) {
										$selected = "selected";
									}
								}
								printf("<option value=\"%s\" %s>%s</option>", $item["id"], $selected, $item["name"]);
							}
						?>
					</select>
				</div>
				<div class="right-one-quarter">
					<label for="quantity">Quantity: </label>
					<input type="number" name="quantity" value="1">
				</div>
            
                <?php
					include("includes/template/forms/transaction.php");
				?>
				
				<div class="left-half">
                	<input type="submit" name="submit" value="Record Sale">
				</div>
				<div class="right-half">
					<!--<div class="callout">
						<label for="name">Name:</label>
						<input type="text" name="name">
						<input type="submit" name="submit" value="Save as Template">
					</div>-->
				</div>

            </form>
			
			
			<hr>
			
			<h2>Import CSV</h2>
			<p>This form creates transactions for each item to track royalties for the sale.  Revenue is assumed to be recorded separately.</p>
			
			<p>Upload a CSV file in the following format:</p>
            <ul>
            	<li><span>One entry per line with no header row</span></li>
                <li><span>Each line containing a comma-delimited list of values as follows:</span><br>
                	<em><span>Sale Date,Item Name,Artist,Sale Price</span></em>
                </li>
				<li><span>Be sure Sale Price reflects net revenue after any fees are accounted for.</span></li>
                <li><span>If any value contains a comma enclose that entire field in double quotes, ex: "Peter, the Great."</span></li>
                <li><span><strong>DO NOT</strong> escape single quote, double quotes, or apostrophes.  The script accounts for this.</span></li>
                <li><span>If there is no value for a particular entry leave it blank but include the comma and don't put any extra spaces around it</span></li>
				<li><span>Title and artist must match.  So "Robert Lund & Spaff.com" won't find "Robert Lund and Spaff.com" or "Robert Lund and Spaff"</span></li>
				<li><span>Only FuMP and other compilations should be credited to "Various Artists."  Nothing should be credited to "The Funny Music Project."  The script tries to compensate but may not work in all instances.</span></li>
            </ul>
			
			<p>Upload your .CSV file:</p>            
            <form action="/transactions" method="post" enctype="multipart/form-data">
				
            	<input type="file" name="csv_file" accept=".csv">
				
				<!--<h3>Accounts</h3>
                <p class="small-text">Debit who made the sale, ex. CDBaby or SongCast.  Credit Third Party Sales, usually.</p>
                <div id="transaction-entries">
                    <div class="entry">
                        <div class="left-half">
                            <label for="account-1">Debit Account:</label>
                            <select name="account-1">
								<option value="0">--== SELECT ACCOUNT ==--</option>
                                <?php
                                    foreach ($accounts as $account) {
                                        $selected = "";
										if (isset($entries)) {
											if ($account["id"] == $entries[0]["account"]) {
												$selected = "selected";
											}
										} else {
											if (isset($routes[3])) {
												if ($account["id"] == $routes[3]) {
													$selected = "selected";
												}
											}
										}
                                        printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
                                    }
                                ?>
                            </select> <a class="button small" onClick="openNewAccountOverlay(1);">New</a>
                        </div>
                        <div class="right-half">
                            <label for="account-2">Credit Account:</label>
                            <select name="account-2">
								<option value="0">--== SELECT ACCOUNT ==--</option>
                                <?php
                                    foreach ($accounts as $account) {
                                        $selected = "";
                                        if ($account["id"] == $entries[1]["account"]) {
                                            $selected = "selected";
                                        }
                                        printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
                                    }
                                ?>
                            </select> <a class="button small" onClick="openNewAccountOverlay(2);">New</a>
                        </div>
                    </div>
					
				</div>-->
				
				<!--<div>
                	<label for="notes">Notes:</label>
                    <textarea name="notes"></textarea>
                </div>-->
            
                <input type="submit" class="default" name="submit" value="Import Sales Report">
				

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php"); ?>