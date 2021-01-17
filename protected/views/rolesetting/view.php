<?php
/* @var $this RoleSettingController */
/* @var $model RoleSetting */

$this->breadcrumbs=array(
	'Role Settings'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RoleSetting', 'url'=>array('index')),
	array('label'=>'Create RoleSetting', 'url'=>array('create')),
	array('label'=>'Update RoleSetting', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RoleSetting', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RoleSetting', 'url'=>array('admin')),
);
?>

<h1>View RoleSetting #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'setting_id',
		'user_id',
	),
)); ?>
