<style type="text/css">
    .center-cropped {
        width: 50px;
        height: 50px;
        background-position: center center;
        background-repeat: no-repeat;
    }
</style>

<?php
$this->breadcrumbs = array(
    "สินค้าใกล้หมด",
);

$stock = new Items();
$web = new Configweb_model();

$Alert = new Alert();
$alam = $Alert->Getalert()['alert_product'];
?>

<div class="panel panel-default" style="margin-bottom: 0px;">
    <div class="panel-heading" style=" padding-bottom: 15px; padding-right: 5px; background: none;">
        <i class="fa fa-info-circle"></i> สินค้าใกล้หมด *สินค้าเหลือน้อยกว่า <?php echo $alam ?> ชิ้น
        <span class="text-danger">*คลิกที่รายชื่อสินค้าเพื่อดูรายละเอียด</span>
    </div>
    <div class="panel-body">
        <table class="table table-striped" id="p_product">
            <thead>
                <tr>
                    <th style=" width: 5%;">#</th>
                    <th>สินค้า</th>
                    <th style="text-align: center;">ราคา / หน่วย</th>
                    <th style="text-align: center;">คงเหลือ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $product_model = new Product();
                $i = 0;
                $branch = Yii::app()->session['branch'];
                foreach ($product as $last):
                    $productID = $last['product_id'];
                    $i++;
                    $trid = "td" . $i;
                    ?>
                    <tr id="<?php echo $trid; ?>">
                        <td style="text-align: center;"><?php echo $i ?></td><td>
                            <a href="<?php echo Yii::app()->createUrl('clinicstockproduct/detail', array('product_id' => $last['product_id'], "branch" => $branch)) ?>">
                                <?php echo $last['product_id']; ?> <?php echo $last['product_nameclinic']; ?></a>
                        </td>
                        <td style=" text-align: center; font-weight: bold;">
                            <?php echo number_format($last['product_price'], 2); ?>
                        </td>
                        <td style=" text-align: center; font-weight: bold;" class=" text-danger">
                            <?php echo $last['total'] ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        //var contentboxsell = $("#content-boxsell").height();
        var screenfull = (boxsell - 290);
        $("#p_product").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "paging": false,
            "bFilter": true, // แสดง search box
            "sScrollY": screenfull, // กำหนดความสูงของ ตาราง
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ]
        });
    }
</script>

