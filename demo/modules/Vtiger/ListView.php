<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
global $app_strings, $mod_strings, $current_language, $currentModule, $theme, $current_user;
global $list_max_entries_per_page;

require_once('Smarty_setup.php');
require_once('include/ListView/ListView.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');

checkFileAccessForInclusion("modules/$currentModule/$currentModule.php");
require_once("modules/$currentModule/$currentModule.php");

$category = getParentTab();
$url_string = '';

if(isset($tool_buttons)==false) {
	$tool_buttons = Button_Check($currentModule);
}

$focus = new $currentModule();
$focus->initSortbyField($currentModule);
$list_buttons=$focus->getListButtons($app_strings,$mod_strings);

if(ListViewSession::hasViewChanged($currentModule,$viewid)) {
	$_SESSION[$currentModule."_Order_By"] = '';
}
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$_SESSION[$currentModule."_Order_By"] = $order_by;
$_SESSION[$currentModule."_Sort_Order"]=$sorder;

$smarty = new vtigerCRM_Smarty();

// Identify this module as custom module.
$smarty->assign('CUSTOM_MODULE', $focus->IsCustomModule);

$smarty->assign('MAX_RECORDS', $list_max_entries_per_page);
$smarty->assign('MOD', $mod_strings);
$smarty->assign('APP', $app_strings);
$smarty->assign('MODULE', $currentModule);
$smarty->assign('SINGLE_MOD', getTranslatedString('SINGLE_'.$currentModule));
$smarty->assign('CATEGORY', $category);
$smarty->assign('BUTTONS', $list_buttons);
$smarty->assign('CHECK', $tool_buttons);
$smarty->assign('THEME', $theme);
$smarty->assign('IMAGE_PATH', "themes/$theme/images/");

$smarty->assign('CHANGE_OWNER', getUserslist());
$smarty->assign('CHANGE_GROUP_OWNER', getGroupslist());
$smarty->assign("CURRENT_USERID", $_SESSION["authenticated_user_id"]);

// Custom View
$customView = new CustomView($currentModule);
$viewid = $customView->getViewId($currentModule);
$customview_html = $customView->getCustomViewCombo($viewid);
$viewinfo = $customView->getCustomViewByCvid($viewid);

// Feature available from 5.1
if(method_exists($customView, 'isPermittedChangeStatus')) {
	// Approving or Denying status-public by the admin in CustomView
	$statusdetails = $customView->isPermittedChangeStatus($viewinfo['status']);

	// To check if a user is able to edit/delete a CustomView
	$edit_permit = $customView->isPermittedCustomView($viewid,'EditView',$currentModule);
	$delete_permit = $customView->isPermittedCustomView($viewid,'Delete',$currentModule);

	$smarty->assign("CUSTOMVIEW_PERMISSION",$statusdetails);
	$smarty->assign("CV_EDIT_PERMIT",$edit_permit);
	$smarty->assign("CV_DELETE_PERMIT",$delete_permit);
}
// END

$smarty->assign("VIEWID", $viewid);

if($viewinfo['viewname'] == 'All') $smarty->assign('ALL', 'All');

if($viewid ==0) {
	echo "<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>";
	echo "<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='". vtiger_imageurl('denied.gif', $theme) ."' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'><span clas
		s='genHeaderSmall'>$app_strings[LBL_PERMISSION]</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:window.history.back();'>$app_strings[LBL_GO_BACK]</a><br>
		</td>
		</tr>
		</tbody></table>
		</div>";
	echo "</td></tr></table>";
	exit;
}

global $current_user;
$queryGenerator = new QueryGenerator($currentModule, $current_user);
if ($viewid != "0") {
	$queryGenerator->initForCustomViewById($viewid);
} else {
	$queryGenerator->initForDefaultCustomView();
}

// Enabling Module Search
$url_string = '';
if($_REQUEST['query'] == 'true') {
	$queryGenerator->addUserSearchConditions($_REQUEST);
	$ustring = getSearchURL($_REQUEST);
	$url_string .= "&query=true$ustring";
	$smarty->assign('SEARCH_URL', $url_string);
}

