<?php
/* @var $this DiagtypeController */
/* @var $model Diagtype */

$this->breadcrumbs=array(
	'Diagtypes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Diagtype', 'url'=>array('index')),
	array('label'=>'Create Diagtype', 'url'=>array('create')),
	array('label'=>'Update Diagtype', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Diagtype', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Diagtype', 'url'=>array('admin')),
);
?>

<h1>View Diagtype #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'typename',
	),
)); ?>
