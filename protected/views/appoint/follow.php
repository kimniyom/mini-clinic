<style type="text/css">
	table thead th{
		font-size:20px;
		color:#FFFFFF;
	}
	table tfoot th{
		font-size:24px;
		color:#FFFFFF;
	}


</style>
<?php
$this->breadcrumbs = array(
	//''=>array('index'),
	'ประวัติการติดตามนัดลูกค้า',
);

$moDel = new Report();
$Config = new Configweb_model();
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
	    <div class="col-lg-3">
        เลือกสาขา
        <select id="branch" class="form-control">
        	<option value="">== เลือกสาขา ==</option>
            <?php foreach ($branchlist as $rs): ?>
                <option value="<?php echo $rs['id'] ?>" <?php echo ($rs['id'] == $branch) ? "selected=selecred" : ""; ?>><?php echo $rs['branchname'] ?></option>
            <?php endforeach;?>
        </select>
    </div>
	<div class="col-md-6 col-lg-6">
		<button type="button" class="btn btn-success" onclick="getHistory()" style="margin-top:25px;">ดูข้อมูล</button>
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
                <th>การติดตาม</th>
                <th>พนักงาน</th>
                <th>วันที่ติดตาม</th>
            </tr>
        </thead>
        <tbody>
            <?php
$i = 0;
foreach ($list as $rs):
	$i++;
	?>
											            <tr>
											                <td style=" text-align: center;"><?php echo $i ?></td>
											                <td><?php echo $rs['cus_name'] ?></td>
											                <td><?php echo $rs['contact'] ?></td>
											                <td><?php echo $rs['emp_name'] ?></td>
											                <td><?php echo $Config->thaidate($rs['datecontact']) ?></td>
											            </tr>
								<?php endforeach;?>
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
		var branch = $("#branch").val();
		if(branch == ""){
			alert("กรุณาเลือกสาขา ...");
			return false;
		}
		window.location="<?php echo Yii::app()->createUrl('appoint/follow') ?>" + "&branch=" + branch;
	}

	function exportAll(){
		var date = $("#datereport").val();
		if(branch == ""){
			alert("กรุณาเลือกสาขา ...");
			return false;
		}
		window.location="<?php echo Yii::app()->createUrl('report/exportreportall') ?>" + "&date=" + date + "&branch=" + branch;
	}


</script>
