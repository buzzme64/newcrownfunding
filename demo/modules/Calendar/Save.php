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
/*********************************************************************************
 * $Header: /advent/projects/wesat/vtiger_crm/sugarcrm/modules/Activities/Save.php,v 1.11 2005/04/18 10:37:49 samk Exp $
 * Description:  Saves an Account record and then redirects the browser to the
 * defined return URL.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('modules/Calendar/Activity.php');
require_once('include/logging.php');
require_once("config.php");
require_once('include/database/PearDatabase.php');
require_once('modules/Calendar/CalendarCommon.php');
//$p=print_r($_POST,true); echo "<pre>$p</pre>";exit;
global $adb,$theme;
$local_log =& LoggerManager::getLogger('index');
$focus = new Activity();
$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
$tab_type = 'Calendar';
//added to fix 4600
$search=vtlib_purify($_REQUEST['search_url']);

$focus->column_fields["activitytype"] = 'Task';
if(isset($_REQUEST['record']))
{
	$focus->id = $_REQUEST['record'];
	$local_log->debug("id is ".$id);
}
if(isset($_REQUEST['mode']))
{
	$focus->mode = $_REQUEST['mode'];
}

if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
{
	$status ='';
	$activity_type='';
	$return_id = $focus->id;
	if(isset($_REQUEST['status']))
	{
		$status = $_REQUEST['status'];
		$activity_type = "Task";
	}
	elseif(isset($_REQUEST['eventstatus']))
	{
		$status = $_REQUEST['eventstatus'];
		$activity_type = "Events";
	}
	if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
	{
		ChangeStatus($status,$return_id,$activity_type);
	}
	else
	{
		echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
		echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
		echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

			<table border='0' cellpadding='5' cellspacing='0' width='98%'>
			<tbody><tr>
			<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
			<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
			</tr>
			<tr>
			<td class='small' align='right' nowrap='nowrap'>
			<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
			</tr>
			</tbody></table>
		</div>";
		echo "</td></tr></table>";die;
	}
	$invitee_qry = "select * from vtiger_invitees where activityid=?";
	$invitee_res = $adb->pquery($invitee_qry, array($return_id));
	$count = $adb->num_rows($invitee_res);
	if($count != 0)
	{
		for($j = 0; $j < $count; $j++)
		{
			$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

		}
		$invitees_ids_string = implode(';',$invitees_ids);
		sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
	}


}
else
{
	$timeFields = array('time_start', 'time_end');
	$tabId = getTabid($tab_type);
	foreach($focus->column_fields as $fieldname => $val)
	{
		$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
		$uitype = $fieldInfo['uitype'];
		$typeofdata = $fieldInfo['typeofdata'];
		if(isset($_REQUEST[$fieldname]))
		{
			if(is_array($_REQUEST[$fieldname]))
				$value = $_REQUEST[$fieldname];
			else
				$value = trim($_REQUEST[$fieldname]);

			if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
				if(!in_array($fieldname, $timeFields)) {
					$date = DateTimeField::convertToDBTimeZone($value);
					$value = $date->format('H:i');
				}
				$focus->column_fields[$fieldname] = $value;
			}else{
				$focus->column_fields[$fieldname] = $value;
			}
			if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
			{
				$focus->column_fields['time_start'] = '';
				$focus->column_fields['duration_hours'] = '';
				$focus->column_fields['duration_minutes'] = '';
			}
			if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
				$focus->column_fields['recurringtype'] = '--None--';
		}
	}
	if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
	        $focus->column_fields['visibility'] = $_REQUEST['visibility'];
	else
	        $focus->column_fields['visibility'] = 'Private';

	if($_REQUEST['assigntype'] == 'U') {
		$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
	} elseif($_REQUEST['assigntype'] == 'T') {
		$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
	}

	$dateField = 'date_start';
	$fieldname = 'time_start';
	$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
	$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
	$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
	if(empty($_REQUEST['time_end'])) {
		$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
												strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
	}
	$dateField = 'due_date';
	$fieldname = 'time_end';
	$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
	$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
	$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

	$focus->save($tab_type);
	/* For Followup START -- by Minnie */
	if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
	{
		$heldevent_id = $focus->id;
		$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
		$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
				$_REQUEST['followup_time_start']);
		$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
				$_REQUEST['followup_time_end']);
		$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
		$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
		$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
		$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
		$focus->column_fields['eventstatus'] = 'Planned';
		$focus->mode = 'create';
		$focus->save($tab_type);
	}
	/* For Followup END -- by Minnie */
	$return_id = $focus->id;
}

if ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Application sending"){
/*zakryvaem otpravku pis'ma i sozdaem ojidanie*/
	$res=mysql_query("update vtiger_leaddetails set leadstatus='2. App Out' where leadid='".((int)$_REQUEST['parent_id'])."'");
	$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Awaiting application";
	$_REQUEST['mode']="";
	$_REQUEST['description']="";
	$_REQUEST['subject']="Waiting for a signed application from the client.";
	
	$local_log =& LoggerManager::getLogger('index');
	$focus = new Activity();
	$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
	$tab_type = 'Calendar';
	//added to fix 4600
	$search=vtlib_purify($_REQUEST['search_url']);

	$focus->column_fields["activitytype"] = 'Task';
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
		$local_log->debug("id is ".$id);
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}

	if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
	{
		$status ='';
		$activity_type='';
		$return_id = $focus->id;
		if(isset($_REQUEST['status']))
		{
			$status = $_REQUEST['status'];
			$activity_type = "Task";
		}
		elseif(isset($_REQUEST['eventstatus']))
		{
			$status = $_REQUEST['eventstatus'];
			$activity_type = "Events";
		}
		if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
		{
			ChangeStatus($status,$return_id,$activity_type);
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
				</tr>
				</tbody></table>
			</div>";
			echo "</td></tr></table>";die;
		}
		$invitee_qry = "select * from vtiger_invitees where activityid=?";
		$invitee_res = $adb->pquery($invitee_qry, array($return_id));
		$count = $adb->num_rows($invitee_res);
		if($count != 0)
		{
			for($j = 0; $j < $count; $j++)
			{
				$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

			}
			$invitees_ids_string = implode(';',$invitees_ids);
			sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
		}


	}
	else
	{
		$timeFields = array('time_start', 'time_end');
		$tabId = getTabid($tab_type);
		foreach($focus->column_fields as $fieldname => $val)
		{
			$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
			$uitype = $fieldInfo['uitype'];
			$typeofdata = $fieldInfo['typeofdata'];
			if(isset($_REQUEST[$fieldname]))
			{
				if(is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);

				if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
					if(!in_array($fieldname, $timeFields)) {
						$date = DateTimeField::convertToDBTimeZone($value);
						$value = $date->format('H:i');
					}
					$focus->column_fields[$fieldname] = $value;
				}else{
					$focus->column_fields[$fieldname] = $value;
				}
				if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
				{
					$focus->column_fields['time_start'] = '';
					$focus->column_fields['duration_hours'] = '';
					$focus->column_fields['duration_minutes'] = '';
				}
				if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
					$focus->column_fields['recurringtype'] = '--None--';
			}
		}
		if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
				$focus->column_fields['visibility'] = $_REQUEST['visibility'];
		else
				$focus->column_fields['visibility'] = 'Private';

		if($_REQUEST['assigntype'] == 'U') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
		} elseif($_REQUEST['assigntype'] == 'T') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
		}

		$dateField = 'date_start';
		$fieldname = 'time_start';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
		if(empty($_REQUEST['time_end'])) {
			$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
													strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
		}
		$dateField = 'due_date';
		$fieldname = 'time_end';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

		$focus->save($tab_type);
		/* For Followup START -- by Minnie */
		if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
		{
			$heldevent_id = $focus->id;
			$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
			$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
					$_REQUEST['followup_time_start']);
			$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
					$_REQUEST['followup_time_end']);
			$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
			$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
			$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
			$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
			$focus->column_fields['eventstatus'] = 'Planned';
			$focus->mode = 'create';
			$focus->save($tab_type);
		}
		/* For Followup END -- by Minnie */
		$return_id = $focus->id;
	}
	
	
	
}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Awaiting application"){
/*zakryvaem ojidanie zayavki, nachinaem proverku zayavki*/
	$res=mysql_query("update vtiger_leaddetails set leadstatus='3. App In' where leadid='".((int)$_REQUEST['parent_id'])."'");
	/*$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Application check";
	$_REQUEST['mode']="";
	$_REQUEST['subject']="Check a signed application.";*/
	$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Awaiting Approval";
	$_REQUEST['mode']="";
	$_REQUEST['description']="";
	$_REQUEST['subject']="Adding data from the application to the vTiger.";
	
	$local_log =& LoggerManager::getLogger('index');
	$focus = new Activity();
	$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
	$tab_type = 'Calendar';
	//added to fix 4600
	$search=vtlib_purify($_REQUEST['search_url']);

	$focus->column_fields["activitytype"] = 'Task';
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
		$local_log->debug("id is ".$id);
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}

	if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
	{
		$status ='';
		$activity_type='';
		$return_id = $focus->id;
		if(isset($_REQUEST['status']))
		{
			$status = $_REQUEST['status'];
			$activity_type = "Task";
		}
		elseif(isset($_REQUEST['eventstatus']))
		{
			$status = $_REQUEST['eventstatus'];
			$activity_type = "Events";
		}
		if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
		{
			ChangeStatus($status,$return_id,$activity_type);
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
				</tr>
				</tbody></table>
			</div>";
			echo "</td></tr></table>";die;
		}
		$invitee_qry = "select * from vtiger_invitees where activityid=?";
		$invitee_res = $adb->pquery($invitee_qry, array($return_id));
		$count = $adb->num_rows($invitee_res);
		if($count != 0)
		{
			for($j = 0; $j < $count; $j++)
			{
				$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

			}
			$invitees_ids_string = implode(';',$invitees_ids);
			sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
		}


	}
	else
	{
		$timeFields = array('time_start', 'time_end');
		$tabId = getTabid($tab_type);
		foreach($focus->column_fields as $fieldname => $val)
		{
			$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
			$uitype = $fieldInfo['uitype'];
			$typeofdata = $fieldInfo['typeofdata'];
			if(isset($_REQUEST[$fieldname]))
			{
				if(is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);

				if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
					if(!in_array($fieldname, $timeFields)) {
						$date = DateTimeField::convertToDBTimeZone($value);
						$value = $date->format('H:i');
					}
					$focus->column_fields[$fieldname] = $value;
				}else{
					$focus->column_fields[$fieldname] = $value;
				}
				if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
				{
					$focus->column_fields['time_start'] = '';
					$focus->column_fields['duration_hours'] = '';
					$focus->column_fields['duration_minutes'] = '';
				}
				if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
					$focus->column_fields['recurringtype'] = '--None--';
			}
		}
		if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
				$focus->column_fields['visibility'] = $_REQUEST['visibility'];
		else
				$focus->column_fields['visibility'] = 'Private';

		if($_REQUEST['assigntype'] == 'U') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
		} elseif($_REQUEST['assigntype'] == 'T') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
		}

		$dateField = 'date_start';
		$fieldname = 'time_start';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
		if(empty($_REQUEST['time_end'])) {
			$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
													strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
		}
		$dateField = 'due_date';
		$fieldname = 'time_end';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

		$focus->save($tab_type);
		/* For Followup START -- by Minnie */
		if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
		{
			$heldevent_id = $focus->id;
			$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
			$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
					$_REQUEST['followup_time_start']);
			$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
					$_REQUEST['followup_time_end']);
			$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
			$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
			$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
			$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
			$focus->column_fields['eventstatus'] = 'Planned';
			$focus->mode = 'create';
			$focus->save($tab_type);
		}
		/* For Followup END -- by Minnie */
		$return_id = $focus->id;
	}
	
	
	
