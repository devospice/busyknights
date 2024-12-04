# Exeltis_Chagas

Site uses PHP.  Set up a local server in the root to run.

Make sure .htaccess file is in the folder

index.php uses the URL to determine which page to load.  For example, domain.com/about will load pages/about.php.  Additional parameters can be found in the routes array.  For example domain.com/about/test/1.  $routes[1] = "about".  $routes[2] = "test".  And $routes[3] = "1".