$list_query = $queryGenerator->getQuery();
if ($module=='Leads'){
	if($_SESSION["authenticated_user_id"]==50) {echo "<a href=/tphp/50powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==10) {echo "<a href=/tphp/10powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==55) {echo "<a href=/tphp/55powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
    elseif($_SESSION["authenticated_user_id"]==56) {echo "<a href=/tphp/56powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==57) {echo "<a href=/tphp/57powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==54) {echo "<a href=/tphp/54powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==29) {echo "<a href=/tphp/29powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==51) {echo "<a href=/tphp/51powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==46) {echo "<a href=/tphp/46powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==53) {echo "<a href=/tphp/53powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==17) {echo "<a href=/tphp/17powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==38) {echo "<a href=/tphp/38powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==20) {echo "<a href=/tphp/20powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==35) {echo "<a href=/tphp/35powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==30) {echo "<a href=/tphp/30powerlinedialer.php target='_blank'> <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==23) {echo "<a href=/tphp/23powerlinedialer.php target='_blank'> <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==6) {echo "<a href=https://powerlinecrm.com/tphp/6powerlinedialer.php target='_blank'> <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==47) {echo "<a href=/tphp/47powerlinedialer.php target='_blank'> <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	elseif($_SESSION["authenticated_user_id"]==52) {echo "<a href=/tphp/52powerlinedialer.php target='_blank'> <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
    }
	else {echo "<a href=/tphp/powerlinedialer.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/phone-icon2.gif'></a>";
   }
	if($_SESSION["authenticated_user_id"]==6 || $_SESSION["authenticated_user_id"]==42 
	 || $_SESSION["authenticated_user_id"]==17 || $_SESSION["authenticated_user_id"]==10){
	echo "<a href=https://powerlinecrm.com/tphp/smsform.php target='_blank' > <img style='margin-left:2%;margin-top:0.5%;' src='themes/softed/images/text_icon.gif'></a>";
   }
	if (!isset($_SESSION)) session_start ();
	if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] == ''){
		/*if (isset($_REQUEST['status']))*/$_SESSION['leadstatus']=urldecode($_REQUEST['status']);
		if (isset($_REQUEST['viewuser'])) $_SESSION['viewuser']=$_REQUEST['viewuser'];
		/*if (isset($_REQUEST['state']))*/ $_SESSION['state']=$_REQUEST['state'];
		//$_SESSION['viewuser']=0; //$_SESSION['usergroup']=0;
	}else{
		//$_SESSION['leadstatus']="";
		//$_SESSION['state']="";
	}
	if ($current_user->is_admin=="off"){
		$list_query.=" and (smownerid='".$current_user->id."' OR smownerid='59')";
	}else{
		//if (!isset($_REQUEST['ajax']) || $_REQUEST['ajax'] == '')
		//	$_SESSION['viewuser']=(int)$_REQUEST['viewuser']; //$_SESSION['usergroup']=(int)$_REQUEST['usergroup'];
		/*if (isset($_SESSION['usergroup']) && $_SESSION['usergroup']>0){
			$_SESSION['leadstatus']=0;
			$res=mysql_query("select id from vtiger_users u inner join vtiger_users2group u2g on u.id=u2g.userid where u2g.groupid='".$_REQUEST['usergroup']."'");
			$users=array();
			while($row=  mysql_fetch_array($res,MYSQLI_ASSOC))$users[]=$row['id'];
			$list_query.=" and smownerid in ('".  implode("','", $users)."')";
		}*/

		if (isset($_SESSION['viewuser']) && $_SESSION['viewuser']>0){
			//$_SESSION['leadstatus']=0;
			$list_query.=" and smownerid='".$_SESSION['viewuser']."'";
		}
	}
	if ($_SESSION['state']=="west"){
		$list_query.=" and vtiger_leadscf.cf_643 not in ('ME', 'NY', 'NJ', 'DE', 'MA', 'IN', 'MI', 'VA', 'WV', 'FL', 'GA', 'NC', 'SC', 'PA', 'OH', 'KY', 'RI', 'CT', 'NH', 'VT', 'MD', 'DC', '')";
	}elseif($_SESSION['state']=="east"){
		$list_query.=" and vtiger_leadscf.cf_643 in ('ME', 'NY', 'NJ', 'DE', 'MA', 'IN', 'MI', 'VA', 'WV', 'FL', 'GA', 'NC', 'SC', 'PA', 'OH', 'KY', 'RI', 'CT', 'NH', 'VT', 'MD', 'DC')";
	}
	if (isset($_SESSION['leadstatus']) && strlen($_SESSION['leadstatus'])>0){
		//$p=print_r($_SESSION,true);echo "<pre>$p</pre>";
		$_SESSION['lvs']['Leads'][50]['start']=1;
		if ($_SESSION['leadstatus']=="Lead Pending"){
			//$list_query.=" and  vtiger_leaddetails.processed='0' ";
			$list_query = str_replace("AND   (  (( vtiger_leadscf.cf_728 <> '1') ))", "", $list_query);
			$list_query.=" and vtiger_leaddetails.leadstatus='".mysql_real_escape_string($_SESSION['leadstatus'])."'";
		}elseif ($_SESSION['leadstatus']!=""){
		//}elseif ($_SESSION['leadstatus']!="10. Follow ups"){
			$list_query.=" and vtiger_leaddetails.leadstatus='".mysql_real_escape_string($_SESSION['leadstatus'])."'";
			//. " AND vtiger_leadscf.cf_728 <> '1'";
		}else{
			$list_query = str_replace("AND   (  (( vtiger_leadscf.cf_728 <> '1') ))", "", $list_query);//." and vtiger_leadscf.cf_728='1'";
		}
	}
}

