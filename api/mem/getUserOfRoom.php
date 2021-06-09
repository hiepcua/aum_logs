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
$page=isset($data['page']) && intval($data['page'])>=1?intval($data['page']):1;
$maxrow=$data['maxrow'];
$where=$data['where'];
$start=((int)$page-1)*$maxrow;

$data=SysGetList('aum_uid',array()," $where LIMIT $maxrow OFFSET $start");
echo json_encode(array('status'=>'yes','page'=>$page,'data'=>$data));

die();