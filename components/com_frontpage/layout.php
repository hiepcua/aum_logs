<?php
if(!isLogin()){
$userCookie=isset($_COOKIE['LOGIN_USER'])?json_decode(decrypt($_COOKIE['LOGIN_USER']),true):array();
$user=isset($userCookie['username'])?$userCookie['username']:'';
$pass=isset($userCookie['password'])?$userCookie['password']:'';
$ischeck=isset($userCookie['ischeck']) && $userCookie['ischeck']=='yes'?'checked=true':'';
?>
<div class='col-sm-4'></div>
<div class='col-sm-4'>
	<div class='main-panel'>
		<div class='main'>
			<form id="frmlogin1" class='frm' method="post" action="<?php echo ROOTHOST;?>ajaxs/login/login_send.php">
				<h3 class='title text-center'>AUM ID</h3>
				<div class='err_mess cred text-center'></div>
				<div class='form'>
					<div class="form-group">
						<label class="control-label">Tài khoản</label>
						<input type='text' class='form-control' name='txt_user' id='txt_user' placeholder='Tài khoản' value='<?php echo $user;?>' required/>
					</div>
					<div class="form-group">
						<label class="control-label">Mật khẩu</label>
						<input type='password' class='form-control' name='txt_pas' id='txt_pas' placeholder='Mật khẩu' value='<?php echo $pass;?>' required/> 
					</div>
					<div class="form-group">
						<label class="custom-control-label"><input type="checkbox" class="custom-control-input" id="isConfirm" <?php echo $ischeck;?>> Nhớ tài khoản của tôi</a>.</label>
					</div>
					<div class='form-group'>
						<button type='submit' id='btn-process-login' class='btn btn-block btn-primary'>ĐĂNG NHẬP</button>
					</div>
					<div class='form-group text-center'>
						<a href='<?php echo ROOTHOST;?>forgot-password'>Quên mật khẩu?</a> 
					</div>
					<script>
						$(document).ready(function(){
							$('#frmlogin1').submit(function(){
								return checkinput();
							})
						});

						function checkinput(){
							var username = $("#txt_user").val();
							var password = $("#txt_pas").val();

							if(username=="" || username=="undefined") {
								return false;
							}if(password=="" || password=="undefined") {
								return false;
							}
							return true;
						}
					</script>
				</div>
			</form>
		</div>
	</div>
</div>
<div class='col-sm-4'></div>
<?php	
}else{
global $_curPrice;
$username=getInfo('username');
$usd_equity=0;
$num_partners=0;
$num_members=0;
$num_contacts=0;
$num_abc=0;

?>
<div class="col-md-12"><div class="row report_box">
	<div class="col-md-3 col-xs-6">
		<div class="box bgred">
			<div class="heading">Đối tác</div>
			<div class="content text-center">
				<div class="total"><?php echo number_format($num_partners,2);?></div>
				<div class="txt">Tổng tất cả đối tác</div>
			</div>
			<div class="more"><a href="#">Quản lý đối tác</a></div>
		</div>
	</div>
	<div class="col-md-3 col-xs-6">
		<div class="box bggreen">
			<div class="heading">Contacts</div>
			<div class="content text-center">
				<div class="col-xs-12">
					<div class="total"><?php echo number_format($num_contacts);?></div>
					<div class="txt">Tổng Contacts</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="more"><a href="javascript:void(0);">Quản lý Contacts tuyển sinh</a></div>
		</div>
	</div>
	<div class="col-md-3 col-xs-6">
		<div class="box bgorange">
			<div class="heading">Hồ sơ học viên</div>
			<div class="content text-center">
				<div class="total"><?php echo number_format($num_members);?></div>
				<div class="txt">Tổng số hồ sơ học viên</div>
			</div>
			<div class="more"><a href="<?php echo ROOTHOST;?>orders">Quản lý hồ sơ đăng ký</a></div>
		</div>
	</div>
	<div class="col-md-3 col-xs-6">
		<div class="box bgblue">
			<div class="heading">Công nợ</div>
			<div class="content text-center">
				<div class="total"><?php echo 0;?> đ</div>
				<div class="txt"><?php echo 0;?> Total backups</div>
			</div>
			<div class="more"><a href="#">Quản lý công nợ</a></div>
		</div>
	</div>
</div></div>
	
<?php
}
?>