<?php /* Smarty version 2.6.18, created on 2014-02-25 08:55:44
         compiled from DetailViewSearch.tpl */ ?>
<div id="searchAcc" style="display: block;position:relative;">
<table width="100%" cellpadding="5" cellspacing="0"  class="searchUIBasic small" align="center" border=0>
	<tr>
		<td class="searchUIName small" nowrap align="left">
			<span class="moduleName"><?php echo $this->_tpl_vars['MODULE']; ?>
</span>
		</td>
		<td class="small" nowrap align=right><b>Search for</b></td>
		<td class="small" style="text-align: center; width:125px;"><input type="text"  class="txtBox" style="width:120px;" name="search_text" id="search_text"></td>
		<td class="small" nowrap width=40% >
			<input name="submit" type="button" class="crmbutton small create" onClick="document.location.href='index.php?action=index&module=Leads&query=true&search=true&search_field=cf_641&search_text='+document.getElementById('search_text').value;" value=" Search Now ">&nbsp;
		</td>
		<td class="small" valign="top" onMouseOver="this.style.cursor='pointer';" onclick="moveMe('searchAcc');searchshowhide('searchAcc','advSearch')">[x]</td>
	</tr>
</table>
</div>
<div style="height:10px;">&nbsp;</div>