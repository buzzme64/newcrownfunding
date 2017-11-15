<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/

require_once('modules/Leads/Leads.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');

$local_log =& LoggerManager::getLogger('index');
global $log,$adb;
$focus = new Leads();
global $current_user;

//added to fix 4600
$search=vtlib_purify($_REQUEST['search_url']);

if(isset($_REQUEST['record']))
{
	$res=mysql_query("select leadstatus from vtiger_leaddetails where leadid='".$_REQUEST['record']."'");
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $oldstatus=$row['leadstatus'];
	$focus->id = $_REQUEST['record'];
}
if(isset($_REQUEST['mode']))
{
	$focus->mode = $_REQUEST['mode'];
}

//$focus->retrieve($_REQUEST['record']);

foreach($focus->column_fields as $fieldname => $val)
{
    if(isset($_REQUEST[$fieldname])) {
		if(is_array($_REQUEST[$fieldname]))
			$value = $_REQUEST[$fieldname];
		else
			$value = trim($_REQUEST[$fieldname]);	
        $log->info("the value is ".$value);
        $focus->column_fields[$fieldname] = $value;
    }
}

if($_REQUEST['assigntype'] == 'U') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
} elseif($_REQUEST['assigntype'] == 'T') {
	$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
}

$focus->save("Leads");
$return_id = $focus->id;

if (strlen(trim($_REQUEST['description']))>0){
	$_REQUEST['description']=trim($_REQUEST['description']);
	$res=  mysql_query("select id from vtiger_crmentity_seq");
	while($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $maxcrm=$row['id'];
	$maxcrm++;
	$res=  mysql_query("insert into vtiger_crmentity(crmid,smcreatorid,smownerid,modifiedby,setype,
		description,createdtime,modifiedtime,viewedtime,status,
		version,presence,deleted) values ('".$maxcrm."','".$current_user->id."','".$current_user->id."','".$current_user->id."','ModComments',
		NULL,'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."',NULL,
		0,1,0)");
	$res=  mysql_query("insert into vtiger_modcomments(modcommentsid,commentcontent,related_to,parent_comments)
		values('".$maxcrm."','".$_REQUEST['description']."','".$return_id."','')");
	$res=  mysql_query("insert into vtiger_modcommentscf(modcommentsid) values ('".$maxcrm."')");
	$res=  mysql_query("update vtiger_crmentity_seq set id='".$maxcrm."'");
	$res=  mysql_query("update vtiger_crmentity set description='' where crmid='".$return_id."'");
}


if (isset($_REQUEST['record'])){
	$res=mysql_query("select processed,changeassigned from vtiger_leaddetails where leadid='".$_REQUEST['record']."'");
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)) {$processed=$row['processed'];$changeassigned=$row['changeassigned'];}
}else {$processed=0;$changeassigned="";}
if (isset($_REQUEST['assigned_user_id']) && $_REQUEST['assigned_user_id']==$current_user->id && $current_user->user_name!="admin"){
	if ($processed==0) {
		$res=mysql_query ("update vtiger_leaddetails set processed='1' where leadid='".$focus->id."'");
	}
}
if ($changeassigned=="") 
	if ($_REQUEST['assigned_user_id']!=$current_user->id && $_REQUEST['assigned_user_id']!=1)
		$res=mysql_query ("update vtiger_leaddetails set changeassigned='".  date("Y-m-d")."' where leadid='".$focus->id."'");

	 $log->info("the return id is ".$return_id);
$parenttab = getParentTab();
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "") $return_module = vtlib_purify($_REQUEST['return_module']);
else $return_module = "Leads";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "") $return_action = vtlib_purify($_REQUEST['return_action']);
else $return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "") $return_id = vtlib_purify($_REQUEST['return_id']);

$local_log->debug("Saved record with id of ".$return_id);
//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '') $return_viewname='0';
if($_REQUEST['return_viewname'] != '')$return_viewname=vtlib_purify($_REQUEST['return_viewname']);

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == "Campaigns")
{
	if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "")
	{
		 $campLeadStatusResult = $adb->pquery("select campaignrelstatusid from vtiger_campaignleadrel where campaignid=? AND leadid=?",array($_REQUEST['return_id'], $focus->id));
		 $leadStatus = $adb->query_result($campLeadStatusResult,0,'campaignrelstatusid');
		 $sql = "delete from vtiger_campaignleadrel where leadid = ?";
		 $adb->pquery($sql, array($focus->id));
		 if(isset($leadStatus) && $leadStatus !=''){
		 $sql = "insert into vtiger_campaignleadrel values (?,?,?)";
		 $adb->pquery($sql, array($_REQUEST['return_id'], $focus->id,$leadStatus));
		 }
		 else{
		 $sql = "insert into vtiger_campaignleadrel values (?,?,1)";
		 $adb->pquery($sql, array($_REQUEST['return_id'], $focus->id));
		}
	}
}

require_once('modules/Leads/createactivity.php');

require_once('modules/Leads/updatephone.php');
updatephone(listhponefield($request), $record);

