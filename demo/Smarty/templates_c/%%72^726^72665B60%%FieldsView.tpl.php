<?php /* Smarty version 2.6.18, created on 2013-09-16 14:19:29
         compiled from modules/Webforms/FieldsView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/Webforms/FieldsView.tpl', 15, false),array('modifier', 'explode', 'modules/Webforms/FieldsView.tpl', 50, false),array('modifier', 'vtiger_imageurl', 'modules/Webforms/FieldsView.tpl', 59, false),)), $this); ?>
<table id="field_table" class="small" border="0" cellpadding="5" cellspacing="1" width="100%">
	<tr>
		<td style="width:2%;height:25px;" class="lvtCol"></td>
		<td style="height:25px;" class="lvtCol"><?php echo getTranslatedString('LBL_FIELDLABEL', $this->_tpl_vars['MODULE']); ?>
</td>
		<td style="height:25px;" class="lvtCol"><?php echo getTranslatedString('LBL_DEFAULT_VALUE', $this->_tpl_vars['MODULE']); ?>
</td>
		<td style="width:2%;height:25px;" class="lvtCol"><?php echo getTranslatedString('LBL_REQUIRED', $this->_tpl_vars['MODULE']); ?>
</td>
		<td style="height:25px;" class="lvtCol" style="width:20%;"><?php echo getTranslatedString('LBL_NEUTRALIZEDFIELD', $this->_tpl_vars['MODULE']); ?>
</td>
	</tr>
	<?php $this->assign('CNT', 0); ?>
	<?php $_from = $this->_tpl_vars['WEBFORMFIELDS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['fieldloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fieldloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['field']):
        $this->_foreach['fieldloop']['iteration']++;
?>
	<?php $this->assign('CNT', $this->_tpl_vars['CNT']+1); ?>
	<?php if ($this->_tpl_vars['field']['editable'] == true && $this->_tpl_vars['field']['type']['name'] != reference && $this->_tpl_vars['field']['name'] != assigned_user_id): ?>
	<tr style="height:25px" id="field_row">
		<td class="dvtCellInfo" align="right" colspan="1">
		<?php if ($this->_tpl_vars['field']['mandatory'] == 1): ?>
			<input type="checkbox" name="fields[]"  checked="checked"  value="<?php echo $this->_tpl_vars['field']['name']; ?>
" record="true" disabled="true">
			<input type="hidden" name="fields[]"  value="<?php echo $this->_tpl_vars['field']['name']; ?>
" record="true" >
		<?php else: ?>
			<?php if ($this->_tpl_vars['WEBFORMID']): ?>
				<?php if ($this->_tpl_vars['WEBFORM']->isWebformField($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == true): ?>
					<input type="checkbox" name="fields[]"  record="false" checked="checked" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" onClick=Webforms.showHideElement('value[<?php echo $this->_tpl_vars['field']['name']; ?>
]','required[<?php echo $this->_tpl_vars['field']['name']; ?>
]','jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
','mincal_<?php echo $this->_tpl_vars['field']['name']; ?>
')>
				<?php else: ?>
					<input type="checkbox" name="fields[]"   record="false" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" onClick=Webforms.showHideElement('value[<?php echo $this->_tpl_vars['field']['name']; ?>
]','required[<?php echo $this->_tpl_vars['field']['name']; ?>
]','jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
','mincal_<?php echo $this->_tpl_vars['field']['name']; ?>
')>
				<?php endif; ?>
			<?php else: ?>
					<input type="checkbox" name="fields[]"  record="false" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" onClick=Webforms.showHideElement('value[<?php echo $this->_tpl_vars['field']['name']; ?>
]','required[<?php echo $this->_tpl_vars['field']['name']; ?>
]','jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
','mincal_<?php echo $this->_tpl_vars['field']['name']; ?>
')>
			<?php endif; ?>
		<?php endif; ?>
		</td>
		<td class="dvtCellLabel" align="left" colspan="1">
		<?php if ($this->_tpl_vars['field']['mandatory'] == 1): ?>
			<font color="red">*</font>
		<?php endif; ?>
			<?php echo getTranslatedString($this->_tpl_vars['field']['label'], $this->_tpl_vars['MODULE']); ?>

		</td>
		<td class="dvtCellInfo">
		<?php if ($this->_tpl_vars['WEBFORMID'] && $this->_tpl_vars['WEBFORM']->isWebformField($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == true): ?>
		<?php $this->assign('defaultvalue', $this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name'])); ?>
			<?php if ($this->_tpl_vars['field']['type']['name'] == picklist | $this->_tpl_vars['field']['type']['name'] == multipicklist): ?><?php $this->assign('val_arr', $this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name'])); ?><?php $this->assign('values', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['val_arr']) : explode($_tmp, $this->_tpl_vars['val_arr']))); ?>
				<select fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" class="small" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
][]" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" style="display:inline;" <?php if ($this->_tpl_vars['field']['type']['name'] == multipicklist): ?>multiple="multiple" size="5"<?php endif; ?>>
						<option value=""><?php echo getTranslatedString('LBL_SELECT_VALUE', $this->_tpl_vars['MODULE']); ?>
</option>
					<?php $_from = $this->_tpl_vars['field']['type']['picklistValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['optionloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['optionloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['optionloop']['iteration']++;
?>
						<option value="<?php echo $this->_tpl_vars['option']['value']; ?>
" <?php if (in_array ( $this->_tpl_vars['option']['value'] , $this->_tpl_vars['defaultvalue'] )): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['option']['label']; ?>
</option>
					<?php endforeach; endif; unset($_from); ?>
				</select>
			<?php elseif ($this->_tpl_vars['field']['type']['name'] == date): ?>
			<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" value="<?php echo $this->_tpl_vars['defaultvalue'][0]; ?>
" >
												<img src="<?php echo vtiger_imageurl('miniCalendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
">
												<font size=1 id="mincal_<?php echo $this->_tpl_vars['field']['name']; ?>
"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATE_FORMAT']; ?>
)</em></font>
												<script id="date_<?php echo $this->_tpl_vars['CNT']; ?>
">
													getCalendarPopup('jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
','value[<?php echo $this->_tpl_vars['field']['name']; ?>
]','<?php echo $this->_tpl_vars['CAL_DATE_FORMAT']; ?>
')
												</script>
			<?php elseif ($this->_tpl_vars['field']['type']['name'] == text): ?>
					<textarea fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" rows="2" onblur="this.className='detailedViewTextBox'" onfocus="this.className='detailedViewTextBoxOn'" class="detailedViewTextBox"  id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  value="<?php echo $this->_tpl_vars['defaultvalue'][0]; ?>
"><?php echo $this->_tpl_vars['defaultvalue'][0]; ?>
</textarea>
			
			<?php elseif ($this->_tpl_vars['field']['type']['name'] == boolean): ?>
					<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="checkbox"  id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" <?php if ($this->_tpl_vars['defaultvalue'][0] == 'on'): ?>checked="checked"<?php endif; ?>" >
			<?php else: ?>
					<?php if ($this->_tpl_vars['field']['name'] == salutationtype): ?>
							<select fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" class="small" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]">
								<option value="" <?php if ($this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == ""): ?>selected="selected"<?php endif; ?>>--None--</option>
								<option value="Mr." <?php if ($this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == "Mr."): ?>selected="selected"<?php endif; ?>>Mr.</option>
								<option value="Ms." <?php if ($this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == "Ms."): ?>selected="selected"<?php endif; ?>>Ms.</option>
								<option value="Mrs." <?php if ($this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == "Mrs."): ?>selected="selected"<?php endif; ?>>Mrs.</option>
								<option value="Dr." <?php if ($this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == "Dr."): ?>selected="selected"<?php endif; ?>>Dr.</option>
								<option value="Prof." <?php if ($this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == "Prof."): ?>selected="selected"<?php endif; ?>>Prof</option>
							</select>
					<?php else: ?>
						<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" value="<?php echo $this->_tpl_vars['defaultvalue'][0]; ?>
" style="display:inline;"></input>
					<?php endif; ?>
			<?php endif; ?>
		<?php else: ?>
			<?php if ($this->_tpl_vars['field']['mandatory'] == 1): ?>
				<?php if ($this->_tpl_vars['field']['type']['name'] == picklist | $this->_tpl_vars['field']['type']['name'] == multipicklist): ?><?php $this->assign('val_arr', $this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name'])); ?><?php $this->assign('values', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['val_arr']) : explode($_tmp, $this->_tpl_vars['val_arr']))); ?>
					<select fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" class="small" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
][]" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" style="display:inline;" class="small" <?php if ($this->_tpl_vars['field']['type']['name'] == multipicklist): ?>multiple="multiple" size="5"<?php endif; ?>>
							<option value="" <?php if ($this->_tpl_vars['field']['default'] == $this->_tpl_vars['option']['value']): ?> selected="selected"<?php endif; ?>><?php echo getTranslatedString('LBL_SELECT_VALUE', $this->_tpl_vars['MODULE']); ?>
</option>
						<?php $_from = $this->_tpl_vars['field']['type']['picklistValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['optionloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['optionloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['optionloop']['iteration']++;
?>
							<option value="<?php echo $this->_tpl_vars['option']['value']; ?>
" <?php if ($this->_tpl_vars['field']['default'] == $this->_tpl_vars['option']['value']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['option']['label']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
				<?php elseif ($this->_tpl_vars['field']['type']['name'] == date): ?>
				<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" value="<?php echo $this->_tpl_vars['field']['default']; ?>
" >
												<img src="<?php echo vtiger_imageurl('miniCalendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
" >
												<font size=1 id="mincal_<?php echo $this->_tpl_vars['field']['name']; ?>
"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATE_FORMAT']; ?>
)</em></font>
												<script id="date_<?php echo $this->_tpl_vars['CNT']; ?>
">
													getCalendarPopup('jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
','value[<?php echo $this->_tpl_vars['field']['name']; ?>
]','<?php echo $this->_tpl_vars['CAL_DATE_FORMAT']; ?>
')
												</script>
				<?php elseif ($this->_tpl_vars['field']['type']['name'] == text): ?>
						<textarea fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" rows="2" onblur="this.className='detailedViewTextBox'" onfocus="this.className='detailedViewTextBoxOn'" class="detailedViewTextBox"  id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  value="$field.default" style="display:inline;"><?php echo $this->_tpl_vars['field']['default']; ?>
</textarea>
				<?php elseif ($this->_tpl_vars['field']['type']['name'] == boolean): ?>
					<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="checkbox"  id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" style="display:inline;" <?php if ($this->_tpl_vars['field']['default']): ?>checked="checked"<?php endif; ?> >
				<?php else: ?>
						<?php if ($this->_tpl_vars['field']['name'] == salutationtype): ?>
							<select fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" class="small" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]">
								<option value="" <?php if ($this->_tpl_vars['field']['default'] == ""): ?>selected="selected"<?php endif; ?>>--None--</option>
								<option value="Mr." <?php if ($this->_tpl_vars['field']['default'] == "Mr."): ?>selected="selected"<?php endif; ?>>Mr.</option>
								<option value="Ms." <?php if ($this->_tpl_vars['field']['default'] == "Ms."): ?>selected="selected"<?php endif; ?>>Ms.</option>
								<option value="Mrs." <?php if ($this->_tpl_vars['field']['default'] == "Mrs."): ?>selected="selected"<?php endif; ?>>Mrs.</option>
								<option value="Dr." <?php if ($this->_tpl_vars['field']['default'] == "Dr."): ?>selected="selected"<?php endif; ?>>Dr.</option>
								<option value="Prof." <?php if ($this->_tpl_vars['field']['default'] == "Prof."): ?>selected="selected"<?php endif; ?>>Prof</option>
							</select>
						<?php else: ?>
							<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" value="<?php echo $this->_tpl_vars['field']['default']; ?>
" style="display:inline;"></input>
						<?php endif; ?>
				<?php endif; ?>
			<?php else: ?>
				<?php if ($this->_tpl_vars['field']['type']['name'] == picklist | $this->_tpl_vars['field']['type']['name'] == multipicklist): ?><?php $this->assign('val_arr', $this->_tpl_vars['WEBFORM']->retrieveDefaultValue($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name'])); ?><?php $this->assign('values', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['val_arr']) : explode($_tmp, $this->_tpl_vars['val_arr']))); ?>
					<select fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" class="small" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
][]" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" style="display:none;" class="small" <?php if ($this->_tpl_vars['field']['type']['name'] == multipicklist): ?>multiple="multiple" size="5"<?php endif; ?>>
							<option value="" <?php if ($this->_tpl_vars['field']['default'] == $this->_tpl_vars['option']['value']): ?> selected="selected"<?php endif; ?>><?php echo getTranslatedString('LBL_SELECT_VALUE', $this->_tpl_vars['MODULE']); ?>
</option>
						<?php $_from = $this->_tpl_vars['field']['type']['picklistValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['optionloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['optionloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['optionloop']['iteration']++;
?>
							<option value="<?php echo $this->_tpl_vars['option']['value']; ?>
" <?php if ($this->_tpl_vars['field']['default'] == $this->_tpl_vars['option']['value']): ?> selected="selected"<?php endif; ?> ><?php echo $this->_tpl_vars['option']['label']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
				<?php elseif ($this->_tpl_vars['field']['type']['name'] == date): ?>
				<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" value="<?php echo $this->_tpl_vars['field']['default']; ?>
" style="display:none;">
												<img src="<?php echo vtiger_imageurl('miniCalendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
" style="display:none;">
												<font size=1 id="mincal_<?php echo $this->_tpl_vars['field']['name']; ?>
" style="display:none;"><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATE_FORMAT']; ?>
)</em></font>
												<script id="date_<?php echo $this->_tpl_vars['CNT']; ?>
">
													getCalendarPopup('jscal_trigger_<?php echo $this->_tpl_vars['field']['name']; ?>
','value[<?php echo $this->_tpl_vars['field']['name']; ?>
]','<?php echo $this->_tpl_vars['CAL_DATE_FORMAT']; ?>
')
												</script>
				<?php elseif ($this->_tpl_vars['field']['type']['name'] == text): ?>
						<textarea fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" rows="2" onblur="this.className='detailedViewTextBox'" onfocus="this.className='detailedViewTextBoxOn'" class="detailedViewTextBox"  id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  value="<?php echo $this->_tpl_vars['field']['default']; ?>
" style="display:none;"><?php echo $this->_tpl_vars['field']['default']; ?>
</textarea>
				<?php elseif ($this->_tpl_vars['field']['type']['name'] == boolean): ?>
					<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="checkbox"  id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" style="display:none;" <?php if ($this->_tpl_vars['field']['default']): ?>checked="checked"<?php endif; ?>>
				<?php else: ?>
						<?php if ($this->_tpl_vars['field']['name'] == salutationtype): ?>
							<select fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" class="small" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" style="display:none;">
								<option value="" <?php if ($this->_tpl_vars['field']['default'] == ""): ?>selected="selected"<?php endif; ?>>--None--</option>
								<option value="Mr." <?php if ($this->_tpl_vars['field']['default'] == "Mr."): ?>selected="selected"<?php endif; ?>>Mr.</option>
								<option value="Ms." <?php if ($this->_tpl_vars['field']['default'] == "Ms."): ?>selected="selected"<?php endif; ?>>Ms.</option>
								<option value="Mrs." <?php if ($this->_tpl_vars['field']['default'] == "Mrs."): ?>selected="selected"<?php endif; ?>>Mrs.</option>
								<option value="Dr." <?php if ($this->_tpl_vars['field']['default'] == "Dr."): ?>selected="selected"<?php endif; ?>>Dr.</option>
								<option value="Prof." <?php if ($this->_tpl_vars['field']['default'] == "Prof."): ?>selected="selected"<?php endif; ?>>Prof</option>
							</select>
						<?php else: ?>
							<input fieldtype="<?php echo $this->_tpl_vars['field']['type']['name']; ?>
" fieldlabel="<?php echo $this->_tpl_vars['field']['label']; ?>
" type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]"  name="value[<?php echo $this->_tpl_vars['field']['name']; ?>
]" value="<?php echo $this->_tpl_vars['field']['default']; ?>
" style="display:none;"></input>
						<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		<?php endif; ?>
		</td>
		<td class="dvtCellInfo" align="center" colspan="1">
			<?php if ($this->_tpl_vars['field']['mandatory'] == 1): ?>
				<input  type="checkbox" checked="checked" disabled="disabled" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" style="display:inline;" >
				<input type="hidden" id="required[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="required[]" value="<?php echo $this->_tpl_vars['field']['name']; ?>
"></input>
			<?php else: ?>
				<?php if ($this->_tpl_vars['WEBFORMID']): ?>
					<?php if ($this->_tpl_vars['WEBFORM']->isWebformField($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == true && $this->_tpl_vars['WEBFORM']->isRequired($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name']) == true): ?>
						<input  type="checkbox" id="required[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="required[]" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" checked="checked" style="display:inline;" >
					<?php else: ?>
						<?php if ($this->_tpl_vars['WEBFORM']->isWebformField($this->_tpl_vars['WEBFORMID'],$this->_tpl_vars['field']['name'])): ?>
							<input  type="checkbox" id="required[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="required[]" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" style="display:inline;">
						<?php else: ?>
							<input type="checkbox" id="required[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="required[]" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" style="display:none;">
						<?php endif; ?>
					<?php endif; ?>
				<?php else: ?>
					<input type="checkbox" id="required[<?php echo $this->_tpl_vars['field']['name']; ?>
]" name="required[]" value="<?php echo $this->_tpl_vars['field']['name']; ?>
" style="display:none;">
				<?php endif; ?>
			<?php endif; ?>
		</td>
		<td class="dvtCellLabel" align="left" colspan="1">
			<?php if ($this->_tpl_vars['WEBFORM']->isCustomField($this->_tpl_vars['field']['name']) == true): ?>
				label:<?php echo $this->_tpl_vars['field']['label']; ?>

			<?php else: ?>
				<?php echo $this->_tpl_vars['field']['name']; ?>

			<?php endif; ?>
		</td>
	</tr>
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
<script type="test/javascript" id="counter">
	var count=<?php echo $this->_tpl_vars['CNT']; ?>
;
</script>
</table>