<?php
/* @var $this DiagtypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Diagtypes',
);

$this->menu=array(
	array('label'=>'Create Diagtype', 'url'=>array('create')),
	array('label'=>'Manage Diagtype', 'url'=>array('admin')),
);
?>

<h1>Diagtypes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
