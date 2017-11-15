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
//$p=print_r($_SESSION,true);echo "<pre>$p</pre>";
require_once('Smarty_setup.php');
require_once('data/Tracker.php');
require_once('include/CustomFieldUtil.php');
require_once('include/utils/utils.php');
require_once('include/utils/UserInfoUtil.php');
require_once('user_privileges/default_module_view.php');

if (isset($_SESSION)) session_start ();
$_SESSION['relatedlist']['Leads']=array(12=>'Activities');
$res=mysql_query("select count(notesid) countnote from vtiger_senotesrel where crmid='".$_REQUEST['record']."'");
while($row=  mysql_fetch_array($res,MYSQL_ASSOC))$count=$row['countnote'];
if ($count>0) $_SESSION['relatedlist']['Leads'][15]='Documents';
global $mod_strings;
global $app_strings;
global $currentModule, $singlepane_view, $current_user;
global $log;

$focus = CRMEntity::getInstance($currentModule);

if (isset($_REQUEST['record'])) {
	$focus->id = $_REQUEST['record'];

	$focus->retrieve_entity_info($_REQUEST['record'], "Leads");
	$focus->id = $_REQUEST['record'];
	$log->debug("id is " . $focus->id);
	$focus->firstname = $focus->column_fields['firstname'];
	$focus->lastname = $focus->column_fields['lastname'];
}
if (isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}

global $theme, $current_user;
$theme_path = "themes/" . $theme . "/";
$image_path = $theme_path . "images/";

$log->info("Lead detail view");

$smarty = new vtigerCRM_Smarty;
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("PRINT_URL", "phprint.php?jt=" . session_id() . $GLOBALS['request_string']);
$smarty->assign("ID", $focus->id);

// Module Sequence Numbering
$mod_seq_field = getModuleSequenceField($currentModule);
if ($mod_seq_field != null) {
	$mod_seq_id = $focus->column_fields[$mod_seq_field['name']];
} else {
	$mod_seq_id = $focus->id;
}
$smarty->assign('MOD_SEQ_ID', $mod_seq_id);
// END

$smarty->assign("SINGLE_MOD", 'Lead');

$lead_name = $focus->lastname;
if (getFieldVisibilityPermission($currentModule, $current_user->id, 'firstname') == '0') {
	$lead_name .= ' ' . $focus->firstname;
}
$smarty->assign("NAME", $lead_name);

$smarty->assign("UPDATEINFO", updateInfo($focus->id));
$smarty->assign("BLOCKS", getBlocks($currentModule, "detail_view", '', $focus->column_fields));
$smarty->assign("CUSTOMFIELD", $cust_fld);

if (useInternalMailer() == 1)
	$smarty->assign("INT_MAILER", "true");


$val = isPermitted("Leads", "EditView", $_REQUEST['record']);

if (isPermitted("Leads", "EditView", $_REQUEST['record']) == 'yes')
	$smarty->assign("EDIT_DUPLICATE", "permitted");


require_once 'modules/Leads/ConvertLeadUI.php';

$uiinfo = new ConvertLeadUI($_REQUEST['record'], $current_user);

if (isPermitted("Leads", "EditView", $_REQUEST['record']) == 'yes'
		&& isPermitted("Leads", "ConvertLead") == 'yes'
		&& (isPermitted("Accounts", "EditView") == 'yes' || isPermitted("Contacts", "EditView") == 'yes')
		&& (vtlib_isModuleActive('Contacts') || vtlib_isModuleActive('Accounts'))
		&& !isLeadConverted($focus->id)
		&& (($uiinfo->getCompany() != null) || ($uiinfo->isModuleActive('Contacts') == true))
) {
	$smarty->assign("CONVERTLEAD", "permitted");
}

$category = getParentTab();
$smarty->assign("CATEGORY", $category);


if (isPermitted("Leads", "Delete", $_REQUEST['record']) == 'yes')
	$smarty->assign("DELETE", "permitted");