$where = $queryGenerator->getConditionalWhere();
if(isset($where) && $where != '') {
	$_SESSION['export_where'] = $where;
} else {
	unset($_SESSION['export_where']);
}

//BNJBNJ make search_text - trim (REUQEST) and use that 
file_put_contents('nork.txt', $_REQUEST['search_text'] . '|');
$search_num = $_REQUEST['search_text']; //BNJBNJ
$search_num = trim(preg_replace('/\D/', '', $search_num));
$search_txt = trim($_REQUEST['search_text']);
file_put_contents('nork.txt', $search_num . '|');
//if ($_REQUEST['ajax'] == 'true'){
	$list_query=  str_ireplace("( vtiger_leadscf.cf_641 LIKE '%".$search_txt."%')", "( vtiger_leadscf.cf_641 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leaddetails.firstname LIKE '%".$search_txt."%') "
			. "or ( vtiger_leaddetails.lastname LIKE '%".$search_txt."%') "
			. "or ( vtiger_leaddetails.email LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.phonecf_648 LIKE '%".$search_txt."%') "
		
	. (strlen($search_num) > 0 ? "or ( strip_non_digit(vtiger_leadscf.cf_648) LIKE '%".$search_num."%')  " : "")

			. "or ( vtiger_leadscf.phonecf_665 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_665 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.phonecf_666 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_666 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.phonecf_675 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_675 LIKE '%".$search_txt."%')"
			. "or ( vtiger_leadscf.phonecf_676 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_676 LIKE '%".$search_txt."%')"
			. "or ( vtiger_leadscf.phonecf_687 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_687 LIKE '%".$search_txt."%')"
			. "or ( vtiger_leadscf.phonecf_688 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_688 LIKE '%".$search_txt."%')"
			. "or ( vtiger_leadscf.phonecf_689 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_689 LIKE '%".$search_txt."%')"
			. "or ( vtiger_leadscf.phonecf_692 LIKE '%".$search_txt."%') "
			. "or ( vtiger_leadscf.cf_692 LIKE '%".$search_txt."%')"
			. "", $list_query);
file_put_contents('nork.txt', $list_query);
//}
// Sorting
if(!empty($order_by)) {
	if($order_by == 'smownerid') $list_query .= ' ORDER BY user_name '.$sorder;
	elseif($order_by=='changeassigned'){
		$list_query.=' ORDER BY changeassigned '.$sorder;
	}
	else {
		$tablename = getTableNameForField($currentModule, $order_by);
		$tablename = ($tablename != '')? ($tablename . '.') : '';
		$list_query .= ' ORDER BY ' . $tablename . $order_by . ' ' . $sorder;
	}
}
//BNJ $list_query=  str_ireplace("vtiger_leaddetails.changeassigned,", "if( vtiger_crmentity.modifiedtime > ifnull(vtiger_leaddetails.changeassigned,'0000-00-00'), vtiger_crmentity.modifiedtime, vtiger_leaddetails.changeassigned ) as changeassigned,", $list_query);
//$list_query=   str_ireplace("vtiger_leaddetails.changeassigned,", "vtiger_leaddetails.changeassigned as changeassigned,", $list_query);
//Postgres 8 fixes


//BNJ $list_query=  str_ireplace("vtiger_leaddetails.changeassigned,", "ifnull(vtiger_leadscf.cf_736,vtiger_leaddetails.changeassigned) as changeassigned,", $list_query); //BNJ

if ((strpos($list_query,'vtiger_leaddetails') !== false)  &&
(strpos($list_query,'vtiger_leadscf') !== false))
{
	$list_query=  str_replace("FROM", 
	", last_funded.last_funded_date FROM",
	$list_query); //BNJ
	$list_query=  str_replace("WHERE", 
	"LEFT JOIN last_funded ON vtiger_leaddetails.leadid = last_funded.leadid WHERE",
	$list_query); //BNJ
}

//$list_query=  str_ireplace("vtiger_leaddetails.changeassigned,", 
//	"ifnull(ifnull(vtiger_leadscf.cf_736, vtiger_crmentity.modifiedtime), vtiger_leaddetails.changeassigned) as changeassigned,", 
//	$list_query); //BNJ

   $list_query=  str_ireplace("vtiger_leaddetails.changeassigned,", 
	"ifnull(ifnull(ifnull(last_funded.last_funded_date, vtiger_leadscf.cf_736), vtiger_crmentity.modifiedtime), vtiger_leaddetails.changeassigned) as changeassigned,", 
	$list_query); //BNJ
	
	
file_put_contents("wtf.txt", $list_query);
if( $adb->dbType == "pgsql")
	$list_query = fixPostgresQuery( $list_query, $log, 0);