/*}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Application check"){*/
/*zakryvaem proverku zayavki,vnosim zayavku v vtiger*/
/*	//$res=mysql_query("update vtiger_leaddetails set leadstatus='3. App Confirmed' where leadid='".((int)$_REQUEST['parent_id'])."'");
	//$res=mysql_query("update vtiger_leaddetails set leadstatus='3. Submitted' where leadid='".((int)$_REQUEST['parent_id'])."'");
	$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Submit application";
	$_REQUEST['mode']="";
	$_REQUEST['subject']="Adding data from the application to the vTiger.";
	
	$local_log =& LoggerManager::getLogger('index');
	$focus = new Activity();
	$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
	$tab_type = 'Calendar';
	//added to fix 4600
	$search=vtlib_purify($_REQUEST['search_url']);

	$focus->column_fields["activitytype"] = 'Task';
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
		$local_log->debug("id is ".$id);
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}

	if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
	{
		$status ='';
		$activity_type='';
		$return_id = $focus->id;
		if(isset($_REQUEST['status']))
		{
			$status = $_REQUEST['status'];
			$activity_type = "Task";
		}
		elseif(isset($_REQUEST['eventstatus']))
		{
			$status = $_REQUEST['eventstatus'];
			$activity_type = "Events";
		}
		if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
		{
			ChangeStatus($status,$return_id,$activity_type);
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
				</tr>
				</tbody></table>
			</div>";
			echo "</td></tr></table>";die;
		}
		$invitee_qry = "select * from vtiger_invitees where activityid=?";
		$invitee_res = $adb->pquery($invitee_qry, array($return_id));
		$count = $adb->num_rows($invitee_res);
		if($count != 0)
		{
			for($j = 0; $j < $count; $j++)
			{
				$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

			}
			$invitees_ids_string = implode(';',$invitees_ids);
			sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
		}


	}
	else
	{
		$timeFields = array('time_start', 'time_end');
		$tabId = getTabid($tab_type);
		foreach($focus->column_fields as $fieldname => $val)
		{
			$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
			$uitype = $fieldInfo['uitype'];
			$typeofdata = $fieldInfo['typeofdata'];
			if(isset($_REQUEST[$fieldname]))
			{
				if(is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);

				if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
					if(!in_array($fieldname, $timeFields)) {
						$date = DateTimeField::convertToDBTimeZone($value);
						$value = $date->format('H:i');
					}
					$focus->column_fields[$fieldname] = $value;
				}else{
					$focus->column_fields[$fieldname] = $value;
				}
				if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
				{
					$focus->column_fields['time_start'] = '';
					$focus->column_fields['duration_hours'] = '';
					$focus->column_fields['duration_minutes'] = '';
				}
				if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
					$focus->column_fields['recurringtype'] = '--None--';
			}
		}
		if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
				$focus->column_fields['visibility'] = $_REQUEST['visibility'];
		else
				$focus->column_fields['visibility'] = 'Private';

		if($_REQUEST['assigntype'] == 'U') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
		} elseif($_REQUEST['assigntype'] == 'T') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
		}

		$dateField = 'date_start';
		$fieldname = 'time_start';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
		if(empty($_REQUEST['time_end'])) {
			$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
													strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
		}
		$dateField = 'due_date';
		$fieldname = 'time_end';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

		$focus->save($tab_type);
		if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
		{
			$heldevent_id = $focus->id;
			$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
			$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
					$_REQUEST['followup_time_start']);
			$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
					$_REQUEST['followup_time_end']);
			$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
			$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
			$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
			$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
			$focus->column_fields['eventstatus'] = 'Planned';
			$focus->mode = 'create';
			$focus->save($tab_type);
		}
		$return_id = $focus->id;
	}*/
