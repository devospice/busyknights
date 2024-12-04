<?php

// Returns an array of associative arrays of the data obtained by the $sql query, or false.
function getDataFromTable($sql, $db = "") {
	
	// global $GLOBAL;
	if (!$db) {
		$db = get_db();
	}
	
	// echo $sql."<br>";
	if ($result = $db->query($sql)) {
		$ar = array();
		while ($row = $result->fetch_assoc()) 
		{
			$ar[] = $row;
		}
		return $ar;
	} else {
		return $result;
	}

}


// Returns a generator object that yeilds the database results one row at a time
function yeildDataFromTable ($sql, $db = "") {
	
	// global $GLOBAL;
	if (!$db) {
		$db = get_db();
	}
	
	// echo $sql."<br>";
	if ($result = $db->query($sql)) {
		while ($row = $result->fetch_assoc()) {
			yield $row;
		} 
	} else {
		return $result;
	}
	
}


// Returns the specified data from the specified table for the given ID.
function getData ($desiredData, $whichTable, $itemID) {

	$query = "SELECT $desiredData FROM $whichTable WHERE id=$itemID";
	$dataArray = getDataFromTable($query);
	if (count($dataArray) > 0) {
		$data = $dataArray[0];
		$finalData = $data[$desiredData];
		return $finalData;
	} else {
		return 0;
	}
	
}



function setActiveYear($yearString) {  
		
	$year2 = substr($yearString, 2);
	$_SESSION["accountsTable"] = "accounts_" . $year2;
	$_SESSION["transactionsTable"] = "transactions_" . $year2;
	$_SESSION["entriesTable"] = "entries_" . $year2;
	$_SESSION["activeYear"] = $yearString;
	
	// echo "Accounts table set to " . $accountsTable . " from setActiveYear<br>";
	// echo "Transactions table set to " . $transactionsTable . " from setActiveYear<br>";
				
}


// Returns the size of the given file in bytes
function remoteFileSize($fileURL) {

	$remoteFile = $fileURL;
	$ch = curl_init($remoteFile);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
	$data = curl_exec($ch);
	curl_close($ch);
	if ($data === false) {
	  return 0;
	  exit;
	}
	
	$contentLength = 'unknown';
	if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
	  $contentLength = (int)$matches[1];
	}
	
	return $contentLength;
	
}



// Returns the result of running the given $sql on the main database.
function runSQL($sql, $db = "") {

	// global $GLOBAL;
	if (!$db) {
		$db = get_db();
	}
	$result = $db->query($sql);
	
	return $result;
	
}

// Returns the ID from the most recent MYSQL action on the database.
function getLastID() {

	$db = get_db();
	$result = $db->insert_id;
	
	return $result;
	
}


// Pulls all non empty, non ID, and non submit keys and values from the given $postVars.  If $returnArray is true, 
// it returns an array of arrays.  If false, it implodes the arrays into strings suitable for a SQL call.
// Use false for INSERT calls and true to pass the result to createUpdateSQL
function getValuesFromForm ($postVars, $returnArray) {

		$keys = array_keys($postVars);
		$valueArray = array();
		$keyArray = array();		
		$db = get_db();
		
		// Remove empty fields
		foreach ($keys as $key) {
			if (($postVars[$key] != "") && ($key != "submit") && ($key != "id")) {
				$keyArray[] = $key;
				$value = sprintf("\"%s\"", $db->real_escape_string($postVars[$key]));
				$valueArray[] = $value;
			}
		}
		
		if ($returnArray == false) {
			$keyString = implode(", ", $keyArray);
			$valueString = implode(", ", $valueArray);

			$returnArray = array($keyString, $valueString);
		} else {
			$returnArray = array($keyArray, $valueArray);
			//$returnArray = array("hi");
		}
				
		return $returnArray;

}

// Given a result from getValuesFromForm(vars, true) creates the necessary "SET SOMETHING = SOMETHING" string for an UPDATE call.
function createUpdateSQL ($valuesFromForm) {
	
	$keys = $valuesFromForm[0];
	$values = $valuesFromForm[1];
	
	$length = count($keys);
	$sql = "SET ";
	for ($i=0; $i<$length; $i++) {
		if ($i == $length - 1) {
			$comma = "";
		} else {
			$comma = ", ";
		}
		$sql = $sql . sprintf("%s = %s%s", $keys[$i], $values[$i], $comma);
	}
	
	return $sql;
	
}


// Returns the SQL to get the accounts opening balance.  Arguments are either "credit" or "debit" with "c - d" being applied to the formula
function getBalanceSQL ($c, $d, $startDate, $endDate, $accountId) {
	$sql = sprintf("SELECT a.starting_balance + COALESCE(e.balance_change, 0) as balance 
						FROM `%s` a
					LEFT JOIN (
						SELECT account, SUM(COALESCE(%s, 0) - COALESCE(%s, 0)) as balance_change
						FROM `%s`
						WHERE date >= '%s' AND date <= '%s'
						GROUP BY account ) e
					ON a.id = e.account
					WHERE
					a.id = '%s'", 
					$_SESSION["accountsTable"], $c, $d, $_SESSION["entriesTable"],
					$startDate, $endDate, $accountId);
	
	return $sql;
}


// Resizes the given image to the new width and height and returns a new image.
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file); 
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}


// Formats the given string to lowercase and removes all spaces and special characters.
// CAREFUL!  This function also removes dots.
function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s\.-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

// Formats the given song title to covert spaces to underscores and remove special characters, and adds ".mp3" to the end.
function sanitizeSongTitle($string) {
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-zA-Z0-9_\s\.-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and dashes to underscores
    $string = preg_replace("/[\s-]/", "_", $string);
    
	$string = $string . ".mp3";
	return $string;
	
}


// returnJSON
// Converts the given array to JSON and then echoes it to JSONP.
function returnJSON ($arr) { 
		
	$arr = json_encode($arr);
	//echo $_GET["jsoncallback"] . "(" . $arr . ")" ;
	echo $arr;
}


?>