if ($module=="Leads" && $current_user->id!=1 && isset($_REQUEST['leadpend'])){
	$list_query.=" and vtiger_leaddetails.processed='0' ";
}
if(PerformancePrefs::getBoolean('LISTVIEW_COMPUTE_PAGE_COUNT', false) === true) {
	$count_result = $adb->query( mkCountQuery( $list_query));
	$noofrows = $adb->query_result($count_result,0,"count");
}else {
	$noofrows = null;
}

$queryMode = (isset($_REQUEST['query']) && $_REQUEST['query'] == 'true');
$start = ListViewSession::getRequestCurrentPage($currentModule, $list_query, $viewid, $queryMode);

$navigation_array = VT_getSimpleNavigationValues($start,$list_max_entries_per_page,$noofrows);

$limit_start_rec = ($start-1) * $list_max_entries_per_page;

//$list_query = str_replace("vtiger_leadscf.cf_648 LIKE", "vtiger_leadscf.phone LIKE", $list_query);

if( $adb->dbType == "pgsql")
	$list_result = $adb->pquery($list_query. " OFFSET $limit_start_rec LIMIT $list_max_entries_per_page", array());
else
	$list_result = $adb->pquery($list_query. " LIMIT $limit_start_rec, $list_max_entries_per_page", array());

$recordListRangeMsg = getRecordRangeMessage($list_result, $limit_start_rec,$noofrows);
$smarty->assign('recordListRange',$recordListRangeMsg);

$smarty->assign("CUSTOMVIEW_OPTION",$customview_html);

// Navigation
$navigationOutput = getTableHeaderSimpleNavigation($navigation_array, $url_string, $currentModule, 'index', $viewid);
$smarty->assign("NAVIGATION", $navigationOutput);

$controller = new ListViewController($adb, $current_user, $queryGenerator);

if(isset($skipAction)==false){
	$skipAction==false;
}

$listview_header = $controller->getListViewHeader($focus,$currentModule,$url_string,$sorder,$order_by,$skipAction);
$listview_entries = $controller->getListViewEntries($focus,$currentModule,$list_result,$navigation_array,$skipAction);

$listview_header_search = $controller->getBasicSearchFieldInfoList();

$smarty->assign('LISTHEADER', $listview_header);
$smarty->assign('LISTENTITY', $listview_entries);
$smarty->assign('SEARCHLISTHEADER',$listview_header_search);

// Module Search
$alphabetical = AlphabeticalSearch($currentModule,'index',$focus->def_basicsearch_col,'true','basic','','','','',$viewid);
$fieldnames = $controller->getAdvancedSearchOptionString();
$criteria = getcriteria_options();
$smarty->assign("ALPHABETICAL", $alphabetical);
$smarty->assign("FIELDNAMES", $fieldnames);
$smarty->assign("CRITERIA", $criteria);

$smarty->assign("AVALABLE_FIELDS", getMergeFields($currentModule,"available_fields"));
$smarty->assign("FIELDS_TO_MERGE", getMergeFields($currentModule,"fileds_to_merge"));

//Added to select Multiple records in multiple pages
$smarty->assign("SELECTEDIDS", vtlib_purify($_REQUEST['selobjs']));
$smarty->assign("ALLSELECTEDIDS", vtlib_purify($_REQUEST['allselobjs']));
$smarty->assign("CURRENT_PAGE_BOXES", implode(array_keys($listview_entries),";"));
ListViewSession::setSessionQuery($currentModule,$list_query,$viewid);

// Gather the custom link information to display
include_once('vtlib/Vtiger/Link.php');
$customlink_params = Array('MODULE'=>$currentModule, 'ACTION'=>vtlib_purify($_REQUEST['action']), 'CATEGORY'=> $category);
$smarty->assign('CUSTOM_LINKS', Vtiger_Link::getAllByType(getTabid($currentModule), Array('LISTVIEWBASIC','LISTVIEW'), $customlink_params));
// END

if(isPermitted($currentModule, "Merge") == 'yes' && file_exists("modules/$currentModule/Merge.php")) {
	$wordTemplates = array();
	$wordTemplateResult = fetchWordTemplateList($currentModule);
	$tempCount = $adb->num_rows($wordTemplateResult);
	$tempVal = $adb->fetch_array($wordTemplateResult);
	for ($templateCount = 0; $templateCount < $tempCount; $templateCount++) {
		$wordTemplates[$tempVal["templateid"]] = $tempVal["filename"];
		$tempVal = $adb->fetch_array($wordTemplateResult);
	}
	$smarty->assign('WORDTEMPLATES', $wordTemplates);
}

$smarty->assign('IS_ADMIN', is_admin($current_user));

