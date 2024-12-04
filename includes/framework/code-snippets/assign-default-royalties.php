				<?php
				$itemId = $cdb->insert_id;
								
				$allocSQL = sprintf("SELECT * FROM pre_allocations WHERE artist = '%s'", $artistId);
				$alloc = getDataFromTable($allocSQL, $cdb);
				
				$allOK = true;
				foreach ($alloc as $allocation) {
					$royaltySQL = sprintf("
						INSERT INTO royalties 
						(sale_item, credit_account, debit_account, percent) 
						VALUES ('%s', '%s', '49', '%s')",
										 $itemId, $allocation["account"], $allocation["percent"]);
					$result2 = runSQL($royaltySQL, $cdb);
					if ($result2 != true) {
						$allOK = false;
					} 
				}
				if ($allOK == true) {
					// $msg .= "Default royalties added.";
				} else {
					$msg .= sprintf("<p class=\"alert\">There was an error adding the default royalties: %s</p>", $cdb->error);
				}
				?>