<?php
/* @var $this CenterStockunitController */
/* @var $model CenterStockunit */

$this->breadcrumbs = array(
    'คลังสินค้า' => Yii::app()->createUrl('store/index'),
    'หน่วยนับ' => array('index'),
    //$model->id=>array('view','id'=>$model->id),
    'Update',
);

?>

<h4>แก้ไขหน่วยนับ <?php echo $model->unit; ?></h4>
<hr/>
<?php $this->renderPartial('_form', array('model' => $model)); ?>