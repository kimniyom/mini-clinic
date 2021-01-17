<?php
/* @var $this PromosionprocedureController */
/* @var $dataProvider CActiveDataProvider */
$Config = new Configweb_model();
$this->breadcrumbs = array(
    'โปรโมชั่น',
);
?>
<h4>โปรโมชั่น(สินค้า)</h4>
<a href="<?php echo Yii::app()->createUrl('promotion/promotionproduct/create') ?>">
    <button type="button" class="btn btn-default"><i class="fa fa-plus"></i> สร้างโปรโมชั่น</button></a><br/><br/>
    <table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>โปรโมชั่น</th>
            <th>จำนวนสินค้า</th>
            <th>ราคาเดิม</th>
            <th>ราคาโปรโมชั่น</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($promotion as $rs): $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo CenterStockproduct::model()->find("product_id=:product_id", array(":product_id" => $rs['product_id']))['product_nameclinic']; ?> (<?php echo $rs['promotionname'] ?>)</td>
                <td><?php echo $rs['number'] ?></td>
                <td><?php echo $rs['priceold'] ?></td>
                <td><?php echo $rs['price'] ?></td>
                <td>
                    <!--
                    <a href="<?php //echo Yii::app()->createUrl('promotion/promotionproduct/view', array("id" => $rs['id']))  ?>"><i class="fa fa-eye text-success"></i></a>-->
                    <a href="<?php echo Yii::app()->createUrl('promotion/promotionproduct/update', array("id" => $rs['id'])) ?>"><i class="fa fa-pencil text-warning"></i></a>
                    <a href="javascript:deletepromotion('<?php echo $rs['id'] ?>')"><i class="fa fa-trash-o text-danger"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    function deletepromotion(id) {
        var r = confirm("Are you sure...?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('promotion/promotionproduct/delete') ?>";
            var data = {id: id};
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }
</script>
