<?php
/* @var $this RepairController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'รายการค่าใช้จ่าย',
);

?>

<h4>รายการค่าใช้จ่าย</h4>
<a href="<?php echo Yii::app()->createUrl('repair/createexpenses') ?>">
<button type="button" class="btn btn-default"><i class='fa fa-plus'></i> บันทึกรายจ่าย</button></a>

<div class="well">
<div class="row" style="margin-bottom:10px;">
    <div class="col-lg-3 col-md-4">
        ตั้งแต่<br/>
        <?php
$this->widget(
	'booster.widgets.TbDatePicker', array(
		//'model' => $model,
		//'attribute' => 'birth',

		'name' => 'datestart',
		'id' => 'datestart',
		'value' => date("Y-m-d"),
		'options' => array(
			'class' => 'form-control',
			'language' => 'th',
			'type' => 'date',
			'format' => 'yyyy-mm-dd',
			'autoclose' => true,
		),
	)
);
?>
    </div>
    <div class="col-lg-3 col-md-4">
	ถึง<br/>
        <?php
$this->widget(
	'booster.widgets.TbDatePicker', array(
		//'model' => $model,
		//'attribute' => 'birth',
		'name' => 'dateend',
		'id' => 'dateend',
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
	<div class="row">
    <div class="col-lg-3 col-md-4">
	เลือกสาขา
        <select id="branch" class="form-control">
            <?php foreach ($branchlist as $rs): ?>
                <option value="<?php echo $rs['id'] ?>"><?php echo $rs['branchname'] ?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="col-lg-2 col-md-4" style=" padding-top: 20px;">
        <button type="button" class="btn btn-default btn-block" onclick="getdatas()">ตกลง</button>
    </div>
</div>
<p style="color:red;">*ลบรายการได้เฉพาะวันที่ปัจุบันเท่านั้น</p>
	<div id="dataexpenses" style="margin-top:10px;"></div>
	</div>


	<script type="text/javascript">
	getdatas();
		function getdatas(){
			var url = "<?php echo Yii::app()->createUrl('repair/dataexpenses') ?>";
			var datestart = $("#datestart").val();
			var dateend = $("#dateend").val();
			var branch = $("#branch").val();
			var data = {branch:branch,datestart:datestart,dateend:dateend};
			$.post(url,data,function(datas){
				$("#dataexpenses").html(datas);
			});
		}
	</script>