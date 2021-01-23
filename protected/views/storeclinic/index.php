<title>คลังสินค้า</title>
<style type="text/css">
    button{
        font-family: Th;
    }
</style>
<?php
$this->breadcrumbs = array(
    'คลังสินค้า',
);

$product_model = new Product();
$branch = Yii::app()->session['branch'];
if ($branch == '99') {
    $WHERE = " ";
} else {
    $WHERE = " AND id = '$branch'";
}
$branchs = Branch::model()->findAll("active = '1' $WHERE");
?>

<?php foreach ($branchs as $rs): ?>
    <h3 style="font-family: Th; margin-left: 15px;"><?php echo $rs['branchname'] ?></h3>
    <div class="row" style=" margin: 0px;">
        <div class="col-lg-2 col-md-2 col-xs-6" style=" margin-bottom: 10px;">
            <a href="<?php echo Yii::app()->createUrl('clinicstoreproduct/index', array("branch" => $rs['id'])) ?>">
                <button type="button" class="btn btn-default btn-block" style=" font-size: 20px;">
                    <img src="<?= Yii::app()->baseUrl; ?>/images/box-icons.png" style="width: 64px;"/><br/>
                    สต๊อกสินค้า
                </button></a>
        </div>
        <div class="col-lg-2 col-md-2 col-xs-6" style=" margin-bottom: 10px;">
            <a href="<?php echo Yii::app()->createUrl('clinicstockproduct/index', array("branch" => $rs['id'])) ?>">
                <button type="button" class="btn btn-default btn-block" style=" font-size: 20px;">
                    <img src="<?= Yii::app()->baseUrl; ?>/images/Product-sale-report-icon.png"/><br/>
                    รายการสินค้า
                </button></a>
        </div>

        <div class="col-lg-2 col-md-2 col-xs-6" style=" margin-bottom: 10px;">
            <a href="<?php echo Yii::app()->createUrl('orders/index', array("branch" => $rs['id'])) ?>">
                <button type="button" class="btn btn-default btn-block" style=" font-size: 20px;">
                    <img src="<?= Yii::app()->baseUrl; ?>/images/text-richtext-icon.png"><br/>
                    ใบสั่งสินค้า
                </button></a>
        </div>
        <!--
        <div class="col-lg-2 col-md-2 col-xs-6" style=" margin-bottom: 10px;">
            <a href="<?php //echo Yii::app()->createUrl('returnproduct/index', array("branch" => $rs['id'])) ?>">
                <button type="button" class="btn btn-default btn-block">
                    <img src="<?php //Yii::app()->baseUrl; ?>/images/return-product-icon.png"><br/>
                    คืนสินค้า
                </button></a>
        </div>
        -->
    </div>
    <hr/>
<?php endforeach; ?>



