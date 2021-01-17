<?php
/* @var $this PromotionprocedureregisterController */
/* @var $model Promotionprocedureregister */

$this->breadcrumbs=array(
	'Promotionprocedureregisters'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Promotionprocedureregister', 'url'=>array('index')),
	array('label'=>'Create Promotionprocedureregister', 'url'=>array('create')),
	array('label'=>'View Promotionprocedureregister', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Promotionprocedureregister', 'url'=>array('admin')),
);
?>

<h1>Update Promotionprocedureregister <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>