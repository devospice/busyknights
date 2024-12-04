						<div>
							<?php
								$artistsSQL = "SELECT * FROM artists ORDER BY name";
								$artists = getDataFromTable($artistsSQL, $cdb);
							?>
							<select name="artist">
								<option value="0">--== Select Artist ==--</option>
								<?php
									foreach ($artists as $artist) {
										printf("<option value=\"%s\">%s</option>", $artist["name"], $artist["name"]);
									}
								?>
							</select>
						</div>
						<div>
							<label for="number_of_tracks" class="inline">Number of tracks by this artist:</label>
							<input type="number" name="number_of_tracks" width="2">
							<input type="button" class="small" name="add" value="Add" onClick="AddRoyaltyArtist();">
						</div>	
						<div>
							<table cellpadding="0" cellspacing="0" border="0" id="artist-list-table">
								<thead>
									<th>Artist</th>
									<th>Number of tracks</th>
									<th>Delete</th>
								</thead>
								<tr><td></td></tr>
							</table>
						</div>

						<hr>