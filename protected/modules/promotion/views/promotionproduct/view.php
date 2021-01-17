<?php
/* @var $this PromotionproductController */
/* @var $model Promotionproduct */

$this->breadcrumbs=array(
	'Promotionproducts'=>array('index'),
	$model->id,
);

?>

<h1>View Promotionproduct #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'number',
		'limit',
		'price',
		'active',
		'create_date',
	),
)); ?>
