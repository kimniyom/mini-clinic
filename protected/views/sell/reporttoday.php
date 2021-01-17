<style type="text/css">
    #box-report-today table thead tr th{
        padding:2px;
    }
    #box-report-today table tbody tr td{
        padding:2px;
    }
</style>
<div id="box-report-today">
    <table style=" width: 100%; color:orange;" id="font-16" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>ลูกค้า</th>
                <th>รายการ</th>
                <th style="text-align:center;">จำนวน</th>
                <th style="text-align:center;">ยอด</th>
            </tr>
        </thead>
        <tbody>
            <?php
$sum = 0;
$i = 0;
foreach ($reporttoday as $rs):
	$i++;
	$sql = "select * from sell where sell_id = '" . $rs['sell_id'] . "' order by id asc";
	$result = Yii::app()->db->createCommand($sql)->queryAll();

	?>
			                <tr style="background:#000000;">
			                    <td style=" text-align: center;"><?php echo $i ?></td>
			                    <td><?php echo $rs['name'] . ' ' . $rs['lname'] ?></td>
			                    <td>
			                        <?php
	foreach ($result as $rss):
		echo $rss['productname'] . "<br/>";
	endforeach;
	?>
			                    </td>
			                    <td style="text-align:center;">
			                        <?php
	foreach ($result as $rss):
		echo $rss['number'] . "<br/>";
	endforeach;
	?>
			                    </td>
			                    <td style=" text-align: right;"><?php echo number_format($rs['total']) ?></td>

			                </tr>
			            <?php endforeach;?>
        </tbody>
    </table>
</div>

