<?php

	/* /transactions/add */
	$pageTitle = $_SESSION["company"]["name"] . " - Transactions";
	$description = $_SESSION["company"]["name"] . " - Edit a Transaction Template";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "transactions";

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

	
	$cdb = get_cdb();
	

	if (isset($routes[3])) {
		$id = $routes[3];
		$templateSQL = sprintf("SELECT * FROM transaction_templates WHERE id = '%s'", $id);
		$templates = getDataFromTable($templateSQL, $cdb);
		$template = $templates[0];
	} else {
		$id = 0;
		$msg = "<p class=\"alert\">Error: No template was found.</p>";
	}

		
?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/accounts.php");
			?>
            <h2>Edit this Transaction Template</h2>
            
			<?php
				// include("includes/template/subnavs/companies.php");
			?>            
            
			<div>
            	<p>Edit the form below to update this transaction template.  (Note: Dates are ignored in templates.)</p>
			</div>
			<!--<div class="right-half">
				<p>Or select from a saved template:</p>
				<?php
					$disabled = "";
					if (count($templates) == 0) {
						$disabled = "disabled";
					}
				?>
				<select name="template-list" <?php echo $disabled; ?> onChange="getValuesFromTemplate(this);">
					<option value="0">--== Template ==--</option>
					<?php
						foreach ($templates as $template) {
							printf("<option value=\"%s\">%s</option>", $template["id"], $template["name"]);
						}
					?>
				</select>
			</div>-->
						
            <form action="/transactions/templates" method="post" id="transaction-form">
            
                <?php
					include("includes/template/forms/transaction.php");
				?>
				
				<input type="hidden" name="id" id="templateId" value="<?php if ($id != 0) {echo $id;} ?>">
				
				<div>
					<label for="name">Template Name:</label>
					<input type="text" name="name" id="tempalteName" value="<?php if ($id != 0) {echo $template["name"];} ?>">
				</div>
				
				<div class="left-half">
                	<input type="submit" name="submit" value="Update Template">
				</div>
				<!--<div class="right-half">
					<div class="callout">
						<label for="name">Name:</label>
						<input type="text" name="name">
						<input type="submit" name="submit" value="Save as Template">
					</div>
				</div>-->

            </form>
            
        </div>
    
    </div>	    
	
	<?php if ($id != 0): ?>
	<script type="text/javascript">
		getValuesFromTemplate2(<?php echo $id; ?>);
	</script>
	<?php endif; ?>
        					
	
<?php include("includes/template/page_bottom.php");  ?>