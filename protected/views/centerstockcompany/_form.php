<?php
/* @var $this CenterStockcompanyController */
/* @var $model CenterStockcompany */
/* @var $form CActiveForm */
?>
<style type="text/css">
    .form .row{
        margin: 0px 0px 10px 0px;
    }
    input[type='text'], textarea {
        background: #111111;
    }
    .form-control{
        background: #111111;
    }
</style>
<br/><br/>
<div class="form">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'type' => 'horizontal',
            //'htmlOptions' => array('class' => 'well'),
    ));
    ?>
    <?php echo $form->errorSummary($model); ?>
    <br/>
    <div class="row">
        <div class="col-lg-2" >
            <?php echo $form->labelEx($model, 'company_id'); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $form->textField($model, 'company_id', array('size' => 10, 'maxlength' => 10, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'company_id'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2" >
            <?php echo $form->labelEx($model, 'company_name'); ?>
        </div>
        <div class="col-lg-8">
            <?php echo $form->textField($model, 'company_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'company_name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2" >
            <?php echo $form->labelEx($model, 'taxnumber'); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $form->textField($model, 'taxnumber', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'taxnumber'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2" >
            <?php echo $form->labelEx($model, 'tel'); ?>
        </div>
        <div class="col-lg-3 col-md-3">
            <?php echo $form->textField($model, 'tel', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'tel'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2" >
            <?php echo $form->labelEx($model, 'address'); ?>
        </div>
        <div class="col-lg-8">
            <?php echo $form->textArea($model, 'address', array('rows' => 3, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'address'); ?>
        </div>
    </div>
    <hr/>
    <div class="row buttons">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'บันทึก' : 'บันทึก', array('class' => 'btn btn-success')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->