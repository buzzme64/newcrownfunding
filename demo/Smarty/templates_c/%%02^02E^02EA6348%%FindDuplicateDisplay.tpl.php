<?php /* Smarty version 2.6.18, created on 2013-12-10 12:06:33
         compiled from FindDuplicateDisplay.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'vtiger_imageurl', 'FindDuplicateDisplay.tpl', 23, false),array('modifier', 'vtlib_purify', 'FindDuplicateDisplay.tpl', 51, false),)), $this); ?>
<script language="JavaScript" type="text/javascript" src="include/js/ListView.js"></script>
<?php if ($this->_tpl_vars['MODULE'] == $_REQUEST['module']): ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				<div id="searchingUI" style="display:none;">
    				<table border=0 cellspacing=0 cellpadding=0 width=100%>
    					<tr>
    						<td align=center>
        						<img src="<?php echo vtiger_imageurl('searching.gif', $this->_tpl_vars['THEME']); ?>
" alt="<?php echo $this->_tpl_vars['APP']['LBL_SEARCHING']; ?>
"  title="<?php echo $this->_tpl_vars['APP']['LBL_SEARCHING']; ?>
">
        					</td>
    					</tr>
    				</table>
				</div>
    		</td>
		</tr>
	</table>
</td>
</tr>
</table>

<?php endif; ?>


<?php if ($this->_tpl_vars['MODULE'] == $_REQUEST['module']): ?>
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
     <tr>
        <td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopLeft.gif', $this->_tpl_vars['THEME']); ?>
"></td>

		<td class="showPanelBg" valign="top" width=100% style="padding:10px;">
<?php endif; ?>
			
					
			<div id="duplicate_ajax" style='margin: 0 10px;'>
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'FindDuplicateAjax.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			</div>
			<div id="current_action" style="display:none"><?php echo vtlib_purify($_REQUEST['action']); ?>
</div>
						
<?php if ($this->_tpl_vars['MODULE'] == $_REQUEST['module']): ?>
     	</td>
        <td valign=top><img src="<?php echo vtiger_imageurl('showPanelTopRight.gif', $this->_tpl_vars['THEME']); ?>
"></td>
   </tr>
</table>
<?php endif; ?>