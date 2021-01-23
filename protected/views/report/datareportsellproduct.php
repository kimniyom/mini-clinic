<style type="text/css">
    #btnreportleft{
        text-align:center;
        padding:0px;
        padding-bottom: 10px;
    }
</style>
<hr/>

<?php
$config = new Configweb_model();
$ChartModel = new Chart();
?>
<div class="row" style="margin:0px;">
    <div class="col-md-3 col-lg-3 col-sm-12">
        <div class="well well-sm" id="report-box-left" style="margin-bottom:0px;">
            <div class="well" id="btnreportleft">
                <h4><?php echo $count ?></h4>
                <hr/>
                จำนวนรายการ
            </div>
            <div class="well" id="btnreportleft">
                <h4><?php echo number_format($sumsell, 2) ?></h4>
                <hr/>
                ยอดขาย
            </div>
            <div class="well" id="btnreportleft">
                <h4><?php echo ($empname) ? $empname . "(" . number_format($empsell, 2) . ")" : "-"; ?></h4>
                <hr/>
                พนักงานทำยอดขายมากที่สุด
            </div>
        </div>
    </div>
    <div class="col-md-9 col-lg-9 col-sm-12">
        <div class="well" id="report-box-right" style="margin-bottom:0px;">
            <div id="typechart" style="min-height:300px;"></div>
            <?php
            echo $ChartModel->SplineChart("typechart", "ยอดขาย(หมวดสินค้า)", "", "จำนวน", "หมวด", $charttype);
            ?>
            <table class="table table-bordered" id="sell">
                <thead>
                    <tr>
                        <th style=" width: 5%;">#</th>
                        <th>รหัสการขาย</th>
                        <th style=" text-align: right;">ราคา</th>
                        <th>พนักงาน</th>
                        <th>วันที่</th>
                        <th>สาขา</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($sell as $rs): $i++;
                        $branch = $rs['branch'];
                        ?>
                        <tr>
                            <td style=" text-align: center;"><?php echo $i ?></td>
                            <td><?php echo $rs['sell_id'] ?></td>
                            <td style=" text-align: right;"><?php echo number_format($rs['totalfinal']) ?></td>
                            <td><?php echo $rs['name'] . " " . $rs['lname'] ?></td>
                            <td><?php echo $config->thaidate($rs['date_sell']) ?></td>
                            <td><?php echo Branch::model()->find("id = '$branch' ")['branchname'] ?></td>
                            <td style="text-align: center;">
                                <a href="Javascript:PrintBill('<?php echo $rs['sell_id'] ?>')"><i class="fa fa-print">พิมพ์ใบเสร็จ</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function PrintBill(sellcode) {
        var url = "<?php echo Yii::app()->createUrl('sell/bill') ?>" + "?sell_id=" + sellcode;
        PopupBill(url, sellcode);
    }

    function PopupBill(url, title) {
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

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        //var contentboxsell = $("#content-boxsell").height();
        var screenfull = (boxsell - 315);
        $("#sell").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "paging": false,
            "bFilter": true, // แสดง search box
            "sScrollX": true,
            "sScrollY": false, // กำหนดความสูงของ ตาราง
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ]
        });

        $("#report-box-left").css({'height': screenfull + 110, 'overflow': 'auto'});
        $("#report-box-right").css({'height': screenfull + 110, 'overflow': 'auto'});
    }

</script>

