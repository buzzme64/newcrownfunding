<?php /* Smarty version 2.6.18, created on 2013-11-18 14:03:31
         compiled from modules/Leads/ConvertLead.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'modules/Leads/ConvertLead.tpl', 27, false),array('modifier', 'getTranslatedString', 'modules/Leads/ConvertLead.tpl', 27, false),array('modifier', 'count', 'modules/Leads/ConvertLead.tpl', 181, false),)), $this); ?>

<?php $this->assign('row', $this->_tpl_vars['UIINFO']->getLeadInfo()); ?>

<form name="ConvertLead" method="POST" action="index.php" onsubmit="VtigerJS_DialogBox.block();">
	<input type="hidden" name="module" value="Leads">
	<input type="hidden" name="transferToName" value="<?php echo $this->_tpl_vars['row']['company']; ?>
">
	<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['UIINFO']->getLeadId(); ?>
">
	<input type="hidden" name="action">
	<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
	<input type="hidden" name="current_user_id" value="<?php echo $this->_tpl_vars['UIINFO']->getUserId(); ?>
'">

	<div id="orgLay" style="display: block;" class="layerPopup" >

		<table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
			<tr>
				<td class="genHeaderSmall" align="left"><img src="<?php echo vtiger_imageurl('Leads.gif', $this->_tpl_vars['THEME']); ?>
"><?php echo getTranslatedString('ConvertLead', $this->_tpl_vars['MODULE']); ?>
 : <?php echo $this->_tpl_vars['row']['firstname']; ?>
 <?php echo $this->_tpl_vars['row']['lastname']; ?>
</td>
				<td align="right"><a href="javascript:fninvsh('orgLay');"><img src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" align="absmiddle" border="0"></a></td>
			</tr>
		</table>
		<table border=0 cellspacing=0 cellpadding=5 width=95% align=center>
			<?php if ($this->_tpl_vars['UIINFO']->isModuleActive('Accounts') && $this->_tpl_vars['row']['company'] != ''): ?>
			<tr>
				<td class="small" >
					<table border="0" cellspacing="0" cellpadding="0" width="95%" align="center" bgcolor="white">
						<tr>
							<td colspan="4" class="detailedViewHeader">
								<input type="checkbox" onclick="javascript:showHideStatus('account_block',null,null);" id="select_account" name="entities[]" value="Accounts" <?php if ($this->_tpl_vars['row']['company'] != ''): ?> checked <?php endif; ?> />
								<b><?php echo getTranslatedString('SINGLE_Accounts', $this->_tpl_vars['MODULE']); ?>
</b>
							</td>
						</tr>
						<tr>
							<td>
								<div id="account_block" <?php if ($this->_tpl_vars['row']['company'] != ''): ?> style="display:block;" <?php else: ?> style="display:none;" <?php endif; ?>>
									<table border="0" cellspacing="0" cellpadding="5" width="100%" align="center" bgcolor="white">
										<tr>
											<td align="right" width="50%" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Accounts','accountname') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('LBL_ACCOUNT_NAME', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo"><input type="text" name="accountname" class="detailedViewTextBox" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Accounts','accountname',0); ?>
" readonly="readonly" module="Accounts" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Accounts','accountname') == true): ?>record="true"<?php endif; ?>></td>
										</tr>
										<?php if ($this->_tpl_vars['UIINFO']->isActive('industry','Accounts')): ?>
										<tr>
											<td align="right" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Accounts','industry') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('industry', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo">
													<?php $this->assign('industry_map_value', $this->_tpl_vars['UIINFO']->getMappedFieldValue('Accounts','industry',1)); ?>
													<select name="industry" class="small" module="Accounts" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Accounts','industry') == true): ?>record="true"<?php endif; ?>>
														<?php $_from = $this->_tpl_vars['UIINFO']->getIndustryList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['industryloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['industryloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['industry']):
        $this->_foreach['industryloop']['iteration']++;
?>
															<option value="<?php echo $this->_tpl_vars['industry']['value']; ?>
" <?php if ($this->_tpl_vars['industry']['value'] == $this->_tpl_vars['UIINFO']->getMappedFieldValue('Accounts','industry',1)): ?>selected="selected"<?php endif; ?>><?php echo getTranslatedString($this->_tpl_vars['industry']['value'], $this->_tpl_vars['MODULE']); ?>
</option>
														<?php endforeach; endif; unset($_from); ?>
													</select>
											</td>
										</tr>
										<?php endif; ?>
									</table>
								</div>
							<td>
						</tr>
					</table>
				</td>
			</tr>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['UIINFO']->isModuleActive('Potentials')): ?>
			<tr>
				<td class="small">
					<table border="0" cellspacing="0" cellpadding="0" width="95%" align="center" bgcolor="white">
						<tr>
							<td colspan="4" class="detailedViewHeader">
								<input type="checkbox" onclick="javascript:showHideStatus('potential_block',null,null);"id="select_potential" name="entities[]" value="Potentials"></input>
								<b><?php echo getTranslatedString('SINGLE_Potentials', $this->_tpl_vars['MODULE']); ?>
</b>
							</td>
						</tr>
						<tr>
							<td>
								<div id="potential_block" style="display:none;">
									<table border="0" cellspacing="0" cellpadding="5" width="100%" align="center" bgcolor="white">
										<?php if ($this->_tpl_vars['UIINFO']->isActive('potentialname','Potentials')): ?>
										<tr>
											<td align="right" width="50%" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','potentialname') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('LBL_POTENTIAL_NAME', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo"><input  name="potentialname" id="potentialname" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','potentialname') == true): ?>record="true"<?php endif; ?> module="Potentials" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Potentials','potentialname',0); ?>
" class="detailedViewTextBox" /></td>
										</tr>
										<?php endif; ?>
										<?php if ($this->_tpl_vars['UIINFO']->isActive('closingdate','Potentials')): ?>
										<tr>
											<td align="right" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','closingdate') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('Expected Close Date', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo">
												<input name="closingdate" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','closingdate') == true): ?>record="true"<?php endif; ?> module="Potentials" style="border: 1px solid rgb(186, 186, 186);" id="jscal_field_closedate" type="text" tabindex="4" size="10" maxlength="10" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Potentials','closingdate',1); ?>
">
												<img src="<?php echo vtiger_imageurl('miniCalendar.gif', $this->_tpl_vars['THEME']); ?>
" id="jscal_trigger_closedate" >
												<font size=1><em old="(yyyy-mm-dd)">(<?php echo $this->_tpl_vars['DATE_FORMAT']; ?>
)</em></font>
												<script id="conv_leadcal">
													getCalendarPopup('jscal_trigger_closedate','jscal_field_closedate','<?php echo $this->_tpl_vars['CAL_DATE_FORMAT']; ?>
')
												</script>
											</td>
										</tr>
										<?php endif; ?>
										<?php if ($this->_tpl_vars['UIINFO']->isActive('sales_stage','Potentials')): ?>
										<tr>
											<td align="right" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','sales_stage') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('LBL_SALES_STAGE', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo">
												<?php $this->assign('sales_stage_map_value', $this->_tpl_vars['UIINFO']->getMappedFieldValue('Potentials','sales_stage',1)); ?>
												<select name="sales_stage" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','sales_stage') == true): ?>record="true"<?php endif; ?> module="Potentials" class="small">
													<?php $_from = $this->_tpl_vars['UIINFO']->getSalesStageList(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['salesStageLoop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['salesStageLoop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['salesStage']):
        $this->_foreach['salesStageLoop']['iteration']++;
?>
														<option value="<?php echo $this->_tpl_vars['salesStage']['value']; ?>
" <?php if ($this->_tpl_vars['salesStage']['value'] == $this->_tpl_vars['sales_stage_map_value']): ?>selected="selected"<?php endif; ?> ><?php echo getTranslatedString($this->_tpl_vars['salesStage']['value'], $this->_tpl_vars['MODULE']); ?>
</option>
													<?php endforeach; endif; unset($_from); ?>
												</select>
											</td>
										</tr>
										<?php endif; ?>
										<?php if ($this->_tpl_vars['UIINFO']->isActive('amount','Potentials')): ?>
										<tr>
											<td align="right" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','amount') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('Amount', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo"><input type="text" name="amount" class="detailedViewTextBox" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Potentials','amount') == true): ?>record="true"<?php endif; ?> module="Potentials" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Potentials','amount',1); ?>
"></input></td>
										</tr>
										<?php endif; ?>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['UIINFO']->isModuleActive('Contacts')): ?>
			<tr>
				<td class="small">
					<table border="0" cellspacing="0" cellpadding="0" width="95%" align="center" bgcolor="white">
						<tr>
							<td colspan="4" class="detailedViewHeader">
								<input type="checkbox" checked="checked" onclick="javascript:showHideStatus('contact_block',null,null);" id="select_contact" name="entities[]" value="Contacts"></input>
								<b><?php echo getTranslatedString('SINGLE_Contacts', $this->_tpl_vars['MODULE']); ?>
</b>
							</td>
						</tr>
						<tr>
							<td>
								<div id="contact_block" style="display:block;" >
									<table border="0" cellspacing="0" cellpadding="5" width="100%" align="center" bgcolor="white">
										<tr>
											<td align="right" width="50%" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Contacts','lastname') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('Last Name', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo"><input type="text" name="lastname" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Contacts','lastname') == true): ?>record="true"<?php endif; ?> module="Contacts" class="detailedViewTextBox" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Contacts','lastname',0); ?>
"></td>
										</tr>
										<?php if ($this->_tpl_vars['UIINFO']->isActive('firstname','Contacts')): ?>
										<tr>
											<td align="right" width="50%" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Contacts','firstname') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('First Name', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo"><input type="text" name="firstname" class="detailedViewTextBox" module="Contacts" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Contacts','firstname',0); ?>
" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Contacts','firstname') == true): ?>record="true"<?php endif; ?> ></td>
										</tr>
										<?php endif; ?>
										<?php if ($this->_tpl_vars['UIINFO']->isActive('email','Contacts')): ?>
										<tr>
											<td align="right" width="50%" class="dvtCellLabel"><?php if ($this->_tpl_vars['UIINFO']->isMandatory('Contacts','email') == true): ?><font color="red">*</font><?php endif; ?><?php echo getTranslatedString('SINGLE_Emails', $this->_tpl_vars['MODULE']); ?>
</td>
											<td class="dvtCellInfo"><input type="text" name="email" class="detailedViewTextBox" value="<?php echo $this->_tpl_vars['UIINFO']->getMappedFieldValue('Contacts','email',0); ?>
" <?php if ($this->_tpl_vars['UIINFO']->isMandatory('Contacts','email') == true): ?>record="true"<?php endif; ?> module="Contacts"></td>
										</tr>
										<?php endif; ?>
									</table>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					&nbsp;
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td class="small">
					<table border="0" cellspacing="0" cellpadding="5" width="95%" align="center" bgcolor="white">
						<tr>
							<td align="right" class="dvtCellLabel" width="50%" style="border-top:1px solid #DEDEDE;"><?php echo getTranslatedString('LBL_LIST_ASSIGNED_USER', $this->_tpl_vars['MODULE']); ?>
</td>
							<td class="dvtCellInfo" width="50%" style="border-top:1px solid #DEDEDE;">
								<input type="radio" name="c_assigntype" value="U" onclick="javascript: c_toggleAssignType(this.value)" <?php echo $this->_tpl_vars['UIINFO']->getUserSelected(); ?>
 />&nbsp;<?php echo getTranslatedString('LBL_USER', $this->_tpl_vars['MODULE']); ?>

								<?php if (count($this->_tpl_vars['UIINFO']->getOwnerList('group')) != 0): ?>
								<input type="radio" name="c_assigntype" value="T" onclick="javascript: c_toggleAssignType(this.value)" <?php echo $this->_tpl_vars['UIINFO']->getGroupSelected(); ?>
 />&nbsp;<?php echo getTranslatedString('LBL_GROUP', $this->_tpl_vars['MODULE']); ?>

								<?php endif; ?>
								<span id="c_assign_user" style="display:<?php echo $this->_tpl_vars['UIINFO']->getUserDisplay(); ?>
">
									<select name="c_assigned_user_id" class="detailedViewTextBox">
										<?php $_from = $this->_tpl_vars['UIINFO']->getOwnerList('user'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['userloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['userloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['user']):
        $this->_foreach['userloop']['iteration']++;
?>
											<option value="<?php echo $this->_tpl_vars['user']['userid']; ?>
" <?php if ($this->_tpl_vars['user']['selected'] == true): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['user']['username']; ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</select>
								</span>
								<span id="c_assign_team" style="display:<?php echo $this->_tpl_vars['UIINFO']->getGroupDisplay(); ?>
">
									<?php if (count($this->_tpl_vars['UIINFO']->getOwnerList('group')) != 0): ?>
									<select name="c_assigned_group_id" class="detailedViewTextBox">
										<?php $_from = $this->_tpl_vars['UIINFO']->getOwnerList('group'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['grouploop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['grouploop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['group']):
        $this->_foreach['grouploop']['iteration']++;
?>
											<option value="<?php echo $this->_tpl_vars['group']['groupid']; ?>
" <?php if ($this->_tpl_vars['group']['selected'] == true): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['group']['groupname']; ?>
</option>
										<?php endforeach; endif; unset($_from); ?>
									</select>
									<?php endif; ?>
								</span>
							</td>
						</tr>
						<tr>
							<td align="right" class="dvtCellLabel" width="50%"><?php echo getTranslatedString('LBL_TRANSFER_RELATED_RECORDS_TO', $this->_tpl_vars['MODULE']); ?>
</td>
							<td class="dvtCellInfo" width="50%">
								<?php if ($this->_tpl_vars['UIINFO']->isModuleActive('Accounts') == true && $this->_tpl_vars['row']['company'] != ''): ?><input type="radio" name="transferto" id="transfertoacc" value="Accounts" onclick="selectTransferTo('Accounts')"  <?php if ($this->_tpl_vars['UIINFO']->isModuleActive('Contacts') != true): ?>checked="checked"<?php endif; ?> /><?php echo getTranslatedString('SINGLE_Accounts', $this->_tpl_vars['MODULE']); ?>
<?php endif; ?>
								<?php if ($this->_tpl_vars['UIINFO']->isModuleActive('Contacts') == true): ?><input type="radio" name="transferto" id="transfertocon" value="Contacts" checked="checked" onclick="selectTransferTo('Contacts')"  /> <?php echo getTranslatedString('SINGLE_Contacts', $this->_tpl_vars['MODULE']); ?>
<?php endif; ?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>
			<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
			<tr>
					<td align="center">
						<input name="Save" value="<?php echo getTranslatedString('LBL_SAVE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" onclick="javascript:this.form.action.value='LeadConvertToEntities'; return verifyConvertLeadData(ConvertLead)" type="submit"  class="crmbutton save small">&nbsp;&nbsp;
						<input type="button" name=" Cancel " value="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" onClick="hide('orgLay')" class="crmbutton cancel small">
					</td>
				</tr>
			</table>
	</div>
</form>

