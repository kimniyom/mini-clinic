<style type="text/css">
    .row{
        margin-bottom: 10px;
    }
</style>
<div class="form well">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'storeaccount-form',
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
        <div class="col-md-2 col-lg-2">
            <?php echo $form->labelEx($model, 'accountnumber'); ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?php echo $form->textField($model, 'accountnumber', array('size' => 20, 'maxlength' => 20)); ?>
            <?php echo $form->error($model, 'accountnumber'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-lg-2">
            <?php echo $form->labelEx($model, 'accountname'); ?>
        </div>
        <div class="col-md-8 col-lg-8">
            <?php echo $form->textField($model, 'accountname', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'accountname'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-lg-2">
            <?php echo $form->labelEx($model, 'bank'); ?>
        </div>
        <div class="col-md-4 col-lg-4">
            <?php
            $form->widget('booster.widgets.TbSelect2', array(
                'model' => $model,
                'asDropDownList' => true,
                'attribute' => 'bank',
                //'name' => 'oid',
                'data' => CHtml::listData(Bank::model()->findAll(""), 'id', 'bankname'),
                //'value' => $model,
                'options' => array(
                    //$model,
                    //'oid',
                    //'tags' => array('clever', 'is', 'better', 'clevertech'),
                    'placeholder' => 'ธนาคาร',
                //'width' => '40%',
                //'tokenSeparators' => array(',', ' ')
                )
            ));
            ?>
            <?php echo $form->error($model, 'bank'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-lg-2">
            <?php echo $form->labelEx($model, 'bankbranch'); ?>
        </div>
        <div class="col-md-6 col-lg-6">
            <?php echo $form->textField($model, 'bankbranch', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'bankbranch'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2 col-lg-2"></div>
        <div class="col-md-8 col-lg-8">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',array('class' => 'btn btn-default')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->