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
        border-radius: 5px;
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
    'ใบสั่งสินค้า (สาขา' . $branchModel->branchname . ")" => array('index', "branch" => $branch),
    'สร้างใบสั่ง (สาขา' . $branchModel->branchname . ")",
);

$companySell = Companycenter::model()->find("id = '1'");
$BranchModel = Branch::model()->find("id = '$branch'");
?>
<div class="panel panel-default" style=" margin-bottom: 0px;">
    <div class="panel-body" style=" border-radius: 0px; position: relative;" id="boxorders">
        <div style=" text-align: center;">
            <!--
            <h4 style=" margin-bottom: 0px;"><?php //echo $BranchModel['branchname'];                                                      ?></h4><br/>
            -->
            <h4 style=" margin: 0px;">ใบสั่งซื้อสินค้า</h4>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <!--
                <table id="companysell">
                    <tr>
                        <td>ผู้ขาย : <?php //echo $companySell['companyname']                                                      ?></td>
                    </tr>
                    <tr>
                        <td>ที่อยู่ : <?php //echo $companySell['address']                                                      ?></td>
                    </tr>
                    <tr>
                        <td>ติดต่อ : คุณ <?php //echo $companySell['memager']                                                      ?> โทร. <?php //echo $companySell['tel']                                                      ?></td>
                    </tr>
                </table>
                -->
                <label>ซัพพลายเออร์(Supplier)</label>
                <?php
                $this->widget('booster.widgets.TbSelect2', array(
                    //'model' => $model,
                    'asDropDownList' => true,
                    //'attribute' => 'itemid',
                    'name' => 'supplier',
                    'id' => 'supplier',
                    'data' => CHtml::listData(CenterStockcompany::model()->findAll(), 'id', 'company_name'),
                    //'value' => $model,
                    'options' => array(
                        'allowClear' => true,
                        //$model,
                        //'oid',
                        //'tags' => array('clever', 'is', 'better', 'clevertech'),
                        'placeholder' => '== Supplier ==',
                        'width' => '100%',
                    //'tokenSeparators' => array(',', ' ')
                    ),
                ));
                ?>
                <br/> <br/>
                <label>ภาษีมูลค่าเพิ่ม</label>
                <select id="vat" class="form-control" onchange="loaddata()">
                    <option value="0">ไม่มีภาษี</option>
                    <option value="1">แยกภาษี 7%</option>
                    <option value="2">รวมภาษี 7%</option>
                </select>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div style=" padding: 10px; position: relative; height: 100px;" class="box-codenumber">
                    <table style=" border: #cccccc solid 1px; float: right;" class="box-codenumber">
                        <tr style=" border-bottom: #cccccc solid 1px;">
                            <td>รหัสสั่งซื้อเลขที่ : </td>
                            <td><?php echo $order_id ?></td>
                        </tr>
                        <tr>
                            <td>วันที่สั่งซื้อ : </td>
                            <td><?php echo date('d/m/Y') ?></td>
                        </tr>
                    </table>
                </div
            </div>
        </div>
    </div>
    <hr/>
    <div class="well">
        <label>สินค้า</label>
        <p style="font-size:12px;">รายการสินค้าที่ระบุในใบสั่งซื้อ</p>
        <hr/>
        <div class="row">
            <div class="col-md-4 col-lg-3">
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

            <div class="col-lg-2 col-md-4">
                <label for="">จำนวน*<span id="unit"></span></label><br/>
                <input type="text" class="form-control" id="number"/>
            </div>
            <div class="col-md-2 col-lg-2" style=" display: none;">
                <label for="">ส่วนลด%</label>
                <input type="text" class="form-control" id="distcountpersent" value="0"/>
            </div>
            <div class="col-md-2 col-lg-2">
                <label for="">ส่วนลด(บาท)</label>
                <input type="text" class="form-control" id="distcountprice" value="0"/>
            </div>
            <div class="col-lg-2 col-md-2">
                <button type="button" class="btn btn-block btn-primary" style=" margin-top: 25px;" onclick="AddproductInlist()"><i class="fa fa-plus"></i> เพิ่ม</button>
            </div>
        </div>
        <hr/>
        <div id="orderlist" class="table table-responsive"></div>
    </div>
</div>
<div class=" panel-footer" style=" padding: 5px;">
    <div class="row" style=" margin: 0px;">
        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
            <button type="button" class="btn btn-success btn-block" onclick="Saveorder()"><i class="fa fa-save"></i> บันทึกแบบฟอร์ม</button>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
            <button type="button" class="btn btn-danger btn-block" onclick="window.location.reload()"><i class="fa fa-remove"></i> ยกเลิก</button>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    //loadimagesProduct();
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

    function combotype() {
        var type_id = "";
        var url = "<?php echo Yii::app()->createUrl('producttype/getsubproductorder') ?>";
        var data = {type_id: type_id};
        $.post(url, data, function(datas) {
            $('#producttype').select2("val", "");
            $("#boxsubproducttype").html(datas);
        });
    }

    function loadimagesProduct() {
    }

    function loaddata() {
        var vat = $("#vat").val();
        var url = "<?php echo Yii::app()->createUrl('orders/loaddata') ?>";
        var order_id = "<?php echo $order_id ?>";
        var branch = "<?php echo $branch ?>";
        var data = {order_id: order_id, branch: branch, vat: vat};
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
        var supplier = $("#supplier").val();
        //var distcount = 0;
        //var private = $("input:radio[name=private]:checked").val();
        if (supplier == "") {
            sweetAlert("แจ้งเตือน...", "กรุณาเลือกคู่ค้าที่จะสั่งซื้อ!", "warning");
            return false;
        }
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

    function Saveorder() {
        var url = "<?php echo Yii::app()->createUrl('orders/save') ?>";
        var order_id = "<?php echo $order_id ?>";
        var branch = "<?php echo $branch ?>";
        var supplier = $("#supplier").val();

        if (supplier == "") {
            sweetAlert("แจ้งเตือน...", "กรุณาเลือกคู่ค้าที่จะสั่งซื้อ!", "warning");
            return false;
        }

        var data = {
            order_id: order_id,
            branch: branch,
            supplier: supplier
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
                alert("ไม่มีรายการสินค้าในใบสั่งซื้อ");
                return false;
            }
        });


    }

</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var screen = $(window).height();
        var screenfull = (screen - 150);
        $("#boxorders").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});

        var w = window.innerWidth;
        if (w <= 786) {
            $("#companysell").css({'width': '100%'});
            $(".box-codenumber").css({'width': '100%', 'margin': '0px', 'padding': '0px', 'border-top': '0px'});
        }
    }
</script>