/*}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Submit application"){

	$res=mysql_query("update vtiger_leaddetails set leadstatus='4. Submitted' where leadid='".((int)$_REQUEST['parent_id'])."'");
	$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Awaiting Approval";
	$_REQUEST['mode']="";
	$_REQUEST['description']="";
	$_REQUEST['subject']="Review of an application for funding.";
	
	$local_log =& LoggerManager::getLogger('index');
	$focus = new Activity();
	$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
	$tab_type = 'Calendar';
	//added to fix 4600
	$search=vtlib_purify($_REQUEST['search_url']);

	$focus->column_fields["activitytype"] = 'Task';
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
		$local_log->debug("id is ".$id);
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}

	if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
	{
		$status ='';
		$activity_type='';
		$return_id = $focus->id;
		if(isset($_REQUEST['status']))
		{
			$status = $_REQUEST['status'];
			$activity_type = "Task";
		}
		elseif(isset($_REQUEST['eventstatus']))
		{
			$status = $_REQUEST['eventstatus'];
			$activity_type = "Events";
		}
		if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
		{
			ChangeStatus($status,$return_id,$activity_type);
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
				</tr>
				</tbody></table>
			</div>";
			echo "</td></tr></table>";die;
		}
		$invitee_qry = "select * from vtiger_invitees where activityid=?";
		$invitee_res = $adb->pquery($invitee_qry, array($return_id));
		$count = $adb->num_rows($invitee_res);
		if($count != 0)
		{
			for($j = 0; $j < $count; $j++)
			{
				$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

			}
			$invitees_ids_string = implode(';',$invitees_ids);
			sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
		}


	}
	else
	{
		$timeFields = array('time_start', 'time_end');
		$tabId = getTabid($tab_type);
		foreach($focus->column_fields as $fieldname => $val)
		{
			$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
			$uitype = $fieldInfo['uitype'];
			$typeofdata = $fieldInfo['typeofdata'];
			if(isset($_REQUEST[$fieldname]))
			{
				if(is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);

				if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
					if(!in_array($fieldname, $timeFields)) {
						$date = DateTimeField::convertToDBTimeZone($value);
						$value = $date->format('H:i');
					}
					$focus->column_fields[$fieldname] = $value;
				}else{
					$focus->column_fields[$fieldname] = $value;
				}
				if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
				{
					$focus->column_fields['time_start'] = '';
					$focus->column_fields['duration_hours'] = '';
					$focus->column_fields['duration_minutes'] = '';
				}
				if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
					$focus->column_fields['recurringtype'] = '--None--';
			}
		}
		if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
				$focus->column_fields['visibility'] = $_REQUEST['visibility'];
		else
				$focus->column_fields['visibility'] = 'Private';

		if($_REQUEST['assigntype'] == 'U') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
		} elseif($_REQUEST['assigntype'] == 'T') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
		}

		$dateField = 'date_start';
		$fieldname = 'time_start';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
		if(empty($_REQUEST['time_end'])) {
			$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
													strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
		}
		$dateField = 'due_date';
		$fieldname = 'time_end';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

		$focus->save($tab_type);

		if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
		{
			$heldevent_id = $focus->id;
			$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
			$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
					$_REQUEST['followup_time_start']);
			$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
					$_REQUEST['followup_time_end']);
			$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
			$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
			$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
			$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
			$focus->column_fields['eventstatus'] = 'Planned';
			$focus->mode = 'create';
			$focus->save($tab_type);
		}

		$return_id = $focus->id;
	}
	
*/}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Awaiting Approval"){
	
	$q=  '###'.strtolower($_REQUEST['description']);
	if (strpos($q, "declined")){
		$res=mysql_query("update vtiger_leaddetails set leadstatus='9. Declined' where leadid='".((int)$_REQUEST['parent_id'])."'");
	}elseif(strpos($q, "approved")){
		
		/* If you need send mail with contract */
		/*$res=  mysql_query("select * from vtiger_leaddetails ld 
	left join vtiger_leadscf lcf on ld.leadid=lcf.leadid
	left join vtiger_leadsubdetails lsd on ld.leadid=lsd.leadsubscriptionid
	left join vtiger_crmentity crm on ld.leadid=crm.crmid
	where ld.leadid='".(int)$_REQUEST['leadid']."'");
		if (mysql_num_rows($res)==1){
			require_once('modules/Emails/mail.php');
		
			$result = $adb->query("select user_name, email1, email2 from vtiger_users where id=1");
			$from_email = $adb->query_result($result,0,'email1');
			$from_name  = $adb->query_result($result,0,'user_name');
		
			$data=array();
			while ($row=  mysql_fetch_array($res, MYSQL_ASSOC)) $data=$row;
			extract($data, EXTR_OVERWRITE);
			$filename = dirname(dirname(__DIR__))."/include/MPDF/contract.pdf";
			send_mail('Leads',$email,$from_name,$from_email,'Powerline Funding Application',"$firstname $lastname!\r\n\r\nPlease read the contract and send it to our mailbox", '', '','','','',$filename);
			
		}*/
		$res=mysql_query("update vtiger_leaddetails set leadstatus='4. Approved' where leadid='".((int)$_REQUEST['parent_id'])."'");
		$_REQUEST['id']="";
		$_REQUEST['eventstatus']="Not Held";
		$_REQUEST['activitytype']="Send contract";
		$_REQUEST['mode']="";
		$_REQUEST['description']="";
		$_REQUEST['subject']="Sending the contract to the client.";
		
		$local_log =& LoggerManager::getLogger('index');
		$focus = new Activity();
		$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
		$tab_type = 'Calendar';
		//added to fix 4600
		$search=vtlib_purify($_REQUEST['search_url']);

		$focus->column_fields["activitytype"] = 'Task';
		if(isset($_REQUEST['record']))
		{
			$focus->id = $_REQUEST['record'];
			$local_log->debug("id is ".$id);
		}
		if(isset($_REQUEST['mode']))
		{
			$focus->mode = $_REQUEST['mode'];
		}

		if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
		{
			$status ='';
			$activity_type='';
			$return_id = $focus->id;
			if(isset($_REQUEST['status']))
			{
				$status = $_REQUEST['status'];
				$activity_type = "Task";
			}
			elseif(isset($_REQUEST['eventstatus']))
			{
				$status = $_REQUEST['eventstatus'];
				$activity_type = "Events";
			}
			if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
			{
				ChangeStatus($status,$return_id,$activity_type);
			}
			else
			{
				echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
				echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
				echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

					<table border='0' cellpadding='5' cellspacing='0' width='98%'>
					<tbody><tr>
					<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
					<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
					</tr>
					<tr>
					<td class='small' align='right' nowrap='nowrap'>
					<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
					</tr>
					</tbody></table>
				</div>";
				echo "</td></tr></table>";die;
			}
			$invitee_qry = "select * from vtiger_invitees where activityid=?";
			$invitee_res = $adb->pquery($invitee_qry, array($return_id));
			$count = $adb->num_rows($invitee_res);
			if($count != 0)
			{
				for($j = 0; $j < $count; $j++)
				{
					$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

				}
				$invitees_ids_string = implode(';',$invitees_ids);
				sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
			}


		}
		else
		{
			$timeFields = array('time_start', 'time_end');
			$tabId = getTabid($tab_type);
			foreach($focus->column_fields as $fieldname => $val)
			{
				$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
				$uitype = $fieldInfo['uitype'];
				$typeofdata = $fieldInfo['typeofdata'];
				if(isset($_REQUEST[$fieldname]))
				{
					if(is_array($_REQUEST[$fieldname]))
						$value = $_REQUEST[$fieldname];
					else
						$value = trim($_REQUEST[$fieldname]);

					if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
						if(!in_array($fieldname, $timeFields)) {
							$date = DateTimeField::convertToDBTimeZone($value);
							$value = $date->format('H:i');
						}
						$focus->column_fields[$fieldname] = $value;
					}else{
						$focus->column_fields[$fieldname] = $value;
					}
					if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
					{
						$focus->column_fields['time_start'] = '';
						$focus->column_fields['duration_hours'] = '';
						$focus->column_fields['duration_minutes'] = '';
					}
					if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
						$focus->column_fields['recurringtype'] = '--None--';
				}
			}
			if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
					$focus->column_fields['visibility'] = $_REQUEST['visibility'];
			else
					$focus->column_fields['visibility'] = 'Private';

			if($_REQUEST['assigntype'] == 'U') {
				$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
			} elseif($_REQUEST['assigntype'] == 'T') {
				$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
			}

			$dateField = 'date_start';
			$fieldname = 'time_start';
			$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
			$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
			$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
			if(empty($_REQUEST['time_end'])) {
				$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
														strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
			}
			$dateField = 'due_date';
			$fieldname = 'time_end';
			$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
			$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
			$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

			$focus->save($tab_type);
			/* For Followup START -- by Minnie */
			if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
			{
				$heldevent_id = $focus->id;
				$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
				$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
						$_REQUEST['followup_time_start']);
				$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
						$_REQUEST['followup_time_end']);
				$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
				$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
				$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
				$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
				$focus->column_fields['eventstatus'] = 'Planned';
				$focus->mode = 'create';
				$focus->save($tab_type);
			}
			/* For Followup END -- by Minnie */
			$return_id = $focus->id;
		}
	}
	
}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Send contract"){
/*otpravili emu kontrakt i jdem-s*/
	$res=mysql_query("update vtiger_leaddetails set leadstatus='5. Contract Out' where leadid='".((int)$_REQUEST['parent_id'])."'");	
	$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Waiting for contract";
	$_REQUEST['mode']="";
	$_REQUEST['description']="";
	$_REQUEST['subject']="Waiting for a signed contract from the client.";
	
	$local_log =& LoggerManager::getLogger('index');
	$focus = new Activity();
	$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
	$tab_type = 'Calendar';
	//added to fix 4600
	$search=vtlib_purify($_REQUEST['search_url']);

	$focus->column_fields["activitytype"] = 'Task';
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
		$local_log->debug("id is ".$id);
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}

	if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
	{
		$status ='';
		$activity_type='';
		$return_id = $focus->id;
		if(isset($_REQUEST['status']))
		{
			$status = $_REQUEST['status'];
			$activity_type = "Task";
		}
		elseif(isset($_REQUEST['eventstatus']))
		{
			$status = $_REQUEST['eventstatus'];
			$activity_type = "Events";
		}
		if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
		{
			ChangeStatus($status,$return_id,$activity_type);
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
				</tr>
				</tbody></table>
			</div>";
			echo "</td></tr></table>";die;
		}
		$invitee_qry = "select * from vtiger_invitees where activityid=?";
		$invitee_res = $adb->pquery($invitee_qry, array($return_id));
		$count = $adb->num_rows($invitee_res);
		if($count != 0)
		{
			for($j = 0; $j < $count; $j++)
			{
				$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

			}
			$invitees_ids_string = implode(';',$invitees_ids);
			sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
		}


	}
	else
	{
		$timeFields = array('time_start', 'time_end');
		$tabId = getTabid($tab_type);
		foreach($focus->column_fields as $fieldname => $val)
		{
			$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
			$uitype = $fieldInfo['uitype'];
			$typeofdata = $fieldInfo['typeofdata'];
			if(isset($_REQUEST[$fieldname]))
			{
				if(is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);

				if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
					if(!in_array($fieldname, $timeFields)) {
						$date = DateTimeField::convertToDBTimeZone($value);
						$value = $date->format('H:i');
					}
					$focus->column_fields[$fieldname] = $value;
				}else{
					$focus->column_fields[$fieldname] = $value;
				}
				if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
				{
					$focus->column_fields['time_start'] = '';
					$focus->column_fields['duration_hours'] = '';
					$focus->column_fields['duration_minutes'] = '';
				}
				if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
					$focus->column_fields['recurringtype'] = '--None--';
			}
		}
		if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
				$focus->column_fields['visibility'] = $_REQUEST['visibility'];
		else
				$focus->column_fields['visibility'] = 'Private';

		if($_REQUEST['assigntype'] == 'U') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
		} elseif($_REQUEST['assigntype'] == 'T') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
		}

		$dateField = 'date_start';
		$fieldname = 'time_start';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
		if(empty($_REQUEST['time_end'])) {
			$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
													strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
		}
		$dateField = 'due_date';
		$fieldname = 'time_end';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

		$focus->save($tab_type);
		/* For Followup START -- by Minnie */
		if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
		{
			$heldevent_id = $focus->id;
			$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
			$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
					$_REQUEST['followup_time_start']);
			$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
					$_REQUEST['followup_time_end']);
			$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
			$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
			$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
			$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
			$focus->column_fields['eventstatus'] = 'Planned';
			$focus->mode = 'create';
			$focus->save($tab_type);
		}
		/* For Followup END -- by Minnie */
		$return_id = $focus->id;
	}
	
}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Waiting for contract"){
	
	$res=mysql_query("update vtiger_leaddetails set leadstatus='6. Contract In' where leadid='".((int)$_REQUEST['parent_id'])."'");
	$_REQUEST['id']="";
	$_REQUEST['eventstatus']="Not Held";
	$_REQUEST['activitytype']="Funding";
	$_REQUEST['mode']="";
	$_REQUEST['description']="";
	$_REQUEST['subject']="Funding.";
	
	$local_log =& LoggerManager::getLogger('index');
	$focus = new Activity();
	$activity_mode = vtlib_purify($_REQUEST['activity_mode']);
	$tab_type = 'Calendar';
	//added to fix 4600
	$search=vtlib_purify($_REQUEST['search_url']);

	$focus->column_fields["activitytype"] = 'Task';
	if(isset($_REQUEST['record']))
	{
		$focus->id = $_REQUEST['record'];
		$local_log->debug("id is ".$id);
	}
	if(isset($_REQUEST['mode']))
	{
		$focus->mode = $_REQUEST['mode'];
	}

	if((isset($_REQUEST['change_status']) && $_REQUEST['change_status']) && ($_REQUEST['status']!='' || $_REQUEST['eventstatus']!=''))
	{
		$status ='';
		$activity_type='';
		$return_id = $focus->id;
		if(isset($_REQUEST['status']))
		{
			$status = $_REQUEST['status'];
			$activity_type = "Task";
		}
		elseif(isset($_REQUEST['eventstatus']))
		{
			$status = $_REQUEST['eventstatus'];
			$activity_type = "Events";
		}
		if(isPermitted("Calendar","EditView",$_REQUEST['record']) == 'yes')
		{
			ChangeStatus($status,$return_id,$activity_type);
		}
		else
		{
			echo "<link rel='stylesheet' type='text/css' href='themes/$theme/style.css'>";
			echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
			echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

				<table border='0' cellpadding='5' cellspacing='0' width='98%'>
				<tbody><tr>
				<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $theme). ?>' ></td>
				<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span class='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
				</tr>
				<tr>
				<td class='small' align='right' nowrap='nowrap'>
				<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>								   						     </td>
				</tr>
				</tbody></table>
			</div>";
			echo "</td></tr></table>";die;
		}
		$invitee_qry = "select * from vtiger_invitees where activityid=?";
		$invitee_res = $adb->pquery($invitee_qry, array($return_id));
		$count = $adb->num_rows($invitee_res);
		if($count != 0)
		{
			for($j = 0; $j < $count; $j++)
			{
				$invitees_ids[]= $adb->query_result($invitee_res,$j,"inviteeid");

			}
			$invitees_ids_string = implode(';',$invitees_ids);
			sendInvitation($invitees_ids_string,$activity_type,$mail_data['subject'],$mail_data);
		}


	}
	else
	{
		$timeFields = array('time_start', 'time_end');
		$tabId = getTabid($tab_type);
		foreach($focus->column_fields as $fieldname => $val)
		{
			$fieldInfo = getFieldRelatedInfo($tabId, $fieldname);
			$uitype = $fieldInfo['uitype'];
			$typeofdata = $fieldInfo['typeofdata'];
			if(isset($_REQUEST[$fieldname]))
			{
				if(is_array($_REQUEST[$fieldname]))
					$value = $_REQUEST[$fieldname];
				else
					$value = trim($_REQUEST[$fieldname]);

				if((($typeofdata == 'T~M') || ($typeofdata == 'T~O')) && ($uitype == 2 || $uitype == 70 )) {
					if(!in_array($fieldname, $timeFields)) {
						$date = DateTimeField::convertToDBTimeZone($value);
						$value = $date->format('H:i');
					}
					$focus->column_fields[$fieldname] = $value;
				}else{
					$focus->column_fields[$fieldname] = $value;
				}
				if(($fieldname == 'notime') && ($focus->column_fields[$fieldname]))
				{
					$focus->column_fields['time_start'] = '';
					$focus->column_fields['duration_hours'] = '';
					$focus->column_fields['duration_minutes'] = '';
				}
				if(($fieldname == 'recurringtype') && ! isset($_REQUEST['recurringcheck']))
					$focus->column_fields['recurringtype'] = '--None--';
			}
		}
		if(isset($_REQUEST['visibility']) && $_REQUEST['visibility']!= '')
				$focus->column_fields['visibility'] = $_REQUEST['visibility'];
		else
				$focus->column_fields['visibility'] = 'Private';

		if($_REQUEST['assigntype'] == 'U') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_user_id'];
		} elseif($_REQUEST['assigntype'] == 'T') {
			$focus->column_fields['assigned_user_id'] = $_REQUEST['assigned_group_id'];
		}

		$dateField = 'date_start';
		$fieldname = 'time_start';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();
		if(empty($_REQUEST['time_end'])) {
			$_REQUEST['time_end'] = date('H:i', strtotime('+10 minutes',
													strtotime($focus->column_fields['date_start'].' '.$_REQUEST['time_start'])));
		}
		$dateField = 'due_date';
		$fieldname = 'time_end';
		$date = new DateTimeField($_REQUEST[$dateField]. ' ' . $_REQUEST[$fieldname]);
		$focus->column_fields[$dateField] = $date->getDBInsertDateValue();
		$focus->column_fields[$fieldname] = $date->getDBInsertTimeValue();

		$focus->save($tab_type);
		/* For Followup START -- by Minnie */
		if(isset($_REQUEST['followup']) && $_REQUEST['followup'] == 'on' && $activity_mode == 'Events' && isset($_REQUEST['followup_time_start']) &&  $_REQUEST['followup_time_start'] != '')
		{
			$heldevent_id = $focus->id;
			$focus->column_fields['subject'] = '[Followup] '.$focus->column_fields['subject'];
			$startDate = new DateTimeField($_REQUEST['followup_date'].' '.
					$_REQUEST['followup_time_start']);
			$endDate = new DateTimeField($_REQUEST['followup_due_date'].' '.
					$_REQUEST['followup_time_end']);
			$focus->column_fields['date_start'] = $startDate->getDBInsertDateValue();
			$focus->column_fields['due_date'] = $endDate->getDBInsertDateValue();
			$focus->column_fields['time_start'] = $startDate->getDBInsertTimeValue();
			$focus->column_fields['time_end'] = $endDate->getDBInsertTimeValue();
			$focus->column_fields['eventstatus'] = 'Planned';
			$focus->mode = 'create';
			$focus->save($tab_type);
		}
		/* For Followup END -- by Minnie */
		$return_id = $focus->id;
	}
	
}elseif ($_REQUEST['parent_type']=="Leads&action=Popup" && (int)$_REQUEST['parent_id']>0 && $_REQUEST['eventstatus']=="Held" && $_REQUEST['activitytype']=="Funding"){
	
	$res=mysql_query("update vtiger_leaddetails set leadstatus='7. Funded' where leadid='".((int)$_REQUEST['parent_id'])."'");
}

