<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once('Smarty_setup.php');

class ModComments_DetailViewBlockCommentWidget {
	private $_name = 'DetailViewBlockCommentWidget';
	
	private $defaultCriteria = 'Last7';
	
	protected $context = false;
	protected $criteria= false;
	
	function __construct() {
	}
	
	function getFromContext($key, $purify=false) {
		if ($this->context) {
			$value = $this->context[$key];
			if ($purify && !empty($value)) {
				$value = vtlib_purify($value);
			}
			return $value;
		}
		return false;
	}
	
	function title() {
		return getTranslatedString('LBL_MODCOMMENTS_INFORMATION', 'ModComments');
	}
	
	function name() {
		return $this->_name;
	}
	
	function uikey() {
		return "ModCommentsDetailViewBlockCommentWidget";
	}
	
	function setCriteria($newCriteria) {
		$this->criteria = $newCriteria;
	}
	
	function getViewer() {
		global $theme, $app_strings, $current_language, $currentModule;
		
		$smarty = new vtigerCRM_Smarty();
		$smarty->assign('APP', $app_strings);
		$lang = return_module_language($current_language,'ModComments');
		if ($currentModule=="Leads") $lang['LBL_ADD_COMMENT']="Add Notes";
		$smarty->assign('MOD', $lang);
		$smarty->assign('THEME', $theme);
		$smarty->assign('IMAGE_PATH', "themes/$theme/images/");
		
		$smarty->assign('UIKEY', $this->uikey());
		if ($currentModule=="Leads") $smarty->assign('WIDGET_TITLE', "Notes");
		else $smarty->assign('WIDGET_TITLE', $this->title());
		$smarty->assign('WIDGET_NAME', $this->name());
		$smarty->assign("MODULE",$currentModule);
		
		return $smarty;
	}
	
	protected function getModels($parentRecordId, $criteria) {
		global $adb, $current_user;

		$moduleName = 'ModComments';
		if(vtlib_isModuleActive($moduleName)) {
			$entityInstance = CRMEntity::getInstance($moduleName);
			
			$queryCriteria  = '';
			switch($criteria) {
				case 'All': $queryCriteria = sprintf(" ORDER BY %s.%s DESC ", $entityInstance->table_name, $entityInstance->table_index); break;
				case 'Last7': $queryCriteria =  sprintf(" ORDER BY %s.%s DESC LIMIT 7", $entityInstance->table_name, $entityInstance->table_index) ;break;
				case 'Mine': $queryCriteria = ' AND vtiger_crmentity.smownerid=' . $current_user->id.sprintf(" ORDER BY %s.%s DESC ", $entityInstance->table_name, $entityInstance->table_index); break;
			}
			
			$query = $entityInstance->getListQuery($moduleName, sprintf(" AND %s.related_to=?", $entityInstance->table_name));
			$query .= $queryCriteria;
			$result = $adb->pquery($query, array($parentRecordId));
		
			$instances = array();
			if($adb->num_rows($result)) {
				while($resultrow = $adb->fetch_array($result)) {
					$instances[] = new ModComments_CommentsModel($resultrow);
				}
			}
		}
		return $instances;
	}
	
	function processItem($model) {
		$viewer = $this->getViewer();
		$viewer->assign('COMMENTMODEL', $model);
		return $viewer->fetch(vtlib_getModuleTemplate("ModComments","widgets/DetailViewBlockCommentItem.tpl"));
	}
	
	function process($context = false) {
		$this->context = $context;
		$sourceRecordId =  $this->getFromContext('ID', true);
		$usecriteria = ($this->criteria === false)? $this->defaultCriteria : $this->criteria;
		
		$viewer = $this->getViewer();
		$viewer->assign('ID', $sourceRecordId);
		$viewer->assign('CRITERIA', $usecriteria);
		
		$viewer->assign('COMMENTS', $this->getModels($sourceRecordId, $usecriteria) );
		
		return $viewer->fetch(vtlib_getModuleTemplate("ModComments","widgets/DetailViewBlockComment.tpl"));
	}
	
}