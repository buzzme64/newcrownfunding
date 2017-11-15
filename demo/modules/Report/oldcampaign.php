<?php

require_once ('../../jpgraph-3.5.0b1/src/jpgraph.php');
require_once ('../../jpgraph-3.5.0b1/src/jpgraph_line.php');
require_once ('../../jpgraph-3.5.0b1/src/jpgraph_bar.php');
require_once ('../../jpgraph-3.5.0b1/src/jpgraph_pie.php');   
require_once ('../../jpgraph-3.5.0b1/src/jpgraph_pie3d.php');   

 
//if (isset($_REQUEST['startdate']) && (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_REQUEST['startdate']) || $_REQUEST['startdate']=='' )) $startdate=$_REQUEST['startdate'];
if (isset($_REQUEST['startdate'])) $startdate=$_REQUEST['startdate'];
else {
	$now = getdate();
	$lastmonth=mktime(0, 0, 0, $now['mon']-1, $now['mday'], $now['year']);
	$startdate=date('m-d-Y',$lastmonth);
}
//if (isset($_REQUEST['enddate']) && (preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_REQUEST['enddate']) || $_REQUEST['enddate']=='' )) $enddate=$_REQUEST['enddate']; else $enddate=date('m-d-Y');
if (isset($_REQUEST['enddate'])) $enddate=$_REQUEST['enddate']; else $enddate=date('m-d-Y');

