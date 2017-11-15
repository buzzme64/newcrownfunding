<?php /* Smarty version 2.6.18, created on 2013-11-13 11:54:12
         compiled from modules/MailManager/Folder.Drafts.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/MailManager/Folder.Drafts.tpl', 9, false),)), $this); ?>
<span class="moduleName" id="mail_fldrname"><?php echo getTranslatedString('LBL_Drafts'); ?>
</span>
<div class="mailClientBg mm_outerborder" id="email_con" name="email_con">

	<table width="100%" cellpadding=3 cellspacing=0 border=0 class="small">
		<?php if ($this->_tpl_vars['FOLDER']->mails()): ?>
		<tr>
			<td>
				
			</td>
			<td align="right" colspan=2>
				<table><tr>
				<?php if ($this->_tpl_vars['FOLDER']->hasPrevPage()): ?>
					<td><a href="#<?php echo $this->_tpl_vars['FOLDER']->name(); ?>
/page/<?php echo $this->_tpl_vars['FOLDER']->pageCurrent(-1); ?>
" onclick="MailManager.folder_drafts(<?php echo $this->_tpl_vars['FOLDER']->pageCurrent(-1); ?>
);"
					><img border="0" src="modules/Webmails/images/previous.gif" title="<?php echo getTranslatedString('LBL_Previous'); ?>
"></a> </td><?php endif; ?>
				<td><b><?php echo $this->_tpl_vars['FOLDER']->pageInfo(); ?>
</b></td>
				<?php if ($this->_tpl_vars['FOLDER']->hasNextPage()): ?> <td><a href="#<?php echo $this->_tpl_vars['FOLDER']->name(); ?>
/page/<?php echo $this->_tpl_vars['FOLDER']->pageCurrent(1); ?>
" onclick="MailManager.folder_drafts(<?php echo $this->_tpl_vars['FOLDER']->pageCurrent(1); ?>
);"
				><img border="0" src="modules/Webmails/images/next.gif" title="<?php echo getTranslatedString('LBL_Next'); ?>
"></a> </td><?php endif; ?>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="5">
			<table class="mm_tableHeadBg small" width="100%" cellspacing="0" border="0" cellpadding="2px" >
				<tr>
					<td align="left" style="width: 10%;" nowrap="nowrap">
					<input align="left" type="checkbox" class='small'  name="selectall" id="parentCheckBox" onClick='MailManager.toggleSelect(this.checked,"mc_box");'/>&nbsp;&nbsp;
					<input type=button class='crmbutton small delete' onclick="MailManager.massMailDelete('__vt_drafts');" name="<?php echo getTranslatedString('LBL_Delete'); ?>
" value="<?php echo getTranslatedString('LBL_Delete'); ?>
" />
				</td>
				<td class="moduleName" align="right"><?php echo getTranslatedString('LBL_Search'); ?>

					<input type="text" id='search_txt' class='small' />&nbsp;
					<?php echo getTranslatedString('LBL_IN'); ?>

					<select class='small' id="search_type">
						<?php $_from = $this->_tpl_vars['SEARCHOPTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value'] => $this->_tpl_vars['label']):
?>
							<option value="<?php echo $this->_tpl_vars['value']; ?>
" ><?php echo getTranslatedString($this->_tpl_vars['label']); ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
					</select>
					<input type=button class="crmbutton edit small" onclick="MailManager.search_drafts();" value="<?php echo getTranslatedString('LBL_FIND'); ?>
" id="mm_search"/>
				</td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['FOLDER']->mails()): ?>
	<table class="small mm_mailwrapper" cellpadding="0" cellspacing="0" border="0" width="100%">

		<?php $_from = $this->_tpl_vars['MAILS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['MAIL']):
?>
		<tr style="cursor: pointer" class="mm_lvtColData mm_normal" id="_mailrow_<?php echo $this->_tpl_vars['MAIL']['id']; ?>
"
            onmouseover='MailManager.highLightListMail(this);' onmouseout='MailManager.unHighLightListMail(this);'>
			<td width="3%"><input type='checkbox' value = "<?php echo $this->_tpl_vars['MAIL']['id']; ?>
" name = 'mc_box' class='small'
                                  onclick="MailManager.toggleSelectMail(this.checked, this);"></td>
			<td width="27%" onclick="MailManager.mail_draft('<?php echo $this->_tpl_vars['MAIL']['id']; ?>
')"><?php echo $this->_tpl_vars['MAIL']['saved_toid']; ?>
</td>
			<td onclick="MailManager.mail_draft('<?php echo $this->_tpl_vars['MAIL']['id']; ?>
')"> <?php echo $this->_tpl_vars['MAIL']['subject']; ?>
</td>
			<td width="17%" align="right" onclick="MailManager.mail_draft('<?php echo $this->_tpl_vars['MAIL']['id']; ?>
')"><?php echo $this->_tpl_vars['MAIL']['date_start']; ?>
</td>
		</tr>
		<?php endforeach; endif; unset($_from); ?>
	</table>
	<?php endif; ?>

	<?php if ($this->_tpl_vars['FOLDER']->mails() == null): ?>
	<table  cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td><a href='javascript:void(0);' onclick="MailManager.folder_drafts();"><b><?php echo getTranslatedString('LBL_Drafts'); ?>
</b></a></td>
		</tr>
		<tr>
			<td><?php echo getTranslatedString('LBL_No_Mails_Found'); ?>
</td>
		</tr>
	<?php endif; ?>
	</table>
</div>