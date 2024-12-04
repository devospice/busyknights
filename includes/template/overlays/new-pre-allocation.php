<div class="overlay" id="new-pre-allocation-overlay">
	
	<div class="account-content">
		<a class="close-box" onClick="closeOverlay('new-pre-allocation-overlay');">X</a>

        <h2>Add a Pre-Allocation</h2>
		<p>Fill out the form below to add a new default pre-allocation for this artist.</p>
		<form method="post" action="/artists/view/<?php echo $artistId; ?>" id="new-pre-allocation-form">
		
			<?php
				include("includes/template/forms/pre-allocation.php");
			?>
			<input type="submit" name="submit" value="Add Pre-Allocation">
			<input type="button" name="cancel" value="Cancel" onClick="closeOverlay('new-pre-allocation-overlay');">


		</form>

	</div>
	
</div>


<div class="overlay" id="edit-pre-allocation-overlay">
	
	<div class="account-content">
		<a class="close-box" onClick="closeOverlay('edit-pre-allocation-overlay');">X</a>

        <h2>Edit this Pre-Allocation</h2>
		<p>Fill out the form below to edit the default pre-allocation for this artist.</p>
		<form method="post" action="/artists/view/<?php echo $artistId; ?>" id="edit-pre-allocation-form">
		
			<input type="hidden" name="id" value="">  <!--NOTE: Must be first item in form here.-->
			<?php
				include("includes/template/forms/pre-allocation.php");
			?>
			<input type="submit" name="submit" value="Update Pre-Allocation">
			<input type="button" name="cancel" value="Cancel" onClick="closeOverlay('edit-pre-allocation-overlay');">


		</form>

	</div>
	
</div>