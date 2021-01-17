<?php
/* @var $this PromotionprocedureregisterController */
/* @var $model Promotionprocedureregister */

$this->breadcrumbs=array(
	'Promotionprocedureregisters'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Promotionprocedureregister', 'url'=>array('index')),
	array('label'=>'Create Promotionprocedureregister', 'url'=>array('create')),
	array('label'=>'Update Promotionprocedureregister', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Promotionprocedureregister', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Promotionprocedureregister', 'url'=>array('admin')),
);
?>

<h1>View Promotionprocedureregister #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'pid',
		'branch',
		'promotion',
		'status',
		'create_date',
	),
)); ?>
