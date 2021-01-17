<?php
/* @var $this PromotionprocedureregisterController */
/* @var $model Promotionprocedureregister */

$this->breadcrumbs = array(
    'รายชื่อลูกค้าที่ลงทะเบียนโปรโมชั่น' => array('index'),
    'เพิ่ม',
);
?>
<h4>ลงทะเบียนโปรโมชั่น</h4>
<div class="panel panel-default">
    <div class="panel-heading">ลงทะเบียน</div>
    <div class="panel-body">
        <div class="row" style=" margin: 0px;">
            <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                <input type="radio" name="type" value="0" onclick="getcombopromotion()"/> โปรทั่วไป
                <input type="radio" name="type" value="1" checked="checked" onclick="getcombopromotion()"/> โปรประจำเดือน
                <div id="combopromotion" style=" margin-top: 10px;"></div>
                <hr/>
                <div id="detailpromotion"></div>
            </div>
            <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12">
                <div class="well">
                    <label>เลือกลูกค้า</label>
                    <div class="row" style=" margin: 0px;">
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <input type="hidden" id="pid"/>
                            <input type="text" id="name" class="form-control" placeholder="ชื่อ"/>
                        </div>
                        <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                            <input type="text" id="lname" class="form-control" placeholder="นามสกุล"/>
                        </div>
                        <div class="row" style=" margin: 0px;">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12" style=" margin-top: 10px;">
                                <button type="button" class="btn btn-default" onclick="searchpatient()"><i class="fa fa-search"></i> ค้นหา</button>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div id="patient"></div>
                </div>
            </div>
        </div>
        <hr/>
        อื่น ๆ
        <textarea class="form-control" id="etc" rows="5" placeholder="Comment..."></textarea>
    </div>
    <div class="panel-footer">
        <button type="button" class="btn btn-success" onclick="Saveregister()">บันทึกข้อมูล</button>
        <button type="button" class="btn btn-danger" onclick="window.location.reload();">ยกเลิก</button>
    </div>
</div>

<!--
POPUP patient 
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popuppatient" data-backdrop="static">
    <div class="modal-dialog modal-lg large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ข้อมูลลูกค้า</h4>
            </div>
            <div class="modal-body" style=" margin: 0px;">
                <div id="popupbodypatient"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    getcombopromotion();
    function getcombopromotion(){
         var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/getpromotions') ?>";
         var type = $('input[name=type]:checked').val();
         var data = {type: type};
         $.post(url, data, function (datas) {
            $("#combopromotion").html(datas);
            getpromotion();
        });
    }
    function searchpatient() {
        var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/searchpatient') ?>";
        var name = $("#name").val();
        var lname = $("#lname").val();
        var data = {name: name, lname: lname};
        if (name == "" && lname == "") {
            alert("กรุณากรอกอย่างน้อย  1 ช่อง...");
            return false;
        }
        $("#patient").html("<center>กำลังประมวลผล ...</center>");
        $.post(url, data, function (datas) {
            $("#popuppatient").modal();
            $("#popupbodypatient").html(datas);
            $("#patient").html("");
        });
    }

    function selectPatient(pid) {
        $("#pid").val(pid);
        var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/patient') ?>";
        var data = {pid: pid};
        $.post(url, data, function (datas) {
            $("#patient").html(datas);
            $("#popuppatient").modal("hide");
            $("#name").val("");
            $("#lname").val("");
        });
    }

    function getpromotion() {
        var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/getpromotion') ?>";
        var id = $("#promotion").val();
        var data = {id: id};
        $.post(url, data, function (datas) {
            $("#detailpromotion").html(datas);
        });
    }

    function Saveregister() {
        var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/save') ?>";
        var promotion = $("#promotion").val();
        var pid = $("#pid").val();
        var comment = $("#comment").val();
        var urlredir;
        if (promotion == "" || pid == "") {
            alert("เลือกข้อมูลไม่ครบ ...");
            return false;
        }

        var data = {promotion: promotion, pid: pid, comment: comment};
        $.post(url, data, function (datas) {
            if (datas == "0") {
                urlredir = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/index') ?>";
                window.location = urlredir;
            } else {
                alert("ลูกค้าท่านนี้ได้ลงทะเบียนโปรโมชั่นรายการนี้แล้วไม่สามารถลงซ้ำได้ ...");
                return false;
            }
        });
    }
</script>