<?php
if (count($_POST)>1){
	$update=array();
	foreach ($_POST as $key=>$value){
		if ($key=="datefunded")
			$update[]=$key."='".substr($_POST[$key],6)."-".substr($_POST[$key],0,2)."-".substr($_POST[$key],3,2)."'";
		else
			$update[]=$key."='".$_POST[$key]."'";
	}
	$query="update vtiger_leads_funded set ".implode(", ",$update)." where id='".(int)$_REQUEST['record']."'";
	mysql_query($query);
?>
<html>
	<head>
		<script>
			//window.opener.updateleadstatus('<?php echo $record; ?>');
			window.opener.location.reload();
			window.close();
		</script>
	</head>
	<body></body>
</html>
<?php
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Super User - Leads - vtiger CRM 5 - Commercial Open Source CRM</title>
	<link REL="SHORTCUT ICON" HREF="themes/images/vtigercrm_icon.ico">
	<style type="text/css">@import url("themes/softed/style.css?v=5.4.0");</style>
	<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
	<link rel="stylesheet" href="/staging/drop/jquery.fileupload-ui.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
	<script language="JavaScript" type="text/javascript" src="modules/Calendar/script.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-cold-1.css">
	<script type="text/javascript" src="jscalendar/calendar.js"></script>
	<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
	<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
	<!-- ActivityReminder customization for callback -->

	<style type="text/css">div.fixedLay1 { position:fixed; }</style>
	<!--[if lte IE 6]>
	<style type="text/css">div.fixedLay { position:absolute; }</style>
	<![endif]-->
	<style type="text/css">div.drop_mnu_user { position:fixed; }</style>
	<!--[if lte IE 6]>
	<style type="text/css">div.drop_mnu_user { position:absolute; }</style>
	<![endif]-->

	<!-- End -->

</head>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 class="small">
<script type="text/javascript">
	function validate(){
		error='';
		if (document.getElementById('funder').value=='') error+= '.Funder must be full\n';
		if (document.getElementById('advamount').value=='') error+= '.Advance amount must be full\n';
		if (document.getElementById('paybackamount').value=='') error+= '.Payback amount must be full\n';
		if (document.getElementById('hp').value=='') error+= '.HP % must be full\n';
		if (document.getElementById('dailyamount').value=='') error+= '.Daily amount must be full\n';
		if (document.getElementById('closingcosts').value=='') error+= '.Closing costs must be full\n';
		if (document.getElementById('datefunded').value=='') error+= '.Date funded must be full\n';
		if (document.getElementById('categories').value=='-') error+='Categories must be full\n';		
		if (error!='') alert(error);
		else document.getElementById('form').submit();
	}
</script>
<?php
$res=  mysql_query("select * from vtiger_leads_funded where id='".$_REQUEST['record']."'");
$data=array();
while ($row=  mysql_fetch_assoc($res)) $data=$row;
$res=mysql_query("select cf_733 from vtiger_cf_733");
while ($row=  mysql_fetch_assoc($res)) $cf_733[]=$row['cf_733'];
?>
		<form action="" method="POST" id="form">
			<table class="small" width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
	<td class="dvtCellLabel" width="100px" align="right">.Funder</td>


	<td class="dvtCellInfo" align="left">

<!-- BNJ
<input id="funder" type="text" value="<?php echo $data['funder']; ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="funder">
-->

<!-- Start BNJ -->

                        <select id="funder" name="funder">
                          <option value="Max Advance"<?php if ($data['funder'] == 'Max Advance') echo " selected"; ?>>Max Advance</option>
                        <option value="MCG"<?php if ($data['funder'] == 'Funder2') echo " selected"; ?>>Funder2</option>
                        </select>
			
<!-- End BNJ -->


</td>



</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">.Advance amount</td>
	<td class="dvtCellInfo" align="left"><input id="advamount" type="text" value="<?php echo $data['advamount']; ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="advamount"></td>
</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">.Payback amount</td>
	<td class="dvtCellInfo" align="left"><input id="paybackamount" type="text" value="<?php echo $data['paybackamount']; ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="paybackamount"></td>
</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">.HP %</td>
	<td class="dvtCellInfo" align="left"><input id="hp" type="text" value="<?php echo $data['hp']; ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="hp"></td>
</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">.Daily amount</td>
	<td class="dvtCellInfo" align="left"><input id="dailyamount" type="text" value="<?php echo $data['dailyamount']; ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="dailyamount"></td>
</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">.Closing costs</td>
	<td class="dvtCellInfo" align="left"><input id="closingcosts" type="text" value="<?php echo $data['closingcosts']; ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="closingcosts"></td>
</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">.Date funded</td>
	<td class="dvtCellInfo" align="left"><input id="datefunded" type="text" value="<?php $date = new DateTimeField($data['datefunded']); echo $date->getDisplayDate(); ?>" maxlength="10" size="11" style="border:1px solid #bababa;" tabindex="" name="datefunded">
			<img id="jscal_trigger_cf_727" src="themes/softed/images/btnL3Calendar.gif">
			<br><font size="1"><em old="(yyyy-mm-dd)">(mm-dd-yyyy)</em></font>
				<script id="massedit_calendar_cf_727" type="text/javascript">
					Calendar.setup ({
						inputField : "datefunded", ifFormat : "%m-%d-%Y", showsTime : false, button : "jscal_trigger_cf_727", singleClick : true, step : 1
					})
				</script></td>
</tr><tr>
	<td class="dvtCellLabel" width="100px" align="right">Categories</td>
	<td class="dvtCellInfo" align="left">
		<?php 
			echo '<select id="categories" name="categories">';
			foreach ($cf_733 as $val){
				echo '<option value="'.$val.'"';
				if ($val==$data['categories']) echo ' selected';
				echo '>'.$val.'</option>';
			}
			echo '</select>';
		?>
	</td>
</tr><tr>
	<td colspan="2" class="dvtCellInfo" align="center"><input type="button" onclick="validate()" value="Save" class="crmButton small save"></td>
</tr>
			</table>
		</form>
</body>
</html>
<?php } ?>
