<style type="text/css">
    .modal.large {
        width: 80%;
    }
</style>

<?php
/* @var $this ProductTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'คิวการรักษา / ตรวจร่างกาย',
);

$WebConfig = new Configweb_model();
?>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#seq" aria-controls="seq" role="tab" data-toggle="tab">คิวรอรับบริการ</a></li>
        <li role="presentation"><a href="#end" aria-controls="end" role="tab" data-toggle="tab" onclick="loadservicesuccess()">คิวที่ได้รับการบริการแล้ว</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="seq" style=" padding: 10px; border-top:0px;">
            <button type="button" class="btn btn-success" onclick="Addseq()"><i class="fa fa-plus"></i> เพิ่มคิว</button>
            <!--
            <button type="button" class="btn btn-default" onclick="AddseqFormAppoint()"><i class="fa fa-plus-circle"></i> เพิ่มคิวจากการนัด</button>
            -->
            <button type="button" class="btn btn-warning" onclick="loadtable()"><i class="fa fa-refresh"></i> </button>
            <div id="datas" style=" margin-top: 10px;"></div>
        </div>
        <div role="tabpanel" class="tab-pane" id="end" style=" padding: 10px; border-top:0px;">
            <button type="button" class="btn btn-warning" onclick="loadservicesuccess()"><i class="fa fa-refresh"></i> Refresh</button>
            <div id="servicesuccess" style=" margin-top: 10px;"></div>
        </div>
    </div>
</div>

<!--
    #### POPUP ADD SEQ ####
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popupaddseq" data-backdrop="static">
    <div class="modal-dialog modal-lg large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">จัดการคิว / ตรวจร่างกาย</h4>
            </div>
            <div class="modal-body" style=" margin: 0px; padding: 0px;">
                <div id="bodyaddseq">
                    <div class="row" style=" margin: 0px;">
                        <div class="col-md-4 col-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label>ชื่อลูกค้า *</label>
                                    <?php
                                    $this->widget(
                                            'booster.widgets.TbSelect2', array(
                                        'name' => 'patient',
                                        'id' => 'patient',
                                        'data' => CHtml::listData($PatientList, 'id', 'name'),
                                        'options' => array(
                                            'placeholder' => 'ลูกค้า',
                                            'width' => '100%',
                                            'allowClear' => true,
                                        ),
                                        'events' => array('change' => 'js:function(e)       
                                            { 
                                                Getpatient(this.value);
                                        }'),
                                            )
                                    );
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="detailpatient" style=" margin-top: 10px;"></div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-8 col-lg-8" style=" padding-bottom: 0px; border-left: #cccccc solid 1px;">
                            <label>ตรวจร่างกาย</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">น้ำหนัก *</div>
                                            <input type="text" class="form-control" id="weight">
                                            <div class="input-group-addon">กก.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">ส่วนสูง *</div>
                                            <input type="text" class="form-control" id="height">
                                            <div class="input-group-addon">ซม.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">อุณหภูมิร่างกาย *</div>
                                            <input type="text" class="form-control" id="btemp">
                                            <div class="input-group-addon">&#176;C</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">อัตราการเต้นชีพจร *</div>
                                            <input type="text" class="form-control" id="pr">
                                            <div class="input-group-addon">/m</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">อัตราการหายใจ *</div>
                                            <input type="text" class="form-control" id="rr">
                                            <div class="input-group-addon">/m</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">ความดันโลหิต *</div>
                                            <input type="text" class="form-control" id="ht">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">รอบเอว *</div>
                                            <input type="text" class="form-control" id="waistline">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    อาการที่มารักษา
                                    <textarea class=" form-control" id="cc" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row" style=" margin-top: 10px;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">วันที่ตรวจ</div>
                                            <input type="text" class="form-control" id="date_serv"  value="<?php echo date("Y-m-d") ?>" readonly="readonly">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style=" margin-top: 0px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="SaveAddseq()">บันทึกรายการ</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
    #### POPUP ADD SEQFORMAPPOINT ####
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popupaddseqformappoint">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">จัดการคิว</h4>
            </div>
            <div class="modal-body">
                <div id="bodyaddseq">
                    <input type="hidden" id="_appoint_id"/>
                    <div class="row">
                        <div class="col-lg-12">
                            ชื่อลูกค้า
                            <?php
                            $this->widget(
                                    'booster.widgets.TbSelect2', array(
                                'name' => '_patient',
                                'id' => '_patient',
                                'data' => CHtml::listData($PatientList, 'id', 'name'),
                                'options' => array(
                                    'placeholder' => 'ลูกค้า',
                                    'width' => '100%',
                                    'allowClear' => true,
                                )
                                    )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            อาการที่นัดรักษา
                            <textarea class=" form-control" id="_comment" readonly="readonly"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            วันที่นัดล่าสุด
                            <input type="text" class="form-control" id="_appoint" readonly="readonly"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="SaveAddseqFormAppoint()">บันทึกรายการ</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    function Addseq() {
        setscreen();
        Getpatient("");
        $("#patient").val("");
        $("#weight").val("");
        $("#height").val("");
        $("#btemp").val("");
        $("#pr").val("");
        $("#rr").val("");
        $("#ht").val("");
        $("#waistline").val("");
        $("#cc").val("");
        $("#popupaddseq").modal();
    }

    function SaveAddseq() {
        var url = "<?php echo Yii::app()->createUrl('queue/saveseq') ?>";
        var patient = $("#patient").val();
        //var comment = $("#comment").val();
        if (patient == "") {
            swal("แจ้งเตือน!", "ยังไม่ได้เลือกลูกค้า ...!", "warning");
            return false;
        }

        var weight = $("#weight").val();
        var height = $("#height").val();
        var btemp = $("#btemp").val();
        var pr = $("#pr").val();
        var rr = $("#rr").val();
        var ht = $("#ht").val();
        var waistline = $("#waistline").val();
        var cc = $("#cc").val();

        if (weight == "" || height == "" || btemp == "" || pr == "" || rr == "" || ht == "" || waistline == "") {
            swal("แจ้งเตือน!", " กรอกข้อมูลช่อง * ไม่ครบ ...!", "warning");
            return false;
        }
        var data = {
            patient: patient,
            //comment: comment,
            //Check Body 
            weight: weight,
            height: height,
            btemp: btemp,
            pr: pr,
            rr: rr,
            ht: ht,
            waistline: waistline,
            cc: cc
        };

        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

    function AddseqFormAppoint() {
        $("#_patient").val("");
        $("#popupaddseqformappoint").modal();
    }

    $(document).ready(function () {
        loadtable();
        $("#_patient").change(function () {
            var patient = this.value;
            var data = {patient: patient};
            var url = "<?php echo Yii::app()->createUrl('queue/getlastservice') ?>";
            $.post(url, data, function (datas) {
                $("#_appoint_id").val(datas.appoint_id);
                $("#_comment").val(datas.comment);
                $("#_appoint").val(datas.appoint);
                //$("#_type").val(datas.type);
            }, 'json');
        });

    });

    function SaveAddseqFormAppoint() {
        var url = "<?php echo Yii::app()->createUrl('queue/saveseqformappoint') ?>";
        var patient = $("#_patient").val();
        var comment = $("#_comment").val();
        var appoint_id = $("#_appoint_id").val();

        //CheckBody

        var data = {
            appoint_id: appoint_id,
            patient: patient,
            comment: comment

        };

        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

</script>

<script type="text/javascript">
    function savebody() {
        var url = "<?php echo Yii::app()->createUrl('checkbody/save') ?>";
        var patient_id = $("#patient").val();
        var weight = $("#weight").val();
        var height = $("#height").val();
        var btemp = $("#btemp").val();
        var pr = $("#pr").val();
        var rr = $("#rr").val();
        var ht = $("#ht").val();
        var waistline = $("#waistline").val();
        var cc = $("#cc").val();
        var data = {
            patient_id: patient_id,
            weight: weight,
            height: height,
            btemp: btemp,
            pr: pr,
            rr: rr,
            ht: ht,
            waistline: waistline,
            cc: cc
        };
        $.post(url, data, function (success) {
            window.location.reload();
        });
    }

    function loadtable() {
        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
        var data = {a: 1};
        $.post(url, data, function (datas) {
            $("#datas").html(datas);
        });
    }

    function loadservicesuccess() {
        var url = "<?php echo Yii::app()->createUrl('queue/getservicesuccess') ?>";
        var data = {a: 1};
        $.post(url, data, function (datas) {
            $("#servicesuccess").html(datas);
        });
    }

    function setscreen() {
        var h = window.innerHeight;
        var bodymodel = (h - 230);
        $("#bodyaddseq").css({'height': bodymodel, 'overflow': 'auto'});
    }

    function Getpatient(id) {
        var data = {id: id};
        var url = "<?php echo Yii::app()->createUrl('queue/getpatient') ?>";
        $.post(url, data, function (datas) {
            $("#detailpatient").html(datas);
        });
    }

    function linkdetail() {
        var patient_id = $("#patient").val();
        var url = "<?php echo Yii::app()->createUrl('patient/view') ?>" + "&id=" + patient_id;
        var win = window.open(url, '_blank');
        win.focus();

    }
</script>

