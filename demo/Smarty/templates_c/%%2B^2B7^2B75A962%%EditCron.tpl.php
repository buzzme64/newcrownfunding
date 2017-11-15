<?php /* Smarty version 2.6.18, created on 2013-09-16 14:22:05
         compiled from modules/CronTasks/EditCron.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getTranslatedString', 'modules/CronTasks/EditCron.tpl', 14, false),array('modifier', 'vtiger_imageurl', 'modules/CronTasks/EditCron.tpl', 18, false),)), $this); ?>
<div id="EditInv" class="layerPopup">
<input id="min_freq" type="hidden" value="<?php echo $this->_tpl_vars['MIN_CRON_FREQUENCY']; ?>
">
<input id="desc" type="hidden" value="<?php echo getTranslatedString('LBL_MINIMUM_FREQUENCY', $this->_tpl_vars['MODULE']); ?>
 <?php echo $this->_tpl_vars['MIN_CRON_FREQUENCY']; ?>
 <?php echo getTranslatedString('LBL_MINS', $this->_tpl_vars['MODULE']); ?>
" size="35" maxlength="40">
<table border=0 cellspacing=0 cellpadding=5 width=100% class=layerHeadingULine>
<tr>
	<td class="layerPopupHeading" align="left"><?php echo $this->_tpl_vars['CRON_DETAILS']['label']; ?>
</td>
	<td align="right" class="small"><img onClick="hide('editdiv');" style="cursor:pointer;" src="<?php echo vtiger_imageurl('close.gif', $this->_tpl_vars['THEME']); ?>
" align="middle" border="0"></td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=5 width=95% align=center>
<tr>
	<td class="small">
	<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
	<tr>
		<td align="right"  class="cellLabel small" width="40%"><b><?php echo $this->_tpl_vars['MOD']['LBL_STATUS']; ?>
 :</b></td>
	<td align="left"  class="cellText small" width="60%">
		<select class="small" id="cron_status" name="cron_status">
	<?php if ($this->_tpl_vars['CRON_DETAILS']['status'] == 1): ?>
		<option value="1" selected><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
		<option value="0"><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
	<?php else: ?>
		<option value="1"><?php echo $this->_tpl_vars['MOD']['LBL_ACTIVE']; ?>
</option>
		<option value="0" selected><?php echo $this->_tpl_vars['MOD']['LBL_INACTIVE']; ?>
</option>
	<?php endif; ?>
	</select>
	</td>
	</tr>
        <tr>
		<td align="right" class="cellLabel small"><b><?php echo $this->_tpl_vars['MOD']['LBL_FREQUENCY']; ?>
</b></td>
		<td align="left" class="cellText small" width="104px"><input class="txtBox" id="CronTime" name="CronTime" value="<?php echo $this->_tpl_vars['CRON_DETAILS']['frequency']; ?>
" style="width:25px;" type="text">
                <select class="small" id="cron_time" name="cron_status">
                <?php if ($this->_tpl_vars['CRON_DETAILS']['time'] == 'min'): ?>
                 <option value="min" selected><?php echo $this->_tpl_vars['MOD']['LBL_MINS']; ?>
</option>
		<option value="hours"><?php echo $this->_tpl_vars['MOD']['LBL_HOURS']; ?>
</option>
                <?php else: ?>
                 <option value="min" ><?php echo $this->_tpl_vars['MOD']['LBL_MINS']; ?>
</option>
                 <option value="hours" selected><?php echo $this->_tpl_vars['MOD']['LBL_HOURS']; ?>
</option>
                <?php endif; ?>
        </td>
        </tr>
        <tr>
        <td colspan=2>
        <?php echo $this->_tpl_vars['CRON_DETAILS']['description']; ?>

        </td>
        <tr>
	</table>
	</td>
</tr>
</table>
<table border=0 cellspacing=0 cellpadding=5 width=100% class="layerPopupTransport">
<tr>
	<td align="center" class="small">
		<input name="save" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" class="crmButton small save" type="button" onClick="fetchSaveCron('<?php echo $this->_tpl_vars['CRON_DETAILS']['id']; ?>
')">
		<input name="cancel" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="crmButton small cancel" type="button" onClick="hide('editdiv');">
	</td>
	</tr>
</table>
</div>