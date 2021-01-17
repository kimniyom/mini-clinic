<style type="text/css">
    #pv table thead tr th{
        white-space: nowrap;
    }
    #pv table tbody tr td{
        white-space: nowrap;
    }
</style>
<?php
$system = new Configweb_model();
?>
<div id="pv">
<table class="table table-bordered" id="tuser" style="width:100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>สินค้า</th>
            <th style="text-align:center;">ล๊อต</th>
            <th style="text-align:right;">จำนวน / รายการ</th>
            <th>สาขา</th>
            <th>วันที่</th>
            <th>หมายเหตุ</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;foreach($datareturn as $rs): $i++;?>
    <tr>
        <td><?php echo $i ?></td>
        <td>
            <?php  
            $Pdetail = CenterStockproduct::model()->find('product_id=:id',array(':id' => $rs['product_id'])); 
            echo $rs['product_id']." : ".$Pdetail['product_name'];
            ?>
        </td>
        <td style="text-align:center;"><?php echo $rs['lotnumber'] ?></td>
        <td style="text-align:right;"><?php echo $rs['number'] ?></td>
        <td><?php echo Branch::model()->find('id=:id',array(':id' => $rs['branch']))['branchname'] ?></td>
        <td><?php echo $rs['create_date'] ?></td>
        <td><?php echo $rs['etc'] ? $rs['etc'] : "-"; ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>
</div>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var w = window.innerWidth;
        var screenfull;
        if (w > 768) {
            //var contentboxsell = $("#content-boxsell").height();
            screenfull = (boxsell - 371);
        } else {
            screenfull = false;
        }
        $("#tuser").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "paging": false,
            "bFilter": true, // แสดง search box
            "sScrollY": screenfull, // กำหนดความสูงของ ตาราง
            "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ]
        });
    }


</script>