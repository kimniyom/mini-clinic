<style type="text/css">
    .modal .large {
        width: 90%;
    }

    #cc_detail{
        background: #111111;
    }
    #date_serv{
        border-color: #333333;
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
<div class="row" style="margin:0px;">
    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12" style=" padding: 0px;">
        <div class="panel panel-default" style="margin-bottom:0px;">
            <div class="panel-heading">
                คิวรอรับบริการ
                <button type="button" class="btn btn-success btn-sm" onclick="Addseq()"><i class="fa fa-plus"></i> เพิ่มคิว</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="loadtable()"><i class="fa fa-refresh"></i> </button>
            </div>
            <div class="panel-body" style="padding-top:0px;" id="seqemployee">
                <div id="resultseqemployee"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12" style=" padding: 0px;">
        <div class="panel panel-default" style="margin-bottom:0px;">
            <div class="panel-heading">
                คิวรอรับยา / สินค้า
                <button type="button" class="btn btn-warning btn-sm" onclick="loadservicesuccess()"><i class="fa fa-refresh"></i> Refresh</button>
            </div>
            <div class="panel-body" style="padding-top:0px;" id="seqsuccess">
                <div id="servicesuccess" style=" margin-top: 10px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12" style=" padding: 0px;">
        <div class="panel panel-default" style="margin-bottom:0px;">
            <div class="panel-heading">
                <i class="fa fa-user-md"></i> คิวห้องตรวจ
                <button type="button" class="btn btn-warning btn-sm" onclick="ReautoloadseqDoctor()"><i class="fa fa-refresh"></i> Refresh</button>
            </div>
            <div class="panel-body" style="padding-top:0px;" id="seqdoctor">
                <div id="resultservice" style=" margin-top: 10px;"></div>
            </div>
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
            <div class="modal-body" style=" margin: 0px; padding: 0px;" id="conten-body-seq">
                <div id="bodyaddseq">
                    <div class="row" style=" margin: 0px;">
                        <div class="col-md-4 col-lg-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" class="form-control" id="patient">
                                    <div class="btn btn-default btn-block btn-lg" onclick="popupsearchpatient()" style=" margin-top: 10px;">เลือกลูกค้า <i class="fa fa-search"></i></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="hidden" id="promotion"/>
                                    <div id="detailpatient" class="well" style=" margin-top: 10px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8 col-lg-8" style=" padding-bottom: 0px; padding-top: 10px;" id="seqright">
                            <b><i class="fa fa-male"></i> ตรวจร่างกาย / ซักประวัติ</b><br/><br/>
                            <div class="alert alert-danger">เครื่องหมาย * ห้ามว่าง</div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">น้ำหนัก </div>
                                            <input type="text" class="form-control" id="weight" onKeyUp="if (this.value * 1 != this.value)
                                                        this.value = '';">
                                            <div class="input-group-addon">กก.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">ส่วนสูง </div>
                                            <input type="text" class="form-control" id="height" onKeyUp="if (this.value * 1 != this.value)
                                                        this.value = '';">
                                            <div class="input-group-addon">ซม.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">อุณหภูมิร่างกาย</div>
                                                <input type="text" class="form-control" id="btemp" onKeyUp="if (this.value * 1 != this.value)
                                                            this.value = '';">
                                                <div class="input-group-addon">&#176;C</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">อัตราการเต้นชีพจร</div>
                                                <input type="text" class="form-control" id="pr" onKeyUp="if (this.value * 1 != this.value)
                                                            this.value = '';">
                                                <div class="input-group-addon">/m</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">อัตราการหายใจ</div>
                                                <input type="text" class="form-control" id="rr" onKeyUp="if (this.value * 1 != this.value)
                                                            this.value = '';">
                                                <div class="input-group-addon">/m</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">ความดันโลหิต</div>
                                                <input type="text" class="form-control" id="ht"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">รอบเอว</div>
                                                <input type="text" class="form-control" id="waistline" onKeyUp="if (this.value * 1 != this.value)
                                                            this.value = '';">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style=" margin-top: 20px;">
                                <div class="col-lg-12">
                                    <b style=" font-size: 16px; color: #cc6600;"><i class="fa fa-frown-o"></i> อาการที่มารักษา <span style="color:red;">*</span></b>
                                    <textarea class="form-control" name="cc_detail" id="cc_detail" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="row" style=" margin-top: 10px;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i> วันที่ตรวจ</div>
                                            <!--
                                            <input type="text" class="form-control" id="date_serv"  value="<?php //echo date("Y-m-d")                                             ?>" readonly="readonly">-->

                                            <?php
                                            $this->widget(
                                                    'booster.widgets.TbDatePicker', array(
                                                //'model' => $model,
                                                //'attribute' => 'birth',
                                                'name' => 'date_serv',
                                                'id' => 'date_serv',
                                                'value' => date("Y-m-d"),
                                                'options' => array(
                                                    'language' => 'th',
                                                    'type' => 'date',
                                                    'format' => 'yyyy-mm-dd',
                                                    'autoclose' => true,
                                                ),
                                                    )
                                            );
                                            ?>
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
    Search patient
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popupsearchpatient" data-backdrop="static" style=" margin-bottom: 0px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ค้นหาลูกค้า</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-12">
                        <label>รหัส</label>
                        <input type="text" id="pid" class="form-control" maxlength="10" placeholder="รหัส CN 6 หลัก" onKeyUp="if (this.value * 1 != this.value)
                                    this.value = '';" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <label>ชื่อ</label>
                        <input type="text" id="name" class="form-control" placeholder="ชื่อบางตัวหรือทุกตัว"/>
                    </div>
                    <div class="col-lg-5">
                        <label>นามสกุล</label>
                        <input type="text" id="lname" class="form-control" placeholder="นามสุลบางตัวหรือทุกตัว"/>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-warning btn-block" onclick="getdata()" style=" margin-top: 25px;"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <hr/>
                <div id="showdatapatient"></div>
            </div>
            <!--
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="popup-detail-patient" data-backdrop="static" style=" margin-bottom: 0px;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ค้นหาลูกค้า</h4>
            </div>
            <div class="modal-body">
                <div id="box-detail-patient"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        loadtable();
        loadservicesuccess();
        loadseqdoctor();
        $("#_patient").change(function() {
            var patient = this.value;
            var data = {patient: patient};
            var url = "<?php echo Yii::app()->createUrl('queue/getlastservice') ?>";
            $.post(url, data, function(datas) {
                $("#_appoint_id").val(datas.appoint_id);
                $("#_comment").val(datas.comment);
                $("#_appoint").val(datas.appoint);
                //$("#_type").val(datas.type);
            }, 'json');
        });

    });

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
        $("#promotion").val("");
        $("#popupaddseq").modal();
    }

    function setnullform() {
        $("#patient").val("");
        $("#weight").val("");
        $("#height").val("");
        $("#btemp").val("");
        $("#pr").val("");
        $("#rr").val("");
        $("#ht").val("");
        $("#waistline").val("");
        $("#cc_detail").val("");
        $("#promotion").val("");
        $("#popupaddseq").modal("hide");
    }

    function SaveAddseq() {
        var url = "<?php echo Yii::app()->createUrl('queue/saveseq') ?>";
        var patient = $("#patient").val();
        var promotion = $('#promotion').val();
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
        var cc = $("#cc_detail").val();
        var date_service = $("#date_serv").val();

        /*
         if (weight == "" || height == "" || btemp == "" || pr == "" || rr == "" || ht == "" || waistline == "") {
         swal("แจ้งเตือน!", " กรอกข้อมูลช่อง * ไม่ครบ ...!", "warning");
         return false;
         }
         */
        if (cc == "") {
            swal("แจ้งเตือน!", "กรุณาใส่อาการที่มารักษา ...!", "warning");
            return false;
        }
        var data = {
            patient: patient,
            //comment: comment,
            //Check Body
            promotion: promotion,
            weight: weight,
            height: height,
            btemp: btemp,
            pr: pr,
            rr: rr,
            ht: ht,
            waistline: waistline,
            cc: cc,
            date_service: date_service
        };

        $.post(url, data, function(datas) {
            //window.location.reload();
            setnullform();
            nodeloadtable();
        });
    }

    function loadtable() {
        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            $("#resultseqemployee").html(datas);
        });
    }

    function loadservicesuccess() {
        var url = "<?php echo Yii::app()->createUrl('queue/getservicesuccess') ?>";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            $("#servicesuccess").html(datas);
            //socket.emit(id, datas);
        });
    }

    function loadseqdoctor() {
        var url = "<?php echo Yii::app()->createUrl('queue/seqdoctor') ?>";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            $("#resultservice").html(datas);
            //socket.emit(id, datas);
        });
    }

    function setscreen() {
        var h = window.innerHeight;
        var w = window.innerWidth;

        if (w >= 768) {
            var bodymodel = (h - 210);
            $("#detailpatient").css({'height': bodymodel - 110, 'overflow': 'auto', 'margin-bottom': '0px'});
            $("#seqright").css({'height': bodymodel, 'overflow': 'auto'});
            $("#showdatapatient").css({'height': bodymodel - 110, 'overflow': 'auto'});
        } else {
            var bodymodel = (h - 210);
            $("#conten-body-seq").css({'height': bodymodel, 'position': 'relative', 'overflow': 'auto'});

        }
    }

    function Getpatient(id) {
        $("#patient").val(id);
        var data = {id: id};
        var url = "<?php echo Yii::app()->createUrl('queue/getpatient') ?>";
        $.post(url, data, function(datas) {
            $("#detailpatient").html(datas);
            $("#popupsearchpatient").modal("hide");
        });
    }

    function linkdetail() {
        var patient_id = $("#patient").val();
        var url = "<?php echo Yii::app()->createUrl('patient/viewpopup') ?>" + "&id=" + patient_id;
        PopupBills(url, "Detail");
        // var win = window.open(url, '_blank');
        //win.focus();

    }

    /******** NODE JS ********/
    var socket = io.connect('<?php echo $WebConfig->LinkNode() ?>');
    function nodeloadtable() {
        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
        var branch = "<?php echo Yii::app()->session['branch'] ?>";
        var id = "seqemployeeramet";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            //$("#datas").html(datas);
            socket.emit(id, datas);
            ReautoloadseqDoctor();
        });
    }

    function ReautoloadseqDoctor() {
        var url = "<?php echo Yii::app()->createUrl('queue/seqdoctor') ?>";
        var branch = "<?php echo Yii::app()->session['branch'] ?>";
        var id = "seqemployeedoctorramet";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            //$("#resultservice").html(datas);
            socket.emit(id, datas, function(success) {
            });
        });
    }

    //ท่อส่งข้อมูลไป server
    var branch = "<?php echo Yii::app()->session['branch'] ?>";
    var id = "seqemployeeramet";
    socket.on(id, function(data) {
        $("#resultseqemployee").html(data);
    });

    var idsuccess = "seqsuccessramet";
    socket.on(idsuccess, function(data) {
        $("#servicesuccess").html(data);
    });

    var idseqdoctor = "seqemployeedoctorramet";
    socket.on(idseqdoctor, function(data, fn) {
        $("#resultservice").html(data);
    });

    function popupsearchpatient() {
        $("#pid").val("");
        $("#name").val("");
        $("#lname").val();
        $("#popupsearchpatient").modal();
    }

    function getdata() {
        var loading = '<i class="fa fa-spinner fa-spin fa-fw"></i> กำลังค้นหาข้อมูล';
        $("#showdatapatient").html(loading);
        var pid = $("#pid").val();
        var name = $("#name").val();
        var lname = $("#lname").val();
        if (pid == '' && name == '' && lname == '') {
            var loading = '';
            alert("เลือกอย่างน้อย 1 ช่อง");
            return false;
        }
        var url = "<?php echo Yii::app()->createUrl('patient/datasearchpatient') ?>";
        var data = {pid: pid, name: name, lname: lname};
        $.post(url, data, function(datas) {
            //$("#loading").html('');
            $("#showdatapatient").html(datas);
        });
    }

    function setcc(promotion, text) {
        $("#promotion").val(promotion);
        $("#cc").val(text);
    }

    function PopupBills(url, title) {
        // Fixes dual-screen position
        //                        Most browsers      Firefox
        var w = 800;
        var h = 600;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }
</script>

