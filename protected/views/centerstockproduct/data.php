<style type="text/css">
    #p_product tbody tr td b{
        color: #cccccc;
    }
    .box-all{
        max-height: 200px;
        max-width: 200px;
        margin: 0px;
    }
    #box-patient table thead tr th{
        white-space: nowrap;
    }
    #box-patient table tbody tr td{
        white-space: nowrap;
    }
</style>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var screenfull;
        var w = window.innerWidth;
        if (w <= 786) {
            screenfull = false;
        } else {
            screenfull = (boxsell - 357);
        }
        $("#p_product").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "paging": false,
            "bFilter": true, // แสดง search box
            //"sScrollY": screenfull, // กำหนดความสูงของ ตาราง
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'print'
            ]
        });
    }


</script>

<table class="table table-bordered" id="p_product">
    <thead>
        <tr>
            <th style=" display: none;"></th>
            <th>ข้อมูลสินค้า</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $product_model = new Product();
        $i = 0;
        foreach ($product as $last):
            //$img_title = $product_model->get_images_product_title($last['product_id']);
            $productID = $last['product_id'];
            $img_title = $product_model->firstpictures($last['product_id']);
            $link = Yii::app()->createUrl('centerstockproduct/detail?product_id=' . $last['product_id']);
            if ($last['status'] == "1") {
                $textcolor = "#999999;";
            } else {
                $textcolor = "";
            }

            if (!empty($img_title)) {
                $img = "uploads/product/" . $img_title;
            } else {
                $img = "images/No_image_available.jpg";
            }
            $i++;
            ?>
            <tr style=" color: <?php echo $textcolor ?>">
                <td style=" display: none;"><?php echo $i ?></td>
                <td>
                    <div class="row">
                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                            <center>
                                <img src="<?php echo Yii::app()->baseUrl ?>/<?php echo $img ?>"
                                     class="img-polaroid img-responsive" style=" max-height: 200px;"/>
                            </center>
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                            <font style=" color: red; font-size: 20px;">
                            รหัส: <?php echo $last['product_id']; ?>
                            ชื่อสามัญบริษัท: <?php echo $last['product_name']; ?>
                            </font>
                            <br/>
                            <b>ชื่อเรียกในคลินิก:</b> <?php echo $last['product_nameclinic']; ?><br/>
                            <b>หมวด:</b> <?php echo $last['category'] ?>
                            <b>ประเภท:</b> <?php echo $last['type_name'] ?><br/>
                            <?php if (Yii::app()->user->id != '15') { ?>
                                <b>ต้นทุน:</b> <?php echo number_format($last['costs'], 2); ?> บาท<br/>
                            <?php } ?>
                            <b>ราคาขาย / หน่วย: <?php echo number_format($last['product_price'], 2); ?> บาท<br/>
                                <b>หน่วยนับ:</b> <?php echo $last['unitname'] ?>
                                <b>สถานะ:</b> <?php if ($last['status'] == "1") { ?>
                                    <font style="color: #cc0033;"><i class="fa fa-remove"></i> เลิกผลิต</font>
                                <?php } else { ?>
                                    <font style="color: #669900;"><i class="fa fa-check"></i> ยังผลิต</font>
                                <?php } ?>
                                <div class="pull-right">
                                    <a href="<?php echo $link ?>" class="btn btn-default"><i class="fa fa-file"></i> รายละเอียด</a>
                                </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

