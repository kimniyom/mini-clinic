<style type="text/css">
    .form-control{
        background: #111111;
    }
    .row{
        margin-top: 10px;
    }

    .select2-container {
        background-color: #111111 !important;
    }
    .select2-drop{
        background-color: #111111 !important;
        border-color: #333333;
        color:#666666;
    }
    .select2-search input {
        background-color: #222222 !important;
        border:none;
    }
    .select2-choice { background-color: #111111 !important; border-color:#222222 !important; height: 40px !important;}
    .select2-search { background-color: #111111 !important; margin-top: 10px;}
    .select2-arrow {
        border-left: 0px solid transparent !important;
        /* 2 */
    }

</style>
<?php
$this->breadcrumbs = array(
    'ใบสั่งสินค้า (สาขา' . $branchModel->branchname . ")",
);
?>

<div class="row" style=" margin: 0px;">
    <div class="col-md-6 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php //if ($branch != "99") { ?>
                <a href="<?php echo Yii::app()->createUrl('orders/create', array('branch' => $branch)) ?>">
                    <button type="button" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> สร้างใบสั่งสินค้า</button>
                </a>
                <?php //} else { ?>
                <!--<button type="button" class="btn btn-default disabled"><i class="fa fa-plus"></i> สร้างใบสั่งสินค้า</button>-->
                <?php //} ?>
            </div>
            <div class="panel-body">
                <div style=" text-align: center"> :: ค้นหา ::</div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <label>สาขา</label>
                        <?php
                        $this->widget(
                                'booster.widgets.TbSelect2', array(
                            'name' => 'branch',
                            'id' => 'branch',
                            'data' => CHtml::listData($BranchList, 'id', 'branchname'),
                            'value' => $branch,
                            'options' => array(
                                'placeholder' => 'เลือกสาขา',
                                'width' => '100%',
                                'allowClear' => true,
                            ),
                                )
                        );
                        ?>
                    </div>
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <label>รหัสใบสั่ง</label>
                        <input type="text" id="ordercode" class="form-control" onkeypress="return chkNumber()" placeholder="กรอกเฉพาะตัวเลข ..."/>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <label>สถานะ</label>
                        <select class="form-control" id="status">
                            <option value="">ทั้งหมด</option>
                            <option value="0">รอการยืนยัน</option>
                            <option value="1">ยืนยันการสั่งซื้อ</option>
                        </select>
                    </div>

                </div>
                <div class="row" style=" margin-top: 10px;">
                    <div class="col-md-6 col-lg-6">
                        <label>เริ่มต้นวันที่</label>
                        <div>
                            <?php
                            $this->widget(
                                    'booster.widgets.TbDatePicker', array(
                                //'model' => $model,
                                //'attribute' => 'birth',
                                'value' => date("Y-m-d"),
                                'id' => 'datestart',
                                'name' => 'datestart',
                                'options' => array(
                                    'language' => 'th',
                                    'type' => 'date',
                                    'format' => 'yyyy-mm-dd',
                                ),
                                    )
                            );
                            ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6">
                        <label>สิ้นสุดวันที่</label>
                        <div>
                            <?php
                            $this->widget(
                                    'booster.widgets.TbDatePicker', array(
                                //'model' => $model,
                                //'attribute' => 'birth',
                                'value' => date("Y-m-d"),
                                'id' => 'dateend',
                                'name' => 'dateend',
                                'options' => array(
                                    'language' => 'th',
                                    'type' => 'date',
                                    'format' => 'yyyy-mm-dd',
                                ),
                                    )
                            );
                            ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <button type="button" class="btn btn-success btn-block" style="margin-top: 25px;" onclick="searchOrders()">ตกลง <i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-9">
        <div id="result"></div>
    </div>
</div>
<script type="text/javascript">
    searchOrders();
    $(document).ready(function() {
        $("#datestart,#dateend").removeClass('ct-form-control');
        $("#datestart,#dateend").addClass('form-control');
    });
    function searchOrders() {
        var loading = '<i class="fa fa-spinner fa-spin fa-fw"></i>';
        $("#result").html(loading);
        var url = "<?php echo Yii::app()->createUrl('orders/search') ?>";
        var datestart = $("#datestart").val();
        var dateend = $("#dateend").val();
        var status = $("#status").val();
        var ordercode = $("#ordercode").val();
        var branch = $("#branch").val();
        var data = {datestart: datestart, dateend: dateend, branch: branch, status: status, order_id: ordercode};
        console.log(data);
        $.post(url, data, function(datas) {
            $("#result").html(datas);
        });
    }

    function Deleteorder(order_id) {
        var r = confirm("Are yoou sure ...?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('orders/deleteorder') ?>";
            var data = {order_id: order_id};
            $.post(url, data, function(datas) {
                searchOrders();
            });
        }
    }
</script>