if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] != "")
	$return_module = vtlib_purify($_REQUEST['return_module']);
else
	$return_module = "Calendar";
if(isset($_REQUEST['return_action']) && $_REQUEST['return_action'] != "")
	$return_action = vtlib_purify($_REQUEST['return_action']);
else
	$return_action = "DetailView";
if(isset($_REQUEST['return_id']) && $_REQUEST['return_id'] != "")
	$return_id = vtlib_purify($_REQUEST['return_id']);

$activemode = "";
if($activity_mode != '')
	$activemode = "&activity_mode=".$activity_mode;

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

if(isset($_REQUEST['contactidlist']) && $_REQUEST['contactidlist'] != '')
{
	//split the string and store in an array
	$storearray = explode (";",$_REQUEST['contactidlist']);
	$del_sql = "delete from vtiger_cntactivityrel where activityid=?";
	$adb->pquery($del_sql, array($record));
	$record = $focus->id;
	foreach($storearray as $id)
	{
		if($id != '')
		{

			$sql = "insert into vtiger_cntactivityrel values (?,?)";
			$adb->pquery($sql, array($id, $record));
			if(!empty($heldevent_id)) {
				$sql = "insert into vtiger_cntactivityrel values (?,?)";
				$adb->pquery($sql, array($id, $heldevent_id));
			}
		}
	}
}

