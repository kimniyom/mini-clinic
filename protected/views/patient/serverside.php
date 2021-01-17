<style type="text/css">
    table tbody tr:hover{
        cursor: pointer;
    }
    .box-all{
        height: 30px;
        width: 30px;
        margin: 0px;
    }
    #box-patient table thead tr th{
        white-space: nowrap;
    }
    #box-patient table tbody tr td{
        white-space: nowrap;
    }
</style>

<title>ทะเบียนลูกค้า</title>
<?php
/* @var $this EmployeeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'ทะเบียนลูกค้า',
);
?>

<table class="table table-striped table-hover" id="patient" style=" width: 100%;">
    <thead>
        <tr>
            <th>id</th>
            <!--<th class="pid">Pid</th>-->
            <th class="pid">Cn</th>
            <th>Name - Lname</th>
            <th>Tel.</th>
            <th class="branch">สาขา</th>
            <th class="type">ประเภท</th>
        </tr>
    </thead>
</table>

<!-- Action -->
<div class="modal fade" tabindex="-1" role="dialog" id="action" style="margin-top:20%;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="_id">
                <div class="row" id="outstock">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <button class="btn btn-default btn-block btn-lg" onclick="view()"><i class="fa fa-eye"></i> ดูข้อมูล</button>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;" id="editupdate">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button class="btn btn-default btn-block btn-lg" onclick="edit()"><i class="fa fa-pencil"></i> แก้ไข</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <button class="btn btn-danger btn-block btn-lg" onclick="deletepatient()"><i class="fa fa-trash"></i> ลบ</button>
                    </div>
                </div>
                <hr/>
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">Close</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $(document).ready(function() {
        serverside();
        /*
         var url = "<?php //echo Yii::app()->createUrl('patient/serverside')               ?>";
         var datatableAjax = $('#employee-grid').dataTable({
         "processing": true,
         "serverSide": true,
         "order": [],
         "ajax": {
         "url": url,
         "type": "POST"
         }
         });
         */
    });

    function serverside() {
        var boxsell = $(window).height();
        var buttonsHtml;
        var w = window.innerWidth;
        var screenfull;
        var branch = "<?php echo $branch ?>";
        var url = "<?php echo Yii::app()->createUrl('patient/getserverside') ?>";
        var datas = {branch: branch};

        if (w > 768) {
            //var contentboxsell = $("#content-boxsell").height();
            var exportbtn = "<?php echo $export ?>";
            screenfull = (boxsell - 333);
            if (exportbtn >= 1) {
                buttonsHtml = [
                    {
                        extend: 'excel',
                        text: 'ส่งออก excel'
                    }
                    //"copy", "excel", "print"
                ];
            } else {
                buttonsHtml = [];
            }
        } else {
            screenfull = false;
            $(".pid").hide();
            $(".branch").hide();
            $(".type").hide();
            buttonsHtml = [];
            $("#btn-btn-search").css({"position": "fixed", "bottom": "5px", "right": "5px", "z-index": "10"});
        }

        var table = $("#patient").DataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "processing": true,
            "serverSide": true,
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "deferRender": true,
            "paging": false,
            "bFilter": true, // แสดง search box
            "dom": "Bfrtip",
            'buttons': buttonsHtml,
            //"order": [],

            "ajax": {
                "url": url,
                "type": "POST",
                "data": datas
            },
            "sScrollY": screenfull, // กำหนดความสูงของ ตาราง
            "scrollX": true
                    /*
                     scroller: {
                     loadingIndicator: true
                     }
                     */

        });

        $('#patient tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            //alert( 'You clicked on '+data[0]+'\'s row' );
            action(data[0]);
        });
    }

    function action(id) {
        $("#_id").val(id);
        $("#action").modal();
    }

    function view() {
        var id = $("#_id").val();
        var url = "<?php echo Yii::app()->createUrl('patient/view') ?>" + "/id/" + id;
        window.location = url;
    }

    function edit() {
        var id = $("#_id").val();
        var url = "<?php echo Yii::app()->createUrl('patient/update') ?>" + "/id/" + id;
        window.location = url;
    }

    function deletepatient() {
        var id = $("#_id").val();
        var r = confirm("คุณแน่ใจหรือไม่ ...");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('patient/delete') ?>";
            var data = {id: id};
            $.post(url, data, function(success) {
                window.location.reload();
            });
        }
    }
</script>



