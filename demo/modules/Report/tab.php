<?php
$tab=array(
	"index"=>"Lead Report",
	"funded"=>"Funded Report",
	"appoutreport"=>"Apps Out Report",
	"campaign"=>"Lead Campaign Report"
);

if (isset($_REQUEST['action']) && isset($tab[$_REQUEST['action']])){
	$action=$_REQUEST['action'];
} else $action="index";
?>

<table width="100%" cellspacing="0" cellpadding="3" border="0">
<tr>
<?php
foreach ($tab as $key=>$value) {
	?>
	<td style="width:10px" class="dvtTabCache">&nbsp;</td>
	<?php
	if ($action==$key){ ?>
	<td align="center" class="dvtSelectedCell" id="cellTabInvite" style="width: 200px"><?php echo $value; ?></td>
	<?php }else{ ?>
	<td align="center" class="dvtUnSelectedCell" id="cellTabAlarm" style="width: 200px"><a href="index.php?module=Report&action=<?php echo $key; ?>"><?php echo $value; ?></a></td>
	<?php
	}
}
?>
<td class="dvtTabCache">&nbsp;</td>
</tr>
</table>