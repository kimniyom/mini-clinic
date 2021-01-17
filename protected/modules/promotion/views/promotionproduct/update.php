<?php
/* @var $this PromotionproductController */
/* @var $model Promotionproduct */

$this->breadcrumbs=array(
	'Promotionproducts'=>array('index'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>

<h1>Update Promotionproduct <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>