<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once('modules/com_vtiger_workflow/VTEntityCache.inc');
require_once('modules/com_vtiger_workflow/VTWorkflowUtils.php');
require_once('modules/com_vtiger_workflow/VTEmailRecipientsTemplate.inc');
require_once('modules/Emails/mail.php');
require_once('include/MPDF/mpdf.php');
class VTEmailTask extends VTTask{
	// Sending email takes more time, this should be handled via queue all the time.
	public $executeImmediately = false;

	public function getFieldNames(){
		return array("subject", "content", "recepient", 'emailcc', 'emailbcc');
	}
	public function doTask($entity){//print_r($this);
		global $adb, $current_user;

		$util = new VTWorkflowUtils();
		$result = $adb->query("select user_name, email1, email2 from vtiger_users where id=1");
		$from_email = $adb->query_result($result,0,'email1');
		$from_name  = $adb->query_result($result,0,'user_name');

		$admin = $util->adminUser();
		$module = $entity->getModuleName();

		$entityCache = new VTEntityCache($admin);

		$et = new VTEmailRecipientsTemplate($this->recepient);
		$to_email = $et->render($entityCache, $entity->getId());
		$ecct = new VTEmailRecipientsTemplate($this->emailcc);
		$cc = $ecct->render($entityCache, $entity->getId());
		$ebcct = new VTEmailRecipientsTemplate($this->emailbcc);
		$bcc = $ebcct->render($entityCache, $entity->getId());
		if(strlen(trim($to_email, " \t\n,")) == 0 && strlen(trim($cc, " \t\n,")) == 0 &&
				strlen(trim($bcc, " \t\n,")) == 0) {
			return ;
		}

		$st = new VTSimpleTemplate($this->subject);
		$subject = $st->render($entityCache, $entity->getId());
		$ct = new VTSimpleTemplate($this->content);
		$content = $ct->render($entityCache, $entity->getId());

		$filename="";
		
		if (isset($this->usepdf) && $this->usepdf==1){
			//$html="<html><body>".returndata($_REQUEST['record'],$_REQUEST['type'],$_REQUEST['level'])."</body></html>";
			/*$p=print_r($entity,true);
			$fp=  fopen('/home/maxadvance/gamlicity.com/powerline/modules/com_vtiger_workflow/tasks/qwerty.txt', 'w');
			fwrite($fp, $p);
			fclose($fp);*/
			extract($entity->data, EXTR_OVERWRITE);
			$useridarray=  explode("x", $assigned_user_id);
			$res=  mysql_query("select phone_work assignedphone, phone_fax assignedfax, email1 assignedemail, concat(last_name,' ',first_name) assignedusername from vtiger_users where id='".$useridarray[1]."'");
			while($row=  mysql_fetch_array($res,MYSQL_ASSOC)){
				$assignedphone=$row['assignedphone'];
				$assignedfax=$row['assignedfax'];
				$assignedemail=$row['assignedemail'];
				$assignedusername=$row['assignedusername'];
			}
			if ($assignedphone=="") $assignedphone="877-812-5812";
			if ($assignedfax=="") $assignedfax="404-400-1270";
			if ($assignedemail=="") $assignedemail="info@powerlinefunding.com";
			require_once('include/MPDF/pdftemplate.php');
			$mpdf = new mPDF('utf-8', 'A4', '8', '', 20, 10, 7, 7, 10, 10);
			$mpdf->charset_in = 'utf-8';
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->WriteHTML($html);
			//$filename=$_SERVER['DOCUMENT_ROOT']."/tmp.pdf";
			$filename = dirname(dirname(dirname(__DIR__)))."/include/MPDF/application.pdf";
			if (file_exists($filename)) unlink ($filename);
			$mpdf->Output($filename);
			$idarray=  explode("x", $id);
			//$query="update vtiger_leaddetails set leadstatus='2. App Out' where leadid='".$idarray[1]."'";
			//echo $query;
			$res=  mysql_query($query);
			//send_mail($module,$to_email,$from_name,$from_email,$subject,$content, $cc, $bcc,'','','',$filename);
		}
		if (isset($this->sendcontract) && $this->sendcontract==1){
			if ($filename=="")
				$filename = dirname(dirname(dirname(__DIR__)))."/include/MPDF/contract.pdf";
			else{
				$filename = array($filename,dirname(dirname(dirname(__DIR__)))."/include/MPDF/contract.pdf");
			}
		}
		//}else
			//send_mail($module,$to_email,$from_name,$from_email,$subject,$content, $cc, $bcc);
		send_mail($module,$to_email,$from_name,$from_email,$subject,$content, $cc, $bcc,'','','',$filename);

		$util->revertUser();
	}
}
?>