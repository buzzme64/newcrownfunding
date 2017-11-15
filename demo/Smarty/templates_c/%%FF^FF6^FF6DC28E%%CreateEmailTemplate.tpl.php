<?php /* Smarty version 2.6.18, created on 2013-09-16 14:20:52
         compiled from CreateEmailTemplate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'CreateEmailTemplate.tpl', 41, false),array('modifier', 'vtiger_imageurl', 'CreateEmailTemplate.tpl', 73, false),)), $this); ?>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>

<script language="JavaScript" type="text/javascript">
    var allOptions = null;

    function setAllOptions(inputOptions) 
    {
        allOptions = inputOptions;
    }

    function modifyMergeFieldSelect(cause, effect) 
    {
        var selected = cause.options[cause.selectedIndex].value;  id="mergeFieldValue"
        var s = allOptions[cause.selectedIndex];
        effect.length = s;
        for (var i = 0; i < s; i++) 
	{
            effect.options[i] = s[i];
        }
        document.getElementById('mergeFieldValue').value = '';
    }
<?php echo '
    function init() 
    {
        var blankOption = new Option(\'--None--\', \'--None--\');
        var options = null;
'; ?>


		var allOpts = new Object(<?php echo count($this->_tpl_vars['ALL_VARIABLES']); ?>
+1);
		<?php $this->assign('alloptioncount', '0'); ?>
		<?php $_from = $this->_tpl_vars['ALL_VARIABLES']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['index'] => $this->_tpl_vars['module']):
?>
	    	options = new Object(<?php echo count($this->_tpl_vars['module']); ?>
+1);
	    	<?php $this->assign('optioncount', '0'); ?>
            options[<?php echo $this->_tpl_vars['optioncount']; ?>
] = blankOption;
            <?php $_from = $this->_tpl_vars['module']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['detail']):
?>
             <?php $this->assign('optioncount', $this->_tpl_vars['optioncount']+1); ?>
				options[<?php echo $this->_tpl_vars['optioncount']; ?>
] = new Option('<?php echo $this->_tpl_vars['detail']['0']; ?>
', '<?php echo $this->_tpl_vars['detail']['1']; ?>
');
			<?php endforeach; endif; unset($_from); ?>      
			 <?php $this->assign('alloptioncount', $this->_tpl_vars['alloptioncount']+1); ?>     
             allOpts[<?php echo $this->_tpl_vars['alloptioncount']; ?>
] = options;
	    <?php endforeach; endif; unset($_from); ?>
        setAllOptions(allOpts);	    
    }
	
	

	
<?php echo '
	function cancelForm(frm)
	{
		frm.action.value=\'detailviewemailtemplate\';
		frm.parenttab.value=\'Settings\';
		frm.submit();
	}
'; ?>

</script>

<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
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
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<?php echo '
				<form action="index.php" method="post" name="templatecreate" onsubmit="if(check4null(templatecreate)) { VtigerJS_DialogBox.block(); } else { return false; }">
				'; ?>

				<input type="hidden" name="action">
				<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['EMODE']; ?>
">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="templateid" value="<?php echo $this->_tpl_vars['TEMPLATEID']; ?>
">
				<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['PARENTTAB']; ?>
">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="<?php echo vtiger_imageurl('ViewTemplate.gif', $this->_tpl_vars['THEME']); ?>
" alt="<?php echo $this->_tpl_vars['MOD']['LBL_MODULE_NAME']; ?>
" width="45" height="60" border=0 title="<?php echo $this->_tpl_vars['MOD']['LBL_MODULE_NAME']; ?>
"></td>
				<?php if ($this->_tpl_vars['EMODE'] == 'edit'): ?>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS']; ?>
</a> > <a href="index.php?module=Settings&action=listemailtemplates&parenttab=Settings"><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATES']; ?>
</a> &gt; <?php echo $this->_tpl_vars['MOD']['LBL_EDIT']; ?>
 &quot;<?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
&quot; </b></td>
				<?php else: ?>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS']; ?>
</a> > <a href="index.php?module=Settings&action=listemailtemplates&parenttab=Settings"><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATES']; ?>
</a> &gt; <?php echo $this->_tpl_vars['MOD']['LBL_CREATE_EMAIL_TEMPLATES']; ?>
 </b></td>
				<?php endif; ?>
					
				</tr>
				<tr>
					<td valign=top class="small"><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATE_DESC']; ?>
</td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<?php if ($this->_tpl_vars['EMODE'] == 'edit'): ?>
						<td class="big"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_PROPERTIES']; ?>
 &quot;<?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
&quot; </strong></td>
						<?php else: ?>
						<td class="big"><strong><?php echo $this->_tpl_vars['MOD']['LBL_CREATE_EMAIL_TEMPLATES']; ?>
</strong></td>
						<?php endif; ?>
						<td class="small" align=right>
							<input type="submit" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" class="crmButton small save" onclick="this.form.action.value='saveemailtemplate'; this.form.parenttab.value='Settings'" >&nbsp;&nbsp;
			<?php if ($this->_tpl_vars['EMODE'] == 'edit'): ?>
				<input type="submit" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="crmButton small cancel" onclick="cancelForm(this.form)" />
			<?php else: ?>
				<input type="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
" class="crmButton small cancel" onclick="window.history.back()" >
			<?php endif; ?>
						</td>
					</tr>
					</table>
					
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
						<td width=20% class="small cellLabel"><font color="red">*</font><strong><?php echo $this->_tpl_vars['UMOD']['LBL_NAME']; ?>
</strong></td>
						<td width=80% class="small cellText"><input name="templatename" type="text" value="<?php echo $this->_tpl_vars['TEMPLATENAME']; ?>
" class="detailedViewTextBox" tabindex="1">&nbsp;</td>
					  </tr>
					<tr>
						<td valign=top class="small cellLabel"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_DESCRIPTION']; ?>
</strong></td>
						<td class="cellText small" valign=top><span class="small cellText">
						  <input name="description" type="text" value="<?php echo $this->_tpl_vars['DESCRIPTION']; ?>
" class="detailedViewTextBox" tabindex="2">
						</span></td>
					  </tr>
					<tr>
						<td valign=top class="small cellLabel"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_FOLDER']; ?>
</strong></td>
						<td class="cellText small" valign=top>
						<?php if ($this->_tpl_vars['EMODE'] == 'edit'): ?>
						<select name="foldername" class="small" tabindex="" style="width:100%" tabindex="3">
                                                    <?php $_from = $this->_tpl_vars['FOLDERNAME']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
                                                     <option value="<?php echo $this->_tpl_vars['FOLDERNAME']; ?>
" <?php echo $this->_tpl_vars['arr']; ?>
><?php echo $this->_tpl_vars['FOLDERNAME']; ?>
</option>
                                                        <?php if ($this->_tpl_vars['FOLDERNAME'] == 'Public'): ?>
                                                          <option value="Personal"><?php echo $this->_tpl_vars['UMOD']['LBL_PERSONAL']; ?>
</option>
                                                        <?php else: ?>
                                                          <option value="Public"><?php echo $this->_tpl_vars['UMOD']['LBL_PUBLIC']; ?>
</option>
                                                         <?php endif; ?>
                                                   <?php endforeach; endif; unset($_from); ?>
                                                 </select>
						<?php else: ?>
						<select name="foldername" class="small" tabindex="" value="<?php echo $this->_tpl_vars['FOLDERNAME']; ?>
" style="width:100%" tabindex="3">
                                                    <option value="Personal"><?php echo $this->_tpl_vars['UMOD']['LBL_PERSONAL']; ?>
</option>
                                                    <option value="Public" selected><?php echo $this->_tpl_vars['UMOD']['LBL_PUBLIC']; ?>
</option>
        	                                </select>
						<?php endif; ?>
					
						</td>
					  </tr>
					
					
					<tr>
					  <td colspan="2" valign=top class="cellText small"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="thickBorder">
                        <tr>
                          <td valign=top><table width="100%"  border="0" cellspacing="0" cellpadding="5" >
                              <tr>
                                <td colspan="3" valign="top" class="small" style="background-color:#cccccc"><strong><?php echo $this->_tpl_vars['UMOD']['LBL_EMAIL_TEMPLATE']; ?>
</strong></td>
                                </tr>
                              <tr>
                                <td width="15%" valign="top" class="cellLabel small"><font color='red'>*</font><?php echo $this->_tpl_vars['UMOD']['LBL_SUBJECT']; ?>
</td>
                                <td width="85%" colspan="2" class="cellText small"><span class="small cellText">
                                  <input name="subject" type="text" value="<?php echo $this->_tpl_vars['SUBJECT']; ?>
" class="detailedViewTextBox" tabindex="4">
                                </span></td>
                              </tr> 




                             <tr>
                              
                                <td width="15%"  class="cellLabel small" valign="center"><?php echo $this->_tpl_vars['UMOD']['LBL_SELECT_FIELD_TYPE']; ?>
</td>
                                <td width="85%" colspan="2" class="cellText small">

		<table>
			<tr>
				<td><?php echo $this->_tpl_vars['UMOD']['LBL_STEP']; ?>
1
				<td>
			
				<td style="border-left:2px dotted #cccccc;"><?php echo $this->_tpl_vars['UMOD']['LBL_STEP']; ?>
2
				<td>

				<td style="border-left:2px dotted #cccccc;"><?php echo $this->_tpl_vars['UMOD']['LBL_STEP']; ?>
3
				<td>
			</tr>
			
			<tr>
				<td>

					<select style="font-family: Arial, Helvetica, sans-serif;font-size: 11px;color: #000000;border:1px solid #bababa;padding-left:5px;background-color:#ffffff;" id="entityType" ONCHANGE="modifyMergeFieldSelect(this, document.getElementById('mergeFieldSelect'));" tabindex="6">
                                        <OPTION VALUE="0" selected><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>

                                        <OPTION VALUE="1"><?php echo $this->_tpl_vars['UMOD']['LBL_ACCOUNT_FIELDS']; ?>
                           
                                        <OPTION VALUE="2"><?php echo $this->_tpl_vars['UMOD']['LBL_CONTACT_FIELDS']; ?>

                                        <OPTION VALUE="3" ><?php echo $this->_tpl_vars['UMOD']['LBL_LEAD_FIELDS']; ?>

                                        <OPTION VALUE="4" ><?php echo $this->_tpl_vars['UMOD']['LBL_USER_FIELDS']; ?>

                                        <OPTION VALUE="5" ><?php echo $this->_tpl_vars['UMOD']['LBL_GENERAL_FIELDS']; ?>

                                        </select>
				<td>
			
				<td style="border-left:2px dotted #cccccc;">
					<select style="font-family: Arial, Helvetica, sans-serif;font-size: 11p
x;color: #000000;border:1px solid #bababa;padding-left:5px;background-color:#ffffff;" id="mergeFieldSelect" onchange="document.getElementById('mergeFieldValue').value=this.options[this.selectedIndex].value;" tabindex="7"><option value="0" selected><?php echo $this->_tpl_vars['APP']['LBL_NONE']; ?>
</select>	
				<td>

				<td style="border-left:2px dotted #cccccc;">	

					<input type="text"  id="mergeFieldValue" name="variable" value="variable" style="font-family: Arial, Helvetica, sans-serif;font-size: 11px;color: #000000;border:1px solid #bababa;padding-left:5px;background-color:#ffffdd;" tabindex="8"/>
				<td>
			</tr>

		</table>
			

				</td>
                              </tr>





                              <tr>
                                <td valign="top" width=10% class="cellLabel small"><?php echo $this->_tpl_vars['UMOD']['LBL_MESSAGE']; ?>
</td>
                                 <td valign="top" colspan="2" width=60% class="cellText small"><p><textarea name="body" style="width:90%;height:200px" class=small tabindex="5"><?php echo $this->_tpl_vars['BODY']; ?>
</textarea></p>
                              </tr>
                          </table></td>
                          
                        </tr>
                      </table></td>
					  </tr>
					</table>
					<br>
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
					  <td class="small" nowrap align=right><a href="#top"><?php echo $this->_tpl_vars['MOD']['LBL_SCROLL']; ?>
</a></td>
					</tr>
					</table>
				</td>
				</tr>
				</table>	
			
			
			
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</form>
	</table>
		
	</div>

</td>
        <td valign="top"><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</tbody>
</table>

<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
<script type="text/javascript" defer="1">var textAreaName = null;
	var textAreaName = 'body';
	CKEDITOR.replace( textAreaName,	{
		extraPlugins : 'uicolor',
		uiColor: '#dfdff1'
	} ) ;
	var oCKeditor = CKEDITOR.instances[textAreaName];
</script>

<script>

function check4null(form)
{

        var isError = false;
        var errorMessage = "";
        // Here we decide whether to submit the form.
        if (trim(form.templatename.value) =='') {
                isError = true;
                errorMessage += "\n template name";
                form.templatename.focus();
        }
        if (trim(form.foldername.value) =='') {
                isError = true;
                errorMessage += "\n folder name";
                form.foldername.focus();
        }
        if (trim(form.subject.value) =='') {
                isError = true;
                errorMessage += "\n subject";
                form.subject.focus();
        }

        // Here we decide whether to submit the form.
        if (isError == true) {
                alert("<?php echo $this->_tpl_vars['APP']['MISSING_FIELDS']; ?>
" + errorMessage);
                return false;
        }
 return true;

}

init();

</script>