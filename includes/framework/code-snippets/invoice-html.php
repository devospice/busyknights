	<table width="650" cellpadding="0" cellspacing="0" border="0" style="border-collapse: collapse;">
		<!--Header-->
		<tr>
			<td width="630" colspan="2" style="padding: 20px 0 0 20px;"><img src="https://fidim.busyknights.com/assets/images/logos/fidim.jpg"></td>
		</tr>
		<tr>
			<td width="305" style="padding-left: 20px;">
				<p style="font-family: arial; font-size: 16px; line-height: 19px; color: #000000; margin: 0 0 10px; font-weight: bold;">FIDIM Interactive, LLC<br>
				P.O. Box 58<br>
				Stockholm, NJ 07460-0058</p>
			</td>
			<td width="295" style="padding-left: 10px; padding-right: 20px; background-color: #DDEEEE;">
				<p style="font-family: arial; font-size: 16px; line-height: 19px; color: #000000; margin: 0 0 10px;"><strong>Account:</strong> <?php echo $account["name"]; ?><br>
				<strong>Invoice Number: </strong><?php echo $invoiceNum; ?><br>
				<?php
					// format date strings
					$startTime = strtotime($startDate);
					$endTime = strtotime($endDate);
					$start = date("M j, Y", $startTime);
					$end = date("M j, Y", $endTime);
				?>
				<strong>Date Range:</strong> <?php printf("%s&ndash;%s", $start, $end); ?> </p>			
			</td>
		</tr>
		<tr>
			<td colspan="2" width="630" height="5" bgcolor="#000000" style="mso-line-height-rule: exactly; padding-left: 20px;"></td>
		</tr>
		<!--Opening Balance-->
		<tr>
			<td width="305" style="padding-left: 20px;">
				<p style="font-family: arial; font-size: 16px; line-height: 19px; color: #000000; margin: 10px 0; font-weight: bold;">Opening Balance:</p>
			</td>
			<td width="305" style="padding-right: 20px; background-color: #DDEEEE;">
				<p style="font-family: arial; font-size: 16px; line-height: 19px; color: #000000; margin: 10px 0; font-weight: bold; text-align: right;"><?php echo $openingBalance; ?></p>			
			</td>
		</tr>
		<tr>
			<td colspan="2" width="650" height="1" bgcolor="#000000" style="mso-line-height-rule: exactly;"></td>
		</tr>
		<!--Transactions-->
		<tr>
			<td colspan="2" width: "650">
				<?php 
					include("includes/template/partials/entries-table-report.php"); 
				?>
			</td>
		</tr>
		<tr>
			<td width="315" style="padding-left: 20px;">
				<p style="font-family: arial; font-size: 16px; line-height: 19px; color: #000000; margin: 10px 0; font-weight: bold;">Closing Balance:</p>
			</td>
			<td width="315" style="padding-right: 20px; background-color: #DDEEEE;">
				<p style="font-family: arial; font-size: 16px; line-height: 19px; color: #000000; margin: 10px 0; font-weight: bold; text-align: right;"><?php echo $closingBalance; ?></p>			
			</td>
		</tr>
		<tr>
			<td colspan="2" width="650" height="1" bgcolor="#000000" style="mso-line-height-rule: exactly;"></td>
		</tr>
		<!--Footer-->
		<tr>
			<td colspan="2" width="650" style="padding: 20px 0;">
				<p style="font-family: arial; font-size: 14px; line-height: 18px; color: black; margin: 0 0 18px; text-align: center;">Please pay within 30 days of the date indicated above.<br>
					Make checks or money orders payable to "FIDIM Interactive, LLC."<br>
					PayPal payments can be sent to "support@fidim.com."
				</p>
				<p style="font-family: arial; font-size: 14px; line-height: 18px; color: black; margin: 0; text-align: center; font-weight: bold;">Thank you for your business!
				</p>
			</td>
		</tr>
		<tr>
			<td width="315" style="padding-left: 20px;"></td>
			<td width="315" style="padding-right: 20px;">
				<img src="/assets/images/logos/tom_sig.jpg" width="225" height="69" style="display: block; border-bottom: 1px solid black; margin-bottom: 10px;">
				<p style="font-family: arial; font-size: 14px; line-height: 18px; color: #000000; margin: 0; font-weight: bold;">
					Thomas Rockwell<br>
					FIDIM Interactive, LLC
				</p>			
			</td>
		</tr>
	</table>