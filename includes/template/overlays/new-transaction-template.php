<div class="overlay" id="new-transaction-template-overlay" data-selectlist="template-list">
	
	<div class="account-content">
		<a class="close-box" onClick="closeOverlay('new-transaction-template-overlay');">X</a>

        <h2>New Transaction Template</h2>
		<p>Fill out the form below to create a new transaction template.</p>
		<form method="put" onSubmit="newInlineTransactionTemplate(this); return false;" id="new-transaction-template-overlay-form">
		
			<?php
				unset($account);
				include("includes/template/forms/transaction.php");
			?>
            
            <label for="name">Name:</label>
            <input type="text" name="name">

			<input type="submit" name="submit" value="Create Transaction Template">
			<input type="button" name="cancel" value="Cancel" onClick="closeOverlay('new-transaction-template-overlay');">


		</form>

	</div>
	
</div>