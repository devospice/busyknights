<?php
	$pageTitle = "404 - Page not found";
	$description = "Description text here";
	$keywords = "Keywords here";
	$activePage = "partners";
	
	include("includes/template/page_top.php");
?>

<div id="container">
		
					
		<h2>404 - Page not found</h2>
        
        <?php
		echo "routes[0] = " . $routes[0] . "<br>";
		echo "routes[1] = " . $routes[1] . "<br>";
		echo "routes[2] = " . $routes[2] . "<br>";
		echo "routes[3] = " . $routes[3] . "<br>";
		echo "filepath = " . $filePath . "<br>";

		echo "file exists: " . file_exists("pages/".$filePath) . "<br>";
		echo "root: " . SITE_ROOT . "<br>";
		echo "test path: " . $testPath;
	
	?>
					
	
<?php include("includes/template/page_bottom.php");