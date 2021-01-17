<?php
/* @var $this PromosionprocedureController */
/* @var $model Promosionprocedure */

$this->breadcrumbs = array(
    'โปรโมชั่นทั้งหมด' => array('index'),
    $model->id,
);
$diagname = Diag::model()->find("diagcode=:diagcode", array(":diagcode" => $model->diag))['diagname'];
?>

<h4>โปรโมชั่น :: <?php echo $diagname ?></h4>

<?php
if($model->type == "0"){
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        //'id',
        [
            'label' => 'หัตถการ',
            'value' => $diagname,
        ],
        'number',
        'limit',
        //'date_start',
        //'date_end',
        [
        'label' => 'ราคา',
        'value' => number_format($model['price'],2),
        ],
        [
        'label' => 'รายละเอียด',
        'value' => $model['detail'] ? $model['detail'] : "-",
        ],
    //'status',
    //'fullprice',
    ),
));
} else {
    $this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        //'id',
        [
            'label' => 'หัตถการ',
            'value' => $diagname,
        ],
        [
        'label' => 'ประจำเดือน',
        'value' => Month::model()->find("id=:id",array(":id" => $model->month))['month_th'],
        ],
        'number',
        'limit',
        //'date_start',
        //'date_end',
        [
        'label' => 'ราคา',
        'value' => number_format($model['price'],2),
        ],
                [
        'label' => 'รายละเอียด',
        'value' => $model['detail'] ? $model['detail'] : "-",
        ],
    //'status',
    //'fullprice',
    ),
));
}
?>
