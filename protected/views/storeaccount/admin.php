<?php
/* @var $this StoreaccountController */
/* @var $model Storeaccount */

$this->breadcrumbs=array(
	//'บัญชีธนาคาร'=>array('index'),
	'บัญชีธนาคาร',
);

?>

<h4>จัดการ บัญชีธนาคาร</h4>
<a href="<?php echo Yii::app()->createUrl('storeaccount/create')?>">
    <button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> เพิ่มบัญชีธนาคาร</button></a>
	<?php $this->widget('booster.widgets.TbGridView', array(
		'id'=>'storeaccount-grid',
		'dataProvider'=>$model->search(),
		//'filter'=>$model,
		'columns'=>array(
			//'id',
			'accountnumber',
			'accountname',
			array(   
	            'name'=>'bank',
	            'value'=>function($data){
	            	return Bank::model()->find("id=:id",array("id"=>$data->bank))['bankname'];
	            },
	        ),
			//'bank',
			'bankbranch',
			array(
				'class'=>'CButtonColumn',
				'htmlOptions' => array('style' => 'width: 100px;'),
			),
		),
	)); ?>



