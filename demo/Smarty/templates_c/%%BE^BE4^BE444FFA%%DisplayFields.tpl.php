<?php /* Smarty version 2.6.18, created on 2013-10-21 03:16:15
         compiled from DisplayFields.tpl */ ?>

<?php $this->assign('fromlink', ""); ?>

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['subdata']):
?>
	<?php if ($this->_tpl_vars['header'] == 'Product Details'): ?>
		<tr>
	<?php elseif ($this->_tpl_vars['MODULE'] == 'Leads'): ?>
		<?php if ($this->_tpl_vars['header'] == 'Description Information'): ?>
			<tr style="display: none;" id="rowdescription">
		<?php elseif ($this->_tpl_vars['header'] == 'Contract Out' || $this->_tpl_vars['header'] == 'Funded'): ?>
			<tr style="display: none;" id="<?php echo $this->_tpl_vars['idrow']; ?>
<?php echo $this->_tpl_vars['i']; ?>
">
		<?php else: ?>
			<tr style="height:25px">
		<?php endif; ?>
		<?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
	<?php else: ?>
		<tr style="height:25px">
	<?php endif; ?>
	<?php $_from = $this->_tpl_vars['subdata']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['mainlabel'] => $this->_tpl_vars['maindata']):
?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'EditViewUI.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php endforeach; endif; unset($_from); ?>
   </tr>
<?php endforeach; endif; unset($_from); ?>