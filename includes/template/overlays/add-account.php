<div class="overlay" id="add-account-overlay" data-selectlist="">
	
	<div class="account-content">
		<a class="close-box" onClick="closeOverlay('add-account-overlay');">X</a>

        <h2>Add an Account</h2>
		<p>Fill out the form below to add a new account.</p>
		<form method="put" onSubmit="newInlineAccount(this); return false;" id="add-account-overlay-form">
		
			<?php
				unset($account);
				include("includes/template/forms/account.php");
			?>
			<input type="submit" name="submit" value="Add Account">
			<input type="button" name="cancel" value="Cancel" onClick="closeOverlay('add-account-overlay');">


		</form>

	</div>
	
</div>