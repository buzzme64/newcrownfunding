<?php
$res=  mysql_query("delete from vtiger_leads_funded where id='".$_REQUEST['record']."'");
echo "#SUCCESS";
?>