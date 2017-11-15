<?php
require_once('modules/Emails/mail.php');
require_once('include/MPDF/mpdf.php');

if (isset($_REQUEST['leadid'])){
	
	if ($current_user->user_name!="admin"){
		$res=mysql_query ("update vtiger_leaddetails set processed='1' where leadid='".$_REQUEST['leadid']."'");
	}
	
	$res=  mysql_query("select * from vtiger_leaddetails ld 
	left join vtiger_leadscf lcf on ld.leadid=lcf.leadid
	left join vtiger_leadsubdetails lsd on ld.leadid=lsd.leadsubscriptionid
	left join vtiger_crmentity crm on ld.leadid=crm.crmid
	where ld.leadid='".(int)$_REQUEST['leadid']."'");
	if (mysql_num_rows($res)==1){
		$result = $adb->query("select user_name, email1, email2 from vtiger_users where id=1");
		$from_email = $adb->query_result($result,0,'email1');
		$from_name  = $adb->query_result($result,0,'user_name');
		
		//$smownerid=$current_user->id;
		
		$data=array();
		$newfax="@efaxsend.com";
		while ($row=  mysql_fetch_array($res, MYSQL_ASSOC)) $data=$row;
		extract($data, EXTR_OVERWRITE);
		
		$res=  mysql_query("select phone_work assignedphone, phone_fax assignedfax, email1 assignedemail, concat(first_name,' ',last_name) assignedusername, last_name, first_name, title, department from vtiger_users where id='".$smownerid."'");
		while($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
			$assignedphone=$row['assignedphone'];
			$assignedfax=$row['assignedfax'];
			$assignedemail=$row['assignedemail'];
			$assignedusername=$row['assignedusername'];
			$assignedlastname=$row['last_name'];
			$assignedfirstname=$row['first_name'];
			$assignedtitle=$row['title'];
			$assigneddepartment=$row['department'];
		}
		if ($assignedphone=="") $assignedphone="877-000-0000";
		if ($assignedfax=="") $assignedfax="212-800-1200";
		if ($assignedemail=="") $assignedemail="info@gavnasites.com";
		$emailbody="<p class='western' lang='en-US'>
	Hi $firstname,</p>
	<div style='width: 30%;font-size: xx-small;'>
<p style='font-size: xx-small;' lang='en-US'>
	It was a pleasure speaking with you earlier. As I mentioned, we are a funding bank and not a broker. As a direct lending bank, we have lower rates and more repayment options than our competitors. We can fund in 24-48 hours once the signed agreement is received from you. Please call me with any and ALL questions you have at any time as I am easily reached at the numbers on my e-card below.</p>

<p class='western' lang='en-US'>
	Please send in the attached application along with:</p>

		<p class='western' lang='en-US'>
			Your 6 most recent bank statements.</p>
	
		<p class='western' lang='en-US'>
			Your 6 most recent credit card processing statements (if applicable)</p>
	
<h5> Business Documentation for a traditional Bank Loan: </h5>


		<p class='western' lang='en-US'>
			2014 Business Tax Return (if available)</p>
	
		<p class='western' lang='en-US'>
			2013 Business Tax Return</p>
	
		<p class='western' lang='en-US'>
			Current Accounts Receivable and Accounts Payable Aging Reports</p>
	
		<p class='western' lang='en-US'>
			Most Recent Personal Tax Return</p>
	
		<p class='western' lang='en-US'>
    	Most Recent Profit and Loss Statement and Balance Sheet</p>
	

<p class='western' lang='en-US'>
	We will process the application immediately and get you the loan offer that will meet your financial needs. I am looking forward to working with you and being a part of your continued success!</p>

<p class='western' lang='en-US'>
<font size='3'><i><b>$assignedfirstname $assignedlastname - $assignedtitle</b></i></font><br />
<span lang='en-US'><i><b>$assigneddepartment</b></i></span>

<span lang='en-US'>Toll Free: </span><font color='#000080'><span lang='zxx'><u><a href='tel:877-000-0000' target='_blank'><span lang='en-US'>877-000-0000</span></a></u></span></font>

	<span lang='en-US'>Direct : </span><font color='#000080'><span lang='zxx'><u><a href='tel:$assignedphone' target='_blank'><span lang='en-US'>$assignedphone</span></a></u></span></font>

	<span lang='en-US'>Fax: </span><font color='#000080'><span lang='zxx'><u><a href='tel:$assignedfax' target='_blank'><span lang='en-US'>$assignedfax</span></a></u></span></font>

	Email: <font color='#000080'><span lang='zxx'><u><a href='mailto:$assignedemail' target='_blank'>$assignedemail</a></u></span></font>

	<font color='#000080'><span lang='zxx'><u><a href='http://www.yoursite.com/' target='_blank'>www.yoursite.com</a></u></span></font>
</p> </div>";

		
		$filename = dirname(dirname(__DIR__))."/include/MPDF/application".$_REQUEST['leadid'].".pdf";
		if (count($_POST)>0){
			if (!file_exists($filename)){
				require_once('include/MPDF/pdftemplate.php');
				$mpdf = new mPDF('utf-8', 'A4', '8', '', 20, 10, 7, 7, 10, 10);
				$mpdf->charset_in = 'utf-8';
				$mpdf->SetDisplayMode('fullpage');
				$mpdf->WriteHTML($html);
				$mpdf->Output($filename);
			}
			send_mail('Leads',$_POST['to'],$assignedusername,$assignedemail,$_POST['subject'],$_POST['emailbody'], $_POST['cc'], $_POST['bcc'],'','','',array("application.pdf"=>$filename));
			
			$res=  mysql_query("select max(crmid) maxcrm from vtiger_crmentity");
			while($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $maxcrm=$row['maxcrm'];
			$maxcrm++;
			$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
				description,createdtime,modifiedtime,viewedtime,status,
				version,presence,deleted)values(
				'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
				'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
				0,1,0),('".($maxcrm+1)."',1,'".$current_user->id."','1','Calendar',
				'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
				0,1,0)")or die("insert into crmentity ".  mysql_errno().". ".  mysql_error());

			$res=  mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
				due_date,time_start,time_end,sendnotification,duration_hours,
				duration_minutes,status,eventstatus,priority,location,
				notime,visibility,recurringtype) values(
				'".$maxcrm."','Sending application to the client.', NULL,'Application sending','".date('Y-m-d')."',
				'".date('Y-m-d')."','10:00','11:00',0,0,
				'',NULL,'Held','','',
				0,'private',''),
				('".($maxcrm+1)."','Waiting for a signed application from the client.',NULL,'Awaiting application','".date('Y-m-d')."',
				'".date('Y-m-d')."','11:00','11:30',0,0,
				'',NULL,'Not Held','','',
				0,'private','')") or die("insert into activity ".mysql_errno.". ".mysql_error());

			$res=  mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$_REQUEST['leadid']."','".$maxcrm."'),('".$_REQUEST['leadid']."','".($maxcrm+1)."')");

			$res=mysql_query("update vtiger_crmentity_seq set id='".($maxcrm+1)."'");

			//$res=  mysql_query("update vtiger_leaddetails set leadstatus='2. App Out' where leadid='".$_REQUEST['leadid']."'"); BT
			
			$res=  mysql_query("update vtiger_leaddetails set leadstatus='2. App Out' where leadid='".$_REQUEST['leadid']."' and leadstatus NOT LIKE '%7. Funded%'");
			
			$res=  mysql_query("insert into  vtiger_leads_appsout set leadid='".$_REQUEST['leadid']."'");
			
			
			$_REQUEST['leadstatus']="2. App Out";
			$return_id=$_REQUEST['leadid'];
			require_once('modules/Leads/createactivity.php');
			
			echo "<html><script type='text/javascript'>window.opener.document.location.reload();</script><body><h3>Email was sent</h3></body></html>";
			if (file_exists($filename)) {
				chmod($filename, 777);
				unlink ($filename);
			}
			exit;
		}
		require_once('include/MPDF/pdftemplate.php');
		$mpdf = new mPDF('utf-8', 'A4', '8', '', 20, 10, 7, 7, 10, 10);
		$mpdf->charset_in = 'utf-8';
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		//$filename=$_SERVER['DOCUMENT_ROOT']."/tmp.pdf";
		if (file_exists($filename)) {
			chmod($filename, 777);
			unlink ($filename);
		}
		$mpdf->Output($filename);
		//$p=print_r($_SERVER['HTTP_USER_AGENT'],true);echo "<pre>$p</pre>";
?>
<html>
<head>
	<title>Compose Mail</title>
	<link REL="SHORTCUT ICON" HREF="include/images/vtigercrm_icon.ico">	
	<style type="text/css">@import url("themes/softed/style.css");</style>
	<script type="text/javascript" src="include/ckeditor2/ckeditor.js"></script>
	<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
	<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
	<script src="include/js/general.js" type="text/javascript"></script>
	<script language="JavaScript" type="text/javascript" src="include/js/en_us.lang.js?"></script>
	<script type="text/javascript" src="modules/Products/multifile.js"></script>
</head>
<body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<form name="EditView" id="EditView" method="POST" action="index.php?module=Leads&action=LeadsAjax&file=viewmail&leadid=<? echo $_REQUEST['leadid'] ?>">
	<table class="small mailClient" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td colspan="2" class="mailClientWriteEmailHeader">Compose E-Mail</td>
	</tr>
	<tr>
		<td class="mailSubHeader" style="width:20%;text-align:right;padding: 5px;"><font color="red">*</font><b>To</b></td>
		<td class="cellText" style="padding: 5px;"><input type="text" value="<? echo $newfax; ?>" name="to" id="to" class="txtBox"></td>
	</tr>
	<tr>
		<td class="mailSubHeader" style="width:20%;text-align:right;padding: 5px;"><b>Cc</b></td>
		<td class="cellText" style="padding: 5px;"><input type="text" value="<? echo $assignedemail; ?>" name="cc" id="cc" class="txtBox"></td>
	</tr>
	<tr>
		<td class="mailSubHeader" style="width:20%;text-align:right;padding: 5px;"><b>Bcc</b></td>
		<td class="cellText" style="padding: 5px;"><input type="text" value="" class="txtBox" name="bcc" id="bcc"></td>
	</tr>
	<tr>
		<td class="mailSubHeader" style="width:20%;text-align:right;padding: 5px;"><font color="red">*</font><b>Subject</b></td>
		<td class="cellText" style="padding: 5px;"><input type="text" value="Funding Application" name="subject" id="subject" class="txtBox"></td>
	</tr>
	<tr>
		<td class="mailSubHeader" style="width:20%;text-align:right;padding: 5px;"><font color="red">*</font><b>Attachment</b></td>
		<td class="cellText" style="padding: 5px;"><!--<a href="include/MPDF/application<? echo $_REQUEST['leadid']; ?>.pdf">-->Application.pdf<!--</a>--></td>
	</tr>
	<tr>
		<td colspan="2" class="cellText" style="padding: 5px;text-align:center;"><input class="crmbutton small save" type="button" onclick="return validate();" value=" Send " name="Send"></td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="emailbody" id="emailbody" style="display:none;"></textarea><textrea name="description" id="description" style="width:100%;" rows="5"><? /*echo $emailbody;*/ ?></textrea></td>
	</tr>
	</table>
</form>
<script type="text/javascript" defer="1">
	var textAreaName = 'description';
	CKEDITOR.replace( textAreaName,	{
		extraPlugins : 'uicolor',
		uiColor: '#dfdff1'
	} ) ;
	var oCKeditor = CKEDITOR.instances[textAreaName];
	<?
	//if (strpos('MSIE',$_SERVER['HTTP_USER_AGENT'])>0){
		echo "var data = '".  str_replace("\n", "' + \n'", str_replace("'", "", $emailbody))."';\n";
		echo "\nCKEDITOR.instances[textAreaName].setData(data);\n";
	//}
	?>
	
	function validate(){
		if (document.getElementById('to').value!='' && document.getElementById('subject').value!=''){
			document.getElementById('emailbody').value=CKEDITOR.instances['description'].getData();
			document.getElementById("EditView").submit();
		}
	}
</script>
</body>
</html>
<?php
		chmod($filename, 777);
		unlink ($filename);
	}
} else viewerror("Lead not found");

function viewerror($text){
	return "<html>
<body>
	<h3>".$text."</h3>
</body>
</html>";
}
