<?php
/* @var $this PromotionproductController */
/* @var $model Promotionproduct */

$this->breadcrumbs=array(
	'Promotionproducts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Promotionproduct', 'url'=>array('index')),
	array('label'=>'Manage Promotionproduct', 'url'=>array('admin')),
);
?>

<h1>Create Promotionproduct</h1>
<?php echo $error ?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>