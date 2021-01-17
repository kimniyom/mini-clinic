<?php
/* @var $this PatientController */
/* @var $model Patient */

$this->breadcrumbs=array(
	'ข้อมูลลูกค้า'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'แก้ไข',
);
$head = "แก้ไขข้อมูล ".$model->name.' '.$model->lname;
?>



<?php $this->renderPartial('_form', array('model'=>$model,'head' => $head )); ?>