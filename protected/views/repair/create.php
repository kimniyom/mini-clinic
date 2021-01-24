<?php

/* @var $this RepairController */
/* @var $model Repair */

$this->breadcrumbs = array(
    'รายจ่าย/ซ่อม - บำรุง' => array('index'),
    'เพิ่ม',
);
?>
<style type="text/css">
    input[type='text']{
        border-color: #333333;
    }

    .form-control{
        background: #111111;
    }
    .select2-container {
        background-color: #111111 !important;
        border-radius: 5px;
    }
    .select2-drop{
        background-color: #111111 !important;
        border-color: #333333;
        color:#666666;
    }
    .select2-search input {
        background-color: #111111 !important;
        border:none;
    }
    .select2-choice { background-color: #111111 !important; border-color:#222222 !important; height: 40px !important;}
    .select2-search { background-color: #111111 !important; margin-top: 10px;}
    .select2-arrow {
        border-left: 0px solid transparent !important;
        /* 2 */
    }
</style>
<h4>เพิ่มข้อมูลซ่อม - บำรุง(ครั้งต่อไป)</h4>

<?php if (Yii::app()->session['branch'] != '99') { ?>
    <?php $this->renderPartial('_form', array('model' => $model, 'datealert' => $datealert)); ?>
<?php } else { ?>
    <center>
        <h3>เมนูนี้สำหรับผู้จัดการร้าน ...!</h3>
    </center>
<?php } ?>
