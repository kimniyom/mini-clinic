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
            <center>
                    <font style=" font-size: 12px; color: #ff9900;">ราคา <?= number_format($product['product_price']) ?>.-  บาท</font>  
            </center>    
        <?php } ?>
    </div>
</div>



