<?php
$res=  mysql_query("select max(crmid) maxcrm from vtiger_crmentity");
while($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $maxcrm=$row['maxcrm'];
$maxcrm++;
if ($_REQUEST['leadstatus']=="Lead Pending"){
	
	if (isset($oldstatus) && $oldstatus=="Lead Pending")
		$res=  mysql_query("update vtiger_leaddetails set leadstatus='1. App not sent' where leadid='".$return_id."'");
	
}elseif ($_REQUEST['leadstatus']=="1. App not sent"){
	if (isset($_REQUEST['cf_713'])){
		$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
			description,createdtime,modifiedtime,viewedtime,status,
			version,presence,deleted)values(
			'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
			'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
			0,1,0),('".($maxcrm+1)."',1,'".$current_user->id."','1','Calendar',
			'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
			0,1,0)");//or die("insert into crmentity ".  mysql_errno().". ".  mysql_error());
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
			0,'private','')");// or die("insert into activity ".mysql_errno.". ".mysql_error());
		$res=  mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."'),('".$return_id."','".($maxcrm+1)."')");
		$res=mysql_query("update vtiger_crmentity_seq set id='".($maxcrm+1)."'");
	}else{
		/*$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
			description,createdtime,modifiedtime,viewedtime,status,
			version,presence,deleted)values(
			'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
			'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
			0,1,0)");
		$res=  mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
			due_date,time_start,time_end,sendnotification,duration_hours,
			duration_minutes,status,eventstatus,priority,location,
			notime,visibility,recurringtype) values(
			'".$maxcrm."','Sending application to the client.', NULL,'Application sending','".date('Y-m-d')."',
			'".date('Y-m-d')."','10:00','11:00',0,0,
			'',NULL,'Not Held','','',
			0,'private','')");
		$res=  mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."')");
		$res=mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");*/
	}
}elseif ($_REQUEST['leadstatus']=="2. App Out"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Application sending'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
	$res=mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted)values(
		'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0)");
	$res=mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
		due_date,time_start,time_end,sendnotification,duration_hours,
		duration_minutes,status,eventstatus,priority,location,
		notime,visibility,recurringtype) values(
		'".$maxcrm."','Waiting for a signed application from the client.', NULL,'Awaiting application','".date('Y-m-d')."',
		'".date('Y-m-d')."','10:00','11:00',0,0,
		'',NULL,'Not Held','','',
		0,'private','')");
	$res=mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."')");
	$res=mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
}elseif ($_REQUEST['leadstatus']=="3. App In"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Awaiting application'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
	$res=mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted)values(
		'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0)");
	$res=mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
		due_date,time_start,time_end,sendnotification,duration_hours,
		duration_minutes,status,eventstatus,priority,location,
		notime,visibility,recurringtype) values(
		'".$maxcrm."','Check a signed application.', NULL,'Application check','".date('Y-m-d')."',
		'".date('Y-m-d')."','10:00','11:00',0,0,
		'',NULL,'Not Held','','',
		0,'private','')");
	$res=mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."')");
	$res=mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
/*}elseif ($_REQUEST['leadstatus']=="4. Submitted"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Application check'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
	$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted)values(
		'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0),('".($maxcrm+1)."',1,'".$current_user->id."','1','Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0)");//or die("insert into crmentity ".  mysql_errno().". ".  mysql_error());
	$res=  mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
		due_date,time_start,time_end,sendnotification,duration_hours,
		duration_minutes,status,eventstatus,priority,location,
		notime,visibility,recurringtype) values(
		'".$maxcrm."','Adding data from the application to the vTiger.', NULL,'Submit application','".date('Y-m-d')."',
		'".date('Y-m-d')."','10:00','11:00',0,0,
		'',NULL,'Held','','',
		0,'private',''),
		('".($maxcrm+1)."','Review of an application for funding.',NULL,'Awaiting Approval','".date('Y-m-d')."',
		'".date('Y-m-d')."','11:00','11:30',0,0,
		'',NULL,'Not Held','','',
		0,'private','')");// or die("insert into activity ".mysql_errno.". ".mysql_error());
	$res=  mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."'),('".$return_id."','".($maxcrm+1)."')");
	$res=mysql_query("update vtiger_crmentity_seq set id='".($maxcrm+1)."'");
*/}elseif ($_REQUEST['leadstatus']=="4. Approved"){
	/*$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and (a.activitytype='Submit application' or a.activitytype='Awaiting Approval')");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");*/
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Application check'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
	$res=mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted)values(
		'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0)");
	$res=mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
		due_date,time_start,time_end,sendnotification,duration_hours,
		duration_minutes,status,eventstatus,priority,location,
		notime,visibility,recurringtype) values(
		'".$maxcrm."','Sending the contract to the client.', NULL,'Send contract','".date('Y-m-d')."',
		'".date('Y-m-d')."','10:00','11:00',0,0,
		'',NULL,'Not Held','','',
		0,'private','')");
	$res=mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."')");
	$res=mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
}elseif ($_REQUEST['leadstatus']=="5. Contract Out"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Send contract'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
	$res=mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted)values(
		'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0)");
	$res=mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
		due_date,time_start,time_end,sendnotification,duration_hours,
		duration_minutes,status,eventstatus,priority,location,
		notime,visibility,recurringtype) values(
		'".$maxcrm."','Waiting for a signed contract from the client.', NULL,'Waiting for contract','".date('Y-m-d')."',
		'".date('Y-m-d')."','10:00','11:00',0,0,
		'',NULL,'Not Held','','',
		0,'private','')");
	$res=mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."')");
	$res=mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
}elseif ($_REQUEST['leadstatus']=="6. Contract In"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Waiting for contract'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
	$res=mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted)values(
		'".$maxcrm."',1,'".$current_user->id."',1,'Calendar',
		'','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,NULL,
		0,1,0)");
	$res=mysql_query("insert into vtiger_activity(activityid,subject,semodule,activitytype,date_start,
		due_date,time_start,time_end,sendnotification,duration_hours,
		duration_minutes,status,eventstatus,priority,location,
		notime,visibility,recurringtype) values(
		'".$maxcrm."','Funding.', NULL,'Funding','".date('Y-m-d')."',
		'".date('Y-m-d')."','10:00','11:00',0,0,
		'',NULL,'Not Held','','',
		0,'private','')");
	$res=mysql_query("insert into vtiger_seactivityrel(crmid,activityid)values('".$return_id."','".$maxcrm."')");
	$res=mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
}elseif ($_REQUEST['leadstatus']=="7. Funded"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0 and a.activitytype='Funding'");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
}elseif ($_REQUEST['leadstatus']=="9. Declined"){
	$res=  mysql_query("select a.activityid from vtiger_seactivityrel sea
		inner join vtiger_activity a on sea.activityid=a.activityid
		inner join vtiger_crmentity crm on sea.activityid=crm.crmid
		where sea.crmid='".$return_id."' and crm.deleted=0");
	$act=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC))$act[]=$row['activityid'];
	$res=  mysql_query("update vtiger_activity set eventstatus='Held' where activityid in (".  implode(",", $act).")");
}
?>
