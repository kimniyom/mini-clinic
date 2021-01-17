<style type="text/css">
    .row{
        margin-bottom: 5px;
    }
</style>
<?php
/* @var $this PromosionprocedureController */
/* @var $model Promosionprocedure */

$this->breadcrumbs=array(
    'โปรโมชั่น'=>array('index'),
    'สร้างโปรโมชั่น',
);

?>
<h4>แก้ไข</h4>
<div class="well">

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            หัตถการ <span class="required">*</span>
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <?php
            $this->widget('booster.widgets.TbSelect2', array(
                //'model' => $model,
                'asDropDownList' => true,
                'name' => 'diag',
                'id' => 'diag',
                'data' => CHtml::listData(Diag::model()->findAll(), 'diagcode', 'diagname'),
                'value' => $model->diag,
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
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            จำนวน/ครั้ง <span class="required">*</span>
        </div>
        <div class="col-md-3 col-lg-2 col-sm-7 col-xs-12">
            <input type='text' id="number" class="form-control" onKeyUp="if(this.value*1!=this.value) this.value='' ;" value="<?php echo $model->number ?>"/>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            ราคาทั้งคอร์ส <span class="required">*</span>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-7 col-xs-12">
            <input type='text' id="price" class="form-control" onKeyUp="if(this.value*1!=this.value) this.value='' ;" value="<?php echo $model->price ?>"/>
        
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
           สถานะ <span class="required">*</span>
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <input type="radio" name="status" id="status" value="0" <?php echo ($model->status == "0") ? "checked" : ""; ?>> ใช้<br/>
            <input type="radio" name="status" id="status" value="1" <?php echo ($model->status == "1") ? "checked" : ""; ?>> ไม่ใช้
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12">
            รายละเอียด
        </div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <textarea id="detail" class="form-control" rows="5"><?php echo $model->detail ?></textarea>
        </div>
    </div>
<hr/>
    <div class="row buttons">
        <div class="col-md-3 col-lg-3 col-sm-5 col-xs-12"></div>
        <div class="col-md-9 col-lg-9 col-sm-7 col-xs-12">
            <button type="button" class="btn btn-default" onclick="saves()">บันทึกข้อมูล</button>
        </div>
    </div>


</div><!-- form -->

<script type="text/javascript">
    function saves(){
      var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/saveupdatepromotion') ?>";
      var id = "<?php echo $model->id ?>";
      var diag = $("#diag").val();
      var number = $("#number").val();
      var price = $("#price").val();
      var status = $("#status").is(':checked') ? 1 : 0;
      var detail = $("#detail").val();
      if(diag == "" || number == "" || price == "" || status == ""){
        alert("กรอกข้อมูล * ไม่ครบ");
        return false;
      }
      var data = {
          id: id,
        diag: diag,
        number: number,
        price: price,
        status: status,
        detail: detail
      };
      $.post(url,data,function(datas){
        window.location="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/index') ?>";
      });
    }
</script>