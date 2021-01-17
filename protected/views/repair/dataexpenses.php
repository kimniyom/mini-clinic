<?php 
$dateNow = date("Y-m-d");
if($repair) { 
	?>
<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th style="text-align:center; width:10%;">วันที่</th>
			<th>รายการ</th>
			<th style="text-align:right; width:10%;">ค่าใช้จ่าย</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sum = 0;
	foreach($repair as $rs): 
		$sum = $sum + $rs['price'];
		?>
	<tr>
		<td style="text-align:center;"><?php echo $rs['date_alert'] ?></td>
		<td><?php echo $rs['object'] ?></td>
		<td style="text-align:right;"><?php echo number_format($rs['price'],2) ?></td>
		<td style="text-align:center;width:10%;">
			<?php if($rs['date_alert'] == $dateNow) { ?>
				<a href="javascript:deleteexpenses('<?php echo $rs['id'] ?>')"><i class="fa fa-trash text-danger"></i></a>
			<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr style="color:red;">
			<th colspan="2" style="text-align:center;">รวม</th>
			<th style="text-align:right;"><?php echo number_format($sum,2)?></th>
			<th></th>
		</tr>
	</tfoot>
</table>
    <?php } else { ?>
        <center>ไม่มีข้อมูล</center>
	<?php } ?>
	
	<script type="text/javascript">
		function deleteexpenses(id){
			var r = confirm("Are you sure...");
			if(r == true){
				var url = "<?php echo Yii::app()->createUrl('repair/deleteexpenses') ?>";
				var data = {id: id};
				$.post(url,data,function(){
					getdatas();
				});
			}
		}
	</script>
	