if (isPermitted("Emails", "EditView", '') == 'yes') {
	//Added to pass the parents list as hidden for Emails -- 09-11-2005
	$parent_email = getEmailParentsList('Leads', $_REQUEST['record'], $focus);
	$smarty->assign("HIDDEN_PARENTS_LIST", $parent_email);
	$vtwsObject = VtigerWebserviceObject::fromName($adb, $currentModule);
	$vtwsCRMObjectMeta = new VtigerCRMObjectMeta($vtwsObject, $current_user);
	$emailFields = $vtwsCRMObjectMeta->getEmailFields();

	$smarty->assign("SENDMAILBUTTON","permitted");
	$emails=array();
	foreach($emailFields as $key => $value) {
		$emails[]=$value;
	}
	$smarty->assign("EMAILS", $emails);
	$cond="LTrim('%s') !=''";
	$condition=array();
	foreach($emails as $key => $value) {
		$condition[]=sprintf($cond,$value);
	}
	$condition_str=implode("||",$condition);
	$js="if(".$condition_str."){fnvshobj(this,'sendmail_cont');sendmail('".$currentModule."',".$_REQUEST['record'].");}else{OpenCompose('','create');}";

	$smarty->assign('JS',$js);
}

if (isPermitted("Leads", "Merge", '') == 'yes') {
	global $current_user;
	require("user_privileges/user_privileges_" . $current_user->id . ".php");

	$wordTemplateResult = fetchWordTemplateList("Leads");
	$tempCount = $adb->num_rows($wordTemplateResult);
	$tempVal = $adb->fetch_array($wordTemplateResult);
	for ($templateCount = 0; $templateCount < $tempCount; $templateCount++) {
		$optionString[$tempVal["templateid"]] = $tempVal["filename"];
		$tempVal = $adb->fetch_array($wordTemplateResult);
	}
	if ($is_admin)
		$smarty->assign("MERGEBUTTON", "permitted");
	elseif ($tempCount > 0)
		$smarty->assign("MERGEBUTTON", "permitted");

	$smarty->assign("TEMPLATECOUNT", $tempCount);
	$smarty->assign("WORDTEMPLATEOPTIONS", $app_strings['LBL_SELECT_TEMPLATE_TO_MAIL_MERGE']);
	$smarty->assign("TOPTIONS", $optionString);
}

$tabid = getTabid("Leads");
$validationData = getDBValidationData($focus->tab_name, $tabid);
$data = split_validationdataArray($validationData);

$smarty->assign("VALIDATION_DATA_FIELDNAME", $data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE", $data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL", $data['fieldlabel']);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);

$smarty->assign("MODULE", $currentModule);
$smarty->assign("EDIT_PERMISSION", isPermitted($currentModule, 'EditView', $_REQUEST['record']));
$smarty->assign("TODO_PERMISSION", CheckFieldPermission('parent_id', 'Calendar'));
$smarty->assign("EVENT_PERMISSION", CheckFieldPermission('parent_id', 'Events'));

$smarty->assign("IS_REL_LIST", isPresentRelatedLists($currentModule));
$smarty->assign("USE_ASTERISK", get_use_asterisk($current_user->id));

if ($singlepane_view == 'true') {
	$related_array = getRelatedLists($currentModule, $focus);
	$smarty->assign("RELATEDLISTS", $related_array);

	require_once('include/ListView/RelatedListViewSession.php');
	if (!empty($_REQUEST['selected_header']) && !empty($_REQUEST['selected_tab_id'])) {
		RelatedListViewSession::addRelatedModuleToSession(vtlib_purify($_REQUEST['selected_tab_id']), vtlib_purify($_REQUEST['selected_header']));
	}
	$open_related_modules = RelatedListViewSession::getRelatedModulesFromSession();
	$smarty->assign("SELECTEDHEADERS", $open_related_modules);
}
$smarty->assign("SinglePane_View", $singlepane_view);

