<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->breadcrumbs = array(
	//'ทะเบียนลูกค้า' => array('index'),
	'ลงทะเบียนลูกค้า',
);
?>

<?php $this->renderPartial('_form', array('model' => $model, 'head' => 'ลงทะเบียนลูกค้า'));?>
<div class="modal fade" tabindex="-1" role="dialog" id="popupcheckpatient">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Check Patient</h4>
            </div>
            <div class="modal-body" style=" text-align: center;">
                <p style=" font-size: 25px;" id="font-th">ตรวจสอบรายชื่อให้แน่ใจว่าระบบไม่มีการลงทะเบียนลูกค้าไว้ในระบบแล้ว ที่เมนู "ค้นหาลูกค้า"</p>
                <a href="<?php echo Yii::app()->createUrl('patient/search') ?>"><button type="button" class="btn btn-primary"><i class="fa fa-search"></i> ค้นหาลูกค้า</button></a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    popupcheckpatient();
    function popupcheckpatient(){
        $("#popupcheckpatient").modal();
    }
</script>