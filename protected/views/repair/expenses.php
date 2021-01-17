<style>
	.row{
		margin:0px;
		margin-bottom: 10px;
	}
</style>
<?php
/* @var $this RepairController */
/* @var $model Repair */

$this->breadcrumbs = array(
	'รายการค่าใช้จ่าย' => array('repair/expenses'),
	'บัญชีรายจ่าย',
);

?>

<center><h4>บันทึกรายจ่าย</h4>
<p style="color:red;">เครื่องหมาย * ห้ามว่าง</p>
</center>
<div class="row">
	<div class="col-md-2 col-lg-2">รายการ *</div>
	<div class="col-md-10 col-lg-10">
		<input type="text" class="form-control" id="object"/>
	</div>
</div>
<div class="row">
	<div class="col-md-2 col-lg-2">รายละเอียด</div>
	<div class="col-md-10 col-lg-10">
		<textarea class="form-control" id="detail" rows="5"></textarea>
	</div>
</div>
<div class="row">
	<div class="col-md-2 col-lg-2">จำนวนเงิน *</div>
	<div class="col-md-3 col-lg-3">
		<input type="text" class="form-control" id="price" onKeyUp="if (this.value * 1 != this.value) this.value = '';"/>
	</div>
</div>

<div class="row">
	<div class="col-md-2 col-lg-2">วันที่ *</div>
	<div class="col-md-4 col-lg-4">
		<?php
$this->widget(
	'booster.widgets.TbDatePicker', array(
		//'model' => $model,
		//'attribute' => 'birth',
		'name' => 'date_alert',
		'id' => 'date_alert',
		'value' => date("Y-m-d"),
		'options' => array(
			'language' => 'th',
			'type' => 'date',
			'format' => 'yyyy-mm-dd',
			'autoclose' => true,
		),
	)
);
?>
	</div>
</div>

<hr/>
<div class="row">
	<div class="col-md-2 col-lg-2"></div>
	<div class="col-md-4 col-lg-4">
		<button type="button" class="btn btn-default" onclick="save()"><i class="fa fa-save"></i> บันทึก</button>
	</div>
</div>

<script type="text/javascript">
	function save(){
		var url = "<?php echo Yii::app()->createUrl('repair/saveexpenses') ?>";
		var object = $("#object").val();
		var detail = $("#detail").val();
		var price = $("#price").val();
		var date_alert = $("#date_alert").val();

		if(object == "" || price == "" || date_alert == ""){
			alert("กรอกข้อมูลไม่ครบ");
			return false;
		}

		var data = {
			object: object,
			detail: detail,
			price: price,
			date_alert: date_alert
		};

		$.post(url,data,function(datas){
			window.location="<?php echo Yii::app()->createUrl('repair/expenses') ?>";
		});
	}
</script>