if (PerformancePrefs::getBoolean('DETAILVIEW_RECORD_NAVIGATION', true) && isset($_SESSION[$currentModule . '_listquery'])) {
	$recordNavigationInfo = ListViewSession::getListViewNavigation($focus->id);
	VT_detailViewNavigation($smarty, $recordNavigationInfo, $focus->id);
}

// Record Change Notification
$focus->markAsViewed($current_user->id);
// END

include_once('vtlib/Vtiger/Link.php');
$customlink_params = Array('MODULE' => $currentModule, 'RECORD' => $focus->id, 'ACTION' => vtlib_purify($_REQUEST['action']));
$smarty->assign('CUSTOM_LINKS', Vtiger_Link::getAllByType(getTabid($currentModule), Array('DETAILVIEWBASIC', 'DETAILVIEW', 'DETAILVIEWWIDGET'), $customlink_params));

$smarty->assign('DETAILVIEW_AJAX_EDIT', PerformancePrefs::getBoolean('DETAILVIEW_AJAX_EDIT', true));

$viewblock=array(
	'Lead Information'=>1,
	'Business Information'=>1,
	'MERCHANT/OWNER INFORMATION'=>1,
	'Address Information'=>1
);
foreach($smarty->_tpl_vars['BLOCKS'] as $key=>$blockfields){
	if (isset($viewblock[$key])){
		foreach ($blockfields as $key2=>$blockrow){
			foreach ($blockrow as $key3=>$blockfield){
				switch ($blockfield['ui']){
					case 1:
					case 5:
					case 7:
					case 11:
					case 13:
					case 15:
					case 17:
					case 21:
						if ($blockfield['value']=="")
							$smarty->_tpl_vars['BLOCKS'][$key][$key2][$key3]['tdstyle']=" style='background:#ffff00;color:#000000;font-weight:bold;'";
						break;
				}
			}
		}
	}
}
$lastcomment="<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" border=\"0\" class=\"small\">
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align=\"right\"></td>
</tr>
<tr><td class=\"dvInnerHeader\" colspan=\"4\"><div style=\"float:left;font-weight:bold;\">
<div style=\"float:left;\">
<a href=\"javascript:showHideStatus('tblComments','aidComments','themes/softed/images/');\">
<img title=\"Display\" alt=\"Display\" style=\"border: 0px solid #000000;\" src=\"themes/images/activate.gif\" id=\"aidComments\">
</a>
</div>
<b>&nbsp;Notes</b>
</div>
</td>
</tr>
</table>
<div id=\"tblComments\"><div id=\"rightcommentview\" style=\"width:auto;display:block;overflow: auto; height: 250px;\">";
$res=  mysql_query("SELECT mc.commentcontent, crm.createdtime, u.first_name, u.last_name
FROM vtiger_modcomments mc
inner join vtiger_crmentity crm on mc.modcommentsid=crm.crmid
inner join vtiger_users u on crm.smownerid=u.id
WHERE related_to='".$_REQUEST['record']."'
order by mc.modcommentsid desc
limit 0,7");
while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
	$date = new DateTimeField($row['createdtime']);
	$lastcomment.="
<div class=\"dataField\" valign=\"top\" style=\"width: 99%; padding-top: 10px;\"> ".nl2br($row['commentcontent'])." </div>
<div class=\"dataLabel\" valign=\"top\" style=\"border-bottom: 1px dotted rgb(204, 204, 204); width: 99%; padding-bottom: 5px;\">
	<font color=\"darkred\"> Author: ".$row['first_name']." ".$row['last_name']." on ".$date->getDisplayDateTimeValue()." </font>
</div>";
}
$lastcomment.="</div><textarea id='rightcomment' style='width:100%'  class='detailedViewTextBox' rows='8' onblur=\"this.className='detailedViewTextBox'\" onfocus=\"this.className='detailedViewTextBoxOn'\"></textarea>"
		. "<input type='button' value=' Save ' class='crmbutton small save' onclick='newcomment(".$_REQUEST['record'].")' /> or
