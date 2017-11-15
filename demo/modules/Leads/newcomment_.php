<?php
$res=  mysql_query("select max(crmid) maxcrm from vtiger_crmentity");
$maxcrm=0;
while($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $maxcrm=$row['maxcrm'];
$maxcrm++;
$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,createdtime,modifiedtime,version,presence,deleted)"
		. "value ('".$maxcrm."','".$current_user->id."','".$current_user->id."','".$current_user->id."','ModComments','".date('Y-m-d H:m:s')."','".date('Y-m-d H:m:s')."',0,1,0)");
$res=  mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
$res=  mysql_query("insert into vtiger_modcomments(modcommentsid,commentcontent,related_to) "
		. "values('".$maxcrm."','".  mysql_real_escape_string($_REQUEST['comment'])."','".$_REQUEST['leadid']."')");
$res=  mysql_query("INSERT INTO vtiger_modcommentscf (modcommentsid)VALUES ('".$maxcrm."')");

$lastcomment="";
$res=  mysql_query("SELECT mc.commentcontent, crm.createdtime, u.first_name, u.last_name
FROM vtiger_modcomments mc
inner join vtiger_crmentity crm on mc.modcommentsid=crm.crmid
inner join vtiger_users u on crm.smownerid=u.id
WHERE related_to='".$_REQUEST['leadid']."'
order by mc.modcommentsid desc
limit 0,7");
while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
	$date = new DateTimeField($row['createdtime']);
	$lastcomment.="
<div class=\"dataField\" valign=\"top\" style=\"width: 99%; padding-top: 10px;\"> ".$row['commentcontent']." </div>
<div class=\"dataLabel\" valign=\"top\" style=\"border-bottom: 1px dotted rgb(204, 204, 204); width: 99%; padding-bottom: 5px;\">
	<font color=\"darkred\"> Author: ".$row['first_name']." ".$row['last_name']." on ".$date->getDisplayDateTimeValue()." </font>
</div>";
}
echo $lastcomment;
//$p=print_r($_REQUEST,true);echo "<pre>$p</pre>";
?>