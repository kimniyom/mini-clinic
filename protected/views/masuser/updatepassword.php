<style type="text/css">
	.form-control{
        background: #111111;
    }
    .row{
        margin-top: 10px !important;
    }

    .select2-container {
        background-color: #111111 !important;
        border-radius: 5px;
    }
    .select2-drop{
        background-color: #111111 !important;
        border-color: #333333;
        color:#666666;
    }
    .select2-search input {
        background-color: #222222 !important;
        border:none;
    }
    .select2-choice { background-color: #111111 !important; border-color:#222222 !important; height: 40px !important;}
    .select2-search { background-color: #111111 !important; margin-top: 10px;}
    .select2-arrow {
        border-left: 0px solid transparent !important;
        /* 2 */
    }
</style>
<?php
/* @var $this MasuserController */
/* @var $model Masuser */

$this->breadcrumbs = array(
    'แก้ไขรหัสผ่าน',
);
?>

<h4><i class="fa fa-lock"></i> แก้ไข username password</h4>
<hr/>
<div class="row" style="margin:0px;">
	<div class="col-md-2 col-lg-2">
		<i class="fa fa-user"></i> ผู้ใช้งาน:
	</div>
	<div class="col-md-6 col-lg-6">
		<input type="text" name="username" class="form-control" id="username" value="<?php echo $model['username'] ?>" />
	</div>
</div>
<div class="row" style="margin:0px;">
	<div class="col-md-2 col-lg-2">
		<i class="fa fa-key"></i> รหัสผ่านเดิม:
	</div>
	<div class="col-md-6 col-lg-6">
		<input type="password" name="password" class="form-control" id="password"/>
	</div>
</div>
<hr/>
<div class="row" style="margin:0px;">
	<div class="col-md-2 col-lg-2">
		<i class="fa fa-key"></i> รหัสผ่านใหม่:
	</div>
	<div class="col-md-6 col-lg-6">
		<input type="password" name="newpassword" class="form-control" id="newpassword"/>
	</div>
</div>
<hr/>
<div class="row" style="margin:0px;">
	<div class="col-md-2 col-lg-2">

	</div>
	<div class="col-md-6 col-lg-6">
		<button type="button" class="btn btn-success" onclick="resetpassword()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
	</div>
</div>

<script type="text/javascript">
	function resetpassword(){
		var url = "<?php echo Yii::app()->createUrl('masuser/resetpassword') ?>";
		var passwordold = "<?php echo $model['password'] ?>";
		var username = $("#username").val();
		var checkpassword = $("#password").val();
		var newpassword = $("#newpassword").val();
		var userid = "<?php echo $model['user_id'] ?>";
		if(username == "" || checkpassword == "" || newpassword == ""){
			alert("กรอกข้อมูลไม่ครบ");
			return false;
		}
		var data = {passwordold: passwordold,checkpassword: checkpassword,newpassword: newpassword,userid: userid,username: username};
		$.post(url,data,function(datas){
			if(datas == "0"){
				alert("รหัสผ่านไม่ถูกต้อง");
				return false;
			} else {
				alert("แก้ไขรหัสผ่านแล้วกรุณาเข้าสู่ระบบใหม่ ...");
				window.location="<?php echo Yii::app()->createUrl('site/logout') ?>";
			}
		});
	}
</script>

