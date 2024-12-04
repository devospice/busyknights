			<?php
			
            // Update main form values
			$deleteSQL = sprintf("DELETE FROM companies WHERE id = %s", $_POST["id"]);
			$result = runSQL($deleteSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Company successfully deleted.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error deleting your company: %s</p>", $cdb->error);
			}

			?>