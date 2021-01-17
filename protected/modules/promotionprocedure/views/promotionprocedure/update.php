<?php
/* @var $this PromosionprocedureController */
/* @var $model Promosionprocedure */

$this->breadcrumbs = array(
    'โปรโมชั่นทั้งหมด' => array('index'),
    $model->id => array('view', 'id' => $model->id),
    'แก้ไข',
);

?>

<h4>แก้ไขโปรโมชั่น <?php echo $model->id; ?></h4>

<?php $this->renderPartial('_form', array('model' => $model)); ?>