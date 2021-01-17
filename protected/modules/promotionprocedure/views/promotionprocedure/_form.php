<style type="text/css">
    .row{
        margin-bottom: 5px;
    }
</style>
<div class="form">

    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'verticalForm',
        'htmlOptions' => array('class' => 'well'),
            )
    ); // for inset effect); 
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'diag'); ?>
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <?php
            $form->widget('booster.widgets.TbSelect2', array(
                'model' => $model,
                'asDropDownList' => true,
                'attribute' => 'diag',
                //'name' => 'oid',
                'data' => CHtml::listData(Diag::model()->findAll(), 'diagcode', 'diagname'),
                //'value' => $model,
                'options' => array(
                    //$model,
                    //'oid',
                    //'tags' => array('clever', 'is', 'better', 'clevertech'),
                    'placeholder' => 'เลือกหัตถการ',
                    'width' => '100%',
                //'tokenSeparators' => array(',', ' ')
                )
            ));
            ?>
            <?php echo $form->error($model, 'diag'); ?>
        </div>
    </div>

        <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'month'); ?>
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <?php
            $monthNow = date("m");
            if(strlen($monthNow) < 2){
                $months = "0".$monthNow;
            } else {
                $months = $monthNow;
            }
            $form->widget('booster.widgets.TbSelect2', array(
                'model' => $model,
                'asDropDownList' => true,
                'attribute' => 'month',
                //'name' => 'oid',
                'data' => CHtml::listData(Month::model()->findAll("id>='$months'"), 'id', 'month_th'),
                //'value' => $model,
                'options' => array(
                    //$model,
                    //'oid',
                    //'tags' => array('clever', 'is', 'better', 'clevertech'),
                    'placeholder' => 'ประจำเดือน',
                    'width' => '100%',
                //'tokenSeparators' => array(',', ' ')
                )
            ));
            ?>
            <?php echo $form->error($model, 'month'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'number'); ?>
        </div>
        <div class="col-md-3 col-lg-2 col-sm-7 col-xs-12">
            <?php echo $form->textField($model, 'number', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'number'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'limit'); ?>
        </div>
        <div class="col-md-3 col-lg-2 col-sm-7 col-xs-12">
            <?php echo $form->textField($model, 'limit', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'limit'); ?>
        </div>
    </div>
    <!--
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php //echo $form->labelEx($model, 'date_start'); ?>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-7 col-xs-12">
            <?php
            /*
            $form->widget(
                    'booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'date_start',
                'options' => array(
                    'language' => 'th',
                    'type' => 'date',
                    'format' => 'yyyy-mm-dd',
                )
                    )
            );
            */
            ?>
            <?php //echo $form->error($model, 'date_start'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php //echo $form->labelEx($model, 'date_end'); ?>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-7 col-xs-12">
            <?php
            /*
            $form->widget(
                    'booster.widgets.TbDatePicker', array(
                'model' => $model,
                'attribute' => 'date_end',
                'options' => array(
                    'language' => 'th',
                    'type' => 'date',
                    'format' => 'yyyy-mm-dd',
                )
                    )
            );
            */
            ?>
            <?php //echo $form->error($model, 'date_end'); ?>
        </div>
    </div>
    -->
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'price'); ?>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-7 col-xs-12">
            <?php echo $form->textField($model, 'price', array('size' => 10, 'maxlength' => 10, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'price'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'status', array("label" => "สถานะ")); ?>
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <?php echo $form->radioButtonList($model, 'status', array("0" => "ใช้", "1" => "ไม่ใช้")); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            <?php echo $form->labelEx($model, 'detail'); ?>
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <?php echo $form->textArea($model, 'detail', array('rows' => '5', 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'detail'); ?>
        </div>
    </div>
<hr/>
    <div class="row buttons">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12"></div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'บันทึกข้อมูล' : 'แก้ไข', array('class' => 'btn btn-default')); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->