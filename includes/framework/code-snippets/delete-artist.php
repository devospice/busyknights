			<?php
			
            // Update main form values
			$deleteSQL = sprintf("DELETE FROM artists WHERE id = %s", $_POST["id"]);
			$result = runSQL($deleteSQL, $cdb);
					
			if ($result == true) {
				$msg = "<p class=\"alert\">Artist successfully deleted.</p>";
			} else {
				$msg = sprintf("<p class=\"alert\">There was an error deleting your artist: %s</p>", $cdb->error);
			}

			?>