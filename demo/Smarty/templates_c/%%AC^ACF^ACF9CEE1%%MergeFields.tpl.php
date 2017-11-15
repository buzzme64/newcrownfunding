<?php /* Smarty version 2.6.18, created on 2015-03-11 00:43:55
         compiled from MergeFields.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'MergeFields.tpl', 111, false),array('modifier', 'truncate', 'MergeFields.tpl', 116, false),array('modifier', 'vtiger_imageurl', 'MergeFields.tpl', 151, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $this->_tpl_vars['APP'][$this->_tpl_vars['MODULE_NAME']]; ?>
 - <?php echo $this->_tpl_vars['APP']['LBL_BROWSER_TITLE']; ?>
</title>
	<link REL="SHORTCUT ICON" HREF="themes/images/vtigercrm_icon.ico">	
	<style type="text/css">@import url("themes/<?php echo $this->_tpl_vars['THEME']; ?>
/style.css");</style>
	<!-- ActivityReminder customization for callback -->
	<?php echo '
	<style type="text/css">div.fixedLay1 { position:fixed; }</style>
	<!--[if lte IE 6]>
	<style type="text/css">div.fixedLay { position:absolute; }</style>
	<![endif]-->
	'; ?>

	<!-- End -->
</head>

<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 class=small>

<?php if ($this->_tpl_vars['EDIT_DUPLICATE'] == 'permitted'): ?>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<script src="include/scriptaculous/prototype.js" type="text/javascript"></script>
<script src="include/js/general.js" type="text/javascript"></script>
<script src="include/js/en_us.lang.js" type="text/javascript"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>

<form name="merge" method="POST" action="index.php" id="form" onsubmit="if(validate_merge('<?php echo $this->_tpl_vars['MODULENAME']; ?>
')){VtigerJS_DialogBox.block(); return true;} else { return false; };">
	<input type=hidden name="module" value="<?php echo $this->_tpl_vars['MODULENAME']; ?>
">
	<input type=hidden name="return_module" value="<?php echo $this->_tpl_vars['MODULENAME']; ?>
">
	<input type="hidden" name="action" value="ProcessDuplicates">
	<input type="hidden" name="mergemode" value="mergesave">
	<input type="hidden" name="parent" value="<?php echo $this->_tpl_vars['PARENT_TAB']; ?>
">
	<input type="hidden" name="pass_rec" value="<?php echo $this->_tpl_vars['IDSTRING']; ?>
">
	<input type="hidden" name="return_action" value="FindDuplicateRecords">
	
	<div style='margin: 0 5px;'>
		<table class="small" border="0" cellspacing=0 cellpadding=4 width="98%">	
		<tr>
			<td align="left" colspan="2" class="moduleName" nowrap="nowrap">
			<?php $this->assign('MODULELABEL', $this->_tpl_vars['MODULENAME']); ?>
			<?php if ($this->_tpl_vars['APP'][$this->_tpl_vars['MODULENAME']] != ''): ?>
				<?php $this->assign('MODULELABEL', $this->_tpl_vars['APP'][$this->_tpl_vars['MODULENAME']]); ?>
			<?php endif; ?>	
			<?php echo $this->_tpl_vars['APP']['LBL_MERGE_DATA_IN']; ?>
 &gt; <span class="hdrLink"><?php echo $this->_tpl_vars['MODULELABEL']; ?>
</span>
			</td>
		</tr>
		<tr>
			<td class="small"><?php echo $this->_tpl_vars['APP']['LBL_DESC_FOR_MERGE_FIELDS']; ?>
</td>
		</tr>
		</table>
	</div>
	
	<div style='margin: 0 5px;'>
		<table class="lvt small" border="0" cellpadding="3" cellspacing="1" width="98%">
		<tr >
			<td class="lvtCol"><b><?php echo $this->_tpl_vars['APP']['LBL_FIELDLISTS']; ?>
</b></td>
			<?php $this->assign('count', 1); ?>
			<?php $this->assign('cnt_rec', 0); ?>
			<?php if ($this->_tpl_vars['NO_EXISTING'] == 1): ?>
				<?php $_from = $this->_tpl_vars['ID_ARRAY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cnt'] => $this->_tpl_vars['record']):
?>	
					<td  class="lvtCol" >
						<b><?php echo $this->_tpl_vars['APP']['LBL_RECORD']; ?>
<?php echo $this->_tpl_vars['count']; ?>
</b>
						<?php if ($this->_tpl_vars['count'] == 1): ?>
							<input name="record" value="<?php echo $this->_tpl_vars['record']; ?>
" onclick="select_All('<?php echo $this->_tpl_vars['JS_ARRAY']; ?>
','<?php echo $this->_tpl_vars['cnt']; ?>
','<?php echo $this->_tpl_vars['MODULENAME']; ?>
');" type="radio" checked> <span style="font-size:11px"><?php echo $this->_tpl_vars['APP']['LBL_SELECT_AS_PARENT']; ?>
</span>
						<?php else: ?>
							<input name="record" value="<?php echo $this->_tpl_vars['record']; ?>
" onclick="select_All('<?php echo $this->_tpl_vars['JS_ARRAY']; ?>
','<?php echo $this->_tpl_vars['cnt']; ?>
','<?php echo $this->_tpl_vars['MODULENAME']; ?>
');" type="radio"> <span style="font-size:11px"><?php echo $this->_tpl_vars['APP']['LBL_SELECT_AS_PARENT']; ?>
</span>
						<?php endif; ?>
					</td>
					<?php $this->assign('cnt_rec', $this->_tpl_vars['cnt_rec']+1); ?>
					<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
				<?php endforeach; endif; unset($_from); ?>
			<?php else: ?>
				<?php $_from = $this->_tpl_vars['ID_ARRAY']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cnt'] => $this->_tpl_vars['record']):
?>	
					<td  class="lvtCol" >
						<b><?php echo $this->_tpl_vars['APP']['LBL_RECORD']; ?>
<?php echo $this->_tpl_vars['count']; ?>
</b>
					<?php $this->assign('found', 0); ?>
					<?php $_from = $this->_tpl_vars['IMPORTED_RECORDS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['child']):
?>
						<?php if ($this->_tpl_vars['record'] == $this->_tpl_vars['child']): ?>	
							<?php $this->assign('found', 1); ?>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
					<?php if ($this->_tpl_vars['found'] == 0): ?>
						<?php if ($this->_tpl_vars['count'] == 1): ?>
							<input name="record" value="<?php echo $this->_tpl_vars['record']; ?>
" onclick="select_All('<?php echo $this->_tpl_vars['JS_ARRAY']; ?>
','<?php echo $this->_tpl_vars['cnt']; ?>
','<?php echo $this->_tpl_vars['MODULENAME']; ?>
');" type="radio" checked> <span style="font-size:11px"><?php echo $this->_tpl_vars['APP']['LBL_SELECT_AS_PARENT']; ?>
</span>
						<?php else: ?>
							<input name="record" value="<?php echo $this->_tpl_vars['record']; ?>
" onclick="select_All('<?php echo $this->_tpl_vars['JS_ARRAY']; ?>
','<?php echo $this->_tpl_vars['cnt']; ?>
','<?php echo $this->_tpl_vars['MODULENAME']; ?>
');" type="radio"> <span style="font-size:11px"><?php echo $this->_tpl_vars['APP']['LBL_SELECT_AS_PARENT']; ?>
</span>
						<?php endif; ?>
					<?php endif; ?>
					</td>
					<?php $this->assign('cnt_rec', $this->_tpl_vars['cnt_rec']+1); ?>
					<?php $this->assign('count', $this->_tpl_vars['count']+1); ?>
				<?php endforeach; endif; unset($_from); ?>
			<?php endif; ?>
		</tr>
			<?php $_from = $this->_tpl_vars['ALLVALUES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cnt'] => $this->_tpl_vars['data']):
?>
			<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['fld_array']):
?>
		<tr class="IvtColdata" onmouseover="this.className='lvtColDataHover';" onmouseout="this.className='lvtColData';" bgcolor="white">
					
					<td ><b><?php echo getTranslatedString($this->_tpl_vars['label'], $this->_tpl_vars['MODULE']); ?>
</b>
					</td>
					<?php $_from = $this->_tpl_vars['fld_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cnt2'] => $this->_tpl_vars['fld_value']):
?>
						<?php if ($this->_tpl_vars['fld_value']['disp_value'] != ''): ?>
							<?php if ($this->_tpl_vars['cnt2'] == 0): ?>
								<td nowrap><input name='<?php echo $this->_tpl_vars['FIELD_ARRAY'][$this->_tpl_vars['cnt']]; ?>
' value='<?php echo $this->_tpl_vars['fld_value']['org_value']; ?>
' type="radio" checked><?php echo ((is_array($_tmp=$this->_tpl_vars['fld_value']['disp_value'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</td>
							<?php else: ?>
								<td nowrap><input name='<?php echo $this->_tpl_vars['FIELD_ARRAY'][$this->_tpl_vars['cnt']]; ?>
' value='<?php echo $this->_tpl_vars['fld_value']['org_value']; ?>
' type="radio"><?php echo ((is_array($_tmp=$this->_tpl_vars['fld_value']['disp_value'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 30) : smarty_modifier_truncate($_tmp, 30)); ?>
</td>
							<?php endif; ?>
						<?php else: ?>
							<?php if ($this->_tpl_vars['cnt2'] == 0): ?>
								<td><input name='<?php echo $this->_tpl_vars['FIELD_ARRAY'][$this->_tpl_vars['cnt']]; ?>
' value='' type="radio" checked><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
</td>
							<?php else: ?>
								<td><input name='<?php echo $this->_tpl_vars['FIELD_ARRAY'][$this->_tpl_vars['cnt']]; ?>
' value='' type="radio"><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
</td>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?>
		</tr>
				<?php endforeach; endif; unset($_from); ?>	
				<?php endforeach; endif; unset($_from); ?>	
		</table>
	</div>
	
	<div style='margin: 0 5px;'>
		<table border=0 class="lvtColData"  width="100%" cellspacing=0 cellpadding="0px">	
		<tr>
				<td align="center" >
				<input title="<?php echo $this->_tpl_vars['APP']['LBL_MERGE_BUTTON_TITLE']; ?>
" class="crmbutton small save" type="submit" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_MERGE_BUTTON_LABEL']; ?>
  " >	
				</td>
			</tr>	
		</table>
	</div>
</form>

<?php else: ?>
	<table border='0' cellpadding='5' cellspacing='0' width='100%' height='450px'><tr><td align='center'>
	<div style='border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 55%; position: relative; z-index: 10000000;'>

		<table border='0' cellpadding='5' cellspacing='0' width='98%'>
		<tbody><tr>
		<td rowspan='2' width='11%'><img src='<?php echo vtiger_imageurl('denied.gif', $this->_tpl_vars['THEME']); ?>
' ></td>
		<td style='border-bottom: 1px solid rgb(204, 204, 204);' nowrap='nowrap' width='70%'>
			<span class='genHeaderSmall'><?php echo $this->_tpl_vars['APP']['LBL_PERMISSION']; ?>
</span></td>
		</tr>
		<tr>
		<td class='small' align='right' nowrap='nowrap'>
		<a href='javascript:self.close();'><?php echo $this->_tpl_vars['APP']['LBL_GO_BACK']; ?>
</a><br>
		</td>
		</tr>
		</tbody></table>
	</div>
	</td></tr></table>
				
<?php endif; ?>
</body>
</html>			