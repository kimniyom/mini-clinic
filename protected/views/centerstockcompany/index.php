<style type="text/css">
    table thead tr th{
        background-image: linear-gradient(to top, #1a1b1c, #1f1f20, #232324, #282828, #2c2c2c);
    }
</style>
<?php
$this->breadcrumbs = array(
    //"คลังสินค้า" => array('store/index'),
    "บริษัทสั่งซื้อสินค้า(suppliers)"
);
$web = new Configweb_model();
?>
<h4>บริษัทสั่งซื้อสินค้า(suppliers)</h4>
<hr/>
<a href="<?php echo Yii::app()->createUrl('centerstockcompany/create') ?>">
    <button class="btn btn-default"><i class="fa fa-plus"></i> เพิ่มบริษัท</button></a>
<br/><br/>
<table class="table-bordered table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th style=" width: 5%; text-align: center;">#</th>
            <th>รหัส</th>
            <th>ชื่อบริษัท</th>
            <th>เลขเสียภาษี</th>
            <th>ที่ิอยู่</th>
            <th>โทรศัพท์</th>
            <th style=" text-align: center;" colspan="2">ตัวเลือก</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($company as $last):
            $i++;
            ?>
            <tr>
                <td style=" text-align: center;"><?php echo $i ?></td>
                <td><?php echo $last['company_id']; ?></td>
                <td><?php echo $last['company_name']; ?></td>
                <td><?php echo $last['taxnumber']; ?></td>
                <td><?php echo $last['address']; ?></td>
                <td><?php echo $last['tel']; ?></td>
                <td style=" text-align: center; font-weight: bold;">
                    <a href="<?php echo Yii::app()->createUrl('centerstockcompany/update', array('id' => $last['id'])) ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;|&nbsp;
                    <a href="javascript:Delete('<?php echo $last['id'] ?>')"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript">
    function Delete(id) {
        var r = confirm("Are you sure ..?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('centerstockcompany/delete') ?>";
            var data = {id: id};
            $.post(url, data, function(success) {
                window.location.reload();
            });
        }
    }
</script>
