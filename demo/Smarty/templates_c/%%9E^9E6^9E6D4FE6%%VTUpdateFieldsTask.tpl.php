<?php /* Smarty version 2.6.18, created on 2013-10-22 06:45:51
         compiled from com_vtiger_workflow/taskforms/VTUpdateFieldsTask.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'com_vtiger_workflow/taskforms/VTUpdateFieldsTask.tpl', 17, false),array('modifier', 'vtiger_imageurl', 'com_vtiger_workflow/taskforms/VTUpdateFieldsTask.tpl', 32, false),)), $this); ?>

<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/vtigerwebservices.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/parallelexecuter.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    var moduleName = '<?php echo $this->_tpl_vars['entityName']; ?>
';
    <?php if ($this->_tpl_vars['task']->field_value_mapping): ?>
        var fieldvaluemapping = JSON.parse('<?php echo ((is_array($_tmp=$this->_tpl_vars['task']->field_value_mapping)) ? $this->_run_mod_handler('escape', true, $_tmp, 'quotes') : smarty_modifier_escape($_tmp, 'quotes')); ?>
');
    <?php else: ?>
        var fieldvaluemapping = null;
    <?php endif; ?>
</script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/fieldexpressionpopup.js" type="text/javascript" charset="utf-8"></script>
<script src="modules/<?php echo $this->_tpl_vars['module']->name; ?>
/resources/updatefieldstaskscript.js" type="text/javascript" charset="utf-8"></script>

<table class="tableHeading" width="100%" border="0" cellspacing="0" cellpadding="5">
    <tr>
        <td class="big" nowrap="nowrap">
            <strong><?php echo $this->_tpl_vars['MOD']['LBL_SET_FIELD_VALUES']; ?>
</strong>
        </td>
        <td class="small" align="right">
            <span id="workflow_loading" style="display:none">
                <b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0">
            </span>
            <span id="save_fieldvaluemapping_add-busyicon"><b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
            <input type="button" class="crmButton create small"
                   value="<?php echo $this->_tpl_vars['MOD']['LBL_ADD_FIELD']; ?>
" id="save_fieldvaluemapping_add" style='display: none;'/>
        </td>
    </tr>
</table>
<br>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "com_vtiger_workflow/FieldExpressions.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br>
<input type="hidden" name="field_value_mapping" value="" id="save_fieldvaluemapping_json"/>
<div id="dump" style="display:None;"></div>
<div id="save_fieldvaluemapping"></div>