<a class='link' onclick=\"$('rightcomment').value='';\" href='javascript:;'>Clear</a></div>";
//$lastcomment="qwerty";
$smarty->assign("LAST7COMMENT",$lastcomment);

$newrow=count($smarty->_tpl_vars['BLOCKS']['Lead Information']);
$i=0;
foreach ($smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow-1] as $key=>$value){
	if ($i==1){
		if (is_array($value)) $usesecondcell=TRUE; else {
			unset($smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow-1][$key]);
			$usesecondcell=FALSE;
		}
	}
	$i++;
}
$res=mysql_query("select smcreatorid from vtiger_crmentity where crmid='".$_REQUEST['record']."'");
while ($row=  mysql_fetch_assoc($res)) $created=$row['smcreatorid'];
if ($usesecondcell) {
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow]=array(
		'Telephone Number'=>$smarty->_tpl_vars['BLOCKS']['Business Information'][0]['Telephone Number'],
		'City'=>$smarty->_tpl_vars['BLOCKS']['Business Information'][1]['City'],
	);
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow+1]=array(
		'State'=>$smarty->_tpl_vars['BLOCKS']['Business Information'][2]['State'],
		'Cell Phone Number'=>$smarty->_tpl_vars['BLOCKS']['MERCHANT/OWNER INFORMATION'][6]['Cell Phone Number'],
	);
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow+2]=array(
		'Home Phone Number'=>$smarty->_tpl_vars['BLOCKS']['MERCHANT/OWNER INFORMATION'][5]['Home Phone Number'],
		'Created By' => Array
                        (
                            'value' => getUserFullName($created),
                            'ui' => "1",
                            'options' => "",
                            'secid' => "",
                            'link' => "",
                            'cursymb' => "",
                            'salut' => "",
                            'notaccess' => "",
                            'cntimage' => "",
                            'isadmin' => "1",
                            'tablename' => "vtiger_crmentity",
                            'fldname' => "smcreatorid",
                            'fldid' => "creatorid",
                            'displaytype' => "1",
                            'readonly' => "1"
                        )
	);
}else { 
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow-1]['Telephone Number']=$smarty->_tpl_vars['BLOCKS']['Business Information'][0]['Telephone Number'];
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow]=array(
		'City'=>$smarty->_tpl_vars['BLOCKS']['Business Information'][1]['City'],
		'State'=>$smarty->_tpl_vars['BLOCKS']['Business Information'][2]['State'],
	);
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow+1]=array(
		'Cell Phone Number'=>$smarty->_tpl_vars['BLOCKS']['MERCHANT/OWNER INFORMATION'][6]['Cell Phone Number'],
		'Home Phone Number'=>$smarty->_tpl_vars['BLOCKS']['MERCHANT/OWNER INFORMATION'][5]['Home Phone Number'],
	);
	$smarty->_tpl_vars['BLOCKS']['Lead Information'][$newrow+2]=array(
		'Created By' => Array
                        (
                            'value' => getUserFullName($created),
                            'ui' => "1",
                            'options' => "",
                            'secid' => "",
                            'link' => "",
                            'cursymb' => "",
                            'salut' => "",
                            'notaccess' => "",
                            'cntimage' => "",
                            'isadmin' => "1",
                            'tablename' => "vtiger_crmentity",
                            'fldname' => "smcreatorid",
                            'fldid' => "creatorid",
                            'displaytype' => "1",
                            'readonly' => "1"
                        )
	);
}
//$p=print_r($smarty->_tpl_vars['BLOCKS'],true);echo "<pre>$p</pre>";
$res=  mysql_query("select leadstatus from vtiger_leaddetails where leadid='".$_REQUEST['record']."'");
while($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $leadstatus=$row['leadstatus'];

foreach ($smarty->_tpl_vars['BLOCKS'] as $key1=>$value1){
	if ($key1=="Contract Out" || $key1=="Funded")
	foreach ($value1 as $key2 => $value2) {
		foreach ($value2 as $key3=>$value3){
			if ($leadstatus!="6. Contract Out" && $key1=="Contract Out") $smarty->_tpl_vars['BLOCKS'][$key1][$key2][$key3]['readonly']=1;
			if ($leadstatus!="8. Funded" && $key1=="Funded") $smarty->_tpl_vars['BLOCKS'][$key1][$key2][$key3]['readonly']=1;
		}
	}
}

$allfunded='<table width="100%" cellspacing="0" cellpadding="0" border="0" class="small">
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td align="right"></td>
</tr>
<tr>
<td class="dvInnerHeader" colspan="4">
<div style="float:left;font-weight:bold;">
<div style="float:left;">
<a href="javascript:showHideStatus(\'tblFundeded\',\'aidFundeded\',\'themes/softed/images/\');">
<img title="Hide" alt="Hide" style="border: 0px solid #000000;" src="themes/images/activate.gif" id="aidFundeded">
</a>
</div>
<b>&nbsp;Funded</b>
<input class="crmbutton small save" type="button" onclick="changeleadstatus(\''.$leadstatus.'\')" value=" Add ">
</div>
</td>
</tr>
</table>
<div id="tblFundeded" style="width:auto;display:block;">';
$res=  mysql_query("select * from vtiger_leads_funded where leadid='".$_REQUEST['record']."' order by `timeadd`");
if (mysql_num_rows($res)>0){
	$allfunded.='<table class="lvt small" width="100%" cellspacing="1" cellpadding="3" border="0">
<tr>
<td class="lvtCol">Funder</td>
<td class="lvtCol">Advance amount</td>
<td class="lvtCol">Payback amount</td>
<td class="lvtCol">HP %</td>
<td class="lvtCol">Daily amount</td>
<td class="lvtCol">Closing costs</td>
<td class="lvtCol">Date funded</td>
<td class="lvtCol">Categories</td>';
if ($current_user->column_fields['is_admin']=="on")
$allfunded.='<td class="lvtCol" colspan=2></td>';
$allfunded.='</tr>';
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
		$date = new DateTimeField($row['datefunded']);
		$allfunded.='<tr class="lvtColData" bgcolor="white" onmouseout="this.className=\'lvtColData\'" onmouseover="this.className=\'lvtColDataHover\'">
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['funder'].'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['advamount'].'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['paybackamount'].'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['hp'].'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['dailyamount'].'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['closingcosts'].'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$date->getDisplayDate().'</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))">'.$row['categories'].'</td>
';
		if ($current_user->column_fields['is_admin']=="on")
			$allfunded.='<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" style="cursor:pointer;" onclick="editfunded(\''.$row['id'].'\')">EDIT</td>
<td onmouseout="vtlib_listview.trigger(\'cell.onmouseout\', $(this))" onmouseover="vtlib_listview.trigger(\'cell.onmouseover\', $(this))" style="cursor:pointer;" onclick="delfunded(\''.$row['id'].'\')">DEL</td>';
		$allfunded.='</tr>';
	}
	$allfunded.='</table>';
	if ($current_user->column_fields['is_admin']=="on")
		$allfunded.='<script type="text/javascript">
	function editfunded(record){
		window.open (\'index.php?module=Leads&action=LeadsAjax&file=changedata2&record=\' + record,
			"qwerty","toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,copyhistory=no,width=450,height=350");
	}
	function delfunded(record){
		if (confirm("Are you sure to remove this record?")){
			new Ajax.Request(
			\'index.php\',
			{
				queue:{
					position: \'end\',
					scope: \'command\'
				},
				method: \'post\',
				postBody:"module=Leads&action=LeadsAjax&file=removefunded&record=" + record,
				onComplete: function(response) {
					var str = response.responseText;
					if(str.indexOf(\'SUCCESS\') > -1)
					{
						location.reload();
					}else
					{
						alert(str);
					}
				}
			}
			);
			}
	}
</script>';
}else{
	$allfunded.="<div style='text-align:center'>No funded</div>";
}
$allfunded.='</div>';
$smarty->assign("ALLFUNDED",$allfunded);

$res=  mysql_query("SELECT vtiger_leaddetails.leadid 
FROM vtiger_leaddetails 
INNER JOIN vtiger_crmentity ON vtiger_leaddetails.leadid = vtiger_crmentity.crmid 
INNER JOIN vtiger_leadscf ON vtiger_leaddetails.leadid = vtiger_leadscf.leadid 
LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id 
LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid 
WHERE vtiger_crmentity.deleted=0 
and vtiger_leaddetails.converted=0 
AND vtiger_leaddetails.leadid > 0 
and vtiger_leaddetails.leadstatus='".$smarty->_tpl_vars['BLOCKS']['LEAD STATUS'][0]['Lead Status']['value']."'");
while($row=  mysql_fetch_assoc($res)) $d[]=$row['leadid'];
foreach ($d as $key=>$value){
	if ($value==$_REQUEST['record']){
		if (isset($d[$key-1])) $smarty->_tpl_vars['privrecord']=$d[$key-1]; else $smarty->_tpl_vars['privrecord']="";
		if (isset($d[$key+1])) $smarty->_tpl_vars['nextrecord']=$d[$key+1]; else $smarty->_tpl_vars['nexrecord']="";
		break;
	}
}
/*$p=print_r($smarty->_tpl_vars['privrecord'],true);echo "<pre>$p</pre>";
$p=print_r($smarty->_tpl_vars['nextrecord'],true);echo "<pre>$p</pre>";
$p=print_r($_SESSION['Leads_listquery'],true);echo "<pre>$p</pre>";
if ($smarty->_tpl_vars['privrecord']=="" && $smarty->_tpl_vars['nextrecord']=="" && isset($_SESSION['Leads_listquery'])){
	$list_query=$_SESSION['Leads_listquery'];
	$res=mysql_query($list_query);
	$arrres=array();
	while ($row=  mysql_fetch_assoc($res))$arrres[]=$row;
	foreach ($arrres as $key=>$value){
		if ($value['leadid']==$_REQUEST['record']){
			if ($key>0) $smarty->_tpl_vars['privrecord']=$arrres[$key-1]['leadid'];
			if ($key<count($arrres)-1) $smarty->_tpl_vars['nextrecord']=$arrres[$key+1]['leadid'];
		}
	}
	if ($smarty->_tpl_vars['privrecord']=="" && isset($arrres[0]))$smarty->_tpl_vars['privrecord']=$arrres[0]['leadid'];
	if ($smarty->_tpl_vars['nextrecord']=="" && isset($arrres[1]))$smarty->_tpl_vars['nextrecord']=$arrres[1]['leadid'];
	if ($smarty->_tpl_vars['privrecord']!="")$smarty->_tpl_vars['privrecordstart']=1;
	if ($smarty->_tpl_vars['nextrecord']!="")$smarty->_tpl_vars['nextrecordstart']=1;
}*/
/*if (!isset($_SESSION['Leads_DetailView_Navigation1']) || $_SESSION['Leads_DetailView_Navigation1']=="[]"){
	$list_query=$_SESSION['Leads_listquery'];
	$res=mysql_query($list_query);
	$q=new stdClass();
	$i=0;
	$arr=array();
	while($row= mysql_fetch_assoc($res)){
		if ($i%20==0 && $i!=0){
			$pg=$i/20;
			$q->$pg=$arr;
			$arr=array();
			$arr[]=$row['leadid'];
		}elseif (($i+1)==  mysql_num_rows($res)){
			$arr[]=$row['leadid'];
			$pg++;
			$q->$pg=$arr;
		}
		else $arr[]=$row['leadid'];
		$i++;
	}
	$_SESSION['Leads_DetailView_Navigation1']=json_encode($q);
}*/
//$p=print_r($smarty->_tpl_vars['BLOCKS'],true);echo "<pre>$p</pre>";
/*if ($leadstatus=="8. Funded"){
if ($smarty->_tpl_vars['BLOCKS']['Funded'][0]['.Funder']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][0]['.Funder']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][0]['Funder']['value'];
if ($smarty->_tpl_vars['BLOCKS']['Funded'][0]['.Advance amount']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][0]['.Advance amount']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][0]['Advance amount']['value'];
if ($smarty->_tpl_vars['BLOCKS']['Funded'][1]['.Payback amount']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][1]['.Payback amount']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][1]['Payback amount']['value'];
if ($smarty->_tpl_vars['BLOCKS']['Funded'][1]['.HP %']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][1]['.HP %']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][1]['HP %']['value'];
if ($smarty->_tpl_vars['BLOCKS']['Funded'][2]['.Daily amount']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][2]['.Daily amount']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][2]['Daily amount']['value'];
if ($smarty->_tpl_vars['BLOCKS']['Funded'][2]['.Closing costs']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][2]['.Closing costs']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][2]['Closing costs']['value'];
if ($smarty->_tpl_vars['BLOCKS']['Funded'][3]['.Date funded']['value']=="")$smarty->_tpl_vars['BLOCKS']['Funded'][3]['.Date funded']['value']=$smarty->_tpl_vars['BLOCKS']['Contract Out'][3]['Date contract sent']['value'];
}*/

$smarty->display("DetailView.tpl");
?>
<script type="text/javascript">
<?
//if ($leadstatus=='9. Declined' || $leadstatus=='5. Approved'){
	echo "changeleadstatus('".$leadstatus."',false);\n";
	echo "runchangeleadstatus('".$leadstatus."');\n";
//}
?>
function sendemailpdf(id){
	//alert(id);
	/*new Ajax.Request(
	'index.php',
	{
		queue:{
			position: 'end',
			scope: 'command'
		},
		method: 'post',
		postBody:"module=Leads&action=LeadsAjax&file=SendEmailPdf&leadid=" + id,
		onComplete: function(response) {
			var str = response.responseText;
			if(str.indexOf('SUCCESS') > -1)
			{
				alert('Email was send');
			}else
			{
				alert(str);
				//return false;
			}
		}
	}
	);*/
	window.open('index.php?module=Leads&action=LeadsAjax&file=viewmail&leadid=' + id,'','toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,copyhistory=no,width=800,height=600');
}
function runchangeleadstatus(newstatus){
	if (newstatus=='9. Declined' || newstatus=='4. Approved'){
		document.getElementById('dtlview_Description').style.display='none';
		document.getElementById('editarea_Description').style.display='';
	}else{
		document.getElementById('dtlview_Description').style.display='';
		document.getElementById('editarea_Description').style.display='none';
	}
}
function changeleadstatus(newstatus,editdesc){
	//viewotherblock(newstatus);
	document.getElementById('hidezone').value=newstatus;
	if (newstatus=='9. Declined' || newstatus=='4. Approved'){
		document.getElementById('description').style.display='table';
		document.getElementById('divsave').style.display='none';
		if (document.getElementById('tblDescriptionInformation').style.display=='none'){
			showHideStatus('tblDescriptionInformation','aidDescriptionInformation','themes/softed/images/');
			if (editdesc!=false){
				document.getElementById('dtlview_Description').style.display='none';
				document.getElementById('crmspanid').style.display='none';
				document.getElementById('editarea_Description').style.display='block';
			}
		}
	}else{
		if ((newstatus=='5. Contract Out' || newstatus=='7. Funded') && editdesc!=false){
			window.open ('index.php?module=Leads&action=LeadsAjax&file=changedata&record=<?php echo $_REQUEST['record']; ?>&status='+newstatus,
			"qwerty","toolbar=no,location=no,directories=no,status=no,scrollbars=no,resizable=no,copyhistory=no,width=450,height=350");
		}
		document.getElementById('description').style.display='none';
		document.getElementById('divsave').style.display='block';
		if (document.getElementById('tblDescriptionInformation').style.display!='none')
			showHideStatus('tblDescriptionInformation','aidDescriptionInformation','themes/softed/images/');
	}
}
function viewotherblock(status){
	document.getElementById('contractout').style.display='none';
	document.getElementById('tblContractOut').style.display='none';
	document.getElementById('funded').style.display='none';
	document.getElementById('tblFunded').style.display='none';
	if (status=='5. Contract Out'){
		document.getElementById('contractout').style.display='';
		document.getElementById('tblContractOut').style.display='';
	}else if (status=='7. Funded'){
		document.getElementById('funded').style.display='';
		document.getElementById('tblFunded').style.display='';
	}
}
function updateleadstatus(keyid){
	val=document.getElementById('hidezone').value;
	description=document.getElementById('txtbox_Description').value;
	description = trim(description);
	if (description.length==0 && (val=='4. Approved' || val=='9. Declined')) alert('Decription must be full');
	else {
		new Ajax.Request(
		'index.php',
		{
			queue:{
				position: 'end',
				scope: 'command'
			},
			method: 'post',
			postBody:"module=Leads&action=LeadsAjax&file=SaveStatus&leadid=" + keyid + "&status=" + val + "&description=" + description,
			onComplete: function(response) {
				var str = response.responseText;
				if(str.indexOf('SUCCESS') > -1)
				{
					//alert('Email was send');
					location.reload();
				}else
				{
					alert(str);
				}
			}
		}
		);
	}
}
function newcomment(leadid, fromdata){
	if (fromdata=='widget') comment=$('txtbox_ModCommentsDetailViewBlockCommentWidget').value;
	else comment=$('rightcomment').value;
	new Ajax.Request(
		'index.php',
		{
			queue:{
				position: 'end',
				scope: 'command'
			},
			method: 'post',
			postBody:"module=Leads&action=LeadsAjax&file=newcomment&leadid=" + leadid + "&comment=" + comment,
			onComplete: function(response) {
				//alert(response.responseText);
				//$('rightcommentview').value=response.responseText;
				document.getElementById('rightcommentview').innerHTML=response.responseText;
				document.getElementById('contentwrap_ModCommentsDetailViewBlockCommentWidget').innerHTML=response.responseText;
				$('rightcomment').value='';
				$('txtbox_ModCommentsDetailViewBlockCommentWidget').value='';
			}
		}
		);
}
function SaveEmail(label,module,keyid,keytblname,keyfldname,id){
	fldvalue=document.getElementById('txtbox_' + label).value;
	new Ajax.Request(
		'index.php',
		{
			queue:{
				position:'end',
				scope:'command'
			},
			method: 'post',
			postBody:"module=" + module + "&action=" + module + "Ajax&file=othersave&table=" + keytblname + "&field=" + keyfldname + "&id=" + id + "&value=" + fldvalue,
			onComplete:function(response){
				if (response.responseText==="OK"){
					window.globaltempvalue=fldvalue;
					document.getElementById('dtlview_' + label).innerHTML="<a href=\"javascript:InternalMailer(" + id + "," + keyid + ",'" + keyfldname + "','" + module + "','record_id');\">" + fldvalue + "</a>";
					hndCancel('dtlview_' + label,'editarea_' + label,label);
				}else alert (response.responseText);
			}
		}
		);
	//module=Leads&action=LeadsAjax&file=viewmail
}
/*function trim( str, charlist ) {    charlist = !charlist ? ' \s\xA0' : charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '\$1');
    var re = new RegExp('^[' + charlist + ']+|[' + charlist + ']+$', 'g');
    return str.replace(re, '');
}*/
</script>
