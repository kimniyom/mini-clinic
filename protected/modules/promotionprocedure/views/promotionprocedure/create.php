<?php
/* @var $this PromosionprocedureController */
/* @var $model Promosionprocedure */

$this->breadcrumbs=array(
	'โปรโมชั่น'=>array('index'),
	'สร้างโปรโมชั่น(ประจำเดือน)',
);

?>

<h4><i class="fa fa-calendar"></i> สร้างโปรโมชั่น(ประจำเดือน)</h4>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>