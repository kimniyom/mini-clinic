<?php
/* @var $this DiagtypeController */
/* @var $data Diagtype */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('typename')); ?>:</b>
	<?php echo CHtml::encode($data->typename); ?>
	<br />


</div>