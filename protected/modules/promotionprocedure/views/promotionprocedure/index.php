<?php
/* @var $this PromosionprocedureController */
/* @var $dataProvider CActiveDataProvider */
$Config = new Configweb_model();
$this->breadcrumbs = array(
    'โปรโมชั่นหัตถการ',
);
?>
<h4>โปรโมชั่น(หัตถการ)</h4>
<a href="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/creates') ?>">
    <button type="button" class="btn btn-default"><i class="fa fa-plus"></i> สร้างโปรโมชั่น</button></a>
<a href="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/create') ?>">
    <button type="button" class="btn btn-info">
        <i class="fa fa-plus"></i> <i class="fa fa-calendar"></i> สร้างโปรโมชั่นประจำเดือน</button></a>
<br/><br/>

<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#promotion" aria-controls="promotion" role="tab" data-toggle="tab">โปรโมชั่น(ทั่วไป)</a></li>
        <li role="presentation"><a href="#promotionmonth" aria-controls="promotionmonth" role="tab" data-toggle="tab">โปรโมชั่นประจำเดือน(<?php echo $month ?>)</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="promotion">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>โปรโมชั่น</th>
                        <th style="text-align:center;">จำนวน(ครั้ง)</th>
                        <th style="text-align:center;">ราคา</th>
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
                            <td><?php echo Diag::model()->find("diagcode=:diagcode", array(":diagcode" => $rs['diag']))['diagname']; ?></td>
                            <td style="text-align:center;"><?php echo $rs['number'] ?></td>
                            
                            <td style="text-align:right;"><?php echo number_format($rs['price'], 2) ?></td>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/view', array("id" => $rs['id'])) ?>"><i class="fa fa-eye text-success"></i></a>
                                <a href="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/updates', array("id" => $rs['id'])) ?>"><i class="fa fa-pencil text-warning"></i></a>
                                <a href="javascript:deletepromotion('<?php echo $rs['id'] ?>')"><i class="fa fa-trash-o text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div role="tabpanel" class="tab-pane" id="promotionmonth">
        <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>โปรโมชั่น</th>
                        <th>จำนวน(ครั้ง)</th>
                        <th>โควต้า</th>
                        <th>ระยะเวลา(โปรโมชั่น)</th>
                        <th>ราคา</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $b = 0;
                    foreach ($promotionmonth as $rs): $b++;
                        ?>
                        <tr>
                            <td><?php echo $b ?></td>
                            <td><?php echo Diag::model()->find("diagcode=:diagcode", array(":diagcode" => $rs['diag']))['diagname']; ?></td>
                            <td style="text-align:center;"><?php echo $rs['number'] ?></td>
                            <td style="text-align:center;"><?php echo $rs['limit'] ?></td>
                            <td><?php echo "ภายในเดือน ".$month; ?></td>
                            <td style="text-align:right;"><?php echo number_format($rs['price'], 2) ?></td>
                            <td>
                                <a href="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/view', array("id" => $rs['id'])) ?>"><i class="fa fa-eye text-success"></i></a>
                                <a href="<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/update', array("id" => $rs['id'])) ?>"><i class="fa fa-pencil text-warning"></i></a>
                                <a href="javascript:deletepromotion('<?php echo $rs['id'] ?>')"><i class="fa fa-trash-o text-danger"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<script type="text/javascript">
    function deletepromotion(id) {
        var r = confirm("Are you sure...?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('promotionprocedure/promotionprocedure/delete') ?>";
            var data = {id: id};
            $.post(url, data, function (datas) {
                if (datas == "1") {
                    alert("มีการลงทะเบียนโปรโมชั่นไม่สามารถลบได้ถ้าต้องการยกเลิกโปรโมชั่นให้เข้าไปแก้ไข เลือกสถานะเป็น 'ไม่ใช้'");
                    return false;
                } else {
                    window.location.reload();
                }
            });
        }
    }
</script>
