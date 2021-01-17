<?php
/* @var $this ReturnproductController */
/* @var $model Returnproduct */

$this->breadcrumbs=array(
	'Returnproducts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Returnproduct', 'url'=>array('index')),
	array('label'=>'Create Returnproduct', 'url'=>array('create')),
	array('label'=>'View Returnproduct', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Returnproduct', 'url'=>array('admin')),
);
?>

<h1>Update Returnproduct <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>