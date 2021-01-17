<?php
/* @var $this StoreaccountController */
/* @var $model Storeaccount */

$this->breadcrumbs = array(
    'บัญชีธนาคาร' => array('index'),
    $model->id,
);
$ModelAccount = new Storeaccount();
$statement = $ModelAccount->statement($model->accountnumber);
?>

<h4>ข้อมูลบัญชี #<?php echo $model->id; ?></h4>

<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        //'id',
        'accountnumber',
        'accountname',
        array(// related city displayed as a link
            'label' => 'ธนาคาร',
            'type' => 'raw',
            'value' => Bank::model()->find("id=:id",array(':id' => $model->id))['bankname'],
        ),
        'bankbranch',
    ),
));
?>

<h4>ข้อมูลการโอนเงิน</h4>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>วันที่</th>
            <th>จำนวน</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;foreach($statement as $rs): $i++;?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $rs['date_sell'] ?></td>
            <td><?php echo number_format($rs['income'],2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
