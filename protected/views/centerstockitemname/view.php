<?php
/* @var $this CenterStockitemNameController */
/* @var $model CenterStockitemName */

$this->breadcrumbs=array(
	'รายการวัตถุดิบ'=>array('index'),
	$model->id,
);

?>

<h4>ItemName #<?php echo $model->id; ?></h4>

<?php $this->widget('booster.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'itemcode',
		'itemname',
		'price',
		[
        	'format'=>'html',
        	'label' => 'หน่วยนับ',
        	'value' => CenterStockunit::model()->find("id='2'")['unit']
    	]
	),
)); ?>
