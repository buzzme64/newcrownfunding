<?php /* Smarty version 2.6.18, created on 2013-10-23 12:23:51
         compiled from CustomFieldMapping.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'CustomFieldMapping.tpl', 16, false),array('modifier', 'getTranslatedString', 'CustomFieldMapping.tpl', 25, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
	<tbody>
		<tr>
			<td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>
			<td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
				<br>
				<div align=center>
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'SetMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
					<!-- DISPLAY -->
					<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%" >
						<tr align="left">
							<td rowspan="2" valign="top" width="50"><img src="<?php echo vtiger_imageurl('custom.gif', $this->_tpl_vars['THEME']); ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_USERS']; ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_USERS']; ?>
" border="0" height="48" width="48"></td>
							<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=ModuleManager&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['VTLIB_LBL_MODULE_MANAGER']; ?>
</a>&gt;<a href="index.php?module=Settings&action=ModuleManager&module_settings=true&formodule=Leads&parenttab=Settings"><?php echo $this->_tpl_vars['MODULE']; ?>
</a> &gt; <?php echo getTranslatedString('LBL_FIELD_SETTINGS', $this->_tpl_vars['MODULE']); ?>
</b></td>
						</tr>
						<tr align="left">
							<td class="small" valign="top"><?php echo getTranslatedString('LBL_FIELD_MAPPING', $this->_tpl_vars['MODULE']); ?>
</td>
						</tr>
					</table>
					<br>
					<form action="index.php?module=Settings&action=SaveConvertLead" method="post" name="index" onsubmit="VtigerJS_DialogBox.block();">
						<table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<td class="big" align="left"><strong><?php echo $this->_tpl_vars['MOD']['LBL_EDIT_FIELD_MAPPING']; ?>
</strong> </td>
								<td class="small">&nbsp;</td>
								<td class="small" align="right">&nbsp;&nbsp;
									<input title="<?php echo getTranslatedString('LBL_SAVE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" name="save" value=" &nbsp;<?php echo getTranslatedString('LBL_SAVE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
&nbsp; " class="crmButton small save" type="submit" onclick ="return validateCustomFieldAccounts();">
									<input title="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" name="cancel" value=" <?php echo getTranslatedString('LBL_CANCEL_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
 " onclick = "window.history.back()"  class="crmButton small cancel" type="button">
									<input title="<?php echo getTranslatedString('LBL_ADD_MAPPING', $this->_tpl_vars['MODULE']); ?>
" type="button" value="<?php echo getTranslatedString('LBL_ADD_MAPPING', $this->_tpl_vars['MODULE']); ?>
" onclick="javascript:cloneAndAddLeadMapping('cloneableNode','mapTable')"  class="crmButton small create"></input>
							</tr>
						</table>
						<table class="listTable" id="mapTable" border="0" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<td rowspan="2" class="colHeader small" width="2%">#</td>
								<td rowspan="2" class="colHeader small" width="15%"><?php echo $this->_tpl_vars['MOD']['FieldLabel']; ?>
</td>
								<td colspan="3" class="colHeader small" valign="top"><div align="center"><?php echo $this->_tpl_vars['MOD']['LBL_MAPPING_OTHER_MODULES']; ?>
</div></td>
							</tr>
							<tr>
								<td class="colHeader small" valign="top" width="23%"><?php echo $this->_tpl_vars['APP']['Accounts']; ?>
</td>
								<td class="colHeader small" valign="top" width="23%"><?php echo $this->_tpl_vars['APP']['Contacts']; ?>
</td>
								<td class="colHeader small" valign="top" width="24%"><?php echo $this->_tpl_vars['APP']['Potentials']; ?>
</td>
							</tr>
								<?php $this->assign('CNT', 0); ?>
								<?php $_from = $this->_tpl_vars['CUSTOMFIELDMAPPING']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mapid'] => $this->_tpl_vars['map']):
?>
									<?php if ($this->_tpl_vars['map']['display'] == 'true' & $this->_tpl_vars['map']['editable'] == 1): ?>
									<?php $this->assign('CNT', $this->_tpl_vars['CNT']+1); ?>
							<tr>
								<td><?php echo $this->_tpl_vars['CNT']; ?>
</td>
								<td>
									<select class="small" name=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Leads] id=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Leads] module="Leads"<?php if ($this->_tpl_vars['map']['editable'] != 1): ?>disabled="disabled"<?php endif; ?> onChange='return validateMapping("<?php echo $this->_tpl_vars['CNT']; ?>
",this,"map[<?php echo $this->_tpl_vars['CNT']; ?>
][Leads]")'>
										<?php $_from = $this->_tpl_vars['map']['lead']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['lead_cf_index'] => $this->_tpl_vars['lead_cf']):
?>
											<option value="<?php echo $this->_tpl_vars['lead_cf']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['lead_cf']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['lead_cf']['fieldtype']; ?>
" <?php if ($this->_tpl_vars['lead_cf']['fieldid'] == $this->_tpl_vars['map']['fieldid']): ?>selected="selected"<?php endif; ?>><?php echo getTranslatedString($this->_tpl_vars['lead_cf']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</select>
								</td>
								<td>
									<select class="small" name=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Accounts] id=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Accounts] module="Accounts" <?php if ($this->_tpl_vars['map']['editable'] != 1): ?>disabled="disabled"<?php endif; ?> onChange='return validateMapping("<?php echo $this->_tpl_vars['CNT']; ?>
",this,"map[<?php echo $this->_tpl_vars['CNT']; ?>
][Accounts]")'>
											<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
										<?php $_from = $this->_tpl_vars['map']['account']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['acc_cf_index'] => $this->_tpl_vars['acc_cf']):
?>
											<option value="<?php echo $this->_tpl_vars['acc_cf']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['acc_cf']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['acc_cf']['fieldtype']; ?>
" <?php echo $this->_tpl_vars['acc_cf']['selected']; ?>
><?php echo getTranslatedString($this->_tpl_vars['acc_cf']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</select>
								</td>
								<td>
									<select class="small" name=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Contacts] id=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Contacts] module="Contacts" <?php if ($this->_tpl_vars['map']['editable'] != 1): ?>disabled="disabled"<?php endif; ?> onChange='return validateMapping("<?php echo $this->_tpl_vars['CNT']; ?>
",this,"map[<?php echo $this->_tpl_vars['CNT']; ?>
][Contacts]")'>
										<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
										<?php $_from = $this->_tpl_vars['map']['contact']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['con_cf_index'] => $this->_tpl_vars['con_cf']):
?>
											<option value="<?php echo $this->_tpl_vars['con_cf']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['con_cf']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['con_cf']['fieldtype']; ?>
" <?php echo $this->_tpl_vars['con_cf']['selected']; ?>
><?php echo getTranslatedString($this->_tpl_vars['con_cf']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</select>
								</td>
								<td>
									<select class="small" name=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Potentials] id=map[<?php echo $this->_tpl_vars['CNT']; ?>
][Potentials] module="Potentials" <?php if ($this->_tpl_vars['map']['editable'] != 1): ?>disabled="disabled"<?php endif; ?> onChange='return validateMapping("<?php echo $this->_tpl_vars['CNT']; ?>
",this,"map[<?php echo $this->_tpl_vars['CNT']; ?>
][Potentials]")'>
										<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
										<?php $_from = $this->_tpl_vars['map']['potential']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['pot_cf_index'] => $this->_tpl_vars['pot_cf']):
?>
											<option value="<?php echo $this->_tpl_vars['pot_cf']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['pot_cf']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['pot_cf']['fieldtype']; ?>
" <?php echo $this->_tpl_vars['pot_cf']['selected']; ?>
><?php echo getTranslatedString($this->_tpl_vars['pot_cf']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</select>
								</td>
							</tr>
							<?php endif; ?>
							<?php endforeach; endif; unset($_from); ?>
							<tr style="visibility:hidden;" id="cloneableNode" >
								<td><div id="snoDiv">incId</div></td>
								<td>
									<div id="leadCloneDiv">
										<select id="leadClone" name="leadClone" id="leadClone" class="small" module="Leads" onChange='return validateMapping("incId",this,"leadClone")'>
											<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
											<?php $_from = $this->_tpl_vars['CUSTOMFIELDMAPPING'][0]['lead']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_index'] => $this->_tpl_vars['field']):
?>
													<option value="<?php echo $this->_tpl_vars['field']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['field']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['field']['fieldtype']; ?>
"><?php echo getTranslatedString($this->_tpl_vars['field']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									</div>
								</td>
								<td >
									<div id="accountCloneDiv">
										<select id="accountClone" name="accountClone" id="accountClone" class="small" module="Accounts" onChange='return validateMapping("incId",this,"accountClone")'>
												<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
											<?php $_from = $this->_tpl_vars['CUSTOMFIELDMAPPING'][0]['account']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_index'] => $this->_tpl_vars['field']):
?>
													<option value="<?php echo $this->_tpl_vars['field']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['field']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['field']['fieldtype']; ?>
"><?php echo getTranslatedString($this->_tpl_vars['field']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									</div>
								</td>
								<td>
									<div id="contactCloneDiv">
										<select id="contactClone" name="contactClone" id="contactClone" class="small" module="Contacts" onChange='return validateMapping("incId",this,"contactClone")'>
												<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
											<?php $_from = $this->_tpl_vars['CUSTOMFIELDMAPPING'][0]['contact']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_index'] => $this->_tpl_vars['field']):
?>
													<option value="<?php echo $this->_tpl_vars['field']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['field']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['field']['fieldtype']; ?>
"><?php echo getTranslatedString($this->_tpl_vars['field']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									</div>
								</td>
								<td>
									<div id="potentialCloneDiv">
										<select id="potentialClone" name="potentialClone" id="potentialClone" class="small" module="Potentials" onChange='return validateMapping("incId",this,"potentialClone")'>
												<option value=''><?php echo getTranslatedString('LBL_NONE', $this->_tpl_vars['MODULE']); ?>
</option>
											<?php $_from = $this->_tpl_vars['CUSTOMFIELDMAPPING'][0]['potential']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field_index'] => $this->_tpl_vars['field']):
?>
													<option value="<?php echo $this->_tpl_vars['field']['fieldid']; ?>
" typeofdata="<?php echo $this->_tpl_vars['field']['typeofdata']; ?>
" fieldtype="<?php echo $this->_tpl_vars['field']['fieldtype']; ?>
"><?php echo getTranslatedString($this->_tpl_vars['field']['fieldlabel'], $this->_tpl_vars['MODULE']); ?>
</option>
											<?php endforeach; endif; unset($_from); ?>
										</select>
									</div>
								</td>
							</tr>
						</table>
						<table class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<td class="small" align="right">&nbsp;&nbsp;
									<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" name="save" value=" &nbsp;<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
&nbsp; " class="crmButton small save" type="submit" onclick ="return validateCustomFieldAccounts();">
									<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" name="cancel" value=" <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
 " onclick = "window.history.back()"  class="crmButton small cancel" type="button">
									<input title="<?php echo getTranslatedString('LBL_ADD_MAPPING', $this->_tpl_vars['MODULE']); ?>
" type="button" value="<?php echo getTranslatedString('LBL_ADD_MAPPING', $this->_tpl_vars['MODULE']); ?>
" onclick="javascript:cloneAndAddLeadMapping('cloneableNode','mapTable')"  class="crmButton small create"></input>
								</td>
							</tr>
						</table>
						<table border="0" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<td class="small">
									<strong><?php echo $this->_tpl_vars['APP']['LBL_NOTE']; ?>
: </strong> <?php echo $this->_tpl_vars['MOD']['LBL_CUSTOM_MAPP_INFO']; ?>

								</td>
							</tr>
						</table>
						<table border="0" cellpadding="5" cellspacing="0" width="100%">
							<tr>
								<td class="small" align="right" nowrap="nowrap"><a href="#top"><?php echo $this->_tpl_vars['MOD']['LBL_SCROLL']; ?>
</a></td>
							</tr>
						</table>
					</form>
				</div>
			</td>
			<td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
		</tr>
	</tbody>
</table>

<script language="JavaScript" type="text/javascript">
	incId=<?php echo $this->_tpl_vars['CNT']+1; ?>
;
</script>
<script>
	var alertmessage = new Array("<?php echo $this->_tpl_vars['MOD']['LBL_TYPEALERT_1']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_WITH']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_TYPEALERT_2']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_LENGTHALERT']; ?>
","<?php echo $this->_tpl_vars['MOD']['LBL_DECIMALALERT']; ?>
");
</script>