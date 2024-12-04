<?php

	/* /app */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Overview";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "overview";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");


    /* THIS PAGE IS USED FOR ONE-TIME RUNNING OF PHP SCRIPTS.
    IT SHOULD NOT OTHERWISE BE CALLED DIRECTLY */

	$cdb = get_cdb();


?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <h2>Utility Script</h2>
            
            <?php
            
            /*$transSQL = "SELECT * FROM `transactions_19`"; 
            $trans = getDataFromTable($transSQL, $cdb);
            
            
            foreach ($trans as $transaction) {
				
				echo $transaction["id"];
                
                $entSQL = sprintf("SELECT * FROM entries WHERE transaction = '%s'", $transaction["id"]);
                $ents = getDataFromTable($entSQL, $cdb);
                
            	foreach ($ents as $entry) {
                    
                    $entrySQL = sprintf("UPDATE entries SET date = '%s' WHERE id = '%s'", $transaction["date"], $entry["id"]);
                    $result = runSQL($entrySQL, $cdb);
                    echo "Entry " . $entry["id"] . " result: " . $result . "<br>";
                    
                }
                
            }*/
            
            ?>
            
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");