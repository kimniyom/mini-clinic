<style type="text/css">
    #box-control-order table thead tr th{
        padding:2px;
    }
    #box-control-order table tbody tr td{
        padding:2px;
    }
</style>
<div id="box-control-order">
    <table style=" width: 100%; color:orange;" id="font-16" class="table table-bordered">
        <thead>
            <tr style=" border-bottom: #efefef solid 1px;">
                <th style="text-align: center; width: 5%;">#</th>
                <th>รายการ</th>
                <th style=" text-align: center;">จำนวน</th>
                <th style=" text-align: right;">รวม</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sum = 0;
            $i = 0;
            foreach ($order as $rs):
                $i++;
                $sum = $sum + $rs['product_price'];
                ?>
                <tr style="background:#000000;">
                    <td style=" text-align: center;"><?php echo $i ?></td>
                    <td><?php echo $rs['product_name'] ?></td>
                    <td style=" text-align: center;"><?php echo $rs['total'] ?></td>
                    <td style="text-align: right;">​<?php echo number_format($rs['product_price'], 2) ?></td>
                    <td style=" text-align: center;">
                        <i class="fa fa-remove" onclick="deleteItems('<?php echo $rs['id'] ?>')" style=" cursor: pointer;"></i></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<input type="hidden" id="numberordertotal" value="<?php echo $i ?>"/>
<script type="text/javascript">
    function deleteItems(id) {
        var url = "<?php echo Yii::app()->createUrl('sell/deleteitemsinorder') ?>";
        var data = {id: id};
        $.post(url, data, function (datas) {
            $("#distcoutvalue").val(0);
            CalculatorDistcount();
            loadorder();
        });
    }
</script>
