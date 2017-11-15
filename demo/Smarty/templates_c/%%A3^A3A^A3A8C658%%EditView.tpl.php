<?php /* Smarty version 2.6.18, created on 2013-09-16 14:19:19
         compiled from modules/Webforms/EditView.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/Webforms/EditView.tpl', 38, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'modules/Webforms/Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/language/<?php echo $this->_tpl_vars['LANGUAGE']; ?>
.lang.js"></script>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['MODULE']; ?>
.js"></script>
<script type="text/javascript">
	<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>
		var mode="edit";
	<?php else: ?>
		var mode="save";
	<?php endif; ?>
</script>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
	<tr>
		<td class="showPanelBg" valign="top" width="100%">
			<div class="small" style="padding:20px">
				<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>
					<span class="lvtHeaderText">Edit : <?php echo $this->_tpl_vars['WEBFORM']->getName(); ?>
</span> <br>
				<?php else: ?>
					<span class="lvtHeaderText">Creating New <?php echo $this->_tpl_vars['MODULE']; ?>
</span> <br>
				<?php endif; ?>
				<hr noshade="noshade" size="1">
				<br>
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="95%">
				<tr>
					<td>
						<table class="small" border="0" cellpadding="3" cellspacing="0" width="100%">
							<tr>
								<td class="dvtTabCache" style="width:10px" nowrap="nowrap">&nbsp;</td>
								<td class="dvtSelectedCell" nowrap="nowrap" align="center"><?php echo getTranslatedString('LBL_MODULE_INFORMATION', $this->_tpl_vars['MODULE']); ?>
</td>
								<td class="dvtTabCache" style="width:65%">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">

					<!-- Basic Information Tab Opened -->
					<div id="basicTab">
					<table class="dvtContentSpace" border="0" cellpadding="3" cellspacing="0" width="100%">
						<tr>
							<td align="left">
							<!-- content cache -->
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr>
										<td id="autocom"></td>
									</tr>
									<tr>
										<td style="padding:10px">
										<!-- General details -->
										<form name="webform_edit" id="webform_edit" action="index.php?module=Webforms&action=Save" method="post">
											<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>
											<input type="hidden" name="id" value=<?php echo $this->_tpl_vars['WEBFORM']->getId(); ?>
></input>
											<?php endif; ?>
											<table   class="small" border="0" cellpadding="0" cellspacing="0" width="100%">
												<tr>
													<td colspan="4" style="padding:5px">
														<div align="center" >
														<input title="<?php echo getTranslatedString('LBL_SAVE_BUTTON_TITLE', $this->_tpl_vars['MODULE']); ?>
" accesskey="<?php echo getTranslatedString('LBL_SAVE_BUTTON_KEY', $this->_tpl_vars['MODULE']); ?>
" class="crmbutton small save" onclick="javascript:return Webforms.validateForm('webform_edit','index.php?module=Webforms&action=Save')" name="button" value="<?php echo getTranslatedString('LBL_SAVE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
 " style="width:70px" type="submit">
														<input title="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_TITLE', $this->_tpl_vars['MODULE']); ?>
" accesskey="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_KEY', $this->_tpl_vars['MODULE']); ?>
" class="crmbutton small cancel" onclick="window.history.back()" name="button" value="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" style="width:70px" type="button">
														</div>
													</td>
												</tr>
												<!--Block Head-->
												<tr>
													<td colspan=<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>"3"<?php else: ?>"4"<?php endif; ?> class="detailedViewHeader">
														<b><?php echo getTranslatedString('LBL_MODULE_INFORMATION', $this->_tpl_vars['MODULE']); ?>
</b>
													</td>
													<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>
													<td  colspan="1" class="detailedViewHeader" align="right">
														<?php echo getTranslatedString('LBL_ENABLE', $this->_tpl_vars['MODULE']); ?>

														<?php if ($this->_tpl_vars['WEBFORM']->getEnabled() == 1): ?>
															<input type="checkbox" name="enabled" id="enabled" checked="checked"></input>
														<?php else: ?>
															<input type="checkbox" name="enabled" id="enabled" ></input>
														<?php endif; ?>
													</td>
													<?php endif; ?>
												</tr>
												<!-- Cell information  -->
												<tr style="height:25px">
													<td class="dvtCellLabel" align="right" width="10%" nowrap="nowrap">
														<font color="red">*</font><?php echo getTranslatedString('LBL_WEBFORM_NAME', $this->_tpl_vars['MODULE']); ?>

													</td>
													<td class="dvtCellInfo" align="left" width="40%">
														<input type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="name"  name="name" value="<?php echo $this->_tpl_vars['WEBFORM']->getName(); ?>
" <?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>readonly="readonly"<?php endif; ?>>
													</td>
													<td class="dvtCellLabel" align="right" width="10%" nowrap="nowrap">
														<font color="red">*</font><?php echo getTranslatedString('LBL_MODULE', $this->_tpl_vars['MODULE']); ?>
 :
													</td>
													<td class="dvtCellInfo" align="left" width="40%">
														<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>
															<?php echo $this->_tpl_vars['WEBFORM']->getTargetModule(); ?>

															<input type="hidden" value="<?php echo $this->_tpl_vars['WEBFORM']->getTargetModule(); ?>
" name="targetmodule" id="targetmodule"></input>
														<?php else: ?>
															<select id="targetmodule" name="targetmodule" onchange='javascript:Webforms.fetchFieldsView(this.value);' class="small">
																<option value="">--module--</option>
																 <?php $_from = $this->_tpl_vars['WEBFORMMODULES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['moduleloop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['moduleloop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module']):
        $this->_foreach['moduleloop']['iteration']++;
?>
																	<option value="<?php echo $this->_tpl_vars['module']; ?>
"><?php echo $this->_tpl_vars['module']; ?>
</option>
																<?php endforeach; endif; unset($_from); ?>
															</select>
														<?php endif; ?>
													</td>
												</tr>
												<tr style="height:25px">
													<td class="dvtCellLabel" align="right" >
														<font color="red">*</font><?php echo getTranslatedString('LBL_ASSIGNED_TO', $this->_tpl_vars['MODULE']); ?>

													</td>
													<td class="dvtCellInfo" align="left" >
														<select id="ownerid" name="ownerid" class="small">
															<option value="">--<?php echo getTranslatedString('LBL_SELECT_USER', $this->_tpl_vars['MODULE']); ?>
--</option>
																<?php $_from = $this->_tpl_vars['USERS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['assigned_user'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['assigned_user']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userid'] => $this->_tpl_vars['username']):
        $this->_foreach['assigned_user']['iteration']++;
?>
																<option value="<?php echo $this->_tpl_vars['userid']; ?>
"
																	<?php if ($this->_tpl_vars['WEBFORMID'] && $this->_tpl_vars['userid'] == $this->_tpl_vars['WEBFORM']->getOwnerId()): ?> selected <?php endif; ?>>
																	<?php echo $this->_tpl_vars['username']; ?>

																</option>
															<?php endforeach; endif; unset($_from); ?>
														</select>
													</td>
													<td class="dvtCellLabel" align="right" >
														<?php echo getTranslatedString('LBL_RETURNURL', $this->_tpl_vars['MODULE']); ?>

													</td>
													<td class="dvtCellInfo" align="left" >
														http:// <input type="text" onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" id="returnurl"  name="returnurl" value="<?php echo $this->_tpl_vars['WEBFORM']->getReturnUrl(); ?>
">
													</td>
												</tr>
												<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?>
												<tr style="height:25px;">
													<td class="dvtCellLabel" align="right" >
														<?php echo getTranslatedString('LBL_PUBLICID', $this->_tpl_vars['MODULE']); ?>

													</td>
													<td class="dvtCellInfo" align="left" >
														<?php echo $this->_tpl_vars['WEBFORM']->getPublicId(); ?>

													</td>
													<td class="dvtCellLabel" align="right" >
														<?php echo getTranslatedString('LBL_POSTURL', $this->_tpl_vars['MODULE']); ?>

													</td>
													<td class="dvtCellInfo" align="left" >
														<?php echo $this->_tpl_vars['ACTIONPATH']; ?>

													</td>
												</tr>
												<?php endif; ?>
												<tr>
													<td class="dvtCellLabel" align="right" colspan="1">
														<?php echo getTranslatedString('LBL_DESCRIPTION', $this->_tpl_vars['MODULE']); ?>

													</td>
													<td  colspan="3">
														<textarea  onblur="this.className='detailedViewTextBox';" onfocus="this.className='detailedViewTextBoxOn';" class="detailedViewTextBox" rows="8" cols="90" onblur="this.className='detailedViewTextBox'" name="description" id="description" onfocus="this.className='detailedViewTextBoxOn'" tabindex="" class="detailedViewTextBox" ><?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?><?php echo $this->_tpl_vars['WEBFORM']->getDescription(); ?>
<?php endif; ?></textarea>
													</td>
												</tr>
												<!--Cell Information end-->
												<tr style="height:25px">
													<td>&nbsp;</td>
												</tr>
												<!--Block Head-->
												<tr>
													<td colspan="3" class="detailedViewHeader">
														<b><?php echo getTranslatedString('LBL_FIELD_INFORMATION', $this->_tpl_vars['MODULE']); ?>
</b>
													</td>
													<td  colspan="1" class="detailedViewHeader" align="right">
													</td>
												</tr>
	<!-- Cell information for fields -->
												<tr >
													<td colspan="4"  >
														<div id="Webforms_FieldsView"></div>
														<?php if ($this->_tpl_vars['WEBFORM']->hasId()): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "modules/Webforms/FieldsView.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
													</td>
												</tr>
	<!--Cell Information end-->
												<tr style="height:25px">
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td colspan="4" style="padding:5px">
														<div align="center" >
														<input title="<?php echo getTranslatedString('LBL_SAVE_BUTTON_TITLE', $this->_tpl_vars['MODULE']); ?>
" accesskey="<?php echo getTranslatedString('LBL_SAVE_BUTTON_KEY', $this->_tpl_vars['MODULE']); ?>
" class="crmbutton small save" onclick="javascript:return Webforms.validateForm('webform_edit','index.php?module=Webforms&action=Save')" name="button" value="<?php echo getTranslatedString('LBL_SAVE_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
 " style="width:70px" type="submit">
														<input title="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_TITLE', $this->_tpl_vars['MODULE']); ?>
" accesskey="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_KEY', $this->_tpl_vars['MODULE']); ?>
" class="crmbutton small cancel" onclick="window.history.back()" name="button" value="<?php echo getTranslatedString('LBL_CANCEL_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
" style="width:70px" type="button">
														</div>
													</td>
												</tr>
											</table>
										</form>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		<!-- Basic Information Tab Closed -->
			</td>
		</tr>
	</table>
	</form></div>
	</td>
	<td align="right" valign="top"><img src="themes/softed/images/showPanelTopRight.gif"></td>
</tr>
</table>