<?php
/* @var $this PromotionprocedureregisterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'รายชื่อผู้ลงทะเบียนโปรโมชั่น',
);

?>

<h4>รายชื่อผู้ลงทะเบียนโปรโมชั่น</h4>

<table class=" table table-striped" id="promotion-regis">
    <thead>
        <tr>
            <th>#</th>
            <th>โปรโมชั่น</th>
            <th>ชื่อ-สกุล</th>
            <th>ราคา</th>
            <th>สาขา</th>
            <th>วันที่ลงทะเบียน</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($register as $rs): $i++;
            ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $rs['diagname']." ".$rs['number']." ครั้ง ".number_format($rs['price'])." บาท"; ?></td>
                <td>
                    <?php 
                    $patient = Patient::model()->find("pid=:pid", array(":pid" => $rs['pid'])); 
                    echo $patient['name']." ".$patient['lname'];
                    ?>
                </td>
                <td><?php echo number_format($rs['price'], 2) ?></td>
                <td><?php echo Branch::model()->find("id=:id", array(":id" => $rs['branch']))['branchname'] ?></td>
                <td><?php echo $rs['create_date'] ?></td>
                <td>
                    <a href="javascript:deleteregister('<?php echo $rs['id'] ?>')"><i class="fa fa-trash-o text-danger"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function(){
       $("#promotion-regis").dataTable(); 
    });
    function deleteregister(id) {
        var r = confirm("Are you sure...?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedureregister/delete') ?>";
            var data = {id: id};
            $.post(url, data, function (datas) {
                    window.location.reload();
            });
        }
    }
</script>