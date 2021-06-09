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
//$data	= json_decode(decrypt($json['data'],PIT_API_KEY),true);
$user=$data['username'];
$sig=$data['sig'];
if (hash_equals(hash('sha256', $user.APP_SECRET, APP_SECRET), $sig)){
	// check quyền truy cập
	// user là admin có quyền truy cập tất cả hệ thống
	// User không phải là admi thì mỗi một site có định danh group (G01, G02... Gn), user thuộc nhóm này mới có quyền truy cập. Mỗi một group sẽ có 1 hoặc nhiều site, tùy theo chức vụ, và site được gán mà user cũng sẽ có các quyền khác nhau
	/*
	L01 Trưởng phòng
	L02 Trưởng nhóm
	L03 nhân viên
	*/
	$data=array();
	$data['user']=$user;
	$data['permission']=>array(
		'G01'=>array('pos'=>'L01','site'=>array('site1','site2')),
		'G02'=>array('pos'=>'L02','site'=>array('site1','site2')),
		'G03'=>array('pos'=>'L03','site'=>array('site1','site2'))
	);
	$data['isadmin']='yes';
	$req=array('status'=>'yes','mess'=>'','data'=>$data);
}else{
	$req=array('status'=>'no','mess'=>'incorrectly');
}
echo json_encode($req);