header("Location: index.php?action=$return_action&module=$return_module&record=$return_id&parenttab=$parenttab&viewname=$return_viewname&start=".vtlib_purify($_REQUEST['pagenumber']).$search);
/** Function to save the Lead custom fields info into database
 *  @param integer $entity_id - leadid
*/
function save_customfields($entity_id)
{
	$log->debug("Entering save_customfields(".$entity_id.") method ...");
	 $log->debug("save custom vtiger_field invoked ".$entity_id);
	global $adb;
	$dbquery="select * from customfields where module='Leads'";
	$result = $adb->pquery($dbquery, array());
	$custquery = "select * from leadcf where leadid=?";
    $cust_result = $adb->pquery($custquery, array($entity_id));
	if($adb->num_rows($result) != 0)
	{
		
		$columns='';
		$params = array();
		$update='';
		$noofrows = $adb->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fldName=$adb->query_result($result,$i,"fieldlabel");
			$colName=$adb->query_result($result,$i,"column_name");
			if(isset($_REQUEST[$colName]))
			{
				$fldvalue=$_REQUEST[$colName];
				 $log->info("the columnName is ".$fldvalue);
				if(get_magic_quotes_gpc() == 1)
                		{
                        		$fldvalue = stripslashes($fldvalue);
                		}
			}
			else
			{
				$fldvalue = '';
			}
			if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && $adb->num_rows($cust_result) !=0)
			{
				//Update Block
				if($i == 0)
				{
					$update = $colName.'=?';
				}
				else
				{
					$update .= ', '.$colName.'=?';
				}
				array_push($params, $fldvalue);
			}
			else
			{
				//Insert Block
				if($i == 0)
				{
					$columns='leadid, '.$colName;
					array_push($params, $entity_id);
				}
				else
				{
					$columns .= ', '.$colName;
				}
				array_push($params, $fldvalue);
			}
			
				
		}
		if(isset($_REQUEST['record']) && $_REQUEST['record'] != '' && $adb->num_rows($cust_result) !=0)
		{
			//Update Block
			$query = 'update leadcf SET '.$update.' where leadid=?'; 
			array_push($params, $entity_id);
			$adb->pquery($query, $params);
		}
		else
		{
			//Insert Block
			$query = 'insert into leadcf ('.$columns.') values('. generateQuestionMarks($params) .')';
			$adb->pquery($query, $params);
		}
		
	}
	$log->debug("Exiting save_customfields method ...");	
}

function getRequestData($return_id)
{
	global $adb;
	$cont_qry = "select * from vtiger_cntactivityrel where activityid=?";
	$cont_res = $adb->pquery($cont_qry, array($return_id));
	$noofrows = $adb->num_rows($cont_res);
	$cont_id = array();
	if($noofrows > 0) {
		for($i=0; $i<$noofrows; $i++) {
			$cont_id[] = $adb->query_result($cont_res,$i,"contactid");
		}
	}
	$cont_name = '';
	foreach($cont_id as $key=>$id) {
		if($id != '') {
			$displayValueArray = getEntityName('Contacts', $id);
			if (!empty($displayValueArray)) {
				foreach ($displayValueArray as $key => $field_value) {
					$contact_name = $field_value;
				}
			}
			$cont_name .= $contact_name .', ';
		}
	}
	$cont_name  = trim($cont_name,', ');
	$mail_data = Array();
	$mail_data['user_id'] = $_REQUEST['assigned_user_id'];
	$mail_data['subject'] = $_REQUEST['subject'];
	$mail_data['status'] = (($_REQUEST['activity_mode']=='Task')?($_REQUEST['taskstatus']):($_REQUEST['eventstatus']));
	$mail_data['activity_mode'] = $_REQUEST['activity_mode'];
	$mail_data['taskpriority'] = $_REQUEST['taskpriority'];
	$mail_data['relatedto'] = $_REQUEST['parent_name'];
	$mail_data['contact_name'] = $cont_name;
	$mail_data['description'] = $_REQUEST['description'];
	$mail_data['assign_type'] = $_REQUEST['assigntype'];
	$mail_data['group_name'] = getGroupName($_REQUEST['assigned_group_id']);
	$mail_data['mode'] = $_REQUEST['mode'];
	$value = getaddEventPopupTime($_REQUEST['time_start'],$_REQUEST['time_end'],'24');
	$start_hour = $value['starthour'].':'.$value['startmin'].''.$value['startfmt'];
	if($_REQUEST['activity_mode']!='Task')
		$end_hour = $value['endhour'] .':'.$value['endmin'].''.$value['endfmt'];
	$startDate = new DateTimeField($_REQUEST['date_start']." ".$start_hour);
	$endDate = new DateTimeField($_REQUEST['due_date']." ".$end_hour);
	$mail_data['st_date_time'] = $startDate->getDBInsertDateTimeValue();
	$mail_data['end_date_time'] = $endDate->getDBInsertDateTimeValue();
	$mail_data['location']=vtlib_purify($_REQUEST['location']);
	return $mail_data;
}

function getFieldRelatedInfo($tabId, $fieldName){
	$fieldInfo = VTCacheUtils::lookupFieldInfo($tabId, $fieldName);
	if($fieldInfo === false) {
		getColumnFields(getTabModuleName($tabid));
		$fieldInfo = VTCacheUtils::lookupFieldInfo($tabId, $fieldName);
	}
	return $fieldInfo;
}
?>
