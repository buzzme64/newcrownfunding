<?php /* Smarty version 2.6.18, created on 2013-10-23 12:23:35
         compiled from modules/Leads/LeadsCustomEntries.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'modules/Leads/LeadsCustomEntries.tpl', 62, false),array('modifier', 'getTranslatedString', 'modules/Leads/LeadsCustomEntries.tpl', 62, false),)), $this); ?>
				<form action="index.php" method="post" name="form" onsubmit="VtigerJS_DialogBox.block();">
				<input type="hidden" name="fld_module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="parenttab" value="Settings">
				<input type="hidden" name="mode">
				<table  class="listTableTopButtons" border="0" cellpadding="5" cellspacing="0" width="100%">
					<tr>
						<td class="big" align="left"><strong><?php echo $this->_tpl_vars['MOD']['LBL_MAPPED_FIELDS']; ?>
</strong> </td>
						<td align="right"><input type="button" class="crmButton create small" onclick="javascript: submitForm('form','index.php?module=Settings&action=LeadCustomFieldMapping');" alt="Edit" title="Edit" value="Edit"/>
						</td>
					<?php if ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
						<input type="radio" name="activitytype" value="E" checked>&nbsp;<?php echo $this->_tpl_vars['APP']['Event']; ?>

						<input type="radio" name="activitytype" value="T">&nbsp;<?php echo $this->_tpl_vars['APP']['Task']; ?>

					<?php endif; ?>
					</tr>
				</table>
				</form>
				<table class="listTable" border="0" cellpadding="5" cellspacing="0" width="100%">
					<?php if ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
					<tr>
						<td rowspan="2" class="colHeader small" width="5%">#</td>
						<td rowspan="2" class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['FieldLabel']; ?>
</td>
					    <td rowspan="2" class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['FieldType']; ?>
</td>
						<td colspan="4" class="colHeader small" valign="top"><div align="center"><?php echo $this->_tpl_vars['MOD']['LBL_MAPPING_OTHER_MODULES']; ?>
</div></td>
					</tr>

					<tr>
					  <td class="colHeader small" valign="top" width="18%"><?php echo $this->_tpl_vars['APP']['Accounts']; ?>
</td>
					  <td class="colHeader small" valign="top" width="18%"><?php echo $this->_tpl_vars['APP']['Contacts']; ?>
</td>
					  <td class="colHeader small" valign="top" width="19%"><?php echo $this->_tpl_vars['APP']['Potentials']; ?>
</td>
					  <td class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['LBL_CURRENCY_TOOL']; ?>
</td>

					</tr>
					<?php else: ?>
					<tr>
                      	<td class="colHeader small" width="5%">#</td>
                      	<td class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['FieldLabel']; ?>
</td>
                      	<td class="colHeader small" width="20%"><?php echo $this->_tpl_vars['MOD']['FieldType']; ?>
</td>
                    	<?php if ($this->_tpl_vars['MODULE'] == 'Calendar'): ?>
                      		<td class="colHeader small" width="20%"><?php echo $this->_tpl_vars['APP']['LBL_ACTIVITY_TYPE']; ?>
</td>
                      	<?php endif; ?>
						</tr>
					<?php endif; ?>
					<?php $_from = $this->_tpl_vars['CFENTRIES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['entries']):
?>
					<tr>
						<?php $_from = $this->_tpl_vars['entries']['map']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>
							<td class="listTableRow small" valign="top" nowrap><?php echo $this->_tpl_vars['value']; ?>
&nbsp;</td>
						<?php endforeach; endif; unset($_from); ?>
							<td class="listTableRow small" valign="top" nowrap>
									<?php if ($this->_tpl_vars['entries']['editable'] == 1): ?>
									<form name="form<?php echo $this->_tpl_vars['entries']['cfmid']; ?>
" method="post">
										<img border="0"  style="cursor: pointer;" src="<?php echo vtiger_imageurl('delete.gif', $this->_tpl_vars['THEME']); ?>
"  alt="<?php echo getTranslatedString('LBL_DELETE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" title="<?php echo getTranslatedString('LBL_DELETE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" onclick="javascript: deleteForm('form<?php echo $this->_tpl_vars['entries']['cfmid']; ?>
','index.php?action=DeleteConvertLeadMapping&module=Settings&parenttab=Settings&cfmid=<?php echo $this->_tpl_vars['entries']['cfmid']; ?>
' );">
									</form>
									<?php endif; ?>
							</td>
					</tr>
					<?php endforeach; endif; unset($_from); ?>
		</table>
		</form>
		<br>
		<?php if ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
			<strong><?php echo $this->_tpl_vars['APP']['LBL_NOTE']; ?>
: </strong> <?php echo $this->_tpl_vars['MOD']['LBL_CUSTOM_MAPP_INFO']; ?>

		<?php endif; ?>