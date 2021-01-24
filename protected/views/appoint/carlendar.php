<title>รายชื่อนัดลูดค้า</title>
<style type="text/css">
    table{
        border: none;
    }
    #ca{
        padding: 10px; background: #FFFFFF;
    }

    h2{
        font-size: 18px;
        text-align: center;
        padding-top: 15px;
    }
</style>
<?php
$this->breadcrumbs = array(
    "นัดลูกค้า",
);
?>
<div id="well well-sm">
    <div class="row" style=" margin: 0px;">
        <div class="col-md-4 col-lg-4">
            <p class="text-danger">*นัดลูกค้าคลิกที่ว่างในช่องวันที่</p>
            <p class="text-danger">*นัดลูกค้าได้เฉพาะสาขาที่ลูกค้าขึ้นทะเบียนไว้</p>
            <button type="button" class="btn btn-primary">นัดรักษาต่อ</button>
            <button type="button" class="btn btn-success">นัดดูอาการ</button>
            <hr/>
            <div class="well well-sm" style="margin-bottom:0px;">
                ค้นหาลูกค้า
                <input type="hidden" id="pid" />
                <div class="row">
                    <div class="col-sm-6 col-md-12 col-lg-12">
                        <input type="text" id="name" placeholder="ชื่อ" class="form-control input-sm"/>
                    </div>
                </div>
                <div class="row" style=" margin-top: 10px;">
                    <div class="col-sm-6 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-md-9 col-lg-9">
                                <input type="text" id="lname" placeholder="หรือสกุล" class="form-control input-sm"/>
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <button type="button" class="btn btn-default btn-block btn-sm" onclick="searchpatient()"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="well" style=" margin-top: 10px;">
                <div id="patient"></div>
            </div>
        </div>
        <div class="col-md-8 col-lg-8" id="p-right">
            <div style=" width: 100%;">
                <?php
                $this->widget('ext.fullcalendar.EFullCalendarHeart', array(
                    //'themeCssFile'=>'cupertino/jquery-ui.min.css',
                    //'id' => 'appoint',
                    'htmlOptions' => array(
                        'style' => 'border:#eeeeee solid 0px;font-size:18px;color:red;'
                    ),
                    'options' => array(
                        'lang' => 'th',
                        'editable' => true,
                        'header' => array(
                            'left' => 'prev,next,today',
                            'center' => 'title',
                            'right' => 'month',
                            //'right' => 'month,agendaWeek,agendaDay',
                            'lang' => 'th',
                        ),
                        //'timeFormat'=> 'H(:mm)',
                        'events' => $this->createUrl('appoint/carlendarevents'), // URL to get event
                        'eventClick' => 'js:function(calEvent, jsEvent, view) {
            $("#myModalHeader").html(calEvent.title);
            $("#myModalBody").load("' . Yii::app()->createUrl("appoint/viewcarlendar/appoint") . '/"+calEvent.id+"/type/"+calEvent.type);
            $("#myModal").modal();
        }',
                        'dayClick' => "js:function(date, jsEvent, view) {
            $('#addappoint').modal();
            $('#date').val(date.format());
        }",
                )));
                ?>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalHeader">Modal</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <p>One fine body&hellip;</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="addappoint" data-backdrop='static'>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalHeader">นัดลูกค้า</h4>
            </div>
            <div class="modal-body" id="myModalBody">
                <input type="hidden" class="form-control" id="date" readonly="readonly"/><br/>
                <div class="row">
                    <div class="col-lg-12">
                        ประเภทนัด *
                        <?php
                        $Type = array("2" => "นัดรักษาต่อ", "3" => "นัดดูอาการ");
                        $this->widget(
                                'booster.widgets.TbSelect2', array(
                            'name' => 'type',
                            'id' => 'type',
                            'data' => $Type,
                            'options' => array(
                                'placeholder' => 'ประเภทนัด',
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
                        สาขา *
                        <?php
                        $this->widget(
                                'booster.widgets.TbSelect2', array(
                            'name' => 'branch',
                            'id' => 'branch',
                            'data' => CHtml::listData($branch, 'id', 'branchname'),
                            'options' => array(
                                'placeholder' => 'สาขานัด',
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
                        <br/>อื่น ๆ
                        <textarea id="etc" class="form-control" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="AddAppoint()">บันทึก</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
    function AddAppoint() {
        var url = "<?php echo Yii::app()->createUrl('appoint/addeven') ?>";
        var appoint = $("#date").val();
        var pid = $("#pid").val();
        var type = $("#type").val();
        var branch = $("#branch").val();
        var etc = $("#etc").val();
        if (pid == '') {
            alert("ยังไม่ได้เลือกลูกค้า");
            $("#patient").focus();
            return false;
        }

        if (type == '') {
            alert("ยังไม่ได้เลือกประเภทนัด");
            $("#type").focus();
            return false;
        }

        if (branch == '') {
            alert("ยังไม่ได้เลือกสาขา");
            $("#branch").focus();
            return false;
        }

        var data = {appoint: appoint, pid: pid, type: type, etc: etc, branch: branch};
        $.post(url, data, function(datas) {
            window.location.reload();
        });
    }
</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var screen = $(window).height();
        var w = window.innerWidth;
        if (w >= 768) {
            var screenfull = (screen - 120);
            $("#p-right").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
            //$("#patientbox").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF'});
            //$("#boxorders").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF', 'overflow': 'auto', 'padding-left': '10px'});
        }
    }

    function searchpatient() {
        var typebuy = "0";
        var url = "<?php echo Yii::app()->createUrl('sell/searchpatient') ?>";
        var name = $("#name").val();
        var lname = $("#lname").val();
        var data = {name: name, lname: lname, typebuy: typebuy};
        if (name == "" && lname == "") {
            alert("กรุณากรอกอย่างน้อย  1 ช่อง...");
            return false;
        }
        $("#patient").html("<center>กำลังประมวลผล ...</center>");
        $.post(url, data, function(datas) {
            $("#popuppatient").modal();
            $("#popupbodypatient").html(datas);
            $("#patient").html("");
        });
    }

    function selectPatient(pid) {
        $("#pid").val(pid);
        var url = "<?php echo Yii::app()->createUrl('sell/patient') ?>";
        var data = {pid: pid, typebuy: "0"};
        $.post(url, data, function(datas) {
            $("#patient").html(datas);
            $("#popuppatient").modal("hide");
            $("#name").val("");
            $("#lname").val("");
        });
    }
</script>





