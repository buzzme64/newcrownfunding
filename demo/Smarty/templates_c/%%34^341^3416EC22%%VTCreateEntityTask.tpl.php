<?php /* Smarty version 2.6.18, created on 2013-09-19 05:28:24
         compiled from com_vtiger_workflow/taskforms/VTCreateEntityTask.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'com_vtiger_workflow/taskforms/VTCreateEntityTask.tpl', 15, false),array('modifier', 'escape', 'com_vtiger_workflow/taskforms/VTCreateEntityTask.tpl', 17, false),array('modifier', 'vtiger_imageurl', 'com_vtiger_workflow/taskforms/VTCreateEntityTask.tpl', 32, false),array('modifier', 'vtiger_imageUrl', 'com_vtiger_workflow/taskforms/VTCreateEntityTask.tpl', 60, false),)), $this); ?>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/vtigerwebservices.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/parallelexecuter.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    var moduleName = '<?php echo $this->_tpl_vars['entityName']; ?>
';
	var moduleLabel = '<?php echo getTranslatedString($this->_tpl_vars['entityName'], $this->_tpl_vars['entityName']); ?>
';
    <?php if ($this->_tpl_vars['task']->field_value_mapping): ?>
        var fieldvaluemapping = JSON.parse('<?php echo ((is_array($_tmp=$this->_tpl_vars['task']->field_value_mapping)) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
');
    <?php else: ?>
        var fieldvaluemapping = null;
    <?php endif; ?>
	var selectedEntityType = '<?php echo $this->_tpl_vars['task']->entity_type; ?>
';
	var createEntityHeaderTemplate = '<input type="button" class="crmButton create small" value="'+"<?php echo getTranslatedString('LBL_ADD_FIELD', $this->_tpl_vars['MODULE']); ?>
"+ '" id="save_fieldvaluemapping_add" />';
</script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/fieldexpressionpopup.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/createentitytaskscript.js" type="text/javascript" charset="utf-8"></script>

<table border="0" cellpadding="5" cellspacing="0" width="100%" class="small">
	<tr valign="top">
		<td class='dvtCellLabel' align="right" width=15% nowrap="nowrap"><?php echo getTranslatedString('LBL_ENTITY_TYPE', $this->_tpl_vars['MODULE']); ?>
</td>
		<td class='dvtCellInfo'>
			<input type="hidden" value='<?php echo $this->_tpl_vars['task']->reference_field; ?>
' name='reference_field' id='reference_field' />
			<span id="entity_type-busyicon"><b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
			<select name="entity_type" id="entity_type" class="small" style="display:none;">
				<option value=''><?php echo getTranslatedString('LBL_SELECT_ENTITY_TYPE', $this->_tpl_vars['MODULE']); ?>
</option>
			</select>
		</td>
	</tr>
	<tr><td colspan="2"><hr size="1" noshade="noshade" /></td></tr>

    <tr>
        <td class="small" align="right" colspan="2">
            <span id="workflow_loading" style="display:none">
                <b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0">
            </span>
            <span id="save_fieldvaluemapping_add-busyicon" style="display:none"><b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
            <span id="save_fieldvaluemapping_add_wrapper"></span>
        </td>
    </tr>

	<tr>
		<td class="small" align="center" colspan="2">
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "com_vtiger_workflow/FieldExpressions.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<input type="hidden" name="field_value_mapping" value="" id="save_fieldvaluemapping_json"/>
			<div id="dump" style="display:none;"></div>
			<div id="save_fieldvaluemapping">
				<div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 45%; position: relative; z-index: 10000000;">
					<table width="98%" cellspacing="0" cellpadding="5" border="0">
						<tbody>
							<tr>
								<td width="25%"><img width="61" height="60" src="<?php echo vtiger_imageUrl('empty.jpg', $this->_tpl_vars['THEME']); ?>
"></td>
								<td width="75%" nowrap="nowrap" style="border-bottom: 1px solid rgb(204, 204, 204);">
									<span class="genHeaderSmall"><?php echo getTranslatedString('LBL_NO_ENTITIES_FOUND', $this->_tpl_vars['MODULE']); ?>
</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</td>
	</tr>

	<tr>
		<td style='padding-top: 10px;' colspan="2">
			<span class="helpmessagebox"><?php echo getTranslatedString('LBL_CREATE_ENTITY_NOTE_ORDER_MATTERS', $this->_tpl_vars['MODULE']); ?>
</span>
		</td>
	</tr>
</table>
<br>