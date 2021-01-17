<?php
/* @var $this StoreaccountController */
/* @var $model Storeaccount */

$this->breadcrumbs=array(
	'บัญชีธนาคาร'=>array('index'),
	$model->accountname=>array('view','id'=>$model->id),
	'แก้ไข',
);

?>

<h2>แก้ไข</h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>