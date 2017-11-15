<?php
require_once('RecycleBinUtils.php');

$idlist=vtlib_purify($_REQUEST['idlist']);
$excludedRecords=vtlib_purify($_REQUEST['excludedRecords']);
$selected_module = vtlib_purify($_REQUEST['selectmodule']);
//$idlists = getSelectedRecordIds($_REQUEST,$selected_module,$idlist,$excludedRecords);
if ($idlist=="all"){
	$res=mysql_query("delete from vtiger_crmentity where setype='".$selected_module."' and deleted=1");
}
else {
	$storearray = explode(";",$idlist);
	$del = "'".implode("', '", $storearray)."'";
	$res=  mysql_query("delete from vtiger_crmentity where crmid in (".$del.") and deleted=1");
}

$parenttab = getParentTab();

header("Location: index.php?module=RecycleBin&action=RecycleBinAjax&file=index&parenttab=$parenttab&mode=ajax&selected_module=$selected_module");
?>
