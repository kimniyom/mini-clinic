<style type="text/css">
    .row{
        margin: 0px;
        margin-bottom: 10px;
    }
</style>
<div class="form">
    <?php
    $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
        'id' => 'verticalForm',
        'htmlOptions' => array('class' => 'well'),
            )
    );
    $ProductList = CenterStockproduct::model()->findAll("private=:private", array(":private" => "0"));
    ?>
    <div class="row" style=" margin: 0px;">
        <div class="col-md-8 col-lg-8">
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($model); ?>

            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php echo $form->labelEx($model, 'product_id'); ?>
                </div>
                <div class="col-md-6 col-lg-6">
                    <?php
                    $form->widget('booster.widgets.TbSelect2', array(
                        'model' => $model,
                        'asDropDownList' => true,
                        'attribute' => 'product_id',
                        //'name' => 'oid',
                        'data' => CHtml::listData($ProductList, 'product_id', 'product_nameclinic'),
                        //'value' => $model,
                        'options' => array(
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => 'เลือกสินค้า',
                            'width' => '100%',
                        //'tokenSeparators' => array(',', ' ')
                        ),
                        'events' => array('change' => 'js:function(e) { 
                            getproduct(this.value);
                        }'),
                    ));
                    ?>
                    <?php echo $form->error($model, 'product_id'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php echo $form->labelEx($model, 'promotionname'); ?>
                </div>
                <div class="col-md-10 col-lg-10">
                    <?php echo $form->textField($model, 'promotionname',array('class' => 'form-control')); ?>
                    <?php echo $form->error($model, 'promotionname'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php echo $form->labelEx($model, 'number'); ?>
                </div>
                <div class="col-md-3 col-lg-3">
                    <?php echo $form->textField($model, 'number'); ?>
                    <?php echo $form->error($model, 'number'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php echo $form->labelEx($model, 'limit'); ?>
                </div>
                <div class="col-md-3 col-lg-2">
                    <?php echo $form->textField($model, 'limit'); ?>
                    <?php echo $form->error($model, 'limit'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php echo $form->labelEx($model, 'price'); ?>
                </div>
                <div class="col-md-4 col-lg-4">
                    <?php echo $form->textField($model, 'price', array('size' => 10, 'maxlength' => 10)); ?>
                    <?php echo $form->error($model, 'price'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2 col-lg-2">
                    <?php echo $form->labelEx($model, 'active'); ?>
                </div>
                <div class="col-md-4 col-lg-4">
                    <?php echo $form->radioButtonList($model, 'active', array('0' => 'ใช้', '1' => 'ไม่ใช้')); ?>
                    <?php echo $form->error($model, 'active'); ?>
                </div>
            </div>

            <hr/>
            <div class="row buttons">
                <div class="col-md-2 col-lg-2"></div>
                <div class="col-md-4 col-lg-4">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'บันทึก' : 'แก้ไข', array('class' => 'btn btn-success')); ?>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div id="detailproduct"></div>
        </div>
    </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    function getproduct(product_id){
        var url = "<?php echo Yii::app()->createUrl('centerstockproduct/getdetail')?> ";
        var data = {product_id: product_id};
        $.post(url,data,function(datas){
            $("#detailproduct").html(datas);
        });
    }
</script>