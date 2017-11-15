<?php
function getphoneonlynumber($phone){
	$newphone="";
	for ($i=0;$i<strlen($phone);$i++){
		$char=substr($phone,$i,1);
		if (preg_match ("/[0-9]{1}/", $char) ) $newphone.=$char;
	}
	return $newphone;
}

function updatephone($phone,$leadid){
	$upd=array();
	foreach($phone as $key=>$value){
		$upd[]= $key." = '". getphoneonlynumber($value)."'";
	}
	if (count($upd)>0)
		$res=  mysql_query("update vtiger_leadscf set ".implode(", ", $upd)." where leadid='".$leadid."'");
}

function listhponefield($request){
	$phonefield=array(
		"cf_648"=>"phonecf_648",
		"cf_665"=>"phonecf_665",
		"cf_666"=>"phonecf_666",
		"cf_675"=>"phonecf_675",
		"cf_676"=>"phonecf_676",
		"cf_687"=>"phonecf_687",
		"cf_688"=>"phonecf_688",
		"cf_689"=>"phonecf_689",
		"cf_692"=>"phonecf_692"
	);
	$ret=array();
	foreach ($phonefield as $key=>$value){
		if (isset($request[$key]) && $request[$key]!="") $ret[ $value ] = $request[$key];
	}
	return $ret;
}
?>