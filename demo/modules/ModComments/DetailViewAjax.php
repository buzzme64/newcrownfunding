<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $currentModule;
$modObj = CRMEntity::getInstance($currentModule);

$ajaxaction = $_REQUEST["ajxaction"];

if($ajaxaction == 'WIDGETADDCOMMENT') {
	global $current_user;
	if (isPermitted($currentModule, 'EditView', '') == 'yes') {
		
		$res=mysql_query("select leadstatus from vtiger_leaddetails where leadid='".$_REQUEST['parentid']."'");
		while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $oldstatus=$row['leadstatus'];
		if (isset($oldstatus) && $oldstatus=="Lead Pending")
			$res=  mysql_query("update vtiger_leaddetails set leadstatus='1. App not sent' where leadid='".$_REQUEST['parentid']."'");
		
		$modObj->column_fields['commentcontent'] = vtlib_purify($_REQUEST['comment']);
		$modObj->column_fields['related_to'] = vtlib_purify($_REQUEST['parentid']);
		$modObj->column_fields['assigned_user_id'] = $current_user->id;
		$modObj->save($currentModule);
	
		if(empty($modObj->column_fields['smcreatorid'])) $modObj->column_fields['smcreatorid'] = $current_user->id;
		if(empty($modObj->column_fields['modifiedtime'])) $modObj->column_fields['modifiedtime']= date('Y-m-d H:i:s');
		
		$widgetInstance = $modObj->getWidget('DetailViewBlockCommentWidget');
		$res=mysql_query("update vtiger_crmentity set modifiedby='".$current_user->id."' where crmid='".(int)$_REQUEST['parentid']."'");
		$res=mysql_query("update vtiger_leaddetails set processed='1' where leadid='".(int)$_REQUEST['parentid']."'");
		echo ':#:SUCCESS'. $widgetInstance->processItem($modObj->getAsCommentModel($modObj->column_fields));
	} else {
		echo ':#:FAILURE';
	}
}

else if($ajaxaction == 'DETAILVIEW') {
	$crmid = $_REQUEST['recordid'];
	$tablename = $_REQUEST['tableName'];
	$fieldname = $_REQUEST['fldName'];
	$fieldvalue = utf8RawUrlDecode($_REQUEST['fieldValue']); 
	if($crmid != '')
	{
		$modObj->retrieve_entity_info($crmid, $currentModule);
		$modObj->column_fields[$fieldname] = $fieldvalue;
		$modObj->id = $crmid;
		$modObj->mode = 'edit';
		$modObj->save($currentModule);
		if($modObj->id != '')
		{
			echo ':#:SUCCESS';
		}else
		{
			echo ':#:FAILURE';
		}   
	}else
	{
		echo ':#:FAILURE';
	}
} elseif($ajaxaction == "LOADRELATEDLIST" || $ajaxaction == "DISABLEMODULE"){
	require_once 'include/ListView/RelatedListViewContents.php';
}
?>