if ($module=="Leads"){
	if (isset($_SESSION['viewuser']) && $_SESSION['viewuser']>0) $viewuser="&viewuser=".$_SESSION['viewuser']; else $viewuser="";
	if (isset($_SESSION['leadstatus']) && $_SESSION['leadstatus']!="") $status="&status=".$_SESSION['leadstatus']; else $status="";
	if (isset($_SESSION['state']) && $_SESSION['state']!="" && $_SESSION['state']!="all") {
		$state="&state=".$_SESSION['state'];
		if ($_SESSION['state']=="west"){
			$query=" and lcf.cf_643 not in ('ME', 'NY', 'NJ', 'DE', 'MA', 'IN', 'MI', 'VA', 'WV', 'FL', 'GA', 'NC', 'SC', 'PA', 'OH', 'KY', 'RI', 'CT', 'NH', 'VT', 'MD', 'DC', '')";
		}elseif($_SESSION['state']=="east"){
			$query=" and lcf.cf_643 in ('ME', 'NY', 'NJ', 'DE', 'MA', 'IN', 'MI', 'VA', 'WV', 'FL', 'GA', 'NC', 'SC', 'PA', 'OH', 'KY', 'RI', 'CT', 'NH', 'VT', 'MD', 'DC')";
		}
	}else {$state="";$query="";}
	if ($current_user->is_admin=="on"){
		if (isset($_SESSION['viewuser']) && $_SESSION['viewuser']>0)
			$res=  mysql_query("select count(leadid) countlead from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid where processed='0' and smownerid='".$_SESSION['viewuser']."' and deleted='0'  and converted='0'");
		else
			$res=  mysql_query("select count(leadid) countlead from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid where processed='0' and deleted='0' and converted='0'");
	}else
		$res=  mysql_query("select count(leadid) countlead from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid where processed='0' and (smownerid='".$current_user->id."'  OR smownerid='59') and deleted='0' and converted='0'");
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)) $countlead=$row['countlead'];
	$smarty->assign('COUNTLEAD', $countlead);
	
	//$p=print_r($smarty,true);echo "<pre>$p</pre>";
	$viewid=array();
	$full=array();
	foreach ($smarty->_tpl_vars['LISTHEADER'] as $key=>$value){
		if (strpos($value, "Change Assigned") || strpos($value, "Date Assigned")){
			$smarty->_tpl_vars['LISTHEADER'][$key]=  str_replace("Change Assigned", "Date", $value);
			$smarty->_tpl_vars['LISTHEADER'][$key]=  str_replace("Date Assigned", "Date", $value);
			$column=$key;
			break;
		}
	}
	foreach ($smarty->_tpl_vars['LISTENTITY'] as $key=>$value){
		$viewid[]=$key;
	}
	//$p=print_r($viewid,true); echo "<pre>$p</pre>";
	if (count($viewid)>0){
//		$res=  mysql_query("select l.leadid, if( crm.modifiedtime > ifnull(l.changeassigned,'0000-00-00'), crm.modifiedtime, l.changeassigned ) result from vtiger_crmentity crm inner join vtiger_leaddetails l on crm.crmid=l.leadid where l.leadid in (".implode(",", $viewid).")");
//		while($row=  mysql_fetch_assoc($res)){
//			$date = new DateTimeField($row['result']);
//			$smarty->_tpl_vars['LISTENTITY'][$row['leadid']][$column]=$date->getDisplayDate();
//		}
		$smarty->assign("COUNTFIELD", count($smarty->_tpl_vars['LISTENTITY'][$viewid[0]])+1);
		if ($current_user->viewnotes=="on" || $current_user->viewnotes==1) {
		/*$res=  mysql_query("select mc.related_to, mc.commentcontent, u.first_name, u.last_name, crm.createdtime from vtiger_modcomments mc
inner join vtiger_crmentity crm on mc.modcommentsid=crm.crmid
inner join vtiger_users u on crm.smownerid=u.id
where modcommentsid in (
select max(modcommentsid) from vtiger_modcomments mc
inner join vtiger_crmentity crm on mc.modcommentsid=crm.crmid
where crm.deleted=0 and related_to in (".implode(",", $viewid).")
group by related_to)");*/
		$res=  mysql_query("select * from (
SELECT mc.related_to, mc.commentcontent, u.first_name, u.last_name, crm.createdtime
FROM vtiger_modcomments mc
INNER JOIN vtiger_crmentity crm ON mc.modcommentsid = crm.crmid
INNER JOIN vtiger_users u ON crm.smownerid = u.id
WHERE related_to
IN (".implode(",", $viewid).")
order by createdtime desc) a group by related_to order by related_to");
		$data=array();
		while($row=  mysql_fetch_array($res, MYSQL_ASSOC)){
			//$data[]=$row;
			$date = new DateTimeField($row['createdtime']);
			$data[]=array(
				"related_to"=>$row['related_to'],
				"commentcontent"=>  nl2br($row['commentcontent']),
				"first_name"=>$row['firstname'],
				"last_name"=>$row['last_name'],
				"createdtime"=>$date->getDisplayDateTimeValue()
			);
		}
		}else $data=array();
		$smarty->assign("VIEWLASTNOTES", $data);
		$smarty->assign("VIEWNOTES", (($current_user->viewnotes=="on" || $current_user->viewnotes==1)?"on":"off"));
		//$p=print_r($data,true); echo "<pre>$p</pre>";
	}
	/*$res=  mysql_query("select f.columnname from vtiger_field f inner join vtiger_blocks b on f.block=b.blockid where (b.blocklabel='Business Information' or b.blocklabel='MERCHANT/OWNER INFORMATION') and f.presence=2");
	$field=array();
	while ($row=  mysql_fetch_array($res, MYSQL_ASSOC)) $field[]=$row['columnname'];
	$query="select ld.leadid, ".implode(", ", $field).", ld.leadstatus from vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid inner join vtiger_leadsubdetails ls on ld.leadid=ls.leadsubscriptionid where ld.leadid in ('".implode("', '",$viewid)."')";
	$res=  mysql_query($query);
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
		$fullrow=true;
		foreach ($field as $value){
			if ($row[$value]=="") $fullrow=false;
		}
		if (!$fullrow) $full[$row['leadid']]=' style="background:#ffff00"';
		if ($row['leadstatus']=="8. Funded") $full[$row['leadid']]=' style="background:#00ff00"';
		elseif ($row['leadstatus']=="9. Declined") $full[$row['leadid']]=' style="background:#C65F58"';
		elseif  ($row['leadstatus']=="2. App Out") $full[$row['leadid']]=' style="background:#aaaaff"';
		//if ($row['leadstatus']=="8. Funded") $funded[]=$row['leadid'];
	}*/
	$smarty->assign('FULL', $full);
	
	$resdata=array(
		"12. New Lead"=>array("count"=>0,"name"=>"New Lead"),
		"Lead Pending"=>array("count"=>0,"name"=>"Lead Pending"),
		"1. App not sent"=>array("count"=>0,"name"=>"App not sent"),
		"2. App Out"=>array("count"=>0,"name"=>"App Out"),
		"3. App In"=>array("count"=>0,"name"=>"App In"),
		"4. Approved"=>array("count"=>0,"name"=>"Approved"),
		"5. Contract Out"=>array("count"=>0,"name"=>"Contract Out"),
		"6. Contract In"=>array("count"=>0,"name"=>"Contract In"),
		"7. Funded"=>array("count"=>0,"name"=>"Funded"),
		"8. Merchant Pass"=>array("count"=>0,"name"=>"Merchant Pass"),
		"9. Declined"=>array("count"=>0,"name"=>"Declined"),
		"10. Follow ups"=>array("count"=>0,"name"=>"Follow ups")
	);
	if ($current_user->is_admin=="on"){
		/*if ((int)$_SESSION['usergroup']>0)
			$res=  mysql_query("SELECT count(leadid) leadcount, leadstatus FROM vtiger_leaddetails ld INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND smownerid in ('".  implode("','", $users)."') AND ld.converted =0 GROUP BY leadstatus");
		else
			$res=  mysql_query("SELECT count(leadid) leadcount, leadstatus FROM vtiger_leaddetails ld INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 GROUP BY leadstatus");*/
		if ((int)$_SESSION['viewuser']>0){
//			echo "(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and lcf.cf_728=0 and leadstatus<>'Lead pending'  AND smownerid in ('".((int)$_SESSION['viewuser'])."') ".$query." GROUP BY leadstatus) union
//(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and ld.converted=0 and leadstatus='Lead Pending'  AND smownerid in ('".((int)$_SESSION['viewuser'])."') ".$query.") union 
//(SELECT count(ld.leadid) leadcount, '10. Follow ups' leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and lcf.cf_728=1  AND smownerid in ('".((int)$_SESSION['viewuser'])."') ".$query.")";
//			$res=  mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND smownerid in ('".((int)$_SESSION['viewuser'])."') AND ld.converted =0 and lcf.cf_728=0 GROUP BY leadstatus) union
//(SELECT count(ld.leadid) leadcount, '10. Follow Apps' leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND smownerid in ('".((int)$_SESSION['viewuser'])."') AND ld.converted =0 and lcf.cf_728=1)");
			$res=  mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and leadstatus<>'Lead pending'  AND smownerid in ('".((int)$_SESSION['viewuser'])."') ".$query." GROUP BY leadstatus) union
(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and ld.converted=0 and leadstatus='Lead Pending'  AND smownerid in ('".((int)$_SESSION['viewuser'])."') ".$query.")");// union 
//(SELECT count(ld.leadid) leadcount, '10. Follow ups' leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and lcf.cf_728=1  AND smownerid in ('".((int)$_SESSION['viewuser'])."') ".$query.")");
		}else{
			if($_SESSION["authenticated_user_id"] == 42 || $_SESSION["authenticated_user_id"] == 55 ){ //|| $_SESSION["authenticated_user_id"] == 17
			$res= mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and smownerid in(17,20,29,35,38,42,55,56,58,59) and leadstatus<>'Lead pending' ".$query." GROUP BY leadstatus) union
(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and smownerid in(17,20,29,35,38,42,55,56,59) and ld.converted=0 and leadstatus='Lead Pending' ".$query.")");// union 
			}
			if($_SESSION["authenticated_user_id"] == 51 || $_SESSION["authenticated_user_id"] == 57){ //$_SESSION["authenticated_user_id"] == 10 
			$res= mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and smownerid in(10,51,57,54,23,52,53,46,47,59) and leadstatus<>'Lead pending' ".$query." GROUP BY leadstatus) union
