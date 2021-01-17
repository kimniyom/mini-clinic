<style type="text/css">
    table tr td{ height:30px;}
    #im-resize{height: 75px; padding: 5px; margin-bottom: 5px;}
    #cart_box{
        float: right; margin-top: 0px; padding-top: 15px;
        position:fixed; top:10px; right:20px;z-index:3;
    }
</style>



<?php $config = new Configweb_model(); ?>

<div class="row" style=" margin: 0px;">
    <div class="col-lg-12 col-md-12 col-xs-12">
        <?php if ($product) { ?>
            <?php
            $Promotion = Promotionproduct::model()->find("product_id=:product_id and active=:active", array(":product_id" => $product['product_id'], ":active" => "0"));
            $product_model = new Product();
            $img_title = $product_model->firstpictures($product['product_id']);
            if (!empty($img_title)) {
                $img = "uploads/product/" . $img_title;
            } else {
                $img = "images/No_image_available.jpg";
            }
            ?>
            <center>
                <?php if ($Promotion['product_id'] == "") { ?>
                    <img src="<?= Yii::app()->baseUrl ?>/<?= $img; ?>" class="img-responsive" alt="Responsive image" style="max-height:80px;"/>
                    <font style=" font-size: 16px; color: #ff9900;">ราคา <?= number_format($product['product_price']) ?>.-  บาท</font>
                <?php } else { ?>
                    <div class="well" style=" cursor: pointer;" onclick="sellpromotion('<?php echo $Promotion['id']?>','<?php echo $Promotion['promotionname'] ?>','<?php echo $Promotion['number'] ?>')">
                        <font style=" font-size: 16px; color: #F00;">
                        ราคา <del><?= number_format($product['product_price']) ?></del>.-  บาท<br/>
                        </font>
                        <font style=" font-size: 16px; color: #00ccff;">
                        โปรโมชั่น <?php echo $product['product_nameclinic'] ?> 
                        (<?php echo $Promotion['promotionname'] ?> <font style=" color: #F00;"><?php echo number_format($Promotion['price']) ?>.-</font>)
                        </font>
                        <br/>
                        <font style=" color: #cccccc;">กดเพื่อใช้โปร</font>
                    </div>
                <?php } ?>
            </center>    
        <?php } ?>
    </div>
</div>



