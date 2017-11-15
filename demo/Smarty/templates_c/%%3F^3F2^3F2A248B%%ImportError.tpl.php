<?php /* Smarty version 2.6.18, created on 2015-10-07 11:18:08
         compiled from modules/Import/ImportError.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/Import/ImportError.tpl', 22, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="modules/MailManager/resources/jquery-1.6.2.min.js"></script>
<script type="text/javascript" charset="utf-8">
	jQuery.noConflict();
</script>
<script language="JavaScript" type="text/javascript" src="modules/Import/resources/Import.js"></script>

<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['FOR_MODULE']; ?>
" />
<table style="width:70%;margin-left:auto;margin-right:auto;margin-top:10px;" cellpadding="10" cellspacing="10" class="searchUIBasic">
	<tr>
		<td class="heading2" align="left">
			<?php echo getTranslatedString('LBL_IMPORT', $this->_tpl_vars['MODULE']); ?>
 - <?php echo getTranslatedString('LBL_ERROR', $this->_tpl_vars['MODULE']); ?>

		</td>
	</tr>
	<tr>
		<td valign="top">
			<table cellpadding="10" cellspacing="0" align="center" class="dvtSelectedCell thickBorder">
				<tr>
					<td class="style1" align="left" colspan="2">
						<?php echo $this->_tpl_vars['ERROR_MESSAGE']; ?>

					</td>
				</tr>
				<?php if ($this->_tpl_vars['ERROR_DETAILS'] != ''): ?>
				<tr>
					<td class="errorMessage" align="left" colspan="2">
						<?php echo getTranslatedString('ERR_DETAILS_BELOW', $this->_tpl_vars['MODULE']); ?>

						<table cellpadding="5" cellspacing="0">
						<?php $_from = $this->_tpl_vars['ERROR_DETAILS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_TITLE'] => $this->_tpl_vars['_VALUE']):
?>
							<tr>
								<td><?php echo $this->_tpl_vars['_TITLE']; ?>
</td>
								<td>-</td>
								<td><?php echo $this->_tpl_vars['_VALUE']; ?>
</td>
							</tr>
						<?php endforeach; endif; unset($_from); ?>
						</table>
					</td>
				</tr>
				<?php endif; ?>
			</table>
		</td>
	</tr>
	<tr>
		<td align="right">
		<?php if ($this->_tpl_vars['CUSTOM_ACTIONS'] != ''): ?>
		<?php $_from = $this->_tpl_vars['CUSTOM_ACTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['_LABEL'] => $this->_tpl_vars['_ACTION']):
?>
			<input type="button" name="<?php echo $this->_tpl_vars['_LABEL']; ?>
" value="<?php echo getTranslatedString($this->_tpl_vars['_LABEL'], $this->_tpl_vars['MODULE']); ?>
"
				   onclick="<?php echo $this->_tpl_vars['_ACTION']; ?>
" class="crmButton small create" />
		<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
		<input type="button" name="goback" value="<?php echo getTranslatedString('LBL_GO_BACK', $this->_tpl_vars['MODULE']); ?>
"
			   onclick="window.history.back()" class="crmButton small edit" />
		</td>
	</tr>
</table>