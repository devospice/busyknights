<?php

	/* /companies/ids */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Company IDs";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "companies";


	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	$cdb = get_cdb();

	$companiesSQL = "SElECT * FROM companies ORDER BY name";
	$companies = getDataFromTable($companiesSQL, $cdb);
		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/companies.php");
			?>
            <h2>Company IDs</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
            <table cellpadding="0" cellspacing="0" border="0">
				<thead>
					<th>Company Name</th>
					<th>ID</th>
				</thead>
				<?php
					$alt = false;
					foreach ($companies as $company) {
						$class = "";
						if ($alt) {
							$class = "class = 'alt'";
						}
						printf("<tr %s><td>%s</td><td>%s</td></tr>", $class, $company["name"], $company["id"]);
						$alt = !$alt;
					}
				?>
			</table>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");