<?php /* Smarty version 2.6.18, created on 2013-12-10 12:06:34
         compiled from FindDuplicateAjax.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'FindDuplicateAjax.tpl', 12, false),array('modifier', 'sizeof', 'FindDuplicateAjax.tpl', 44, false),)), $this); ?>
<table width='100%' border='0' cellpadding='5' cellspacing='0' class='tableHeading'>
	<tr>
		<td class='big' align='left'>
			<b><?php echo $this->_tpl_vars['APP']['LBL_DUPLICATE_DATA_IN']; ?>
 <?php echo $this->_tpl_vars['MOD']['LBL_MODULE_NAME']; ?>
</b>
		</td>
	</tr>
</table>
<br>
<table border="0" align ="center" width ="95%">
	<tr>
		<td >
            <?php $this->assign('massDelete', ((is_array($_tmp='LBL_MASS_DELETE')) ? $this->_run_mod_handler('getTranslatedString', true, $_tmp, $this->_tpl_vars['MODULE']) : getTranslatedString($_tmp, $this->_tpl_vars['MODULE']))); ?>
            <?php if ($this->_tpl_vars['DELETE'] == $this->_tpl_vars['massDelete']): ?>
                 <input class="crmbutton small delete" type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_DELETE']; ?>
" onclick="return delete_fields('<?php echo $this->_tpl_vars['MODULE']; ?>
')"/>
            <?php endif; ?>
        </td>
		<td nowrap >
			<table border=0 cellspacing=0 cellpadding=0 class="small">
				<tr><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</tr>
			</table>	
        </td>
	</tr>
</table>

<table class="lvt small" border="0" cellpadding="3" align="center" cellspacing="1" width="95%" >
<tr>
	<td class="lvtCol" width="40px">
		<input type="checkbox" name="CheckAll" onclick='selectAllDel(this.checked,"del");' >
	</td>
	<?php $_from = $this->_tpl_vars['FIELD_NAMES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['field_values']):
?>
		<td class="lvtCol big"> 
			<b><?php echo getTranslatedString($this->_tpl_vars['key'], $this->_tpl_vars['MODULE']); ?>
</b>
		</td>
	<?php endforeach; endif; unset($_from); ?>
	<td class="lvtCol big" cellpadding="3">
		<?php echo $this->_tpl_vars['APP']['LBL_MERGE_SELECT']; ?>

	</td>
	<td class="lvtCol big" cellpadding="2" width="120px">
		<?php echo $this->_tpl_vars['APP']['LBL_ACTION']; ?>

	</td>
</tr>
	<?php $this->assign('tdclass', 'IvtColdata'); ?>
	<?php $_from = $this->_tpl_vars['ALL_VALUES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['data']):
?>
		<?php $this->assign('cnt', sizeof($this->_tpl_vars['data'])); ?>
		<?php $this->assign('cnt2', 0); ?>
		<?php if ($this->_tpl_vars['tdclass'] == 'IvtColdata'): ?>
			<?php $this->assign('tdclass', 'sep1'); ?>
		<?php else: ?>
			<?php $this->assign('tdclass', 'IvtColdata'); ?>
		<?php endif; ?>
			<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['newdata1']):
?>
				<tr class="<?php echo $this->_tpl_vars['tdclass']; ?>
" nowrap="nowrap" >
					<td>
						<input type="checkbox" name="del" value="<?php echo $this->_tpl_vars['data'][$this->_tpl_vars['key3']]['recordid']; ?>
" onclick='selectDel(this.name,"CheckAll");'  >
					</td>
					<?php $_from = $this->_tpl_vars['newdata1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['newdata2']):
?>
						<td >
							<?php if ($this->_tpl_vars['key'] == 'recordid'): ?>	
								<a href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=DetailView&record=<?php echo $this->_tpl_vars['data'][$this->_tpl_vars['key3']]['recordid']; ?>
&parenttab=<?php echo $this->_tpl_vars['CATEGORY']; ?>
" target ="blank"><?php echo $this->_tpl_vars['newdata2']; ?>
</a>
							<?php else: ?>
								<?php if ($this->_tpl_vars['key'] == 'Entity Type'): ?>
									<?php if ($this->_tpl_vars['newdata2'] == 0 && $this->_tpl_vars['newdata2'] != NULL): ?>
										<?php if ($this->_tpl_vars['VIEW'] == true): ?>
											<?php echo $this->_tpl_vars['APP']['LBL_LAST_IMPORTED']; ?>

										<?php else: ?>
											<?php echo $this->_tpl_vars['APP']['LBL_NOW_IMPORTED']; ?>

										<?php endif; ?>
									<?php else: ?>
										<?php echo $this->_tpl_vars['APP']['LBL_EXISTING']; ?>

								<?php endif; ?>
							<?php else: ?>
								<?php echo $this->_tpl_vars['newdata2']; ?>

							<?php endif; ?>
							<?php endif; ?>
						</td>
					<?php endforeach; endif; unset($_from); ?>	
					<td cellpadding="3" nowrap width="80px">
						<input name="<?php echo $this->_tpl_vars['key1']; ?>
" id="<?php echo $this->_tpl_vars['key1']; ?>
" value="<?php echo $this->_tpl_vars['data'][$this->_tpl_vars['key3']]['recordid']; ?>
"  type="checkbox">
					</td>
					<?php if ($this->_tpl_vars['cnt2'] == 0): ?>
						<td align="center" rowspan='<?php echo $this->_tpl_vars['cnt']; ?>
'><input class="crmbutton small edit" name="merge" value="<?php echo $this->_tpl_vars['APP']['LBL_MERGE']; ?>
" onclick="merge_fields('<?php echo $this->_tpl_vars['key1']; ?>
','<?php echo $this->_tpl_vars['MODULE']; ?>
','<?php echo $this->_tpl_vars['CATEGORY']; ?>
');" type="button"></td>
					<?php endif; ?>
					<?php $this->assign('cnt2', $this->_tpl_vars['cnt2']+1); ?>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
	<?php endforeach; endif; unset($_from); ?>
</table>
<div name="group_count" id="group_count" style="display :none">
		<?php echo $this->_tpl_vars['NUM_GROUP']; ?>

</div>