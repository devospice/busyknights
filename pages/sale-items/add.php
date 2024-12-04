<?php

	/* /sales/new-item */
	$pageTitle = $_SESSION["company"]["name"] . " - Sale Items";
	$description = $_SESSION["company"]["name"] . " - Add a New Item";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	
	$templateSQL = "SELECT * FROM transaction_templates ORDER BY name";
	$templates = getDataFromTable($templateSQL, $cdb);
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Add a New Sale Item</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Fill out the form below to add a new sale item. Set up royalties after the item is set up.</p>

						
            <form action="/sale-items" method="post" id="sale-item-form">
            
                <?php
					include("includes/template/forms/sale-item.php");
				?>
				                
                <input type="submit" name="submit" value="Add Sale Item">

            </form>
			
			<hr>
			
			<h2>Import CSV</h2>
			<p>This form creates the sale item for each artist and assigns royalties based on pre-allocations.</p>
			
			<p>Upload a CSV file in the following format:</p>
            <ul>
            	<li><span>One entry per line with no header row</span></li>
                <li><span>Each line containing a comma-delimited list of values as follows:</span><br>
                	<em><span>Item Name,Artist,Release Date,Catalog Number,Bar Code,Description</span></em>
                </li>
                <li><span>If any value contains a comma enclose that entire field in double quotes, ex: "Peter, the Great."</span></li>
                <li><span>If any value contains an apostrophe, single quote, or double quote, those marks must be escaped with a back slash, ex: John Doe\'s Ave.</span></li>
                <li><span>If there is no value for a particular entry leave it blank but include the comma and don't put any extra spaces around it</span></li>
				<li><span>Royalties are not assigned for "Various Artist" releases.</span></li>
            </ul>
			
			<p>Upload your .CSV file:</p>            
            <form action="/sale-items" method="post" enctype="multipart/form-data">
            
            	<input type="file" name="csv_file" accept=".csv">
                <input type="submit" class="default" name="submit" value="Import Sale Items">

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");