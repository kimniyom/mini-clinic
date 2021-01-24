<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->breadcrumbs = array(
    //'ลูกค้า' => array('index'),
    $model->name,
);

$MasuserModel = new Masuser();
$config = new Configweb_model();
$branchModel = new Branch();
$Author = $MasuserModel->GetDetailUser($model->emp_id);
?>
<style type="text/css">
    #font-18{
        color: #339900;
    }
</style>

<input type="hidden" id="patient_id" value="<?php echo $model['id'] ?>"/>

<div class="panel panel-default" style=" margin-bottom: 0px;">
    <div class="panel-heading" style=" background: none;">
        <i class="fa fa-user"></i> ข้อมูลค้า  <span id="sumbuyall" style=" color: #ff0000;"></span>
    </div>
    <div class="row" style="margin:0px;">
        <div class="col-md-2 col-lg-2" style="text-align: center; padding: 0px;" id="p-left">
            <div id="box-img-profiles" style=" padding: 5px;">
                <?php
                if (!empty($model['images'])) {
                    $img_profile = "uploads/profile/" . $model['images'];
                } else {
                    if ($model['sex'] == 'M') {
                        $img_profile = "images/Big-user-icon.png";
                    } else if ($model['sex'] == 'F') {
                        $img_profile = "images/Big-user-icon-female.png";
                    } else {
                        $img_profile = "images/Big-user.png";
                    }
                }
                ?>
                <center>
                    <img src="<?php echo Yii::app()->baseUrl; ?>/<?php echo $img_profile; ?>" class="img-responsive img-thumbnail" id="img_profile" style=" max-height: 200px;"/>
                    <button type="button" class="btn btn-xs btn-default btn-block" onclick="popupprofile()">เปลี่ยนรูปภาพ</button>
                </center>
            </div>

            <div style=" background: #333333; border-bottom: #333333 solid 1px; border-top: #333333 solid 1px; padding: 5px; font-weight: bold;">
                <i class="fa fa-shopping-cart"></i> ประวัติการซื้อสินค้า
            </div>
            <div id="sellhistory" style=" text-align: left;">
            </div>


        </div>
        <div class="col-md-7 col-lg-7" style="padding-right: 0px; padding-left: 0px; border-left: #333333 solid 1px; border-right: #333333 solid 1px;" id="p-right">
            <div class="wells" style="margin: 5px; background: none;">
                <a href="<?php echo Yii::app()->createUrl('patient/update', array('id' => $model['id'])) ?>">
                    <button type="button" class="btn btn-default btn-sm pull-right" id="font-rsu-14">
                        <i class="fa fa-pencil"></i> แก้ไข
                    </button></a>
                HN
                <p class="label" id="font-18">
                    <?php echo $model['cn'] ?>
                </p><br/>
                ชื่อ - สกุล
                <p class="label" id="font-18">
                    <?php echo Pername::model()->find("oid = '$model->oid'")['pername'] ?>
                    <?php echo $model['name'] . ' ' . $model['lname'] ?></p><br/>
                บัตรประชาชน<p class="label" id="font-18"><?php echo ($model['card']) ? $model['card'] : "-"; ?></p><br/>
                เพศ <p class="label" id="font-18"><?php
                    if ($model['sex'] == 'M') {
                        echo "ชาย";
                    } else {
                        echo "หญิง";
                    }
                    ?></p><br/>

                เกิดวันที่ <p class="label" id="font-18"><?php
                    if (isset($model['birth'])) {
                        echo $config->thaidate($model['birth']);
                    } else {
                        echo "-";
                    }
                    ?></p>
                อายุ <p class="label" id="font-18"><?php
                    if (isset($model['birth'])) {
                        echo $config->get_age($model['birth']);
                    } else {
                        echo "-";
                    }
                    ?></p> ปี
                อาชีพ <p class="label" id="font-18"><?php
                    $occ = $model['occupation'];
                    echo Occupation::model()->find("id = '$occ' ")['occupationname'];
                    ?></p><br/>

                สถานที่รับบริการ <p class="label" id="font-18"><?php
                    echo "สาขา " . $branchModel->Getbranch($model['branch']);
                    ?></p>
                ประเภทลูกค้า <p class="label" id="font-18"><?php
                    echo Gradcustomer::model()->find('id=:id', array(':id' => $model['type']))['grad'];
                    ?></p><br/>
                วันที่ลงทะเบียน <p class="label" id="font-18"><?php
                    if (isset($model['create_date'])) {
                        echo $config->thaidate($model['create_date']);
                    } else {
                        echo "-";
                    }
                    ?></p>
                ข้อมูลอัพเดทวันที่ <p class="label" id="font-18"><?php
                    if (isset($model['d_update'])) {
                        echo $config->thaidate($model['d_update']);
                    } else {
                        echo "-";
                    }
                    ?></p><br/>
                ผู้บันทึกข้อูล <p class="label" id="font-18"><?php
                    $OID = $Author['oid'];
                    echo Pername::model()->find("oid = '$OID'")['pername'] . $Author['name'] . '' . $Author['lname'];
                    ?></p>
                <br/>

                <hr style=" margin: 5px;"/>
                <label>ข้มูลการติดต่อ</label>
                <ul style=" padding-top: 5px;">
                    <?php
                    echo "<li><label>เบอร์โทรศัพท์ : </label> ";
                    if (isset($model['tel'])) {
                        echo ($model['tel']);
                    } else {
                        echo "-";
                    }
                    "</li>";

                    echo "<li><label>อีเมล์ : </label> ";
                    if (isset($model['email'])) {
                        echo ($model['email']);
                    } else {
                        echo "-";
                    }
                    "</li>";

                    echo "<li><label>อื่น ๆ : </label> ";
                    if (isset($model['contact'])) {
                        echo ($model['contact']);
                    } else {
                        echo "-";
                    }
                    "</li>";
                    ?>
                </ul>
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#drug" aria-controls="drug" role="tab" data-toggle="tab" onclick="loaddrug()" style=" padding: 5px; border-radius:0px;">อาการแพ้ยา</a>
                        </li>
                        <li role="presentation">
                            <a href="#disease" aria-controls="disease" role="tab" data-toggle="tab"
                               style=" padding: 5px; border-radius:0px;" onclick="loaddisease()">โรคประจำตัว</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" style=" padding-top: 10px; padding: 10px; border-top:2px #2a9fd6 solid;">
                        <div role="tabpanel" class="tab-pane active" id="drug"><div id="result_drug"></div></div>
                        <div role="tabpanel" class="tab-pane" id="disease"><div id="result_disease"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3" style=" padding: 0px;">
            <div style=" background: #333333; border-bottom: #333333 solid 1px; padding: 5px; font-weight: bold;"><i class="fa fa-user-md"></i> ประวัติการรับบริการ</div>
            <div id="history"></div>

            <div style=" background:#333333; border-bottom: #333333 solid 1px;  border-top: #333333 solid 1px; padding: 5px; font-weight: bold;">
                <i class="fa fa-calendar-o"></i> การนัด | <a href="<?php echo Yii::app()->createUrl('appoint/carlendar') ?>" style=" color: #0000FF;"><i class="fa fa-plus"></i> เพิ่มวันนัด</a>
            </div>
            <div id="appoint"></div>
        </div>
    </div>
