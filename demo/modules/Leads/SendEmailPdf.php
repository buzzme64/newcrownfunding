<?php
require_once('modules/Emails/mail.php');
require_once('include/MPDF/mpdf.php');
global $current_user;

if (isset($_REQUEST['leadid'])){
$res=  mysql_query("select * from vtiger_leaddetails ld 
	left join vtiger_leadscf lcf on ld.leadid=lcf.leadid
	left join vtiger_leadsubdetails lsd on ld.leadid=lsd.leadsubscriptionid
	left join vtiger_crmentity crm on ld.leadid=crm.crmid
	where ld.leadid='".(int)$_REQUEST['leadid']."'");
	if (mysql_num_rows($res)==1){
		
		$result = $adb->query("select user_name, email1, email2 from vtiger_users where id=1");
		$from_email = $adb->query_result($result,0,'email1');
		$from_name  = $adb->query_result($result,0,'user_name');
		
		$data=array();
		while ($row=  mysql_fetch_array($res, MYSQL_ASSOC)) $data=$row;
		extract($data, EXTR_OVERWRITE);
		$res=  mysql_query("select phone_work assignedphone, phone_fax assignedfax, email1 assignedemail, concat(first_name,' ',last_name) assignedusername from vtiger_users where id='".$smownerid."'");
		while($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
			$assignedphone=$row['assignedphone'];
			$assignedfax=$row['assignedfax'];
			$assignedemail=$row['assignedemail'];
			$assignedusername=$row['assignedusername'];
		}
		if ($assignedphone=="") $assignedphone="877-812-5812";
		if ($assignedfax=="") $assignedfax="404-400-1270";
		if ($assignedemail=="") $assignedemail="info@powerlinefunding.com";
		require_once('include/MPDF/pdftemplate.php');
		$mpdf = new mPDF('utf-8', 'A4', '8', '', 20, 10, 7, 7, 10, 10);
		$mpdf->charset_in = 'utf-8';
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		//$filename=$_SERVER['DOCUMENT_ROOT']."/tmp.pdf";
		$filename = dirname(dirname(__DIR__))."/include/MPDF/application.pdf";
		if (file_exists($filename)) unlink ($filename);
		$mpdf->Output($filename);
		//$idarray=  explode("x", $id);
		//$query="update vtiger_leaddetails set leadstatus='2. App Out' where leadid='".$idarray[1]."'";
		//echo $query;
		//$res=  mysql_query($query);
		send_mail('Leads',$email,$from_name,$from_email,'Powerline Funding Application',"Hy, $firstname $lastname!\n\nPlease fill in the application form and send it to our mailbox", '', '','','','',$filename);
		
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
		
		$res=  mysql_query("update vtiger_leaddetails set leadstatus='2. App Out' where leadid='".$_REQUEST['leadid']."'");
		
		echo "#SUCCESS";
	} else echo "We not found data";
} else echo "We lost leadid. R.I.P.";
?>
