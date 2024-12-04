            <div class="section-nav flex" id="subnav-main">
				<div>
					<a href="/transactions/add" class="button">Add Transaction</a>
					<a href="/transactions/subscription-distribution" class="button">Distribute Subscription Revenue</a>
					<a href="/transactions/templates" class="button">Edit Templates</a>
				</div>
				<div>
					<h3 class="transactions-nav">
						<span class="nav">&#9664; <a href="/transactions?ts=<?php echo $lastmonth; ?>">Previous Month</a> | <a href="/transactions?ts=<?php echo $nextmonth; ?>">Next Month</a> &#9654;</span>
					</h3>
				</div>
            </div>
            <div class="section-nav flex locked" id="subnav-locked">
				<div>
					<a href="/transactions/add" class="button">Add Transaction</a>
					<a href="/transactions/subscription-distribution" class="button">Distribute Subscription Revenue</a>
					<a href="/transactions/templates" class="button">Edit Templates</a>
				</div>
				<div style="padding-right: 25px;">
					<h3 class="transactions-nav">
						<span class="nav">&#9664; <a href="/transactions?ts=<?php echo $lastmonth; ?>">Previous Month</a> | <a href="/transactions?ts=<?php echo $nextmonth; ?>">Next Month</a> &#9654;</span>
					</h3>
				</div>
           </div>
