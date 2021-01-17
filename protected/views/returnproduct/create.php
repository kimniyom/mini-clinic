<?php
/* @var $this ReturnproductController */
/* @var $model Returnproduct */

$this->breadcrumbs=array(
	'Returnproducts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Returnproduct', 'url'=>array('index')),
	array('label'=>'Manage Returnproduct', 'url'=>array('admin')),
);
?>

<h1>Create Returnproduct</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>