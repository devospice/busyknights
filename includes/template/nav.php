        <aside>
        	<nav>
            	<a href="/contacts" class="button" id="nav-contacts">Contacts</a>
            	<a href="/artists" class="button" id="nav-artists">Artists</a>
            	<a href="/companies" class="button" id="nav-companies">Companies</a>
            	<a href="/accounts" class="button" id="nav-accounts">Accounts</a>
				
				<?php
					foreach ($featuredAccounts as $feature) {
						$startDate = sprintf("%s-01-01", $_SESSION["activeYear"]);
						if ($_SESSION["activeYear"] == date("Y")) {
							// This year, stop today
							$endDate = sprintf("%s-%s-%s", $_SESSION["activeYear"], date("m"), date("d"));
						} else {
							// Prior year, stop on 12/31
							$endDate = sprintf("%s-12-31", $_SESSION["activeYear"]);
						}
						$accountBalanceSQL = getBalanceSQL("debit", "credit", $startDate, $endDate, $feature["id"]);
						$accountBalances = getDataFromTable($accountBalanceSQL, $cdb);
						$accountBalance = $accountBalances[0]["balance"];
						if (!$accountBalance) {
							$accountBalance = "0.00";
						}
						
						echo "<div class=\"sub-account\">";
							printf("<div><a href=\"/accounts/view/%s\">%s</a></div><p>$%s</p>", $feature["id"], $feature["name"], $accountBalance);
						echo "</div>";
					}
				?>
				
					
				
				
                <hr>
            	<a href="/transactions" class="button" id="nav-companies">Transactions</a>
            	<a href="/transactions/add" class="button" id="nav-companies">New Transaction</a>
            	<a href="/transactions/subscription-distribution" class="button" id="nav-subscription">Subscription Distribution</a>
            	<!--<a href="/transactions/pay-digital" class="button" id="nav-pay-digital">Pay Digital</a>-->
				<a href="/accounts/payments" class="button" id="nav-payments">Payments</a>
                <hr>
            	<a href="/sale-items/" class="button" id="nav-accounts">Sale Items</a>
            	<a href="/sale-items/add" class="button" id="nav-accounts">New Sale Item</a>
            	<a href="/sale-items/sale" class="button" id="nav-accounts">Record Sale</a>
            	<a href="/sale-items/add-stock" class="button" id="nav-accounts">Add to Stock</a>
            </nav>
        </aside>
