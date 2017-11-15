<?php /* Smarty version 2.6.18, created on 2015-10-07 10:47:21
         compiled from modules/Import/Import_Done_Buttons.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/Import/Import_Done_Buttons.tpl', 13, false),)), $this); ?>

<input type="button" name="ok" value="<?php echo getTranslatedString('LBL_OK_BUTTON_LABEL', $this->_tpl_vars['MODULE']); ?>
"
				   onclick="location.href='index.php?module=<?php echo $this->_tpl_vars['FOR_MODULE']; ?>
&action=index'" class="crmButton small edit" />