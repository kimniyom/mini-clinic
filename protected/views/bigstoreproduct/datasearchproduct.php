<style type="text/css">
    #box-data table thead tr th{
        white-space: nowrap;
    }
    #box-data table tbody tr td{
        white-space: nowrap;
    }
</style>
<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var w = window.innerWidth;
        var screenfull;
        if (w > 768) {
            //var contentboxsell = $("#content-boxsell").height();
            screenfull = (boxsell - 455);
        } else {
            screenfull = false;
            $("#btn-search-pd").addClass("btn btn-default btn-block");
            $(".columns").hide();
        }
        //var contentboxsell = $("#content-boxsell").height();
        $("#p_product").dataTable({
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
<?php
$config = new Configweb_model();
$Clinic = new ClinicStoreproduct();
?>

<div id="box-data">
    <table class="table table-bordered table-hover" id="p_product" style=" width: 100%;">
        <thead>
            <tr>
                <th style=" width: 5%;">#</th>
                <th>รหัส</th>
                <th>ชื่อสินค้า</th>
                <th style="text-align: center;" class="columns">ราคา / หน่วย</th>
                <th class="columns">หมวด</th>
                <th class="columns">ประเภท</th>
                <th style=" text-align: right; color: #009900; font-weight: bold;">คงเหลือ</th>
                <!--
                <th style=" text-align: center;">รายละเอียด</th>
                -->
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($product as $last):
                //$img_title = $product_model->get_images_product_title($last['product_id']);
                $productID = $last['product_id'];
                $link = Yii::app()->createUrl('clinicstockproduct/detail&product_id=' . $last['product_id']);
                $i++;
                ?>
                <tr>
                    <td style=" text-align: center;"><?php echo $i ?></td>
                    <td><?php echo $last['product_id']; ?></td>
                    <td><?php echo $last['product_name']; ?></td>
                    <td style=" text-align: center; font-weight: bold;" class="columns">
                        <?php echo number_format($last['product_price'], 2); ?>
                    </td>
                    <td class="columns"><?php echo $last['category'] ?></td>
                    <td class="columns"><?php echo $last['type_name'] ?></td>
                    <td style=" text-align: right;color: #009900; font-weight: bold;">
                        <?php
                        $total = $Clinic->Checkstock($last['product_id'], $branch);
                        echo number_format($total) . ' ' . $last['unit']
                        ?>
                    </td>
                    <!--
                    <td style="text-align: center;"><a href="<?//php echo $link ?>">รายละเอียด</a></td>
                    -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