</div>

<!-- แก้ไขโปรไฟล์ -->
<div class="modal fade" tabindex="-1" role="dialog" id="popupprofile" data-backdrop='static'>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">รูปภาพ</h4>
            </div>
            <div class="modal-body">
                <form id="upload" method="post" action="<?php echo Yii::app()->createUrl('patient/save_upload', array('id' => $model['id'])) ?>" enctype="multipart/form-data">
                    <div id="drop">
                        เลือกรูปภาพ<br/>
                        <a class="btn btn-primary"><i class="fa fa-picture-o"></i> Browse</a>
                        <input type="file" name="upl" />
                    </div>

                    <ul style="">
                        <!-- The file uploads will be shown here -->
                    </ul>

                </form>
                <p id="font-16" style=" color: #ff0000; margin-bottom: 0px;">(ขนาดไม่เกิน 2MB)</p>
                <p id="font-16" style=" color: #ff0000; margin-bottom: 0px;">นามสกุล .jpg .png</p>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- ข้อมูลวันนีด -->
<div class="modal fade" tabindex="-1" role="dialog" id="popupviewappoint" data-backdrop='static'>
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <input type="hidden" id="appoint_id" />
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ข้อมูลวันนัด</h4>
            </div>
            <div class="modal-body">
                <div id="viewappoint"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-block" onclick="deleteappoint()"><i class="fa fa-trash-o"></i> ลบ</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">

    $(function() {
        var ul = $('#upload ul');
        $('#drop a').click(function() {
            // Simulate a click on the file input button
            // to show the file browser dialog
            $(this).parent().find('input').click();
        });

        // Initialize the jQuery File Upload plugin
        $('#upload').fileupload({

            // This element will accept file drag/drop uploading
            dropZone: $('#drop'),

            // This function is called when a file is added to the queue;
            // either via the browse button, or via drag/drop:

            add: function(e, data) {

                var tpl = $('<li class="working"><input type="text" value="0" data-width="36" data-height="36"' +
                        ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

                // Append the file name and file size
                //data.files[0].name
                tpl.find('p').text("")
                        .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

                // Add the HTML to the UL element
                data.context = tpl.appendTo(ul);

                // Initialize the knob plugin
                tpl.find('input').knob();

                // Listen for clicks on the cancel icon
                tpl.find('span').click(function() {

                    if (tpl.hasClass('working')) {
                        jqXHR.abort();
                    }

                    tpl.fadeOut(function() {
                        tpl.remove();
                    });

                });

                //Automatically upload the file once it is added to the queue
                //var jqXHR = data.submit();

                var jqXHR = data.submit()
                        .success(function(result, textStatus, jqXHR) {
                            if (result == "error") {
                                data.context.addClass('error');
                            }

                        })
                        //.error(function (jqXHR, textStatus, errorThrown) {alert(jqXHR); return false;})
                        .complete(function(result, textStatus, jqXHR) {
                            window.location.reload();
                        });
            },

            progress: function(e, data) {
                var type = data.files[0].type;
                var size = data.files[0].size;

                if (type == "image/jpeg" && size <= "1000000") {
                    // Calculate the completion percentage of the upload
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    // Update the hidden input field and trigger a change
                    // so that the jQuery knob plugin knows to update the dial
                    data.context.find('input').val(progress).change();

                    if (progress == 100) {
                        data.context.removeClass('working');
                    } else {
                        data.context.addClass('error');
                    }
                } else {
                    data.context.addClass('error');
                }

            },

            fail: function(e, data) {
                // Something has gone wrong!
                data.context.addClass('error');
            }

        });

        // Prevent the default action when a file is dropped on the window
        $(document).on('drop dragover', function(e) {
            e.preventDefault();
        });

        // Helper function that formats the file sizes
        function formatFileSize(bytes) {
            if (typeof bytes !== 'number') {
                return '';
            }

            if (bytes >= 1000000000) {
                return (bytes / 1000000000).toFixed(2) + ' GB';
            }

            if (bytes >= 1000000) {
                return (bytes / 1000000).toFixed(2) + ' MB';
            }

            return (bytes / 1000).toFixed(2) + ' KB';
        }

    });

    function popupprofile() {
        $("#popupprofile").modal();
    }

    function loaddrug() {
        var url = "<?php echo Yii::app()->createUrl('patientdrug/getdrug') ?>";
        var patient_id = "<?php echo $model['id'] ?>";
        var data = {patient_id: patient_id};

        $.post(url, data, function(result) {
            $("#result_drug").html(result);
        });
    }

    function loaddisease() {
        var url = "<?php echo Yii::app()->createUrl('patientdisease/getdisease') ?>";
        var patient_id = "<?php echo $model['id'] ?>";
        var data = {patient_id: patient_id};

        $.post(url, data, function(result) {
            $("#result_disease").html(result);
        });
    }

    function loadhistory() {
        var patient_id = "<?php echo $model['id'] ?>";
        var url = "<?php echo Yii::app()->createUrl('patient/history') ?>";
        var data = {patient_id: patient_id};
        $.post(url, data, function(result) {
            $("#history").html(result);
        });
    }

    function loadappoint() {
        var patient_id = "<?php echo $model['id'] ?>";
        var url = "<?php echo Yii::app()->createUrl('patient/appoint') ?>";
        var data = {patient_id: patient_id};
        $.post(url, data, function(result) {
            $("#appoint").html(result);
        });
    }

    function loadsellhistory() {
        var pid = "<?php echo $model['pid'] ?>";
        var url = "<?php echo Yii::app()->createUrl('patient/sellhistory') ?>";
        var data = {pid: pid};
        $.post(url, data, function(result) {
            $("#sellhistory").html(result);
        });
    }

    function viewappoint(appoint_id) {
        $("#appoint_id").val(appoint_id);
        var url = "<?php echo Yii::app()->createUrl('patient/getappointpatient') ?>";
        var data = {appoint_id: appoint_id};
        $.post(url, data, function(result) {
            $("#viewappoint").html(result);
            $("#popupviewappoint").modal();
        });

    }

</script>

<script type="text/javascript">

    setpage();
    loadappoint();
    loadhistory();
    loaddrug();
    loadsellhistory();
    Sumbuy();
    function setpage() {
        var screen = window.innerWidth;
        if (screen > 768) {
            Setscreen();
            SetBoxHistory();
        } else {
            $("#p-right").css({'border': 'none'});
        }
    }
    function Setscreen() {
        var screen = $(window).height();
        //var contentboxsell = $("#content-boxsell").height();
        var screenfull = (screen - 145);
        $("#p-left").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
        $("#p-right").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
        //$("#patientbox").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF'});
        //$("#boxorders").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF', 'overflow': 'auto', 'padding-left': '10px'});

    }

    function SetBoxHistory() {
        var screen = $(window).height();
        //var contentboxsell = $("#content-boxsell").height();
        var screenfull = ((screen - 205) / 2);
        $("#history").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '0px'});
        $("#appoint").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '0px'});

        //$("#p-left").css({'height': sellhistory, 'overflow': 'auto', 'padding-bottom': '25px'});
        //$("#box-img-profile").css({'height': 205, 'overflow': 'auto', 'padding-bottom': '0px'});
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

    function Sumbuy() {
        var url = "<?php echo Yii::app()->createUrl('patient/sumbuyall') ?>";
        var pid = "<?php echo $model['pid'] ?>";
        var patient_id = "<?php echo $model['id'] ?>";
        var data = {pid: pid, patient_id: patient_id};
        $.post(url, data, function(datas) {
            $("#sumbuyall").html(datas);
        });

    }
</script>