(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and smownerid in(10,51,57,54,23,52,53,46,47,59) and ld.converted=0 and leadstatus='Lead Pending' ".$query.")");// union 
			}
			elseif ($_SESSION["authenticated_user_id"] != 42 && $_SESSION["authenticated_user_id"] != 55  && $_SESSION["authenticated_user_id"] != 51 && $_SESSION["authenticated_user_id"] != 57) {
				$res= mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and leadstatus<>'Lead pending' ".$query." GROUP BY leadstatus) union
(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and ld.converted=0 and leadstatus='Lead Pending' ".$query.")");// union 
				
			}
		}
	}else{
//		echo "(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and lcf.cf_728=0 and leadstatus<>'Lead pending' AND crm.smownerid='".$current_user->id."' ".$query." GROUP BY leadstatus) union
//(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and ld.converted=0 and leadstatus='Lead Pending' AND crm.smownerid='".$current_user->id."' ".$query.") union 
//(SELECT count(ld.leadid) leadcount, '10. Follow ups' leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and lcf.cf_728=1 AND crm.smownerid='".$current_user->id."' ".$query.")";
//		$res=  mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND crm.smownerid='".$current_user->id."' AND ld.converted =0 and lcf.cf_728=0 GROUP BY leadstatus) union
//(SELECT count(ld.leadid) leadcount, '10. Follow Apps' leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND crm.smownerid='".$current_user->id."' AND ld.converted =0 and lcf.cf_728=1)");
		$res=mysql_query("(SELECT count(ld.leadid) leadcount, leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and leadstatus<>'Lead pending' AND (crm.smownerid='".$current_user->id."' OR smownerid='59') ".$query." GROUP BY leadstatus) union
(select count(ld.leadid) leadcount, 'Lead Pending' from vtiger_leaddetails ld inner join vtiger_crmentity crm on ld.leadid=crm.crmid inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid where crm.deleted=0 and ld.converted=0 and leadstatus='Lead Pending' AND crm.smownerid='".$current_user->id."' ".$query.")");// union 
//(SELECT count(ld.leadid) leadcount, '10. Follow ups' leadstatus FROM vtiger_leaddetails ld inner join vtiger_leadscf lcf on ld.leadid=lcf.leadid INNER JOIN vtiger_crmentity crm ON ld.leadid = crm.crmid WHERE crm.deleted =0 AND ld.converted =0 and lcf.cf_728=1 AND crm.smownerid='".$current_user->id."' ".$query.")");
	}
	while ($row=  mysql_fetch_array($res,MYSQLI_ASSOC)){
		if (isset($resdata[$row['leadstatus']]))
			$resdata[$row['leadstatus']]['count']=$row['leadcount'];
	}
	$td1=array();
	$td2=array();
	foreach ($resdata as $key=>$value){
		if ($_SESSION['leadstatus']==$key) $background="background:#777777;"; else $background="";
		$td1[]="<td style='width:120px;font-weight: bold;text-align:center;$background'><a href='index.php?module=Leads&action=ListView".$viewuser.$state."&status=".urlencode($key)."'>".$value['name']."</a></td>";
		$td2[]="<td style='text-align:center;width: 100px;height: 100px;background: #0167F6;-moz-border-radius: 50px;-webkit-border-radius: 50px;border-radius: 50px;color: white ;font-size: 200%;'><a style='color:white !important;' href='index.php?module=Leads&action=ListView".$viewuser.$state."&status=".urlencode($key)."'>".$value['count']."</a></td>";
	}
	$resdatastr = "<table style='width:100%;'>
<tr>";
	/*if (isset($_SESSION['viewuser']) && $_SESSION['viewuser']>0)
		$resdatastr.="<td></td><td style='width:100px;text-align:center;'><a href='index.php?module=Leads&action=ListView&viewuser=".$_SESSION['viewuser']."&status=".urlencode("0. Lead Pending")."'>Lead Pending</a></td>";
	else
		$resdatastr.="<td></td><td style='width:100px;text-align:center;'><a href='index.php?module=Leads&action=ListView&status=".urlencode("0. Lead Pending")."'>Lead Pending</a></td>";*/
	$resdatastr.="<td></td>".  implode("<td rowspan='2' style='font-size:18px;text-align:center;width:20px;'>&#9658;</td>", $td1)."<td></td>
</tr>
<tr>
	<td></td>".  implode("", $td2)."<td></td>
</tr>
</table>";//<td></td><td style='width:100px;text-align:center;'>".$countlead."</td>
	$smarty->assign('RESDATA', $resdatastr);
	if ($current_user->is_admin=="on"){
		//$res=  mysql_query("select groupid, groupname from vtiger_groups");
		$res=  mysql_query("select id, concat(first_name,' ',last_name) username from vtiger_users order by username");
		$str="";
		//$q=(int)$_SESSION['usergroup'];
		$q=(int)$_SESSION['viewuser'];
		/*unset ($_GET['usergroup']);
		foreach ($_GET as $key => $value) {
			$str.="&".$key."=".$value;
		}*/
		//$select="<b>Groups:</b> <select name='group' class='small' onchange='document.location.href=\"index.php?module=Leads&action=index&usergroup=\" + this.value'><option value='0'";
		$select="<b>Users:</b> <select name='viewuser' class='small' onchange='document.location.href=\"index.php?module=Leads&action=index".$status.$state."&viewuser=\" + this.value'><option value='0'";
		if ($q>0) $select.=" selected";
		$select.=">All</option>";
		while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
			$select.="<option value='".$row['id']."'";
			if ($q==$row['id'])$select.=" selected";
			$select.=">".$row['username']."</option>";
		}
		$select.="</select>";
		$select.="</td><td>";
	}
		$select.="<b>State:</b><select name='viewuser' class='small' onchange='document.location.href=\"index.php?module=Leads&action=index".$viewuser.$status."&state=\" + this.value'>";
		$state=array("all"=>"All","west"=>"West","east"=>"East");
		foreach ($state as $key=>$value){
			$select.="<option value='".$key."'";
			if (($_SESSION['state']=="all" || !isset($_SESSION['state'])) && $key=="all") $select.=" selected";
			elseif ($key==$_SESSION['state']) $select.=" selected";
			$select.=">".$value."</option>";
		}
		$select.="</select>";
		$smarty->assign('SELECTGROUP',$select);
	//}
	//$smarty->assign('FINDLEAD',"");
	?>
