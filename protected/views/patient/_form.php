<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>

<style type="text/css">
    .form .row{
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
    <div class="panel panel-default" style=" margin-bottom: 0px;">
        <div class="panel-heading"><?php echo $head ?></div>
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'patient-form',
            // Please note: When you enable ajax validation, make sure the corresponding
            // controller action is handling ajax validation correctly.
            // There is a call to performAjaxValidation() commented in generated controller code.
            // See class documentation of CActiveForm for details on this.
            'enableAjaxValidation' => false,
        ));
        ?>

        <div class="panel-body" id="form-patient-body">
            <p class="note">Fields with <span class="required">*</span> are required.</p>
            <div style=" color: #ff0033;">
                <?php echo $form->errorSummary($model); ?>
            </div>
            <h4><i class="fa fa-user"></i> ข้อมูลทั่วไป</h4>
            <hr/>
            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'oid'); ?>
                </div>
                <div class="col-lg-3">
                    <?php
//echo CHtml::dropDownList('oid', $model, CHtml::listData(Pername::model()->findAll(""), 'oid', 'pername'), array('class' => 'form-control')
//echo $form->dropDownList($model, 'oid', CHtml::listData(Pername::model()->findAll(""), 'oid', 'pername'), array('class' => 'form-control'));
                    ?>

                    <?php
                    $form->widget('booster.widgets.TbSelect2', array(
                        'model' => $model,
                        'asDropDownList' => true,
                        'attribute' => 'oid',
                        //'name' => 'oid',
                        'data' => CHtml::listData(Pername::model()->findAll(""), 'oid', 'pername'),
                        //'value' => $model,
                        'options' => array(
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => 'คำนำหน้าชื่อ',
                        //'width' => '40%',
                        //'tokenSeparators' => array(',', ' ')
                        ),
                    ));
                    /*
                      $this->widget(
                      'booster.widgets.TbSelect2', array(
                      'asDropDownList' => true,
                      'name' => 'clevertech1',
                      'options' => array(
                      //'tags' => array('clever', 'is', 'better', 'clevertech'),
                      'placeholder' => 'type clever, or is, or just type!',
                      'width' => '40%',
                      'tokenSeparators' => array(',', ' ')
                      )
                      )
                      );
                     *
                     */
                    ?>

                    <?php echo $form->error($model, 'oid'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'name'); ?>
                </div>
                <div class="col-lg-10">
                    <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'lname'); ?>
                </div>
                <div class="col-lg-10">
                    <?php echo $form->textField($model, 'lname', array('size' => 60, 'maxlength' => 100, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'lname'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'card'); ?>
                </div>
                <div class="col-lg-5">
                    <?php //echo $form->textField($model, 'card', array('size' => 60, 'maxlength' => 13, 'class' => 'form-control')); ?>

                    <?php
                    $form->widget("ext.maskedInput.MaskedInput", array(
                        "model" => $model,
                        "attribute" => "card",
                        //"id" => 'card',
                        //"name" => 'card',
                        "mask" => '9-9999-99999-99-9',
                        "clientOptions" => array("autoUnmask" => true), /* autoUnmask defaults to false */
                        "defaults" => array("removeMaskOnSubmit" => false),
                            /* once defaults are set will be applied to all the masked fields  removeMaskOnSubmit defaults to true */
                    ));
                    ?>
                    <?php echo $form->error($model, 'card'); ?>

                </div>
            </div>


            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'sex'); ?>
                </div>
                <div class="col-lg-3">
                    <?php
                    $DATASEX = array("M" => "ชาย", "F" => "หญิง");
                    echo $form->dropDownList($model, 'sex', $DATASEX, array('empty' => '== เลือกเพศ ==', 'class' => 'form-control')
                    );
                    ?>
                    <?php echo $form->error($model, 'sex'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'birth'); ?>
                </div>
                <div class="col-lg-4">
                    <?php
                    $form->widget(
                            'booster.widgets.TbDatePicker', array(
                        'model' => $model,
                        'attribute' => 'birth',
                        'options' => array(
                            'language' => 'th',
                            'type' => 'date',
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ),
                            )
                    );
                    ?>

                    <?php echo $form->error($model, 'birth'); ?>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'occupation'); ?>
                </div>
                <div class="col-lg-8">
                    <?php
                    $form->widget('booster.widgets.TbSelect2', array(
                        'model' => $model,
                        'asDropDownList' => true,
                        'attribute' => 'occupation',
                        //'name' => 'oid',
                        'data' => CHtml::listData(Occupation::model()->findAll(""), 'id', 'occupationname'),
                        //'value' => $model,
                        'options' => array(
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => 'อาชีพ',
                            'width' => '100%',
                        //'tokenSeparators' => array(',', ' ')
                        ),
                    ));
                    ?>

                    <?php echo $form->error($model, 'occupation'); ?>
                </div>
            </div>

            <h4><i class="fa fa-phone"></i> ข้อมูลติดต่อ</h4>
            <hr/>
            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'tel'); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo $form->textField($model, 'tel', array('size' => 10, 'maxlength' => 10, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'tel'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'email'); ?>
                </div>
                <div class="col-lg-9">
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'contact'); ?>
                </div>
                <div class="col-lg-5">
                    <?php echo $form->textArea($model, 'contact', array('rows' => 5, 'class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'contact'); ?>
                </div>
            </div>

            <h4><i class="fa fa-home"></i> ข้อมูลสาขา</h4>
            <hr/>
            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'branch'); ?>
                </div>
                <div class="col-lg-6">
                    <?php
                    if (Yii::app()->session['branch'] == '99') {
                        $where = " id != '99'";
                    } else {
                        $branch_id = Yii::app()->session['branch'];
                        $where = "id = '$branch_id'";
                    }
                    $form->widget('booster.widgets.TbSelect2', array(
                        'model' => $model,
                        'asDropDownList' => true,
                        'attribute' => 'branch',
                        //'name' => 'oid',
                        'data' => CHtml::listData(Branch::model()->findAll($where), 'id', 'branchname'),
                        //'value' => $model,
                        'options' => array(
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => 'สถานบริการที่เข้ารับ',
                            'width' => '100%',
                        //'tokenSeparators' => array(',', ' ')
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'branch'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'type'); ?>
                </div>
                <div class="col-lg-6">
                    <?php
                    $form->widget('booster.widgets.TbSelect2', array(
                        'model' => $model,
                        'asDropDownList' => true,
                        'attribute' => 'type',
                        //'name' => 'oid',
                        'data' => CHtml::listData(Gradcustomer::model()->findAll(""), 'id', 'grad'),
                        //'value' => $model,
                        'options' => array(
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => 'ประเภทลูกค้า',
                            'width' => '100%',
                        //'tokenSeparators' => array(',', ' ')
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model, 'type'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2">
                    <?php echo $form->labelEx($model, 'create_date'); ?>
                </div>
                <div class="col-lg-5">
                    <?php
                    $form->widget(
                            'booster.widgets.TbDatePicker', array(
                        'model' => $model,
                        'attribute' => 'create_date',
                        'options' => array(
                            'background' => '#FFFFFF',
                            'language' => 'th',
                            'type' => 'date',
                            'format' => 'yyyy-mm-dd',
                            'autoclose' => true,
                        ),
                            )
                    );
                    ?>
                    <?php echo $form->error($model, 'create_date'); ?>
                </div>
            </div>


        </div>
        <div class="panel-footer">
            <div class="row" style="padding:0px; margin: 0px;">
                <div class="col-lg-2"></div>
                <div class="col-lg-10">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-success')); ?>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->

<script type="text/javascript">
    setscreen();
    function setscreen() {
        var w = window.innerWidth;
        var h = window.innerHeight;
        var screen = (h - 200);
        if (w >= 768) {
            $("#form-patient-body").css({'height': screen, 'overflow': 'auto'});
        }
    }
</script>