<?php
/* @var $this StoreaccountController */
/* @var $model Storeaccount */

$this->breadcrumbs=array(
	'บัญชีธนาคาร'=>array('index'),
	'เพิ่ม',
);

?>

<h2>เพิ่มบัญชี </h2>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>