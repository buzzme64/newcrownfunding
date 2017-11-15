<?php

$user_name = getUserName($user_id);
//echo vtiger_users.user_name;

if (isset($_REQUEST['startdate']) && (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_REQUEST['startdate']) || $_REQUEST['startdate']=='' )) $startdate=$_REQUEST['startdate'];
else {
	$now = getdate();
	$lastmonth=mktime(0, 0, 0, $now['mon']-1, $now['mday'], $now['year']);
	$startdate=date('Y-m-d',$lastmonth);
}
if (isset($_REQUEST['enddate']) && (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_REQUEST['enddate']) || $_REQUEST['enddate']=='' )) $enddate=$_REQUEST['enddate']; else $enddate=date('Y-m-d');
//if (isset($_REQUEST['user']) && preg_match("/^[0-9]+$/",$_REQUEST['user'])) $viewuser=$_REQUEST['user']; else $viewuser=0;

$res=mysql_query("select id, user_name from vtiger_users where deleted=0 order by user_name");
if (mysql_num_rows($res)>0){
	$users=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
		$users[]=$row;
	}
}

if (isset($_REQUEST['startdate']) || isset($_REQUEST['enddate']) || isset($_REQUEST['user'])){
	$table=array();
	$result="<br/><table class='lvt small' cellspacing='1' cellpadding='3' width='100%' border='0'><tr><td class='lvtCol'></td>";
	$res=  mysql_query("select leadstatus from vtiger_leadstatus order by leadstatusid");
	while ($row=  mysql_fetch_array($res, MYSQL_ASSOC)){
		foreach ($users as $user) {
//			if ($viewuser!=0){
//				if ($viewuser==$user['id']) $table[$user['user_name']][$row['leadstatus']]=0;
				if (in_array($user['id'], $_REQUEST['user'])) $table[$user['user_name']][$row['leadstatus']]=0;
//			}else $table[$user['user_name']][$row['leadstatus']]=0;
		}
		$table["total"][$row['leadstatus']]=0;
		$result.="<td class='lvtCol'>".$row['leadstatus']."</td>";
	}
	$result.="<td class='lvtCol'>Total</td></tr>";
	
	$query="select u.user_name, l.leadstatus, count(l.leadid) countlead
		from vtiger_leaddetails l
		inner join vtiger_leadstatus ls on l.leadstatus=ls.leadstatus
		inner join vtiger_leadscf lcf on l.leadid=lcf.leadid
		inner join vtiger_crmentity crm on l.leadid=crm.crmid
		inner join vtiger_users u on crm.smownerid=u.id
		where crm.deleted=0  AND l.converted =0 ";// and l.leadstatus<>'10. Follow ups' ";//and lcf.cf_728=0 ";
	if ($startdate!='') $query.=" and crm.createdtime>='".$startdate."'";
	if ($enddate!='') $query.=" and crm.createdtime<='".$enddate."'";
	//if ($viewuser>0) $query.=" and crm.smownerid='".$viewuser."'";
	if (count($_REQUEST['user'])>0) $query.=" and crm.smownerid in (".  implode(", ", $_REQUEST['user']).")";
	$query.=" group by leadstatus, user_name order by ls.leadstatusid";
	//echo $query;
	$res=  mysql_query($query);
	
	while($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
		if (isset($table[$row['user_name']][$row['leadstatus']])){
			$table[$row['user_name']][$row['leadstatus']]=$row['countlead'];
			$table["total"][$row['leadstatus']]+=$row['countlead'];
			$table[$row['user_name']]["total"]+=$row['countlead'];
			$table["total"]["total"]+=$row['countlead'];
		}
	}
	foreach ($table as $key=>$row){
		$result.="<tr class=\"lvtColData\" bgcolor=\"white\" onmouseout=\"this.className='lvtColData'\" onmouseover=\"this.className='lvtColDataHover'\"><td class='lvtCol'>".$key."</td>";
		foreach ($row as $cell){
			$result.="<td onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" style='text-align:center;'>".$cell."</td>";
		}
		$result.="</tr>";
	}
	
	$result.="</table>";
	
}else{
	$result='';
}

echo '<link href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>';
?>

<table cellspacing="0" cellpadding="0" width="100%" border="0" class="small">
<tr><td style="height:2px"></td></tr>
<tr>
<td nowrap="" class="moduleName" style="padding-left:10px;padding-right:50px">
	<a href="index.php?action=index&amp;module=Report&amp;parenttab=Analytics" class="hdrLink">Report</a>
</td>
<tr><td style="height:2px"></td></tr>
</tbody></table>

<?php require_once 'modules/Report/tab.php'; ?>

<table cellspacing="0" cellpadding="0" width="98%" border="0" align="center">
<tr>
	<td valign="top"></td>
	<td class="showPanelBg" width="100%" valign="top" style="padding:10px;">
<?php
require 'modules/Leads/header.php'; 
echo $search_string;
?>
		<div id="ListViewContents" class="small" style="width:100%;">

<form action="index.php?module=Report&action=index" method="POST" name="search">
<div style="text-align: center;">
<table style="width:500px;" align="center">
<tr>
<td style="vertical-align: top;">Start Date:</td><td style="vertical-align: top;"><input type="text" value="<?php echo $startdate; ?>" name="startdate" id="startdate" size="10" class="small" /></td>
<td rowspan="2" style="vertical-align: top;">Broker:</td><td rowspan="2" style="vertical-align: top;">
<select name="user[]" multiple size="7" style="width: 200px;">
	<?php
	$i=0;
	foreach ($users as $user){
		echo "<option value='".$user['id']."'"; 
		if (isset($_REQUEST['user']) && in_array($user['id'], $_REQUEST['user'])) {$i++;echo " selected";}
		echo ">".$user['user_name']."</option>";
	}
	?>
</select><br/><input type="checkbox" id="alluser" onclick="setSelectOptions('search', 'user[]', this.checked);"<?php if ($i==count($users)) echo " checked"; ?>> <label for="alluser">All user</label></td></tr>
<tr style="vertical-align: top;">
<td>End Date:</td><td style="vertical-align: top;"><input type="text" value="<?php echo $enddate; ?>" name="enddate" id="enddate" size="10" class="small" /></td>
</tr>
<tr><td colspan="4" style="text-align:center;">
<input type="submit" value=" View " class="crmButton small save"></td></tr>
</table>
</div>
</form>
<?php
echo $result;
?>

		</div>
	</td>
	<td valign="top"></td>
</tr>
</table>

<script type='text/javascript'>
jQuery(function($) {
jQuery('#startdate').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['en'],{'showAnim':'fold','dateFormat':'mm-dd-yy','changeMonth': true, 'changeYear': true}));
jQuery('#enddate').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['en'],{'showAnim':'fold','dateFormat':'mm-dd-yy','changeMonth': true, 'changeYear': true}));
});
function setSelectOptions(the_form, the_select, do_check)
{
	var selectObject = document.forms[the_form].elements[the_select];
	var selectCount  = selectObject.length;
	for (var i = 0; i < selectCount; i++) {
		selectObject.options[i].selected = do_check;
	}
	return true;
}
</script>