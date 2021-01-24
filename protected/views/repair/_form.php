<style type="text/css">
    .row{
        margin-bottom: 10px;
    }

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

<div class="form">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'type' => 'horizontal',
        'htmlOptions' => array('class' => 'well'),
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3 col-lg-3">
            <?php echo $form->labelEx($model, 'object'); ?>
        </div>
        <div class="col-md-9 col-lg-9">
            <?php echo $form->textField($model, 'object', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'object'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3">
            <?php echo $form->labelEx($model, 'detail'); ?>
        </div>
        <div class="col-md-9 col-lg-9">
            <?php echo $form->textArea($model, 'detail', array('size' => 60, 'maxlength' => 255, 'rows' => 6, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'detail'); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-3 col-lg-3">
            <?php echo $form->labelEx($model, 'date_alert'); ?>
        </div>
        <div class="col-md-9 col-lg-9">
            <?php echo $form->textField($model, 'date_alert', array('value' => $datealert, 'class' => 'form-control', 'readonly' => 'readonly')); ?>
            <?php echo $form->error($model, 'date_alert'); ?>
        </div>
    </div>


    <hr/>
    <div class="row buttons">
        <div class="col-md-3 col-lg-3"></div>
        <div class="col-md-9 col-lg-9">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'บันทึก', array('class' => 'btn btn-success')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->