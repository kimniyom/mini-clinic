<?php
/* @var $this DiagtypeController */
/* @var $model Diagtype */

$this->breadcrumbs=array(
	'Diagtypes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Diagtype', 'url'=>array('index')),
	array('label'=>'Create Diagtype', 'url'=>array('create')),
	array('label'=>'View Diagtype', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Diagtype', 'url'=>array('admin')),
);
?>

<h1>Update Diagtype <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>