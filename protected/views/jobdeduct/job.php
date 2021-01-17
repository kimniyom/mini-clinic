<?php
$config = new Configweb_model();
?>

<table class="table table-bordered table-striped" id="tb-job" style=" width: 100%; background: #000000;">
    <thead>
        <tr>
            <th>#</th>
            <th>รายการ</th>
            <th style=" text-align: right;">ยอด</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sum = 0;
        $i = 0;
        foreach ($job as $rs): $i++;
            $sum = ($sum + $rs['result']);
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $rs['commision'] ?></td>
                <td style=" text-align: right;">
                    <?php echo number_format($rs['result']) . " บาท"; ?>
                </td>
                <td style=" text-align: center;"><i class="fa fa-trash-o text-danger" style=" cursor: pointer;" onclick="deletejob('<?php echo $rs['id'] ?>')"></i></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td style=" text-align: center;" colspan="2">รวม</td>
            <td style=" text-align: right; color: #ff0033;"><?php echo number_format($sum, 2) ?> บาท</td>
            <td style=" text-align: center;"></td>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var w = window.innerWidth;
        var screenfull;
        if (w >= 768) {
            screenfull = (boxsell - 490);
        } else {
            screenfull = false;
        }
        $("#tb-job").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "searching": false,
            "paging": false,
            "bFilter": true, // แสดง search box
            "sScrollY": screenfull, // กำหนดความสูงของ ตาราง
            "scrollX": true
            /*
             dom: 'Bfrtip',
             buttons: [
             'copy', 'excel', 'print'
             ]
             */
        });
    }

    function deletejob(id) {
        var url = "<?php echo Yii::app()->createUrl('jobdeduct/delete') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            getjob();
        });
    }
</script>

