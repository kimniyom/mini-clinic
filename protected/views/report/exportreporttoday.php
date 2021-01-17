<?php
//คำสั่ง connect db เขียนเพิ่มเองนะ

$strExcelFileName = "รายการขายวันที่" . $date . ".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$year = Yii::app()->session['budgetyear'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php $moDel = new Report();?>
    </head>
    <body>
    	<table style=" width: 100%; color:orange;" id="font-16" class="table table-bordered">
        <tbody>
          <tr>
              <td style="text-align:center;">#</td>
              <td>ลูกค้า</td>
              <td>รายการ</td>
              <td style="text-align:center;">ยอด</td>
          </tr>
            <?php
$sum = 0;
$i = 0;
$sum = 0;
foreach ($list as $rs):
	$i++;
	$branch = $rs['branch'];
	$patientId = $rs['patient_id'];
	$sellList = $moDel->getPatientService($patientId, $branch, $date);
	//ดึง Service ลูกค้าแต่ละคนว่ามีกี่ service
	$serviceList = $moDel->getServicePatient($patientId, $branch, $date);
	?>
			            <tr>
			                <td style=" text-align: center;"><?php echo $i ?></td>
			                <td><?php echo $rs['name'] . ' ' . $rs['lname'] ?></td>
			                <td></td>
			                <td></td>
			            </tr>
						<?php
	foreach ($sellList as $rss) {
		$sum = $sum + $rss['price'];
		?>
			            <tr>
			                <td></td>
			                <td></td>
			                <td><?php echo $rss['productname'] ?></td>
			                <td style="text-align:right;"><?php echo $rss['price'] ?></td>
			            </tr>
			            <?php }?>
			            <?php
	foreach ($serviceList as $rsService) {
		$detailList = $moDel->getDetailServiceAll($rsService['id']);
		foreach ($detailList as $detailLists) {
			$sum = $sum + $detailLists['total'];
			?>
			            <tr>
			                <td></td>
			                <td></td>
			                <td><?php echo $detailLists['detail'] ?></td>
			                <td style="text-align:right;"><?php echo $detailLists['total'] ?></td>
			            </tr>
			            <?php
	}
	}
	?>
			            <?php endforeach;?>

      <tr>
  			<td></td>
        <td></td>
  			<td style="text-align:center;">รวม</td>
  			<td style="text-align:right;"><?php echo number_format($sum, 2) ?></td>
      </tr>
		</tbody>
    </table>
    </body>
    </html>
