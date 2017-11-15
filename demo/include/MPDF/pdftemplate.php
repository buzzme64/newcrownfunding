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
<td style='width:50%'><img src='http://104.236.176.41/vtiger/demo/include/MPDF/logopdf.png' alt='Crown Funding Group' style='width:220px;height:77px;'></td>
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
			<td style='width:50%;border: 1px solid #000000' colspan='6'>Legal/Corporate Name<br/>&nbsp;</td>
			<td style='width:50%;border: 1px solid #000000' colspan='6'>DBA<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='2'>Physical Address<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000' colspan='3'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Zip Code<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Telephone Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Date of Incorporation<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Length of Ownership:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000'>Website:<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Fax Number<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Hours of Operation<br/>&nbsp;</td>
			<td style='width:50%;border: 1px solid #000000' colspan='6'>Federal Tax ID<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:50%;border: 1px solid #000000' colspan='6'>Entity Type  (Select One)<br/>&#9633;Sole Proprietorship &#9633;Partnership &#9633;Corporation &#9633;LLC &#9633;Other</td>
			<td style='width:50%;border: 1px solid #000000' colspan='6'>Email Address<br/>&nbsp;</td>
		</tr>
		<tr>
		    <td style='width:20%;border: 1px solid #000000' colspan='3'>Type of Business<br/>&nbsp;</td>
			<td style='width:60%;border: 1px solid #000000' colspan='6'>Property is:<br/>&#9633;Owned &#9633;Rented &#9633;<br />Landlord/Bank</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Product/Service Offered:<br/>&nbsp;</td>
		</tr>
		<tr>
		    <td style='width:30%;border: 1px solid #000000' colspan='3'>Do You Currently Have a Cash Advance:<br/>&#9633;Yes &#9633;No &#9633;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>With Which Company:<br/>&#9633;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Balance:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Credit Score:<br/>&nbsp;</td>
		</tr>
		<tr>
		    <td style='width:70%;border: 1px solid #000000' colspan='6'>Last 3 months Average Deposit Volume:<br/>&#9633;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Peak Months:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Average Annual Gross Sales:<br/>&nbsp;</td>
		</tr>

	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>Business Owner Information</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>First Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='4'>Last Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='4'>Owner %</td>
		</tr>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Home Address<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='4'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000' colspan='2'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Zip Code<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>DOB:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='4'>SSN<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Home#:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Cell#<br/>&nbsp;</td>
		</tr>
	</table>
	<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>Business Partner Information</b></div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>First Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='4'>Last Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='4'>Owner %</td>
		</tr>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Home Address<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='4'>City<br/>&nbsp;</td>
			<td style='width:10%;border: 1px solid #000000' colspan='2'>State<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>Zip Code<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:20%;border: 1px solid #000000' colspan='2'>DOB:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='4'>SSN<br/>&nbsp;</td>
			<td style='width:20%;border: 1px solid #000000' colspan='3'>Home#:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Cell#<br/>&nbsp;</td>
		</tr>
	</table>
<div style='height:10px;'></div><div style='width:100%;margin:0px;padding:0px;font:10px times;'><b>Business Trade References</b><br>(please list 3)/div>
	<table cellspacing='0' cellpadding='0' style='width:100%;margin:0px;padding:0px;font:10px times;border: 1px solid #000000' width='100%'>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Business Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Contact Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Phone#:<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Business Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Contact Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Phone#:<br/>&nbsp;</td>
		</tr>
		<tr>
			<td style='width:40%;border: 1px solid #000000' colspan='4'>Business Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Contact Name:<br/>&nbsp;</td>
			<td style='width:30%;border: 1px solid #000000' colspan='3'>Phone#:<br/>&nbsp;</td>
		</tr>
	</table>


	<table cellspacing='0' cellpadding='0' style='width:100%;margin-top:20px;padding:0px;font:20px times;border: 0px' width='100%'>
	<tr>
		<td colspan='4' style='font:20px'>
By signing below, Applicant authorizes Crown Funding Group, it’s assigns, agents, and affiliates to obtain a consumer report from a credit bureau or credit 
agency and to investigate the references given on any other statement or data obtained from the Applicant.
		</td>
		</tr>
		<tr></tr>
		<tr>
			<td style='width:50%'>_____________</td>
			<td style='width:50%'>_____________</td>
			<td style='width:50%'>_____________</td>
			<td style='width:50%'>_____________</td>
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
