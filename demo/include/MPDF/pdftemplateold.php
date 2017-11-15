<?php
$html="
<html>
<head>
<style>
table{ width: 100%; }
</style>
</head>
<body>
<table cellpadding='0' style='width:100%;margin:0px;padding:0px;font:8px times;'>
<tr>
<td style='width:50%; text-align:right;'>
	<table style='width:100%;margin:0px;padding:0px;font:8px times;' width='100%'>
	<tr>
		<td style='width:40%'></td>
		<td style='width:60%; text-align:left;vertical-align:top;' valign='top'>
			<table style='margin:0px;padding:0px;font:8px times;' valign='top'>
				<tr>
					<td>Phone</td>
					<td>$assignedphone</td>
				</tr>
				<tr>
					<td>Fax</td>
					<td>$assignedfax</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>$assignedemail</td>
				</tr>
				<tr>
					<td>Rep Name</td>
					<td>$assignedusername</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</td>
</tr>
</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>BUSINESS INFORMATION</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='2'>Legal/Corporate Name<br/>&nbsp;</td>
			<td style='width:50%;border: 1px solid #000000' colspan='3'>DBA<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='2'>Physical Address<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>Zip Code<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='2'>Mailing Address (If different from physical address)<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>Zip Code<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000'>Telephone Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>Date Business Started (mo/day/yr)<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>State of Incorporation<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='2'>Federal Tax ID<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000'>Fax Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000'>Hours of Operation<br/>&nbsp;</td>
			<td style='width:50%;border: 1px solid #000000' colspan='3'>Product/Service Sold<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='2'>Type of Entity (Select One)<br/>&#9633;Sole Proprietorship &#9633;Partnership &#9633;Corporation &#9633;LLC &#9633;Other</td>
			<td style='width:50%;border: 1px solid #000000' colspan='3'>Email Address<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:70%;border: 1px solid #000000' colspan='3'>Type of Business (Select One)<br/>&#9633;Retail &#9633;Wholesale &#9633;Business Services &#9633;Consumer Services &#9633;Restaurant/Bar &#9633;Other</td>
			<td style='width:30%;border: 1px solid #000000' colspan='2'>Website Address<br/>&nbsp;</td>
		</tr>
	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>MERCHANT/OWNER INFORMATION</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Corporate Officer/Owner Name<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Title<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Length of Ownership<br/>____Years and ____Months</td>
		</tr>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Home Address<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Zip Code<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>Ownership %<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Date of Birth(month/day/year)<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Social Security Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Home Phone Number <br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Cell Phone Number<br/>&nbsp;</td>
		</tr>
	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>PARTNER INFORMATION</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Corporate Officer/Owner Name<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Title<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Length of Ownership<br/>____Years and ____Months</td>
		</tr>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Home Address<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Zip Code<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>Ownership %<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Date of Birth(month/day/year)<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Social Security Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Home Phone Number <br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Cell Phone Number<br/>&nbsp;</td>
		</tr>
	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>BUSINESS PROPERTY INFORMATION</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Own/Lease<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Time at This Location <br/>____Years and ____Months</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Monthly Rent or Mortgage <br/>$&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Date Lease Ends(month/day/year)<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Business Landlord or Mortgage Bank<br/>&nbsp;</td>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Contact Name and/or Account No.<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Office/Mobile Number<br/>&nbsp;</td>
		</tr>
	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>BUSINESS TRADE REFERENCES</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Business Name<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Contact or Account Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Phone Number<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Fax Number<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Business Name<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Contact or Account Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Phone Number<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Fax Number<br/>&nbsp;</td>
		</tr>
	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>OTHER INFORMATION</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Current Processing Company<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000'>No. of terminal<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Average Monthly Credit Card Sales<br/>$&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Average Monthly Total Sales (Cash, Check and Credit)<br/>$&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Requested Advance Amount<br/>$&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Requested Advance Amount credit card receipts)<br/>%&nbsp;</td>
			<td style='width:60%;border: 1px solid #000000' colspan='6'>Highest of Volume Months (please circle months, or N/A if no seasonality)<br/>&#9633;Jan &#9633;Feb &#9633;Mar &#9633;Apr &#9633;May &#9633;June &#9633;July &#9633;Aug &#9633;Sep &#9633;Oct &#9633;Nov &#9633;Dec &#9633;N/A</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Prior/Current Cash Advance Company<br/>$&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Current Balance<br/>%&nbsp;</td>
			<td style='width:50%;border: 1px solid #000000' colspan='5'>Do you usually close the business during part of the year?<br/>&#9633;Yes &#9633;No &nbsp;Details:</td>
		</tr>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='5'>Any open State/Federal Tax Liens Against Business or Owner?<br/>&#9633;Yes &#9633;No &nbsp;Details:</td>
			<td style='width:50%;border: 1px solid #000000' colspan='5'>Any Lawsuits or Judgments Pending against Business or Owner?<br/>&#9633;Yes &#9633;No &nbsp;Details:</td>
		</tr>
	</table>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 0px' width='100%'>
	<tr>
		<td colspan='4'>
Applicant authorizes Your Company its assigns, agents, bank or financial institutions to obtain and investigative or consumer report from a credit bureau or a credit agency and
to investigate the references given on any other statement or data obtained from applicant.
		</td>
		</tr>
		<tr>
			<td style='width:25%'>_____________</td>
			<td style='width:25%'>_____________</td>
			<td style='width:25%'>_____________</td>
			<td style='width:25%'>_____________</td>
		</tr>
		<tr>
			<td colspan='4' style='height:4px;'></td>
		</tr>
		<tr>
			<td style='width:25%'>Applicant's Signature</td>
			<td style='width:25%'>Date</td>
			<td style='width:25%'>Co-Signature</td>
			<td style='width:25%'>Date</td>
		</tr>
		</table>
</body>
</html>
";
?>
