{*<!--

/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

-->*}

{assign var="fromlink" value=""}

<!-- Added this file to display the fields in Create Entity page based on ui types  -->
{foreach key=label item=subdata from=$data}
	{if $header eq 'Product Details'}
		<tr>
	{elseif $MODULE == 'Leads'}
		{if $header == 'Description Information'}
			<tr style="display: none;" id="rowdescription">
		{elseif $header == 'Contract Out' || $header == 'Funded'}
			<tr style="display: none;" id="{$idrow}{$i}">
		{else}
			<tr style="height:25px">
		{/if}
		{assign var=i value=$i+1}
	{else}
		<tr style="height:25px">
	{/if}
	{foreach key=mainlabel item=maindata from=$subdata}
		{include file='EditViewUI.tpl'}
	{/foreach}
   </tr>
{/foreach}