<script type="text/javascript">
	function addnote(id){
		document.getElementById('viewnotes' + id).style.display='none';
		document.getElementById('addnotes' + id).style.display='block';
		document.getElementById('spanaddnote' + id).style.display='none';
		document.getElementById('spansave' + id).style.display='inline';
	}
	function cancelsavenote(id){
		document.getElementById('viewnotes' + id).style.display='block';
		document.getElementById('addnotes' + id).style.display='none';
		document.getElementById('spanaddnote' + id).style.display='inline';
		document.getElementById('spansave' + id).style.display='none';
	}
	function savenote(id){
		comment=document.getElementById('newnote' + id).value;
		if (comment!=''){
		new Ajax.Request(
			'index.php',
			{
				queue:{
					position: 'end',
					scope: 'command'
				},
				method: 'post',
				postBody:"module=Leads&action=LeadsAjax&file=newcomment&leadid=" + id + "&comment=" + comment + '&limit=1',
				onComplete: function(response) {
					document.getElementById('viewnotes'+id).innerHTML=response.responseText;
					document.getElementById('newnote' + id).value='';
					cancelsavenote(id);
				}
			}
			);
		} else alert('Note is empty.');
	}
</script>
<?php
} else {
	$smarty->assign('FULL', array());
	/*$q='<table class="searchUIBasic small" width="100%" cellspacing="0" cellpadding="5" border="0" align="center"><tr>
		<td nowrap="" align="left" class="searchUIName small"><span class="moduleName">Search Leads</span></td>
		<td nowrap="" align="right" class="small"><b>Search for</b></td>
		<td class="small" style="text-align: center; width:125px;"><input type="text" class="txtBox" style="width:120px;" name="searchlead_text" id="searchlead_text"></td>
		<td nowrap="" class="small"><input type="button" name="button" class="crmbutton small create" value=" Search Now " onclick="document.location.href=\'index.php?action=index&module=Leads&parenttab=Marketing&query=true&search_field=cf_641&search_text=\' + document.getElementById(\'searchlead_text\').value"></td>
                <td style="width:40%"></td>
	</tr></table>';
	//$q='';
	$smarty->assign('FINDLEAD',$q);*/
}

ob_start();

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("ListViewEntries.tpl");
else
	$smarty->display('ListView.tpl');

$content = ob_get_contents();

$newfilename = $_SESSION["authenticated_user_id"]."testw2.txt";
 file_put_contents($newfilename,$content);
$_SESSION['phone_numbers'] = shell_exec('perl phone_grabber.pl '.$newfilename);

if($_SESSION["authenticated_user_id"]==6 || $_SESSION["authenticated_user_id"]==42 
	 || $_SESSION["authenticated_user_id"]==17 || $_SESSION["authenticated_user_id"]==10){
$_SESSION['cell_numbers'] = shell_exec('php /var/www/getallcell.php');
	 }

// $_SESSION['cell_numbers'] = shell_exec('perl cell_grabber.pl '.$newfilename);

?>
