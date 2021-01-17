<style type="text/css">
	#box-report-today table thead th{
		font-size:30px;
		color:#FFFFFF;
	}
	#box-report-today table tfoot th{
		font-size:30px;
		color:#FFFFFF;
	}

	#box-report-today table tbody td{
		font-size:28px;
	}

	#box-report-today table tbody th{
		font-size:30px;
	}
</style>
<?php
$this->breadcrumbs = array(
	//''=>array('index'),
	'ประวัติการขาย / การให้บริการ',
);

$moDel = new Report();
?>
<style type="text/css">
#box-report-today table thead tr th {
    padding: 2px;
}

#box-report-today table tbody tr td {
    padding: 2px;
}
</style>
<div class="row" style="margin:0px;">
	<div class="col-md-4 col-lg-3 col-sm-6">
		<label>เลือกวันที่</label>
		<div>
			<?php
$this->widget('booster.widgets.TbDatePicker', array(
	//'model' => $model,
	//'attribute' => 'birth',
	'value' => $date,
	'id' => 'datereport',
	'name' => 'datereport',
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
	    <div class="col-lg-3 col-md-4 col-sm-6" style="display: none;">
	    	<label style="padding-bottom:0px; margin-bottom: 3px;">เลือกสาขา</label>
        <select id="branch" class="form-control">
        	<option value="">== เลือกสาขา ==</option>
            <?php foreach ($branchlist as $rs): ?>
                <option value="<?php echo $rs['id'] ?>" <?php echo ($rs['id'] == $branch) ? "selected=selecred" : ""; ?>><?php echo $rs['branchname'] ?></option>
            <?php endforeach;?>
        </select>
    </div>
	<div class="col-md-4 col-lg-3 col-sm-6 col-xs-12">
		<button type="button" class="btn btn-success btn-block" onclick="getHistory()" style="margin-top:23px;">ดูข้อมูล</button>
	</div>
</div>
<hr/>
<div class="row" style="margin:0px;">
<div class="col-md-12 col-lg-12">
<div id="box-report-today">
    <table style=" width: 100%; color:orange;" id="report" class="table table-bordered">
        <thead>
            <tr>
                <th style="text-align:center;">#</th>
                <th>ลูกค้า</th>
                <th>รายการ</th>
				<th style="text-align:center;">จำนวน</th>

            </tr>
        </thead>
        <tbody>
            <?php
$sellList = $moDel->getPatientService($branch, $date);
$i = 0;
$sum = 0;
foreach ($list as $rs):
	$i++;
	$branch = $rs['branch'];
	$patientId = $rs['patient_id'];

	//ดึง Service ลูกค้าแต่ละคนว่ามีกี่ service
	$serviceList = $moDel->getServicePatient($patientId, $branch, $date);
	?>
																																																																            <tr style="background:#000000;">
																																																																                <td style=" text-align: center;"><?php echo $i ?></td>
																																																																                <td><?php echo $rs['name'] . ' ' . $rs['lname'] ?></td>
																																																																                <td></td>
																																																																                <td></td>

																																																																            </tr>

																																																																            <?php
	foreach ($serviceList as $rsService) {
		$detailList = $moDel->getDetailServiceAll($rsService['id']);
		foreach ($detailList as $detailLists) {
			$sum = $sum + $detailLists['total'];
			?>
																																																																            <tr>
																																																																                <td></td>
																																																																                <td></td>
																																																																                <td style="color: <?php echo ($detailLists['type'] == 1) ? "red" : "" ?>"><?php echo $detailLists['detail'] ?></td>
																																																																				<td style="text-align:center;"><?php echo $detailLists['number'] ?></td>

																																																																            </tr>
																																																																            <?php
	}
	}
	?>
																																										<tr>
																																											<th></th>
																																											<th></th>
																																											<th></th>
																																											<th style="text-align: center;">ค่ารักษา <?php echo $moDel->sumServiceAll($patientId, $date) ?></th>
																																										</tr>
																																																																            <?php endforeach;?>
<!-- ขายยาไม่ตรวจ -->

																																																										            <tr>
																																																										                <td></td>
																																																										                <td></td>
																																																										                <td><?php echo $sellList['productname'] ?></td>
																																																														<td style="text-align:center;"><?php echo $sellList['price'] ?> บาท</td>

																																																										            </tr>

<!-- End -->

											<tr style="background: #ffffff; font-size: 24px; color:red;">
											<th></th>
											<th></th>
											<th style="text-align:center;">รวม</th>
											<th style="text-align:center;">
											<?php echo number_format($sum + $sellList['price'], 2) ?>
											</th>
										</tr>
        </tbody>

    </table>
</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#report").dataTable({
			//"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
			"bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
			//"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
			//"scrollCollapse": true,
			"bPaginate": false,
			"bFilter": true, // แสดง search box
			//"sScrollY": screenfull, // กำหนดความสูงของ ตาราง
			//"scrollX": true,
			"dom": "Bfrtip",
        	"bSort": false,
			'buttons': [
			{
							extend: 'excel',
							text: 'ส่งออก excel'
					}
			]
		});
	});
	function getHistory(){
		var date = $("#datereport").val();
		//var branch = $("#branch").val();
		/*
		if(branch == ""){
			alert("กรุณาเลือกสาขา ...");
			return false;
		}
		*/
		window.location="<?php echo Yii::app()->createUrl('report/reportsellall') ?>" + "&date=" + date + "&branch=" + 1;
	}

	function exportAll(){
		var date = $("#datereport").val();
		/*
		if(branch == ""){
			alert("กรุณาเลือกสาขา ...");
			return false;
		}
		*/
		window.location="<?php echo Yii::app()->createUrl('report/exportreportall') ?>" + "&date=" + date + "&branch=" + 1;
	}


</script>
