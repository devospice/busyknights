            <div class="section-nav" id="subnav-main">
				<p><a href="/accounts/edit/<?php echo $account["id"] ?>" class="button">Edit this Account</a>
                <a href="/transactions/add/<?php echo $account["id"] ?>" class="button">New Transaction</a>
            	<a href="/payments/add/<?php echo $account["id"] ?>" class="button">Add Payment Info</a>
            	
				<?php if ($account["list_on_left"] == true): ?>
					<a href="javascript:removeFromNav('<?php echo $account["id"] ?>');" class="button">Remove from Left Nav</a>
				<?php else: ?>
					<a href="javascript:addToNav('<?php echo $account["id"] ?>');" class="button">Add to Left Nav</a>
				<?php endif; ?>
					
              	<a href="/accounts/edit-categories" class="button">Account Categories</a></p>
				<p><a href="/accounts/view-asset">Asset</a> | <a href="/accounts/view-equity">Equity</a> | <a href="/accounts/view-expense">Expense</a> | <a href="/accounts/view-liability">Liability</a> | <a href="/accounts/view-revenue">Revenue</a> | <a href="/accounts/view-all">All</a></p>
          </div>
            <div class="section-nav locked" id="subnav-locked">
				<p><a href="/accounts/edit/<?php echo $account["id"] ?>" class="button">Edit this Account</a>
                <a href="/transactions/add/<?php echo $account["id"] ?>" class="button">New Transaction</a>
            	<a href="/payments/add/<?php echo $account["id"] ?>" class="button">Add Payment Info</a>
              	<a href="/accounts/edit-categories" class="button">Account Categories</a></p>
				<p><a href="/accounts/view-asset">Asset</a> | <a href="/accounts/view-equity">Equity</a> | <a href="/accounts/view-expense">Expense</a> | <a href="/accounts/view-liability">Liability</a> | <a href="/accounts/view-revenue">Revenue</a> | <a href="/accounts/view-all">All</a></p>
            </div>
