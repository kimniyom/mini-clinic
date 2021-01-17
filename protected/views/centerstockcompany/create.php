<?php
/* @var $this CenterStockcompanyController */
/* @var $model CenterStockcompany */

$this->breadcrumbs = array(
    'บริษัทสั่งซื้อสินค้า(suppliers)' => array('index'),
    'เพิ่ม',
);
?>

<h4>เพิ่มบริษัทสั่งซื้อสินค้า(suppliers)</h4>
<?php $this->renderPartial('_form', array('model' => $model)); ?>