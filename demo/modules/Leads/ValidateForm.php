<?php

if (isset($_REQUEST['record']) && preg_match("/^[0-9]+$/", $_REQUEST['record']) )
	$res=  mysql_query("select vtiger_leadscf.leadid, firstname, lastname, email, cf_641, cf_640, cf_642, cf_643, cf_644, cf_648 from vtiger_leadscf
	inner join vtiger_leaddetails on vtiger_leaddetails.leadid=vtiger_leadscf.leadid
	left join vtiger_crmentity on vtiger_leadscf.leadid=vtiger_crmentity.crmid
	where vtiger_crmentity.deleted=0 and vtiger_leadscf.leadid!='".$_REQUEST['record']."' and (cf_641='".  mysql_real_escape_string($_REQUEST['dba'])."' or
		cf_640='".  mysql_real_escape_string($_REQUEST['legalname'])."' or
		cf_648='".  mysql_real_escape_string($_REQUEST['phone'])."' or
		vtiger_leaddetails.email='".  mysql_real_escape_string($_REQUEST['email'])."')");
else
	$res=  mysql_query("select vtiger_leadscf.leadid, firstname, lastname, email, cf_641, cf_640, cf_642, cf_643, cf_644, cf_648 from vtiger_leadscf
	inner join vtiger_leaddetails on vtiger_leaddetails.leadid=vtiger_leadscf.leadid
	left join vtiger_crmentity on vtiger_leadscf.leadid=vtiger_crmentity.crmid
	where vtiger_crmentity.deleted=0 and (cf_641='".  mysql_real_escape_string($_REQUEST['dba'])."' or
		cf_640='".  mysql_real_escape_string($_REQUEST['legalname'])."' or
		cf_656='".  mysql_real_escape_string($_REQUEST['ownername'])."' or
		cf_648='".  mysql_real_escape_string($_REQUEST['phone'])."' or
		vtiger_leaddetails.email='".  mysql_real_escape_string($_REQUEST['email'])."')");
/*(cf_642='".  mysql_real_escape_string($_REQUEST['city'])."' and
		cf_643='".  mysql_real_escape_string($_REQUEST['state'])."' and
		cf_644='".  mysql_real_escape_string($_REQUEST['zip'])."')*/
if (mysql_num_rows($res)==0) echo "#SUCCESS";
else {
	$data=array();
	$error=array(
		"dba"=>"",
		"legalname"=>"",
		"ownername"=>"",
		"phone"=>"",
		"address"=>"",
		"email"=>""
	);
	$errorstr="";
	while($row=  mysql_fetch_array($res,MYSQL_ASSOC)){$data[]=$row;}
	$confirm=true;
	foreach ($data as $value) {
		if ($value['cf_641']==$_REQUEST['dba'] && $value['cf_641']!='') { 
			$error['dba']="DBA already exist";/* ( <a href='index.php?module=Leads&parenttab=Marketing&action=DetailView&record=".$value['leadid']."' target='_blank'>".$value['firstname']." ".$value['lastname']."</a> )"; */
			$confirm=false;
			
			
	 
	}
		if ($value['cf_640']==$_REQUEST['legalname'] && $value['cf_640']!='') {
			$error['legalname']="Legal Name already exist";/* ( <a href='index.php?module=Leads&parenttab=Marketing&action=DetailView&record=".$value['leadid']."' target='_blank'>".$value['firstname']." ".$value['lastname']."</a> )";*/
			$confirm=false;
		}
		if ($value['cf_648']==$_REQUEST['phone'] && $value['cf_648']!='') $error['phone']="Telephone Number already exist";/* ( <a href='index.php?module=Leads&parenttab=Marketing&action=DetailView&record=".$value['leadid']."' target='_blank'>".$value['firstname']." ".$value['lastname']."</a> )";*/
		if ($value['cf_656']==$_REQUEST['ownername'] && $value['cf_656']!='') $error['ownename']="Owner Name already exist";/* ( <a href='index.php?module=Leads&parenttab=Marketing&action=DetailView&record=".$value['leadid']."' target='_blank'>".$value['firstname']." ".$value['lastname']."</a> )";*/
		//if ($value['cf_642']==$_REQUEST['city'] && $value['cf_643']==$_REQUEST['state'] && $value['cf_644']==$_REQUEST['zip']) $error['address']="Phisical Address is already exist";
		if ($value['email']==$_REQUEST['email'] && $value['email']!='') $error['email']="Email already exist";/* ( <a href='index.php?module=Leads&parenttab=Marketing&action=DetailView&record=".$value['leadid']."' target='_blank'>".$value['firstname']." ".$value['lastname']."</a> )";*/
		
	}
	foreach ($error as $val) {
		if ($val!="") {
			if ($confirm)
				$errorstr.=$val."\n";
			else
				$errorstr.=$val."<br/>";
		}
	}
	//$errorstr= trim( implode("\n", $error));
	if ($errorstr=="") echo "#SUCCESS";
	else {
		$res=new stdClass();
		$res->text=$errorstr;
		$res->confirm=$confirm;
		//$errorstr;
		echo json_encode($res);
	}
}
?>