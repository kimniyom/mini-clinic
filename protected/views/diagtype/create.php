<?php
/* @var $this DiagtypeController */
/* @var $model Diagtype */

$this->breadcrumbs=array(
	'Diagtypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Diagtype', 'url'=>array('index')),
	array('label'=>'Manage Diagtype', 'url'=>array('admin')),
);
?>

<h1>Create Diagtype</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>