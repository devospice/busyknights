<?php

	/* /contacts/import */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Import Artists";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "artists";
	

	include("includes/template/page_top.php");
	include("includes/framework/login-check.php");

?>

<div id="container">

	<?php include("includes/template/header.php"); ?>	
    
    <div id="content-container">
    	
		<?php include("includes/template/nav.php"); ?>
                
        <div id="content-area">
        	
            <?php
				// include("includes/template/searches/companies.php");
			?>
            <h2>Import Artists</h2>
            
			<?php
				include("includes/template/subnavs/artists.php");
			?>            
            
			<p><strong>This feature creates a new artist, contact, account, and assigns payment information.</strong></p>
			
            <p>Upload a CSV file in the following format:</p>
            <ul>
            	<li><span>One entry per line with no header row</span></li>
                <li><span>Each line containing a comma-delimited list of values as follows:</span><br>
                	<em><span>Artist Name, Artist Website, Contact First Name, Contact Last Name, Contact Address 1, Contact Address 2, Contact City, Contact State, Contact Zip, Contact Phone, Contact Email, Pay by Paypal (0 or 1), Paypal Email, Paypal Demonination (USD, etc), Check Payable To, Check Address 1, Check Address 2, Check City, Check State, Check Zip, Check Country</span></em>
                </li>
                <li><span>If any value contains a comma enclose that entire field in double quotes, ex: "Peter, the Great."</span></li>
                <li><span>If any value contains an apostrophe, single quote, or double quote, those marks must be escaped with a back slash, ex: John Doe\'s Ave.</span></li>
                <li><span>If there is no value for a particular entry leave it blank but include the comma and don't put any extra spaces around it</span></li>
            </ul>
            
            <p>Example: 	</p>
            <div class="callout">
            	<p class="small-text	 no-bottom">Devo Spice,https://www.devospice.com,Tom,Rockwell,3 Cliffside Court,,Hamburg,NJ,07419,201-317-2732,devospice@gmail.com,1,devospice@gmail.com,USD,,,,,,,<br>
					Art Paul Schlossar,,Art Paul,Schlosser,615 Howard Plae #207,,Madison,WI,53703,,imaprince2001@yahoo.com,0,,USD,Art Paul Schlosser,2019 Sherman Ave #11,,Madison,Wisconsin,53704,USA
                </p>
            </div>
            
            <p>Upload your .CSV file:</p>            
            <form action="/artists" method="post" enctype="multipart/form-data">
            
            	<input type="file" name="csv_file" accept=".csv">
                <input type="submit" class="default" name="submit" value="Import Artists">

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");