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
//BNJ added cf_735 below
	$query="select crm.smownerid, l.leadid, l.firstname, l.lastname, lcf.cf_641 dba, lf.funder, lf.advamount, lf.paybackamount, lf.dailyamount, lf.datefunded, lf.closingcosts, lf.hp, lf.categories, lcf.cf_734
	from vtiger_leaddetails l
	inner join vtiger_leadscf lcf on l.leadid=lcf.leadid
	inner join vtiger_leads_funded lf on l.leadid=lf.leadid
	inner join vtiger_crmentity crm on l.leadid=crm.crmid
	where crm.deleted=0  AND l.converted =0 and l.leadstatus='7. Funded'";
	if ($startdate!='') $query.=" and lf.datefunded>='".$startdaten."'";
	if ($enddate!='') $query.=" and lf.datefunded<='".$enddaten."'";
	if (count($_REQUEST['user'])>0) $query.=" and crm.smownerid in (".  implode(", ", $_REQUEST['user']).")";
	$query.=" order by crm.smownerid";
	$res=  mysql_query($query);
        $subtotal = 0;
	while($row=  mysql_fetch_assoc($res)){
		$restable[$row['smownerid']][]=array(
			"leadid"=>$row['leadid'],
			"firstname"=>$row['firstname'],
			"lastname"=>$row['lastname'],
			"dba"=>$row['dba'],
			"funder"=>$row['funder'],
			"campaign_src"=>$row['cf_734'],   //BNJ
			"advamount"=>$row['advamount'],
			"paybamount"=>$row['paybackamount'],
			"dailyamount"=>$row['dailyamount'],
			"datefunded"=>$row['datefunded'],
			"closecosts"=>$row['closingcosts'],
			"hp"=>$row['hp'],
			"categories"=>$row['categories']
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

<form action="index.php?module=Report&action=funded" method="POST" name="search">
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
if ($restable!=array()){
foreach($restable as $key=>$value){
    $nvalue1 = 0;
    $nnvalue1 = 0;
    
	echo "<div  class=\"hdrLink\" onclick=\"$('#datauser".$key."').toggle('slow');\">".getUserName($key)."</div><div id='datauser".$key."'>";
	echo "<table class=\"lvt small\" width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">
	<tr>
	<td class=\"lvtCol\" style='width:16%'>DBA</td>
	<td class=\"lvtCol\" style='width:7%'>Funder</td>
	<td class=\"lvtCol\" style='width:5%'>Categories</td>
	<td class=\"lvtCol\" style='width:10%'>Advanced amount</td>
	<td class=\"lvtCol\" style='width:8%'>Payback amount</td>
	<td class=\"lvtCol\" style='width:8%'>Daily amount</td>
	<td class=\"lvtCol\" style='width:8%'>Date funded</td>
	<td class=\"lvtCol\" style='width:8%'>Close costs</td>
	<td class=\"lvtCol\" style='width:6%'>HB, %</td>
	</tr>";
	foreach ($value as $value1) {
		echo "<tr class=\"lvtColData\" bgcolor=\"white\" onmouseover=\"this.className='lvtColDataHover'\" onmouseout=\"this.className='lvtColData'\">
	<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['dba']."</td>
	<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['funder']."</td>
	<td onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['categories']."</td>
	<td style=\"text-align:left;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".withoutpoint($value1['advamount'])."</td>
	<td style=\"text-align:left;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".withoutpoint($value1['paybamount'])."</td>
	<td style=\"text-align:center;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['dailyamount']."</td>
	<td style=\"text-align:center;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".date_format(date_create($value1['datefunded']), 'm-d-Y')."</td>
	<td style=\"text-align:center;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['closecosts']."</td>
	<td style=\"text-align:center;\" onmouseover=\"vtlib_listview.trigger('cell.onmouseover', $(this))\" onmouseout=\"vtlib_listview.trigger('cell.onmouseout', $(this))\">".$value1['hp']."</td>
</tr>";
		//$total[$key]['advamount']+=newnumber($value1['advamount']);
		//$total[$key]['paybamount']+=newnumber($value1['paybamount']);
		$nvalue1 = preg_replace('/[\$g]/','',$value1['advamount']);
		$nvalue1 = preg_replace('/[\,g]/','',$nvalue1);
		$nnvalue1 = preg_replace('/[\$g]/','',$value1['paybamount']);
		$nnvalue1 = preg_replace('/[\,g]/','',$nnvalue1);
		$total[$key]['advamount'] +=(float)$nvalue1;
		$total[$key]['paybamount'] +=(float)$nnvalue1;
		$total_deals = $total_deals+1;
                $subtotal = $subtotal +1;
		
		if (preg_match("/max/i", "".$value1['funder'])) {
        $total_funder["Max Advance"] +=(float)$nvalue1;
             }
		if (preg_match("/cow/i", "".$value1['funder'])) {
        $total_funder["Cash Cow"] +=(float)$nvalue1;
             }
		if (preg_match("/cooper/i", "".$value1['funder'])) {
        $total_funder["Cooper"] +=(float)$nvalue1;
             }
		if (preg_match("/nu/i", "".$value1['funder'])) {
        $total_funder["Nu Look"] +=(float)$nvalue1;
             }
		if (preg_match("/bcf/i", "".$value1['funder'])) {
        $total_funder["BCF"] +=(float)$nvalue1;
             }
		if (preg_match("/nnr/i", "".$value1['funder'])) {
        $total_funder["NNR"] +=(float)$nvalue1;
             }
		if (preg_match("/fusion/i", "".$value1['funder'])) {
        $total_funder["Fusion Cap"] +=(float)$nvalue1;
             }
		if (preg_match("/iou/i", "".$value1['funder'])) {
        $total_funder["IOU"] +=(float)$nvalue1;
             }
		if (preg_match("/bgc/i", "".$value1['funder'])) {
        $total_funder["BGC"] +=(float)$nvalue1;
             }
		if (preg_match("/knight/i", "".$value1['funder'])) {
        $total_funder["Knight Cap"] +=(float)$nvalue1;
             }
		if (preg_match("/MCG/i", "".$value1['funder'])) {
        $total_funder["MCG"] +=(float)$nvalue1;
             }
		if (preg_match("/Retail/i", "".$value1['funder'])) {
        $total_funder["Retail"] +=(float)$nvalue1;
             }
		if (preg_match("/Quarter/i", "".$value1['funder'])) {
        $total_funder["Quarter Sp"] +=(float)$nvalue1;
             }
             if (preg_match("/Strategic/i", "".$value1['funder'])) {
        $total_funder["Strategic G"] +=(float)$nvalue1;
             }
			 if (preg_match("/WBL/i", "".$value1['funder'])) {
        $total_funder["WBL"] +=(float)$nvalue1;
             }
             if (preg_match("/Retail/i", "".$value1['funder'])) {
        $total_funder["Retail Capital"] +=(float)$nvalue1;
             }
			  if (preg_match("/AMERI/i", "".$value1['funder'])) {
        $total_funder["AMERI MERCHANT"] +=(float)$nvalue1;
             }
			  if (preg_match("/Bank/i", "".$value1['funder'])) {
        $total_funder["Bank Card"] +=(float)$nvalue1;
             }
			   if (preg_match("/American/i", "".$value1['funder'])) {
        $total_funder["American Business"] +=(float)$nvalue1;
             }
			    if (preg_match("/quickbridge/i", "".$value1['funder'])) {
        $total_funder["Quickbridge"] +=(float)$nvalue1;
             }
				if (preg_match("/fast/i", "".$value1['funder'])) {
        $total_funder["Fast 24/7"] +=(float)$nvalue1;
             }
             if (preg_match("/Circle/i", "".$value1['funder'])) {
        $total_funder["Funding Circle"] +=(float)$nvalue1;
             }
			 if (preg_match("/Super/i", "".$value1['funder'])) {
        $total_funder["Super G"] +=(float)$nvalue1;
             }
			  if (preg_match("/Rapid/i", "".$value1['funder'])) {
        $total_funder["Rapid Advance"] +=(float)$nvalue1;
             }
             
				
              
		
	//BNJ
	$c_src = $value1['campaign_src'];
	if (!$c_src) { $c_src = 'Unknown'; }
        $total_campaign_src[$c_src] +=(float)$nvalue1;
	//END BNJ			
	}
	echo "<tr>
 <td style='font-weight:bold;'>SubTotal:</td>
        
        <td style='font-weight:bold;'>".setpointtonumber($subtotal)." Deals</td>
        

	<td style='font-weight:bold;'>Total:
	
	<td>\$".setpointtonumber($total[$key]['advamount'])."</td>
	<td>\$".setpointtonumber($total[$key]['paybamount'])."</td>
	<td style=\"text-align:center;\" colspan='1'></td>
	</tr>";
echo "</table><div style='height:15px;'></div></div>";
$subtotal = 0;
}
foreach($total as $value){
	$total['advamount']+=$value['advamount'];
	$total['paybamount']+=$value['paybamount'];
        $subtotal = $subtotal +1;
}

//This is the bottom total
echo "<table class=\"lvt small\" width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">
<tr>
<td style='font-weight:bold; width:12%;'>Total:   &nbsp;&nbsp; ".setpointtonumber($total_deals)." Deals </td>
<td colspan='1'style=\"width:15%;\"> </td>
<td></td><td></td><td></td>
<td style=\"width:13%;\">&nbsp;\$".setpointtonumber($total['advamount'])."</td>
<td >&nbsp;\$".setpointtonumber($total['paybamount'])."</td>
<td style=\"text-align:center;\" colspan='4'></td>
</tr>
</table>";


echo "<table class=\"lvt small\" width=\"100%\" cellspacing=\"3\" cellpadding=\"3\" border=\"0\">
<tr>
<td style='font-weight:bold; width:15%;'>Total:   &nbsp;&nbsp; </td>";
$legends = array();
$data = array(); 
$data_flag=0;  
foreach ($total_funder as $key => $value) {
   echo "<td style='font-weight:bold;  width:9%;'>".$key."  $".setpointtonumber($value)."&nbsp;&nbsp;</td>";
  $legends[] = $key;
  $data[]=setpointtonumber($value);
  $data_flag=1;
}


echo "
<td colspan='1'style=\"width:25%;\"> </td>

<td style=\"text-align:center;\" colspan='4'></td>
</tr>
</table>";
//BNJ
echo "<table class=\"lvt small\" width=\"100%\" cellspacing=\"3\" cellpadding=\"3\" border=\"0\">
<tr>
<td style='font-weight:bold; width:15%;'>Total by Campaign Source:   &nbsp;&nbsp; </td>";
$legends2 = array();
$data2 = array();
foreach ($total_campaign_src as $key => $value) {
	//if($key!= "Hot" && $key!="Warm"){
   echo "<td style='font-weight:bold;  width:9%;'>".$key." <br>  $".setpointtonumber($value)."&nbsp;&nbsp;</td>";
	 $legends2[] = $key;
  $data2[]=setpointtonumber($value);
	//}
}


echo "
<td colspan='1'style=\"width:25%;\"> </td>

<td style=\"text-align:center;\" colspan='4'></td>
</tr>
</table>";
//END BNJkkkkkkkkk
}
?>
		</div>
	</td>
	<td valign="top"></td>
</tr>
</table>
<div style="margin-left: 100px;float:left;">
<?php
 // Browser usage statistics, %  

  if($data_flag==1) {
  // Creating a new graphic   
  $graph = new PieGraph(600, 450);   
  $graph->SetShadow();   
  
  // Naming the graphic  
  $graph->title->Set('Funder Chart');   
  $graph->title->SetFont(FF_DED, FS_BOLD, 14);   
  
  // Legend positioning (%/100)   
  $graph->legend->Pos(0.1, 0.2);   
  
  // Creating a 3D pie graphic   
  $p1 = new PiePlot3d($data);   
  
  // Setting the graphic center (%/100)   
  $p1->SetCenter(0.55, 0.6);   
  
  // Setting the ancle   
  $p1->SetAngle(30);   
  
  // Choosing the type   
  $p1->value->SetFont(FF_DED, FS_NORMAL, 12);   
  
  // Setting legends for graphic segments  
  $p1->SetLegends($legends);   
  
  // Adding the diagram to the graphic  
  
  $graph->Add($p1);   
  // Showing graphic  
  
  $graph->Stroke("file.jpg");
  ?>
  <img src="file.jpg" />
  </div>
   <div style="float:left;margin-left:150px;">
  <?php
  $graph = new PieGraph(600, 450);   
  $graph->SetShadow();   
  
  // Naming the graphic  
  $graph->title->Set('Campaign Chart');   
  $graph->title->SetFont(FF_DED, FS_BOLD, 14);   
  
  // Legend positioning (%/100)   
  $graph->legend->Pos(0.1, 0.2);   
  
  // Creating a 3D pie graphic   
  $p1 = new PiePlot3d($data2);   
  
  // Setting the graphic center (%/100)   
  $p1->SetCenter(0.55, 0.6);   
  
  // Setting the ancle   
  $p1->SetAngle(30);   
  
  // Choosing the type   
  $p1->value->SetFont(FF_DED, FS_NORMAL, 12);   
  
  // Setting legends for graphic segments  
  $p1->SetLegends($legends2);   
  
  // Adding the diagram to the graphic  
  
  $graph->Add($p1);   
  // Showing graphic  
  
  $graph->Stroke("file2.jpg");
  ?>
  <img src="file2.jpg" />
  <?php
  
  }
  
  //$graph->Stroke();  
?>
</div>

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
