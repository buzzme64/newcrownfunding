<?php
//print_r($_REQUEST);
$res=  mysql_query("select ".$_REQUEST['field']." from ".$_REQUEST['table']." where ".$_REQUEST['field']."='".mysql_real_escape_string($_REQUEST['value'])."' and leadid!=".$_REQUEST['id']) or die ("Cannot check email");
if (mysql_num_rows($res)==0){
	$res=  mysql_query("update ".$_REQUEST['table']." set ".$_REQUEST['field']."='".  mysql_real_escape_string($_REQUEST['value'])."' where leadid=".$_REQUEST['id']);
	echo "OK";
}else echo "This email is used";
?>