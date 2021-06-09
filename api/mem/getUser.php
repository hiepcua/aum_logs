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
$key	= isset($data['key']) ? antiData($data['key']) : '';
$page	= isset($data['page']) && intval($data['page'])>=1?intval($data['page']):'';
$maxrow = isset($data['maxrow']) ? intval($data['maxrow']) : 0;
$g_code	= isset($data['g_code']) ? antiData($data['g_code']) : '';
$p_code	= isset($data['p_code']) ? antiData($data['p_code']) : '';
$start	= ((int)$page-1)*$maxrow;

$limit  = $where = '';
if($g_code != '') $where .= " AND g_code='$g_code'";
if($p_code != '') $where .= " AND p_code='$p_code'";
if($page > 0 && maxrow > 0) {
	$limit = "LIMIT $maxrow OFFSET $start";
}
$data = array();
if($key==PIT_API_KEY){
	$data = SysGetList('aum_uid',array()," $where $limit");
	$ids = ''; $arr = array();
	foreach($data as $r) {
		$id = $r['id'];
		$ids .= $id."','";
		$arr["$id"] = $r;
	}
	if($ids!='') $ids = substr($ids,0,strlen($ids)-3);
	$staff = SysGetList('aum_staff',array()," AND user_id IN ('$ids')");
	foreach($staff as $r) {
		$id = $r['user_id'];
		$arr["$id"]["fullname"] = $r['fullname'];
		$arr["$id"]["birthday"] = $r['birthday'];
		$arr["$id"]["gender"] 	= $r['gender'];
		$arr["$id"]["address"] 	= $r['address'];
		$arr["$id"]["phone"] 	= $r['phone'];
		$arr["$id"]["email"] 	= $r['email'];
		$arr["$id"]["par_id"] 	= $r['par_id'];
		$arr["$id"]["path"] 	= $r['path'];
	}
	
	echo json_encode(array('status'=>'yes','page'=>$page,'maxrow'=>$maxrow,'data'=>$arr));
}else{
	echo json_encode(array('status'=>'no','data'=>"Key fail"));
}
die();