//code added to send mail to the vtiger_invitees
if(isset($_REQUEST['inviteesid']) && $_REQUEST['inviteesid']!='')
{
	$mail_contents = getRequestData($return_id);
	sendInvitation($_REQUEST['inviteesid'],$_REQUEST['activity_mode'],$_REQUEST['subject'],$mail_contents);
}

//to delete contact account relation while editing event
if(isset($_REQUEST['deletecntlist']) && $_REQUEST['deletecntlist'] != '' && $_REQUEST['mode'] == 'edit')
{
	//split the string and store it in an array
	$storearray = explode (";",$_REQUEST['deletecntlist']);
	foreach($storearray as $id)
	{
		if($id != '')
		{
			$record = $focus->id;
			$sql = "delete from vtiger_cntactivityrel where contactid=? and activityid=?";
			$adb->pquery($sql, array($id, $record));
		}
	}

}

//to delete activity and its parent table relation
if(isset($_REQUEST['del_actparent_rel']) && $_REQUEST['del_actparent_rel'] != '' && $_REQUEST['mode'] == 'edit')
{
	$parnt_id = $_REQUEST['del_actparent_rel'];
	$sql= 'delete from vtiger_seactivityrel where crmid=? and activityid=?';
	$adb->pquery($sql, array($parnt_id, $record));
}

