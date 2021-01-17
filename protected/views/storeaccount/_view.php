<?php
/* @var $this StoreaccountController */
/* @var $data Storeaccount */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accountnumber')); ?>:</b>
	<?php echo CHtml::encode($data->accountnumber); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accountname')); ?>:</b>
	<?php echo CHtml::encode($data->accountname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bank')); ?>:</b>
	<?php echo CHtml::encode($data->bank); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bankbranch')); ?>:</b>
	<?php echo CHtml::encode($data->bankbranch); ?>
	<br />


</div>