//$res=mysql_query("select id, user_name from vtiger_users where deleted=0 and is_admin = 'off' and user_name !=  'btopol' or user_name =  'cally' order by user_name");
$res=mysql_query("select id, user_name from vtiger_users where deleted=0 and user_name !=  'btopol' and user_name !=  'alexcorp' and user_name !=  'Giselle' and user_name !=  'ivan' and user_name !=  'admin' order by user_name");
if (mysql_num_rows($res)>0){
	$users=array();
	while ($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
		$users[]=$row;
	}
}
if (isset($_REQUEST['startdate']) || isset($_REQUEST['enddate']) || isset($_REQUEST['user'])){
	$restable=array();
	$arr_start = explode('-', $startdate);
    $startdaten = $arr_start[2].'-'.$arr_start[0].'-'.$arr_start[1];
    $arr_end = explode('-', $enddate);
    $enddaten = $arr_end[2].'-'.$arr_end[0].'-'.$arr_end[1];
	/*$query="select crm.smownerid, l.leadid, l.firstname, l.lastname, lcf.cf_641 dba, lcf.cf_721 funder, lcf.cf_722 advamount, lcf.cf_723 paybamount, lcf.cf_725 dailyamount, lcf.cf_727 datefunded, lcf.cf_726 closecosts, lcf.cf_724 hp, lcf.cf_733 categories
	from vtiger_leaddetails l
	inner join vtiger_leadscf lcf on l.leadid=lcf.leadid
	inner join vtiger_crmentity crm on l.leadid=crm.crmid
	where crm.deleted=0  AND l.converted =0 and l.leadstatus='7. Funded'";
	if ($startdate!='') $query.=" and lcf.cf_727>='".$startdaten."'";
	if ($enddate!='') $query.=" and lcf.cf_727<='".$enddaten."'";//crm.createdtime*/
	//vtiger_leaddetails set leadstatus='2. App Out' where leadid='".$_REQUEST['leadid']."'");
	
//BNJ added cf_735 below
	//$query="select crm.smownerid, l.leadid, l.firstname, l.lastname, lcf.cf_641 dba,lcf.cf_734, lcf.cf_735,ifnull(lcf.cf_736,crm.modifiedtime)  as changeassigned
	//$query="select crm.smownerid, l.leadid, l.firstname, l.lastname, lcf.cf_641 dba,lcf.cf_734,crm.modifiedtime , lcf.cf_735,lcf.cf_736 as stat_date  the good line with the table
	$query="select crm.smownerid, l.leadid, l.firstname, l.lastname, lcf.cf_641 dba,lcf.cf_734,crm.modifiedtime, lcf.cf_735, lcf.cf_736 as stat_date,l.leadstatus
	from vtiger_leaddetails l 
	inner join vtiger_leadscf lcf on l.leadid=lcf.leadid
	inner join vtiger_crmentity crm on l.leadid=crm.crmid";
	$query.=" and lcf.cf_736   >='".$startdaten." 00:00:00'";
	$query.=" and lcf.cf_736   <='".$enddaten." 00:00:00'";
	if (count($_REQUEST['user'])>0) $query.=" and crm.smownerid in (".  implode(", ", $_REQUEST['user']).")";
	$query.="  order by l.leadstatus ";
	//$query.=" order by stat_date";
file_put_contents("wtfwtf.txt", $query);
	$res=  mysql_query($query);
        $subtotal = 0;
	while($row=  mysql_fetch_assoc($res)){
		$restable[$row['smownerid']][]=array(
			"leadid"=>$row['leadid'],
			"firstname"=>$row['firstname'],
			"lastname"=>$row['lastname'],
			"campaign_src"=>$row['cf_734'],   //BNJ
			"dba"=>$row['dba'],
			"assigned"=>$row['stat_date'],
			"priority"=>$row['cf_735'],  //BT
			"status"=>preg_replace("/[0-9]+\./", "", $row['leadstatus']) //BT
			
		);
	}
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

<form action="index.php?module=Report&action=campaign" method="POST" name="search">
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
</select><br/><input type="checkbox" id="alluser" onclick="setSelectOptions('search', 'user[]', this.checked);"<?php if ($i==count($users)) echo " checked"; ?>> <label for="alluser">All Brokers</label></td></tr>
<tr style="vertical-align: top;">
<td>End Date:</td><td style="vertical-align: top;"><input type="text" value="<?php echo $enddate; ?>" name="enddate" id="enddate" size="10" class="small" /></td>
</tr>
<tr><td colspan="4" style="text-align:center;">
<input type="submit" value=" View " class="crmButton small save"></td></tr>
</table>
</div>
</form>
<?php
$total=array();
$total_deals=0;
$total_funder = array();
$total_campaign_src = array(); //BNJ
$sub_campaign_src = array(); //BNJ
//$total_priority  = array();
$total_status  = array();
if ($restable!=array()){
foreach($restable as $key=>$value){
    $nvalue1 = 0;
    $nnvalue1 = 0;
    
	echo "<div  class=\"hdrLink\" onclick=\"$('#datauser".$key."').toggle('slow');\">".getUserName($key)."</div><div id='datauser".$key."'>";
	echo "<table class=\"lvt small\" width=\"60%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">
	<tr>
	<td class=\"lvtCol\" style='width:16%'>DBA</td>
	<td class=\"lvtCol\" style='width:8%'>Date Out</td>
	<td class=\"lvtCol\" style='width:8%'>Campaign Src</td>
	<td class=\"lvtCol\" style='width:8%'>Status</td>
	<td class=\"lvtCol\" style='width:8%'>Amount</td>
	<!--<td class=\"lvtCol\" style='width:8%'>Priority</td>-->
	</tr>";
	foreach ($value as $value1) {
		$c_status = $value1['status'];	
		$famount="";
		//if($c_status=='Funded'){
			//$res=mysql_query("select advamount from vtiger_leads_funded where leadid='".$value1['leadid']."' and datefunded  >='".$startdaten."'");
			if (preg_match("/Funded/i", $c_status)) {
			$res=mysql_query("select advamount from vtiger_leads_funded where leadid=".$value1['leadid']);	
			if ($row = mysql_fetch_array($res))
				{
			$famount = $row['advamount'];
			$famount = preg_replace('/[\$g]/','',$famount);
		    $famount = preg_replace('/[\,g]/','',$famount);
			$famount = setpointtonumber($famount);
			$famount = "$".$famount;
				}
	}
		//}
		echo "<tr bgcolor=\"white\" onmouseover=\"this.className='lvtColDataHover'\" onmouseout=\"this.className='lvtColData'\">
	<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['dba']."</td>
		<td style=\"text-align:center;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".date_format(date_create($value1['assigned']), 'm-d-Y')."</td>
	<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['campaign_src']."</td>
	<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['status']."</td>";
	
	echo"<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$famount."</td>";
	//echo"<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['priority']."</td>
	echo"</tr>";
		//$total[$key]['advamount']+=newnumber($value1['advamount']);
		//$total[$key]['paybamount']+=newnumber($value1['paybamount']);
		$total_deals = $total_deals+1;
                $subtotal = $subtotal +1;
				
				$c_src = $value1['campaign_src'];
	if (!$c_src) { $c_src = 'Unknown'; }
        $sub_campaign_src[$c_src] = $sub_campaign_src[$c_src]+1;
	    $total_campaign_src[$c_src] = $total_campaign_src[$c_src]+1;
		
		/*$c_priority = $value1['priority'];
	if (!$c_priority) { $c_priority = 'Unknown'; }
        $total_priority[$c_priority]  = $total_priority[$c_priority] +1;*/
	
	
	if (!$c_status) { $c_status = 'Unknown'; }
        $total_status[$c_status]  = $total_status[$c_status] +1;
		
	}
	echo "<tr>
 <td style='font-weight:bold;'>SubTotal: ".setpointtonumber($subtotal)." Deals</td>
     </tr></table><table class=\"lvt small\" width=\"60%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\"><tr>";
        echo " <td style='font-weight:bold;'>Campaign Src:</td>";
        foreach ($sub_campaign_src as $key => $value) {
	    echo "<td style='font-weight:bold;  '>".$key." <br>  ".$value."&nbsp;&nbsp;</td>";	
              }
        

	
	echo "</tr>";
	/*
	echo "<tr>
 <td style='font-weight:bold;'>Priority Total:</td>";
        
         
        foreach ($total_priority as $key => $value) {
	    echo "<td style='font-weight:bold;  '>".$key." <br>  ".$value."&nbsp;&nbsp;</td><td colspan='1'style=\"width:12%;\"> </td>";	
              }
        

	
	echo "</tr>";*/
	
	echo "<tr>
 <td style='font-weight:bold;'>Total Statuses:</td>";
        foreach ($total_status as $key => $value) {
	    echo "<td style='font-weight:bold;width:15%'>".$key." <br>  ".$value."&nbsp;&nbsp;</td>";	
              }
	echo "</tr>";
	
echo "</table><div style='height:15px;'></div></div>";
$subtotal = 0;
unset($sub_campaign_src);
//$total_priority = array();
$total_status = array();


/*foreach ($value as $value1) {
$c_src = $value1['campaign_src'];
	if (!$c_src) { $c_src = 'Unknown'; }
        $total_campaign_src[$c_src] = $total_campaign_src[$c_src]+1;
}*/
}
//This is the bottom total
echo "<table class=\"lvt small\" width=\"60%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">
<tr>
<td style='font-weight:bold; width:12%;'>Total:   &nbsp;&nbsp; ".setpointtonumber($total_deals)." Deals </td>
<td colspan='1'style=\"width:12%;\"> </td>


</tr>";

foreach ($total_campaign_src as $key => $value) {
	
   echo "<tr><td style='font-weight:bold;  width:12%;'>".$key." <br>  ".$value."&nbsp;&nbsp;</td><td colspan='1'style=\"width:12%;\"> </td></tr>";
	
}
echo"</table>";
}
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

<?php
function newnumber($hernya){
	$newnumber="";
	for ($i=0;$i<strlen($hernya);$i++){
		$char=substr($hernya,$i,1);
		if (preg_match("/[0-9]{1}/", $char)) $newnumber.=$char;
	}
	return $newnumber;
}
function setpointtonumber($number){
     $english_format_number = number_format($number);
     return $english_format_number;
	/*if (strlen($number)>3){
		return substr($number,0,  strlen($number)-3).",".substr($number,  strlen($number)-3);
	}else return $number;*/
}
function withoutpoint($hernya){
	$pos=  strpos($hernya, ".");
	if ($pos) return substr($hernya,0,$pos);
	else return $hernya;
}
?>
