<title>ทะเบียนลูกค้า</title>
<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'ค้นหาข้อมูลลูกค้า',
);

$system = new Configweb_model();
$branchModel = new Branch();
$typeModel = new Gradcustomer();
?>

<div class="panel panel-default" style=" margin-bottom: 0px;">
    <div class="panel-heading">
        <div class="row" style=" margin: 0px;">
            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-6">
                <label>เลข HN</label>
                <input type="text" id="cn" class="form-control input-lg" maxlength="6" placeholder="เลข HN 6 หลัก" onKeyUp="if(this.value*1!=this.value) this.value='' ;" />
            </div>
            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-6">
                <label>ชื่อ</label>
                <input type="text" id="name" class="form-control input-lg" placeholder="ชื่อบางตัวหรือทุกตัว"/>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-5 col-xs-6">
                <label>นามสกุล</label>
                <input type="text" id="lname" class="form-control input-lg" placeholder="บางตัวหรือทุกตัว"/>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-4">
                <button type="button" class="btn btn-primary btn-block btn-lg" onclick="getdata()" style=" margin-top: 25px;"><i class="fa fa-search"></i> ค้นหา</button>
            </div>
        </div>
    </div>
    <div class="panel-body" id="bodypanel">
        <div id="showdata" style=" margin-top: 10px;"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        setbodypanel();
    });
    $(document).keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            getdata();
        }
    });
    function setbodypanel(){
        var w = window.innerWidth;
        var h = window.innerHeight;
        var hbody = h -202;
        if(w >= 768){
            $("#bodypanel").css({"height":hbody,"overflow":"auto"});
        }
    }
    function getdata() {
        var loading = '<i class="fa fa-spinner fa-spin fa-fw"></i> กำลังค้นหาข้อมูล';
        var cn = $("#cn").val();
        var name = $("#name").val();
        var lname = $("#lname").val();
        var url = "<?php echo Yii::app()->createUrl('patient/datasearch') ?>";
        if(cn == "" && name == "" && lname == ""){
            alert("เลือกอย่างน้อย 1 เงื่อนไข");
            return false;
        } else {
            $("#showdata").html(loading);
            var data = {cn: cn, name: name,lname: lname};
            $.post(url, data, function (datas) {
                $("#showdata").html(datas);
            });
        }
    }

</script>



