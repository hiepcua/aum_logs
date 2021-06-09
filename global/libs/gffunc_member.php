<?php
function isLogin(){
	if(isset($_SESSION['MEMBER_LOGIN']) && $_SESSION['MEMBER_LOGIN']['islogin']){
		/* $user=getInfo('username');
		if(checkExpires($user)===true) return false; */
		return true;
	}
	return false;
}
function getSessionLogin(){
	if(isset($_SESSION['MEMBER_LOGIN'])){
		return $_SESSION['MEMBER_LOGIN'];
	}
	return null;
}
function setSessionLogin($data){
	if(is_array($data)){ $_SESSION['MEMBER_LOGIN']=$data;}
	else {$_SESSION['MEMBER_LOGIN']=null;}
}
function getInfo($field){
	$info=isset($_SESSION['MEMBER_LOGIN'][$field])?$_SESSION['MEMBER_LOGIN'][$field]:'N/a';
	return $info;
}
function setInfo($field,$val){
	if(isset($_SESSION['MEMBER_LOGIN']))$_SESSION['MEMBER_LOGIN'][$field]=$val;
}
function checkExpires($user){
	// get session login
	$now=time();
	if(isset($_SESSION['MEMBER_LOGIN']) && $now-$_SESSION['MEMBER_LOGIN']['action_time']>=ACTION_TIMEOUT){
		$obj=new CLS_POSTGRES;
		$sql="SELECT session FROM aum_uid_login WHERE username='$user' AND isactive=1 ORDER BY id DESC";
		$obj->Query($sql);
		if($obj->Num_rows()>0){
			$r=$obj->Fetch_Assoc();
			if($_SESSION['MEMBER_LOGIN']['session']!=$r['session']){
				LogOut($user);
				return true;
			}
		}else{
			die('Check Expire error. Please contact administrator!');
		}
	}
	// check time out login
	if(isset($_SESSION['MEMBER_LOGIN']) && $now-$_SESSION['MEMBER_LOGIN']['action_time']>=MEMBER_TIMEOUT){
		LogOut();
	}
	return false;
}
function LogIn($user,$pass){
	$arr=array('status'=>'no','data'=>null);
	if($user==''||$pass=='')	return $arr;
	$fields=array();
	$obj=new CLS_POSTGRES;
	if(SysCount("aum_uid"," AND (username='$user' OR id='$user') AND isactive='yes'")!=1) return $arr;
	$r=SysGetList("aum_uid",$fields," AND (id='$user' OR username='$user') AND isactive='yes'");
	if($r[0]['password']!=$pass) return $arr;
	$arr['status'] = 'yes';
	$arr['data'] = $r[0];
	
	$user_id = $r[0]['id'];
	$rs = SysGetList("aum_staff",$fields," AND user_id='$user_id' ");
	$arr['data']['fullname'] = $rs[0]['fullname'];
	$arr['data']['birthday'] = $rs[0]['birthday'];
	$arr['data']['gender']   = $rs[0]['gender'];
	$arr['data']['address']  = $rs[0]['address'];
	$arr['data']['phone']    = $rs[0]['phone'];
	$arr['data']['email']    = $rs[0]['email'];
	$arr['data']['par_id']   = $rs[0]['par_id'];
	$arr['data']['path']     = $rs[0]['path'];
	
	return $arr;
}
function LogOut($user){
	if(isset($_SESSION['MEMBER_LOGIN'])){
		unset($_SESSION['MEMBER_LOGIN']);
		$sql="UPDATE aum_uid_login SET isactive=0 WHERE username='$user'";
		$obj=new CLS_POSTGRES;
		$obj->Exec($sql);
	}
}

// Generate token
function getToken($length){
  $token = "";
  $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
  $codeAlphabet.= "0123456789";
  $max = strlen($codeAlphabet); // edited

  for ($i=0; $i < $length; $i++) {
    $token .= $codeAlphabet[random_int(0, $max-1)];
  }

  return $token;
}