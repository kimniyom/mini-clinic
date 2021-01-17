<?php
/* @var $this DiagController */
/* @var $model Diag */
/* @var $form CActiveForm */
?>
<style type="text/css">
    .form .row{
        margin-bottom: 10px;
    }
</style>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'diag-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-lg-2">
            <?php echo $form->labelEx($model, 'diagname'); ?>
        </div>
        <div class="col-lg-10">
            <?php echo $form->textField($model, 'diagname', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'diagname'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2"><?php echo $form->labelEx($model, 'type'); ?></div>
        <div class="col-lg-10">
            <?php
            $form->widget('booster.widgets.TbSelect2', array(
                'model' => $model,
                'asDropDownList' => true,
                'attribute' => 'type',
                //'name' => 'oid',
                'data' => CHtml::listData(Diagtype::model()->findAll(""), 'id', 'typename'),
                //'value' => $model,
                'options' => array(
                    //$model,
                    //'oid',
                    //'tags' => array('clever', 'is', 'better', 'clevertech'),
                    'placeholder' => 'ประเภท',
                //'width' => '40%',
                //'tokenSeparators' => array(',', ' ')
                )
            ));
            ?>
            <?php echo $form->error($model, 'type'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <?php echo $form->labelEx($model, 'cost'); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $form->textField($model, 'cost', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'cost'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <?php echo $form->labelEx($model, 'price'); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $form->textField($model, 'price', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'price'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <?php echo $form->labelEx($model, 'action'); ?>
        </div>
        <div class="col-lg-10">
            <?php echo $form->textArea($model, 'action', array('rows' => '6','class' => 'form-control')); ?>
            <?php echo $form->error($model, 'action'); ?>
        </div>
    </div>

    <div class="row buttons">
        <div class="col-lg-2"></div>
        <div class="col-lg-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-success')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->