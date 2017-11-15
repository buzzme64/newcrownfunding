<?php
require_once('modules/Leads/Leads.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
global $current_user;
$res=  mysql_query("update vtiger_leaddetails set leadstatus='".$_POST['status']."' where leadid='".$_POST['leadid']."'");
$_REQUEST['leadstatus']=$_POST['status'];
$return_id=$_POST['leadid'];

if ($_POST['status']=="5. Contract Out" || $_POST['status']=="7. Funded"){
if ($_POST['status']=="5. Contract Out")
	$arr=array(
		"Funder"=>"cf_714",
		"Advance amount"=>"cf_715",
		"Payback amount"=>"cf_716",
		"HP %"=>"cf_717",
		"Daily amount"=>"cf_718",
		"Closing costs"=>"cf_719",
		"Date contract sent"=>"cf_720"
	);
elseif ($_POST['status']=="7. Funded")
	$arr=array(
		".Funder"=>"cf_721",
		".Advance amount"=>"cf_722",
		".Payback amount"=>"cf_723",
		".HP %"=>"cf_724",
		".Daily amount"=>"cf_725",
		".Closing costs"=>"cf_726",
		".Date funded"=>"cf_727"
	);
	$res=mysql_query("select ".implode(", ", $arr)." from vtiger_leadscf where leadid='".$_POST['leadid']."'");
	$data=array();
	while($row=  mysql_fetch_array($res,MYSQL_ASSOC))$data=$row;
	$error=array();
	foreach ($arr as $key=>$value){
		if ($data[$value]=="") $error[]=$key." must be full";
	}
	if (count($error)>0) {
		echo implode ("\n", $error);
		exit;
	}
}

if (strlen(trim($_REQUEST['description']))>0){
	$_POST['description']=trim($_POST['description']);
	$res=  mysql_query("select id from vtiger_crmentity_seq");
	while($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $maxcrm=$row['id'];
	$maxcrm++;
	$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted) values ('".$maxcrm."','".$current_user->id."','".$current_user->id."','".$current_user->id."','ModComments',
		NULL,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,
		0,1,0)");
	$res=  mysql_query("insert into vtiger_modcomments(modcommentsid,commentcontent,related_to,parent_comments)
		values('".$maxcrm."','".$_POST['description']."','".$return_id."','')");
	$res=  mysql_query("insert into vtiger_modcommentscf(modcommentsid) values ('".$maxcrm."')");
	$res=  mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
	$res=  mysql_query("update vtiger_crmentity set description='' where crmid='".$return_id."'");
}

if ($_REQUEST['leadstatus']=="8. Funded"){
	$res=  mysql_query("select cf_714, cf_715,cf_716,cf_717,cf_718,cf_719,cf_720,
		cf_721,cf_722,cf_723,cf_724,cf_725,cf_726,cf_727 from vtiger_leadscf where leadid='".$return_id."'");
	$update=array();$data=array();
	while ($row=mysql_fetch_array($res,MYSQL_ASSOC))$data=$row;
	if ($data['cf_721']=="") $update[]="cf_721='".$data['cf_714']."'";
	if ($data['cf_722']=="") $update[]="cf_722='".$data['cf_715']."'";
	if ($data['cf_723']=="") $update[]="cf_723='".$data['cf_716']."'";
	if ($data['cf_724']=="") $update[]="cf_724='".$data['cf_717']."'";
	if ($data['cf_725']=="") $update[]="cf_725='".$data['cf_718']."'";
	if ($data['cf_726']=="") $update[]="cf_726='".$data['cf_719']."'";
	if ($data['cf_727']=="0000-00-00") $update[]="cf_727='".$data['cf_720']."'";
	if (count($update)>0){
		$updatestr="update vtiger_leadscf set ".implode(", ", $update)." where leadid='".$return_id."'";
		$res=  mysql_query($updatestr);
	}
}

$res=mysql_query("update vtiger_crmentity set modifiedtime='".date("Y-m-d H:i:s")."' where crmid='".$return_id."'");

require_once('modules/Leads/createactivity.php');
echo "#SUCCESS";
?>