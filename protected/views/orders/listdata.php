<style type="text/css">
    #tablelistorder tfoot tr td{
        font-weight: bold;
    }
    #tablelistorder thead tr th{
        white-space: nowrap;
    }
</style>
<?php
$Thaibath = new Thaibaht();
?>

<table style=" width: 100%;" class="table table-bordered" id="tablelistorder">
    <thead>
        <tr>
            <th style=" text-align: center;">#</th>
            <th>รหัสสินค้า</th>
            <th>สินค้า</th>
            <th style=" text-align: center;">จำนวน</th>
            <th style=" text-align: center;">หน่วยนับ</th>
            <th style=" text-align: center;">ราคา/หน่วย</th>
            <th style="text-align: right;">ส่วนลด</th>
            <th style="text-align: right;">จำนวนเงิน</th>
            <th style=" text-align: center;">ยกเลิก</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sumproduct = 0;
        $sumdistcount = 0;
        $sumrow = 0;
        $sumAll = 0;
        $i = 0;
        $taxresult = 0;
        foreach ($order as $rs):
            $i++;
            $sumrow = ($rs['costs'] * $rs['number']);
            $sumAll = ($sumAll + $sumrow);
            $sumproduct = ($sumproduct + $rs['pricetotal']);
            $sumdistcount = ($sumdistcount + $rs['distcountprice']);

            //vat
            if ($vat == 1) {
                $tax = ($sumproduct * 7) / 100;
                $taxresult = number_format($tax, 2);
            } else if ($vat == 2) {
                $tax = ($sumproduct * 7) / 107;
                $taxresult = number_format($tax, 2);
            } else {
                $tax = 0;
                $taxresult = 0;
            }
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i ?></td>
                <td><?php echo $rs['product_id'] ?></td>
                <td><?php echo $rs['product_nameclinic'] ?></td>
                <td style=" text-align: center;"><?php echo number_format($rs['number']) ?></td>
                <td style=" text-align: center;"><?php echo $rs['unitname'] ?></td>
                <td style=" text-align: right;"><?php echo number_format($sumrow, 2) ?></td>
                <td style=" text-align: right;"><?php echo ($rs['distcountprice']) ? $rs['distcountprice'] : "" ?></td>
                <td style=" text-align: right;"><?php echo number_format($rs['pricetotal'], 2) ?></td>
                <td style=" text-align: center;">
                    <a href="javascript:deleteproduct('<?php echo $rs['id'] ?>')"><i class="fa fa-remove text-danger"></i></a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" rowspan="5">
                หมายเหตุ
            </td>
        </tr>
        <tr>
            <td>รวมเงิน</td>
            <td style=" text-align: right;"><?php echo number_format($sumAll, 2) ?></td>
            <td></td>
        </tr>
        <tr>
            <td>ส่วนลด</td>
            <td style=" text-align: right;"><?php echo number_format($sumdistcount, 2) ?></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <?php if ($vat == 2) { ?>
                    ยอดก่อนรวมภาษี
                <?php } else { ?>
                    ยอดหลังหักส่วนลด
                <?php } ?>
            </td>
            <td style=" text-align: right;">
                <?php
                if ($vat == 2) {
                    echo number_format($sumproduct - $taxresult, 2);
                } else {
                    echo number_format($sumproduct, 2);
                }
                ?>
            </td>
            <td></td>
        </tr>
        <tr>
            <td>ภาษีมูลค่าเพิ่ม 7 %</td>
            <td style=" text-align: right;">
                <?php
                echo $taxresult;
                ?>
            </td>
            <td></td>
        </tr>

        <tr>
            <td colspan="6" style=" text-align: center;">
                <?php
                //$pricetotal = number_format(($priceresult + $tax), 2);
                if ($vat == 2) {
                    $totalResult = $sumproduct;
                } else {
                    $totalResult = ($sumproduct + $taxresult);
                }
                $priceresult = $totalResult;
                $pricetotal = number_format(($priceresult), 2);
                $priceCovert = str_replace(",", "", $pricetotal);
                if (substr($priceCovert, -2) == "00") {
                    $priceCoverts = str_replace(".00", "", $priceCovert);
                } else {
                    $priceCoverts = $priceCovert;
                }

                echo "(" . $Thaibath->convert($priceCoverts) . ")";
                ?>
            </td>
            <td>รวมเงินทั้งสิ้น</td>
            <td style=" text-align: right;"><?php echo number_format(sprintf('%.2f', $priceCovert), 2); ?></td>
            <td></td>
        </tr>

        <input type="text" name="priceresult" id="priceresult" value="<?php echo $priceresult ?>">
    </tfoot>
</table>



<script type="text/javascript">
    function deleteproduct(id) {
        var r = confirm("Are you sure ...?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('listorder/deleteproduct') ?>";
            var data = {id: id};
            $.post(url, data, function(success) {
                loaddata();
            });
        }
    }
</script>
