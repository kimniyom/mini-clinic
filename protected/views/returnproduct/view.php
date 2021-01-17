<?php
/* @var $this ReturnproductController */
/* @var $model Returnproduct */

$this->breadcrumbs=array(
	//'Returnproducts'=>array('index'),
	'ส่งคืนสินค้า',
);

?>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>สินค้า</th>
			<th style="text-align:center;">ล๊อต</th>
			<th style="text-align:right;">จำนวน / รายการ</th>
			<th>สาขา</th>
			<th>วันที่</th>
			<th>หมายเหตุ</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $i=0;foreach($product as $rs): $i++;?>
	<tr>
		<td><?php echo $i ?></td>
		<td>
			<?php  
			$Pdetail = CenterStockproduct::model()->find('product_id=:id',array(':id' => $rs['product_id'])); 
			echo $rs['product_id']." : ".$Pdetail['product_name'];
			?>
		</td>
		<td style="text-align:center;"><?php echo $rs['lotnumber'] ?></td>
		<td style="text-align:right;"><?php echo $rs['number'] ?></td>
		<td><?php echo Branch::model()->find('id=:id',array(':id' => $rs['branch']))['branchname'] ?></td>
		<td><?php echo $rs['create_date'] ?></td>
		<td><?php echo $rs['etc'] ? $rs['etc'] : "-"; ?></td>
		<th style="text-align:center;">
			<button type="button" class="btn btn-default" onclick="confirmreturn('<?php echo $rs['id'] ?>')"><i class="fa fa-check text-success"></i> Confirm</button>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>



<script type="text/javascript">
	function confirmreturn(id){
		var url = "<?php echo Yii::app()->createUrl('returnproduct/confirm')?>";
		var data = {id: id};
		$.post(url,data,function(datas){
			window.location.reload();
		});
	}
</script>
