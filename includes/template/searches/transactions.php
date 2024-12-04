<?
	$accountsSQL = sprintf("SELECT name, id FROM %s ORDER BY name", $_SESSION["accountsTable"]);
	$accounts = getDataFromTable($accountsSQL, $cdb);
?>

<h3>Search Transactions</h3>
<form id="transaction-search" action="/transactions/search" method="post">
	<div class="left-half">
		<label for="account">Account:</label>
		<select name="account">
			<option value="0">--== SELECT ACCOUNT ==--</option>
			<?php
				foreach ($accounts as $account) {
					$selected = "";
					if (isset($entries)) {
						if ($account["id"] == $entries[0]["account"]) {
							$selected = "selected";
						}
					} else {
						if (isset($routes[3])) {
							if ($account["id"] == $routes[3]) {
								$selected = "selected";
							}
						}
					}
					printf("<option value=\"%s\" %s>%s</option>", $account["id"], $selected, $account["name"]);
				}
			?>
		</select>
	</div>
	<div class="right-half">
		<label for="date">Date:</label>
		<input type="date" name="date">
	</div>
	<input type="text" name="query">
	<input type="submit" name="submit" value="Search">
</form>
