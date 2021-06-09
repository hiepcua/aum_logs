<?php
session_start();
ini_set('display_errors',1);
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.postgre.php');
$json 	= json_decode(file_get_contents('php://input'),true); 
$data 	= json_decode(decrypt($json['data'],PIT_API_KEY),true);
$user=$data['user'];
$where=$data['where'];
if($user!=''){
	$data=SysCount('aum_uid'," $where");
	echo json_encode(array('status'=>'yes','data'=>$data));
}else{
	echo json_encode(array('status'=>'no','mess'=>'username is empty!'));
}

die();