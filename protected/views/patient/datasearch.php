
<?php
$webconfig = new Configweb_model();
if ($patient) {
	?>
<div class="row">
    <?php foreach ($patient as $rs): ?>
    <div class="col-lg-6 col-mf-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 style="color:yellow;">เลข HN <?php echo $rs['cn'] ?>
                    <a href="javascript:updateCn('<?php echo $rs['id'] ?>')" class="pull-right"><i class="fa fa-pencil"></i> แก้ไขเลข HN</a>
                </h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                        <?php if ($rs['images']) {?>
                        <img src="<?php echo Yii::app()->baseUrl ?>/uploads/profile/<?php echo $rs['images'] ?>" style=" max-height: 180px;" class="img-responsive"/>
                        <?php } else {?>
                        <img src="<?php echo Yii::app()->baseUrl ?>/images/No_image.jpg" style=" max-height: 180px;" class="img-responsive"/>
                        <?php }?>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                        <div class="list-group">
                            <div class="list-group-item"><label>ชื่อ - สกุล :</label> <?php echo $rs['name'] . ' ' . $rs['lname'] ?></div>
                            <div class="list-group-item"><label>สาขาลงทะเบียน :</label> <?php echo $rs['branchname'] ?></div>
                            <div class="list-group-item"><label>อายุ :</label> <?php echo ($rs['birth']) ? $webconfig->get_age($rs['birth']) . " ปี " : "-"; ?></div>
                            <div class="list-group-item"><label>ประเภท :</label> <?php echo $rs['grad'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <a href="<?php echo Yii::app()->createUrl('patient/view', array("id" => $rs['id'])) ?>" target="_blank">
                    <button type="button" class="btn btn-success"><i class="fa fa-search"></i> ดูข้อมูล</button></a>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>
<?php } else {?>
    <center><h2>ไม่พบข้อมูล ...! </h2></center>
<?php }?>

<!--
//แก้ไข CN
-->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" id="popupupdateCn">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">แก้ไขเลข HN</h4>
      </div>
      <div class="modal-body">
        <p style="color:red;">*เลข HN ไม่สามารถซ้ำในระบบได้</p>
        <input type="hidden" name="patientidupdate" id="patientidupdate">
        <label>HN ใหม่</label>
        <input type="text" name="cn_new" id="cn_new" class="form-control" maxlength="6" onKeyUp="if(this.value*1!=this.value) this.value='' ;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveUpdateCn()">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>

<script type="text/javascript">
    function updateCn(id){
        $("#patientidupdate").val(id);
        $("#popupupdateCn").modal();
    }

    function saveUpdateCn(){
         var id = $("#patientidupdate").val();
         var cn_new = $("#cn_new").val();
         if(cn_new == ""){
            alert("กรุณากรอกเลข CN ใหม่");
            return false;
         }

         if(cn_new.length < 6){
            alert("เลข CN ต้องประกอบด้วยตัวเลข 6 ตัวเท่านั้น ...!");
            return false;
         }

         var url = "<?php echo Yii::app()->createUrl('patient/updatecn') ?>";
         var data = {id: id,cn: cn_new};
         $.post(url,data,function(datas){
            alert(datas);
            if(datas == 1){
                alert("มีเลข CN ในระบบแล้วไม่สามารถแก้ไขได้");
                return false;
            } else {
                $("#popupupdateCn").modal('hide');
                $('.modal-backdrop').hide();
                getdata();
            }

         });
    }
</script>


