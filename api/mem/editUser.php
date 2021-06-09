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

$arr=array();
$username=antiData($data['username']);
$arr['g_code']=antiData($data['g_code']);
$arr['p_code']=antiData($data['p_code']);
$arr['permiss']=antiData($data['permiss']);

if($username!=''){
	SysEdit('aum_uid',$arr," username='$username'");
	echo json_encode(array('status'=>'yes','mess'=>'create user success'));
}else{
	echo json_encode(array('status'=>'no','mess'=>'uid or username is empty!'));
}

die();