if(isset($_REQUEST['view']) && $_REQUEST['view']!='')
	$view=vtlib_purify($_REQUEST['view']);
if(isset($_REQUEST['hour']) && $_REQUEST['hour']!='')
	$hour=vtlib_purify($_REQUEST['hour']);
if(isset($_REQUEST['day']) && $_REQUEST['day']!='')
	$day=vtlib_purify($_REQUEST['day']);
if(isset($_REQUEST['month']) && $_REQUEST['month']!='')
	$month=vtlib_purify($_REQUEST['month']);
if(isset($_REQUEST['year']) && $_REQUEST['year']!='')
	$year=vtlib_purify($_REQUEST['year']);
if(isset($_REQUEST['viewOption']) && $_REQUEST['viewOption']!='')
	$viewOption=vtlib_purify($_REQUEST['viewOption']);
if(isset($_REQUEST['subtab']) && $_REQUEST['subtab']!='')
	$subtab=vtlib_purify($_REQUEST['subtab']);

if($_REQUEST['recurringcheck']) {
	include_once dirname(__FILE__) . '/RepeatEvents.php';
	Calendar_RepeatEvents::repeatFromRequest($focus);
}

//code added for returning back to the current view after edit from list view
if($_REQUEST['return_viewname'] == '')
	$return_viewname='0';
if($_REQUEST['return_viewname'] != '')
	$return_viewname=vtlib_purify($_REQUEST['return_viewname']);

$parenttab=getParentTab();

if(!empty($_REQUEST['start'])) {
	$page='&start='.vtlib_purify($_REQUEST['start']);
}
if(!empty($_REQUEST['pagenumber'])){
	$page = "&start=".vtlib_purify($_REQUEST['pagenumber']);
}
if($_REQUEST['maintab'] == 'Calendar')
	header("Location: index.php?action=".$return_action."&module=".$return_module."&view=".$view."&hour=".$hour."&day=".$day."&month=".$month."&year=".$year."&record=".$return_id."&viewOption=".$viewOption."&subtab=".$subtab."&parenttab=$parenttab");
else
	header("Location: index.php?action=$return_action&module=$return_module$view$hour$day$month$year&record=$return_id$activemode&viewname=$return_viewname$page&parenttab=$parenttab$search");
?>
