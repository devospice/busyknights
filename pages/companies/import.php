<?php

	/* /companies/import */
	$pageTitle = $_SESSION["company"]["name"];
	$description = $_SESSION["company"]["name"] . " - Import Companies";
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
            <h2>Import Companies</h2>
            
			<?php
				include("includes/template/subnavs/companies.php");
			?>            
            
            <p>Upload a CSV file in the following format:</p>
            <ul>
            	<li><span>One entry per line with no header row</span></li>
                <li><span>Each line containing a comma-delimited list of values as follows:</span><br>
                	<em><span>Company Name,Address,Address 2,City,State,Zip Code,Country,Web Site,Email Address 1,Email Address 2,Phone 1,Phone 2,Fax,Notes</span></em>
                </li>
                <li><span>If any value contains a comma enclose that entire field in double quotes, ex: "Apple, Inc."</span></li>
                <li><span>If any value contains an apostrophe, single quote, or double quote, those marks must be escaped with a back slash, ex: Indexing the world\'s information</span></li>
                <li><span>If there is no value for a particular entry leave it blank but include the comma and don't put any extra spaces around it<br>
            </ul>
            
            <p>Example: 	</p>
            <div class="callout">
            	<p class="small-text	 no-bottom">Amazon,410 Terry Ave. North,,Seattle,WA,98109,USA,http://www.amazon.com,support@amazon.com,,(206) 266-1000,,,Free 2-day shipping with Prime<br>
"Apple,Inc",1 Infinite Loop,,Cupertino,CA,95014,USA,http://www.apple.com,info@apple.com,,(408) 606-5775,,,Makers of iPhone and Macintosh computers<br>
Facebook,1 Hacker Way,,Menlo Park,CA,94025,USA,http://www.facebook.com,support@facebook.com,,(650) 853-1300,,,Over 2 billion monthly active users<br>
Google,111 8th Ave,,New York,NY,10011,USA,http://www.google.com,support@google.com,,(212) 565-0000,,,Indexing the world\'s information<br>
Microsoft,1 Microsoft Way,,Redmond,WA,98052,USA,http://www.microsoft.com,support@microsoft.com,,(425) 882-8080,,,Makers of the Surface computers,XBox,and Office
                </p>
            </div>
            
            <p>Upload your .CSV file:</p>            
            <form action="/companies" method="post" enctype="multipart/form-data">
            
            	<input type="file" name="csv_file" accept=".csv">
                <input type="submit" class="default" name="submit" value="Import Companies">

            </form>
            
        </div>
    
    </div>	    	
        					
	
<?php include("includes/template/page_bottom.php");