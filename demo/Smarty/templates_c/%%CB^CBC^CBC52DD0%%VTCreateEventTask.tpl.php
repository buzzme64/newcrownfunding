<?php /* Smarty version 2.6.18, created on 2013-10-07 07:21:10
         compiled from com_vtiger_workflow/taskforms/VTCreateEventTask.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'com_vtiger_workflow/taskforms/VTCreateEventTask.tpl', 35, false),)), $this); ?>

<script src="modules/com_vtiger_workflow/resources/vtigerwebservices.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript" charset="utf-8">
var moduleName = '<?php echo $this->_tpl_vars['entityName']; ?>
';
var eventStatus = '<?php echo $this->_tpl_vars['task']->status; ?>
';
var eventType = '<?php echo $this->_tpl_vars['task']->eventType; ?>
';
</script>
<script src="modules/com_vtiger_workflow/resources/createeventtaskscript.js" type="text/javascript" charset="utf-8"></script>


<div id="view">
	<table border="0" cellpadding="5" cellspacing="0" width="100%" class="small">
	<tr valign="top">
		<td class='dvtCellLabel' align="right" width=15% nowrap="nowrap"><b><font color=red>*</font> Event Name</b></td>
		<td class='dvtCellInfo'><input type="text" name="eventName" value="<?php echo $this->_tpl_vars['task']->eventName; ?>
" id="workflow_eventname" class="form_input"></td>
	</tr>
	<tr valign="top">
		<td class='dvtCellLabel' align="right" width=15% nowrap="nowrap"><b>Description</b></td>
		<td class='dvtCellInfo'><textarea name="description" rows="8" cols="40" class='detailedViewTextBox'><?php echo $this->_tpl_vars['task']->description; ?>
</textarea></td>
	</tr>
	<tr valign="top">
		<td class='dvtCellLabel' align="right" width=15% nowrap="nowrap"><b>Status</b></td>
		<td class='dvtCellInfo'>
			<span id="event_status_busyicon"><b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
			<select id="event_status" value="<?php echo $this->_tpl_vars['task']->status; ?>
" name="status" class="small" style="display: none;"></select>
		</td>
	</tr>
	<tr valign="top">
		<td class='dvtCellLabel' align="right" width=15% nowrap="nowrap"><b>Type</b></td>
		<td class='dvtCellInfo'>
			<span id="event_type_busyicon"><b><?php echo $this->_tpl_vars['MOD']['LBL_LOADING']; ?>
</b><img src="<?php echo vtiger_imageurl('vtbusy.gif', $this->_tpl_vars['THEME']); ?>
" border="0"></span>
			<select id="event_type" value="<?php echo $this->_tpl_vars['task']->eventType; ?>
" name="eventType" class="small" style="display: none;"></select>
		</td>
	</tr>
	<tr><td colspan="2"><hr size="1" noshade="noshade" /></td></tr>
	<tr>
		<td colspan="2" align="right">
			<span class="helpmessagebox"><?php echo $this->_tpl_vars['MOD']['LBL_WORKFLOW_NOTE_EVENT_TASK_TIMEZONE']; ?>
</span>
		</td>
	</tr>
	<tr>
		<td align="right"><b>Start Time</b></td>
		<?php if ($this->_tpl_vars['task']->startTime != ''): ?>
			<?php $this->assign('now', $this->_tpl_vars['task']->startTime); ?>
		<?php else: ?>
			<?php $this->assign('now', $this->_tpl_vars['USER_TIME']); ?>
		<?php endif; ?>
		<td><input type="hidden" name="startTime" value="<?php echo $this->_tpl_vars['now']; ?>
" id="workflow_time" style="width:60px"  class="time_field"></td>
	</tr>
	<tr>
		<td align="right"><b>Start Date</b></td>
		<td>
			<input type="text" name="startDays" value="<?php echo $this->_tpl_vars['task']->startDays; ?>
" id="start_days" style="width:30px" class="small"> days
			<select name="startDirection" class="small">
				<option <?php if ($this->_tpl_vars['task']->startDirection == 'After'): ?>selected<?php endif; ?> value="After">After</option>
				<option <?php if ($this->_tpl_vars['task']->startDirection == 'Before'): ?>selected<?php endif; ?> value="Before">Before</option>
			</select>
			<select name="startDatefield" value="<?php echo $this->_tpl_vars['task']->startDatefield; ?>
" class="small">
				<?php $_from = $this->_tpl_vars['dateFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['label']):
?>
				<option value='<?php echo $this->_tpl_vars['name']; ?>
' <?php if ($this->_tpl_vars['task']->startDatefield == $this->_tpl_vars['name']): ?>selected<?php endif; ?>>
					<?php echo $this->_tpl_vars['label']; ?>

				</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr>
		<td align="right"><b>End Time</b></td>
		<?php if ($this->_tpl_vars['task']->endTime != ''): ?>
			<?php $this->assign('now', $this->_tpl_vars['task']->endTime); ?>
		<?php else: ?>
			<?php $this->assign('now', $this->_tpl_vars['USER_TIME']); ?>
		<?php endif; ?>
		<td><input type="hidden" name="endTime" value="<?php echo $this->_tpl_vars['now']; ?>
" id="end_time" style="width:60px" class="time_field"></td>
	</tr>
	<tr>
		<td align="right"><b>End Date</b></td>
		<td><input type="text" name="endDays" value="<?php echo $this->_tpl_vars['task']->endDays; ?>
" id="end_days" style="width:30px" class="small"> days
			<select name="endDirection" class="small">
				<option <?php if ($this->_tpl_vars['task']->endDirection == 'After'): ?>selected<?php endif; ?> value="After">After</option>
				<option <?php if ($this->_tpl_vars['task']->endDirection == 'Before'): ?>selected<?php endif; ?> value="Before">Before</option>
			</select>
			<select name="endDatefield" value="<?php echo $this->_tpl_vars['task']->endDatefield; ?>
" class="small">
				<?php $_from = $this->_tpl_vars['dateFields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['name'] => $this->_tpl_vars['label']):
?>
				<option value='<?php echo $this->_tpl_vars['name']; ?>
' <?php if ($this->_tpl_vars['task']->endDatefield == $this->_tpl_vars['name']): ?>selected<?php endif; ?>>
					<?php echo $this->_tpl_vars['label']; ?>

				</option>
				<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr>
		<td nowrap align=right width=20% valign=top>
		<strong><?php echo $this->_tpl_vars['MOD']['LBL_REPEAT']; ?>
 </strong>
		</td>
		<td nowrap width=80% valign=top>
			<table border=0 cellspacing=0 cellpadding=0>
			<tr>
				<td width=20><input type="checkbox" name="recurringcheck" onClick="showhide('repeatOptions')" <?php if ($this->_tpl_vars['task']->recurringcheck == 'on'): ?>checked<?php endif; ?>></td>
				<td><?php echo $this->_tpl_vars['MOD']['LBL_ENABLE_REPEAT']; ?>
</td>
			</tr>
			<tr>
				<td colspan=2>
				<div id="repeatOptions" style="display:<?php if ($this->_tpl_vars['task']->recurringcheck != 'on'): ?>none<?php else: ?>block<?php endif; ?>">
					<table border=0 cellspacing=0 cellpadding=2 bgcolor="#FFFFFF">
					<tr>
					<td>
						<?php echo $this->_tpl_vars['MOD']['LBL_REPEATEVENT']; ?>

					</td>
					<td><select name="repeat_frequency" class="small">
					<?php unset($this->_sections['numdays']);
$this->_sections['numdays']['name'] = 'numdays';
$this->_sections['numdays']['start'] = (int)1;
$this->_sections['numdays']['loop'] = is_array($_loop=15) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['numdays']['show'] = true;
$this->_sections['numdays']['max'] = $this->_sections['numdays']['loop'];
$this->_sections['numdays']['step'] = 1;
if ($this->_sections['numdays']['start'] < 0)
    $this->_sections['numdays']['start'] = max($this->_sections['numdays']['step'] > 0 ? 0 : -1, $this->_sections['numdays']['loop'] + $this->_sections['numdays']['start']);
else
    $this->_sections['numdays']['start'] = min($this->_sections['numdays']['start'], $this->_sections['numdays']['step'] > 0 ? $this->_sections['numdays']['loop'] : $this->_sections['numdays']['loop']-1);
if ($this->_sections['numdays']['show']) {
    $this->_sections['numdays']['total'] = min(ceil(($this->_sections['numdays']['step'] > 0 ? $this->_sections['numdays']['loop'] - $this->_sections['numdays']['start'] : $this->_sections['numdays']['start']+1)/abs($this->_sections['numdays']['step'])), $this->_sections['numdays']['max']);
    if ($this->_sections['numdays']['total'] == 0)
        $this->_sections['numdays']['show'] = false;
} else
    $this->_sections['numdays']['total'] = 0;
if ($this->_sections['numdays']['show']):

            for ($this->_sections['numdays']['index'] = $this->_sections['numdays']['start'], $this->_sections['numdays']['iteration'] = 1;
                 $this->_sections['numdays']['iteration'] <= $this->_sections['numdays']['total'];
                 $this->_sections['numdays']['index'] += $this->_sections['numdays']['step'], $this->_sections['numdays']['iteration']++):
$this->_sections['numdays']['rownum'] = $this->_sections['numdays']['iteration'];
$this->_sections['numdays']['index_prev'] = $this->_sections['numdays']['index'] - $this->_sections['numdays']['step'];
$this->_sections['numdays']['index_next'] = $this->_sections['numdays']['index'] + $this->_sections['numdays']['step'];
$this->_sections['numdays']['first']      = ($this->_sections['numdays']['iteration'] == 1);
$this->_sections['numdays']['last']       = ($this->_sections['numdays']['iteration'] == $this->_sections['numdays']['total']);
?>
					<option value="<?php echo $this->_sections['numdays']['index']; ?>
" <?php if ($this->_tpl_vars['task']->repeat_frequency == $this->_sections['numdays']['index']): ?>selected<?php endif; ?>><?php echo $this->_sections['numdays']['index']; ?>
</option>
					<?php endfor; endif; ?>
					</select></td>
					<td>
						<select name="recurringtype" onChange="rptoptDisp(this)" class="small">
							<option value="Daily" <?php if ($this->_tpl_vars['task']->recurringtype == 'Daily'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAYS']; ?>
</option>
							<option value="Weekly" <?php if ($this->_tpl_vars['task']->recurringtype == 'Weekly'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_WEEKS']; ?>
</option>
							<option value="Monthly" <?php if ($this->_tpl_vars['task']->recurringtype == 'Monthly'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_MONTHS']; ?>
</option>
							<option value="Yearly" <?php if ($this->_tpl_vars['task']->recurringtype == 'Yearly'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_YEAR']; ?>
</option>
						</select>
						<!-- Limit for Repeating Event -->
						<b><?php echo $this->_tpl_vars['MOD']['LBL_UNTIL']; ?>
:</b> <input type="text" name="calendar_repeat_limit_date" id="calendar_repeat_limit_date" class="textbox" style="width:90px" value="<?php echo $this->_tpl_vars['REPEAT_DATE']; ?>
"></td><td align="left"><img border=0 src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
btnL3Calendar.gif" alt="<?php echo $this->_tpl_vars['MOD']['LBL_SET_DATE']; ?>
" title="<?php echo $this->_tpl_vars['MOD']['LBL_SET_DATE']; ?>
" id="jscal_trigger_calendar_repeat_limit_date">
						<script type="text/javascript">
						Calendar.setup ({
							inputField : "calendar_repeat_limit_date", ifFormat : "<?php echo $this->_tpl_vars['dateFormat']; ?>
", showsTime : false, button : "jscal_trigger_calendar_repeat_limit_date", singleClick : true, step : 1
						})
						</script>
						<!-- END -->
					</td>
					</tr>
					</table>

					<div id="repeatWeekUI" style="display:<?php if ($this->_tpl_vars['task']->recurringtype != 'Weekly'): ?>none<?php else: ?>block<?php endif; ?>;">
					<table border=0 cellspacing=0 cellpadding=2>
						<tr>
					<td><input name="sun_flag" value="sunday" type="checkbox" <?php if ($this->_tpl_vars['task']->sun_flag == 'sunday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_SUN']; ?>
</td>
					<td><input name="mon_flag" value="monday" type="checkbox" <?php if ($this->_tpl_vars['task']->mon_flag == 'monday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_MON']; ?>
</td>
					<td><input name="tue_flag" value="tuesday" type="checkbox" <?php if ($this->_tpl_vars['task']->tue_flag == 'tuesday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_TUE']; ?>
</td>
					<td><input name="wed_flag" value="wednesday" type="checkbox" <?php if ($this->_tpl_vars['task']->wed_flag == 'wednesday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_WED']; ?>
</td>
					<td><input name="thu_flag" value="thursday" type="checkbox" <?php if ($this->_tpl_vars['task']->thu_flag == 'thursday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_THU']; ?>
</td>
					<td><input name="fri_flag" value="friday" type="checkbox" <?php if ($this->_tpl_vars['task']->fri_flag == 'friday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_FRI']; ?>
</td>
					<td><input name="sat_flag" value="saturday" type="checkbox" <?php if ($this->_tpl_vars['task']->sat_flag == 'saturday'): ?>checked<?php endif; ?>></td><td><?php echo $this->_tpl_vars['MOD']['LBL_SM_SAT']; ?>
</td>
						</tr>
					</table>
					</div>

					<div id="repeatMonthUI" style="display:<?php if ($this->_tpl_vars['task']->recurringtype != 'Monthly'): ?>none<?php else: ?>block<?php endif; ?>;">
					<table border=0 cellspacing=0 cellpadding=2 bgcolor="#FFFFFF">
						<tr>
							<td>
								<table border=0 cellspacing=0 cellpadding=2>
									<tr>
										<td><input type="radio" <?php if ($this->_tpl_vars['task']->repeatMonth == 'date'): ?>checked<?php endif; ?> name="repeatMonth" value="date"></td><td><?php echo $this->_tpl_vars['MOD']['on']; ?>
</td>
										<td><input type="text" class="textbox" style="width:20px" value="<?php echo $this->_tpl_vars['task']->repeatMonth_date; ?>
" name="repeatMonth_date" ></td>
										<td><?php $this->assign('languageKey', 'day of the month'); ?><?php echo $this->_tpl_vars['MOD'][$this->_tpl_vars['languageKey']]; ?>
</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td>
								<table border=0 cellspacing=0 cellpadding=2>
									<tr>
										<td>
											<input type="radio" <?php if ($this->_tpl_vars['task']->repeatMonth == 'day'): ?>checked<?php endif; ?> name="repeatMonth" value="day"></td>
										<td><?php echo $this->_tpl_vars['MOD']['on']; ?>
</td>
										<td>
											<select name="repeatMonth_daytype" class="small">
												<option value="first" <?php if ($this->_tpl_vars['task']->repeatMonth_daytype == 'first'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['First']; ?>
</option>
												<option value="last" <?php if ($this->_tpl_vars['task']->repeatMonth_daytype == 'last'): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['Last']; ?>
</option>
											</select>
										</td>
										<td>
											<select name="repeatMonth_day" class="small">
												<option value=1 <?php if ($this->_tpl_vars['task']->repeatMonth_day == 1): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAY1']; ?>
</option>
												<option value=2 <?php if ($this->_tpl_vars['task']->repeatMonth_day == 2): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAY2']; ?>
</option>
												<option value=3 <?php if ($this->_tpl_vars['task']->repeatMonth_day == 3): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAY3']; ?>
</option>
												<option value=4 <?php if ($this->_tpl_vars['task']->repeatMonth_day == 4): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAY4']; ?>
</option>
												<option value=5 <?php if ($this->_tpl_vars['task']->repeatMonth_day == 5): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAY5']; ?>
</option>
												<option value=6 <?php if ($this->_tpl_vars['task']->repeatMonth_day == 6): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['MOD']['LBL_DAY6']; ?>
</option>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</div>

				</div>

				</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
</div>