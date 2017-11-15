<?php /* Smarty version 2.6.18, created on 2015-01-21 15:41:15
         compiled from EmailDetailView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'emails_checkFieldVisiblityPermission', 'EmailDetailView.tpl', 43, false),)), $this); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_tpl_vars['APP']['LBL_CHARSET']; ?>
">
<title><?php echo $this->_tpl_vars['MOD']['TITLE_VTIGERCRM_MAIL']; ?>
</title>
<link REL="SHORTCUT ICON" HREF="themes/images/vtigercrm_icon.ico">	
<style type="text/css">@import url("themes/<?php echo $this->_tpl_vars['THEME']; ?>
/style.css");</style>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
<body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table class="small" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
   <tr>
	<td colspan="3">
		<table border=0 cellspacing=0 cellpadding=0 width=100% class="mailClientWriteEmailHeader">
		<tr>
		<td ><?php echo $this->_tpl_vars['MOD']['LBL_DETAILVIEW_EMAIL']; ?>
</td>
		</tr>
		</table>

	</td>
   </tr> 
   <?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
   <?php $_from = $this->_tpl_vars['row']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['title'] => $this->_tpl_vars['elements']):
?>
   <?php if ($this->_tpl_vars['elements']['fldname'] == 'subject'): ?>	
   	<tr>
	<td class="lvtCol" width="15%" height="70px" style="padding: 5px;" align="right"><b><?php echo $this->_tpl_vars['MOD']['LBL_TO']; ?>
</b></td>
	<td class="dvtCellLabel" style="padding: 5px;">&nbsp;<?php echo $this->_tpl_vars['TO_MAIL']; ?>
</td>
	<td class="dvtCellLabel" width="20%" rowspan="4"><div id="attach_cont" class="addEventInnerBox" style="overflow:auto;height:140px;width:100%;position:relative;left:0px;top:0px;"></td>
   	</tr>
	   <?php if (emails_checkFieldVisiblityPermission('ccmail') == '0'): ?>
	   <tr>
		<td class="lvtCol" style="padding: 5px;" align="right"><b><?php echo $this->_tpl_vars['MOD']['LBL_CC']; ?>
</b></td>
		<td class="dvtCellLabel" style="padding: 5px;">&nbsp;<?php echo $this->_tpl_vars['CC_MAIL']; ?>
</td>
	   </tr>
	   <?php endif; ?>
	   <?php if (emails_checkFieldVisiblityPermission('bccmail') == '0'): ?>
	   <tr>
		<td class="lvtCol" style="padding: 5px;" align="right"><b><?php echo $this->_tpl_vars['MOD']['LBL_BCC']; ?>
</b></td>
		<td class="dvtCellLabel" style="padding: 5px;">&nbsp;<?php echo $this->_tpl_vars['BCC_MAIL']; ?>
</td>
	   </tr>
	   <?php endif; ?>
	<tr>
	<td class="lvtCol" style="padding: 5px;" align="right"><b><?php echo $this->_tpl_vars['MOD']['LBL_SUBJECT']; ?>
</b></td>
	<td class="dvtCellLabel" style="padding: 5px;">&nbsp;<?php echo $this->_tpl_vars['elements']['value']; ?>
</td>
   	</tr>
   	<tr>
	<td colspan="3" class="dvtCellLabel" style="padding: 10px;" align="center"><input type="button" name="forward" value=" <?php echo $this->_tpl_vars['MOD']['LBL_FORWARD_BUTTON']; ?>
 " alt="<?php echo $this->_tpl_vars['MOD']['LBL_FORWARD_BUTTON']; ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_FORWARD_BUTTON']; ?>
" class="crmbutton small edit" onClick=OpenCompose('<?php echo $this->_tpl_vars['ID']; ?>
','forward')>&nbsp;
	<input type="button" title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_EDIT']; ?>
" name="edit" value=" <?php echo $this->_tpl_vars['APP']['LBL_EDIT']; ?>
 " class="crmbutton small edit" onClick=OpenCompose('<?php echo $this->_tpl_vars['ID']; ?>
','edit')>&nbsp;

	<input name="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="crmbutton small cancel" type="button" onClick="window.close()">
	&nbsp;
	<input type="button" title="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_EMAIL']; ?>
" name="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_EMAIL']; ?>
" value="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_EMAIL']; ?>
" class="crmbutton small edit" onClick="OpenCompose('<?php echo $this->_tpl_vars['ID']; ?>
', 'print')">&nbsp;
	</td>
	</tr>
   <?php elseif ($this->_tpl_vars['elements']['fldname'] == 'description'): ?>
   	<tr>
	<td style="padding: 5px;" colspan="3" valign="top"><div style="overflow:auto;height:415px;width:100%;"><?php echo $this->_tpl_vars['elements']['value']; ?>
</div></td>

   	</tr>
   <?php elseif ($this->_tpl_vars['elements']['fldname'] == 'filename'): ?>
   	<tr><td colspan="3">
   	<div id="attach_temp_cont" style="display:none;">
		<table class="small" width="100% ">
		<?php $_from = $this->_tpl_vars['elements']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['attachments']):
?>
			<tr><td width="90%"><?php echo $this->_tpl_vars['attachments']; ?>
</td></tr>	
		<?php endforeach; endif; unset($_from); ?>	
		</table>	
	</div>	
   	</td></tr>	
   <?php endif; ?>	
   <?php endforeach; endif; unset($_from); ?>
   <?php endforeach; endif; unset($_from); ?>
   <tr>
	<td colspan="3" class="dvtCellLabel" style="padding: 10px;" align="center"><input type="button" name="forward" value=" <?php echo $this->_tpl_vars['MOD']['LBL_FORWARD_BUTTON']; ?>
 " alt="<?php echo $this->_tpl_vars['MOD']['LBL_FORWARD_BUTTON']; ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_FORWARD_BUTTON']; ?>
" class="crmbutton small edit" onClick=OpenCompose('<?php echo $this->_tpl_vars['ID']; ?>
','forward')>&nbsp;
	<input type="button" title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_EDIT']; ?>
" name="edit" value=" <?php echo $this->_tpl_vars['APP']['LBL_EDIT']; ?>
 " class="crmbutton small edit" onClick=OpenCompose('<?php echo $this->_tpl_vars['ID']; ?>
','edit')>&nbsp;

	<input name="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="crmbutton small cancel" type="button" onClick="window.close()">
	&nbsp;
	<input type="button" title="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_EMAIL']; ?>
" name="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_EMAIL']; ?>
" value="<?php echo $this->_tpl_vars['MOD']['LBL_PRINT_EMAIL']; ?>
" class="crmbutton small edit" onClick="OpenCompose('<?php echo $this->_tpl_vars['ID']; ?>
', 'print')"> &nbsp;
	</td>
   </tr>


</table>		
<script>
$('attach_cont').innerHTML = $('attach_temp_cont').innerHTML;
</script>