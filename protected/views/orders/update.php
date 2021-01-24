<style type="text/css">
    #companysell tr td{
        border-bottom: #cccccc solid 1px;
    }

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
/* @var $this OrdersController */
/* @var $model Orders */
$branch = $order['branch'];
$this->breadcrumbs = array(
    'ใบสั่งสินค้า' => array('index', "branch" => $branch),
    'แก้ไขใบสั่ง',
);

$companySell = Companycenter::model()->find("id = '1'");
$BranchModel = Branch::model()->find("id = '$branch'");
?>

<div class="panel panel-default" style=" margin-bottom: 0px;">
    <div class="panel-body" id="boxorders">
        <div style=" text-align: center;">
            <h4 style=" margin: 0px;">ใบสั่งซื้อสินค้า</h4>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <table >
                    <tr>
                        <td>ผู้ขาย : <?php echo $companySell['companyname'] ?></td>
                    </tr>
                    <tr>
                        <td>ที่อยู่ : <?php echo $companySell['address'] ?></td>
                    </tr>
                    <tr>
                        <td>ติดต่อ : คุณ <?php echo $companySell['memager'] ?> โทร. <?php echo $companySell['tel'] ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div style=" padding: 10px; position: relative; height: 100px;">
                    <table style="float: right;">
                        <tr>
                            <td colspan="2" style=" text-align: center">
                                รหัสสั่งซื้อเลขที่ <br/>
                                <?php echo $order_id ?>
                            </td>
                        </tr>
                        <tr>
                            <td>วันที่สั่งซื้อ : </td>
                            <td><?php echo $order['create_date'] ?></td>
                        </tr>
                    </table>
                </div
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-4">
            <label>ภาษีมูลค่าเพิ่ม</label>
            <select id="vat" class="form-control" onchange="loaddata()">
                <option value="0" <?php echo ($order['vattype'] == 0) ? "selected" : "" ?>>ไม่มีภาษี</option>
                <option value="1" <?php echo ($order['vattype'] == 1) ? "selected" : "" ?>>แยกภาษี 7%</option>
                <option value="2" <?php echo ($order['vattype'] == 2) ? "selected" : "" ?>>รวมภาษี 7%</option>
            </select>
        </div>
    </div>

    <hr/>
    <div class="well">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <label for="">สินค้า*</label><br/>
                <?php
                $this->widget('booster.widgets.TbSelect2', array(
                    //'model' => $model,
                    'asDropDownList' => true,
                    //'attribute' => 'itemid',
                    'name' => 'product',
                    'id' => 'product',
                    'data' => CHtml::listData(ClinicStockproduct::model()->findAll(), 'product_id', 'product_name'),
                    //'value' => $model,
                    'options' => array(
                        'allowClear' => true,
                        //$model,
                        //'oid',
                        //'tags' => array('clever', 'is', 'better', 'clevertech'),
                        'placeholder' => '== รายการสินค้า ==',
                        'width' => '100%',
                    //'tokenSeparators' => array(',', ' ')
                    ),
                ));
                ?>

            </div>

            <div class="col-lg-2 col-md-6">
                <label for="">จำนวน*<span id="unit"></span></label><br/>
                <input type="text" class="form-control" id="number" value="1"/>
            </div>
            <div class="col-md-2 col-lg-2">
                <label for="">ส่วนลด(บาท)</label>
                <input type="text" class="form-control" id="distcountprice" value="0"/>
            </div>
            <div class="col-lg-1 col-md-2">
                <button type="button" class="btn btn-block btn-success" style=" margin-top: 25px;" onclick="AddproductInlist()">เพิ่ม</button>
            </div>
        </div>
    </div>
    <div id="orderlist">
        ​​
    </div>
</div>
<div class="panel-footer">
    <button type="button" class="btn btn-success" onclick="Saveorder()"><i class="fa fa-pencil"></i> แก้ไขแบบฟอร์ม</button>
</div>
</div>

<script type="text/javascript">
    loaddata();
    $(document).ready(function() {
        $("#product").change(function() {
            var product_id = $("#product").val();
            var data = {product_id: product_id};
            var url = "<?php echo Yii::app()->createUrl('orders/detailproduct') ?>";
            $.post(url, data, function(datas) {
                $("#unit").html("(" + datas + ")");
            });
        });
    });

    function loadimagesProduct() {
    }

    function loaddata() {
        var vat = $("#vat").val();
        var url = "<?php echo Yii::app()->createUrl('orders/loaddata') ?>";
        var order_id = "<?php echo $order_id ?>";
        var branch = "<?php echo $branch ?>";
        var data = {
            order_id: order_id,
            branch: branch,
            vat: vat
        };
        $.post(url, data, function(datas) {
            $("#orderlist").html(datas);
        });
    }

    function AddproductInlist() {
        var url = "<?php echo Yii::app()->createUrl('listorder/save') ?>";
        //var product_name = $("#product_name").val();
        //var product_nameclinic = $("#product_nameclinic").val();
        //var company = $("#company").val();
        //var type_id = $("#producttype").val();
        //var subproducttype = $("#subproducttype").val();
        //var product_price = $("#product_price").val();
        var product = $("#product").val();
        var order_id = "<?php echo $order_id ?>";
        var number = $("#number").val();
        var distcountprice = $("#distcountprice").val();
        //var supplier = $("#supplier").val();
        //var distcount = 0;
        //var private = $("input:radio[name=private]:checked").val();

        if (product == '' || number == '' || product == null) {
            sweetAlert("แจ้งเตือน...", "กรอกข้อมูลไม่ครบ!", "warning");
            return false;
        }

        var data = {
            product_id: product,
            order_id: order_id,
            number: number,
            distcountprice: distcountprice
        };

        $.post(url, data, function(success) {
            loaddata();
            $("#distcountprice").val("");
            $('#product').select2("val", "");
            $("#number").val("");
            //combotype();
        });
    }

    function Saveorderssss() {
        var url = "<?php echo Yii::app()->createUrl('orders/view', array('order_id' => $order_id)) ?>";
        window.location = url;
    }

    function Saveorder() {
        var url = "<?php echo Yii::app()->createUrl('orders/updateorder') ?>";
        var order_id = "<?php echo $order_id ?>";
        //var branch = "<?php //echo $branch  ?>";
        //var supplier = $("#supplier").val();
        var vattype = $("#vat").val();
        var priceresult = $("#priceresult").val();

        var data = {
            order_id: order_id,
            //branch: branch,
            //supplier: supplier,
            vattype: vattype,
            priceresult: priceresult
        };

        var urlcheck = "<?php echo Yii::app()->createUrl('orders/checklistorder') ?>";
        var daracheck = {order_id: order_id};
        $.post(urlcheck, daracheck, function(datas) {
            if (datas > 0) {
                $.post(url, data, function(success) {
                    var url = "<?php echo Yii::app()->createUrl('orders/view', array('order_id' => $order_id)) ?>";
                    window.location = url;
                });
            } else {
                //alert("ไม่มีรายการสินค้าในใบสั่งซื้อ");
                sweetAlert("แจ้งเตือน...", "ไม่มีรายการสินค้าในใบสั่งซื้อ!", "warning");
                return false;
            }
        });


    }

</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var screen = $(window).height();
        var w = window.innerWidth;
        if (w >= 768) {
            //var contentboxsell = $("#content-boxsell").height();
            var screenfull = (screen - 160);
            $("#boxorders").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
            //$("#patientbox").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF'});
            //$("#boxorders").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF', 'overflow': 'auto', 'padding-left': '10px'});
        }
    }


</script>
