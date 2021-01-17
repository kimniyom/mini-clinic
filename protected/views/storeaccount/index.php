<?php
/* @var $this StoreaccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'บัญชีธนาคาร',
);

?>

<h4>บัญชีธนาคาร</h4>

<?php $this->widget('zii.widgets.GridView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
