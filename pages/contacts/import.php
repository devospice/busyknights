<?php

	/* /contacts/import */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Import Contacts";
	$keywords = "accounting, small business accounting, automatic royalty distribution";
	$activePage = "contacts";
	

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
            <h2>Import Contacts</h2>
            
			<?php
				include("includes/template/subnavs/contacts.php");
			?>            
            
            <p>Upload a CSV file in the following format:</p>
            <ul>
            	<li><span>One entry per line with no header row</span></li>
                <li><span>Each line containing a comma-delimited list of values as follows:</span><br>
                	<em><span>First Name,Last Name,Address,Address 2,City,State,Zip Code,Country,Email Address 1,Email Address 2,Email Address 3,Email Address 4,Phone (home),Phone (office),Phone (cell),Phone (alt),Fax (home),Fax (office),Company ID</span></em>
                </li>
                <li><span>If any value contains a comma enclose that entire field in double quotes, ex: "Peter, the Great."</span></li>
                <li><span>If any value contains an apostrophe, single quote, or double quote, those marks must be escaped with a back slash, ex: John Doe\'s Ave.</span></li>
                <li><span>If there is no value for a particular entry leave it blank but include the comma and don't put any extra spaces around it</span></li>
				<li><span>Company ID's can be found <a href="#" onClick="window.open('/companies/ids','CompanyIDs','resizable,height=425,width=425');">here</a>.</span></li>
            </ul>
            
            <p>Example: 	</p>
            <div class="callout">
            	<p class="small-text	 no-bottom">Buffy,Summers,1630 Revello Dr.,,Sunnydale,CA,94043,USA,buffy@vampireslayers.com,,,,434-555-6665,,,,,,<br>
Herman,Munster,1313 Mockingbird Lane,,Mockingbird Heights,CA,94952,USA,herman@themunsters.com,,,,602-555-1234,,,,,,<br>
Homer,Simpson,742 Evergreen Ter.,,Springfield,OR,97403,USA,homer@internetking.com,,,,714-555-9876,,,,,,<br>
Kelly,Bundy,9764 Jeopardy Lane,Chicago,IL,60607,USA,kelly@whoabundy.com,,,,912-555-8008,,,,,,
                </p>
            </div>
            
            <p>Upload your .CSV file:</p>            
            <form action="/contacts" method="post" enctype="multipart/form-data">
            
            	<input type="file" name="csv_file" accept=".csv">
                <input type="submit" class="default" name="submit" value="Import Contacts">

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");