<style type="text/css">
    table tr td{ height:30px;}
    #im-resize{height: 75px; padding: 5px; margin-bottom: 5px;}
    #cart_box{
        float: right; margin-top: 0px; padding-top: 15px;
        position:fixed; top:10px; right:20px;z-index:3;
    }
</style>

<script type="text/javascript">
    function set_group_img(img) {
        $("#img_group").html("<img src='<?php echo Yii::app()->baseUrl ?>/uploads" + "/" + img + " ' width='80%' style='margin-right:20px;' />");
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();

        $('.img_zoom').magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            gallery: {
                enabled: true
            }
            // other options
        });

    });
</script>


<?php
$Web = new Configweb_model();
$product_id = $product['product_id'];
?>

<?php $config = new Configweb_model(); ?>
<div class="well well-sm" style=" width:100%; margin-top:0px;text-align: left; margin-bottom: 0px;">
    <div class="row" style=" margin: 0px;">
        <div class="col-lg-4 col-md-6 col-xs-12" style=" padding-top: 20px;" id="p-left">
            <?php
            $product_model = new Product();
            $img_title = $product_model->firstpictures($product['product_id']);
            if (!empty($img_title)) {
                $img = "uploads/product/" . $img_title;
            } else {
                $img = "images/No_image_available.jpg";
            }
            if ($img != "") {
                ?>
                <center>
                    <img src="<?= Yii::app()->baseUrl ?>/<?= $img; ?>" class="img-responsive thumbnail" alt="Responsive image" id="img-cart"/>
                </center>     
            <?php } else { ?>
                <div id="img" style="width:200px; height:350px; background:#CCC; font-size:36px; text-align:center; padding-top:30px; margin-right:20px;">
                    NO<br />Images 
                </div>
            <?php } ?>
        </div>

        <div class="col-lg-8 col-md-6 col-xs-12" id="p-right">
            <font style=" color: #F00; font-size: 18px; font-weight: normal;">
            ชื่อสินค้า : <?= $product['product_nameclinic'] ?>
            </font><br/>
            <b>รหัสสินค้า</b> <?= $product['product_id'] ?><br/>
            <b>หมวดสินค้า</b> <?= $product['type_name'] ?><br/>
            <b>ประเภทสินค้า</b> <?= $product['subtypename'] ?><br/>
            <b>อัพเดทล่าสุด</b> <?= $config->thaidate($product['d_update']); ?>

            <br/>
            <font style=" font-size: 18px; color: #F00;">
            ราคาขาย <?= number_format($product['product_price']) ?>.-  บาท
            </font>
        </div>
    </div>
</div>






