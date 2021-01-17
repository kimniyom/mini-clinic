<?php
/* @var $this ProductTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'คลังสินค้า',
);

$product_model = new Product();
?>

<h1>
    <img src="<?= Yii::app()->baseUrl; ?>/images/shipping-box-icon.png" 
         style="border-radius:20px; padding:2px; border:#FFF solid 2px;">
    คลังสินค้า 
    <a href="<?php echo Yii::app()->createUrl('backend/typeproduct/from_add_type') ?>">
        <button type="button" class="btn btn-default" id="btn-bg-default"><i class="fa fa-plus"></i> เพิ่มประเภทสินค้า</button></a>
    <a href="<?php echo Yii::app()->createUrl('backend/typeproduct/from_add_type') ?>">
        <button type="button" class="btn btn-default" id="btn-bg-default"><i class="fa fa-plus"></i> หน่วยนับ</button></a>
        
</h1>
<hr/>
<h4>คลังสินค้ากลาง</h4>
<div class="row">
    <div class="col-lg-4 col-md-4">
        <button type="button" class="btn btn-success btn-block">
            <img src="<?= Yii::app()->baseUrl; ?>/images/shipping-box-icon.png" 
                         style="border-radius:20px; padding:2px; border:#FFF solid 2px;"><br/>
            คลังสินค้ากลาง
        </button>
    </div>
</div>
<hr/>
<h4>คลังสินค้าย่อย</h4>
<div class="row">
    <?php
    foreach ($type as $rs):
        ?>
        <div class="col-md-4 col-lg-4">
            <a href="<?php echo Yii::app()->createUrl('backend/product/Getproduct/type_id/' . $rs['type_id']) ?>">
                <button type="button" class="btn btn-default btn-block">
                    <img src="<?= Yii::app()->baseUrl; ?>/images/shipping-box-icon.png" 
                         style="border-radius:20px; padding:2px; border:#FFF solid 2px;"><br/>
                         <?php echo $rs['type_name'] ?>
                    <span class="label" style=" background: #24282d;">
                        <?php echo $product_model->get_count_product_type($rs['type_id']); ?>
                    </span>
                </button>
            </a>
        </div>
    <?php endforeach; ?>
</div>
