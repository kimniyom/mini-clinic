<?php
/* @var $this RepairController */
/* @var $model Repair */

$this->breadcrumbs=array(
	'รายจ่าย/ซ่อม - บำรุง'=>array('index'),
	'เพิ่ม',
);

?>

<h4>เพิ่มข้อมูลซ่อม - บำรุง(ครั้งต่อไป)</h4>

<?php if (Yii::app()->session['branch'] != '99') { ?>
<?php $this->renderPartial('_form', array('model'=>$model,'datealert' => $datealert)); ?>
<?php } else { ?>
<center>
    <h3>เมนูนี้สำหรับผู้จัดการร้าน ...!</h3>
</center>
<?php } ?>
