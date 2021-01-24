<style type="text/css">
    table{
        border: none;
    }

    #checkboxtpayment {
        margin: 0px;
        padding: 0px;
    }

    .checkboxtpayment label {
        width: 100%;
        border-radius: 0px;
        border: 0px solid #D1D3D4
    }

    /* hide input */
    .checkboxtpayment input.radio:empty {
        margin-left: -999px;
    }

    /* style label */
    .checkboxtpayment input.radio:empty ~ label {
        position: relative;
        float: left;
        line-height: 2.5em;
        text-indent: 3.25em;
        margin-top: 0px;
        cursor: pointer;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .checkboxtpayment input.radio:empty ~ label:before {
        position: absolute;
        display: block;
        top: 0;
        bottom: 0;
        left: 0;
        content: '';
        width: 2.5em;
        background: #D1D3D4;
        border-radius: 0px 0 0 0px;
    }

    /* toggle hover */
    .checkboxtpayment input.radio:hover:not(:checked) ~ label:before {
        content:'\2714';
        text-indent: .9em;
        color:  #ff3300;
    }

    .checkboxtpayment input.radio:hover:not(:checked) ~ label {
        color:  #ff3300;
    }

    /* toggle on */
    .checkboxtpayment input.radio:checked ~ label:before {
        content:'\2714';
        text-indent: .9em;
        color: #ffcc00;
        background-color: #4DCB6D;
    }

    .checkboxtpayment input.radio:checked ~ label {
        color:  #ff3300;

    }

    /* radio focus */
    .checkboxtpayment input.radio:focus ~ label:before {
        box-shadow: 0 0 0 3px #999;
    }


    input[type="text"]{
        background:#000000;
    }

    #reporttoday table thead tr th{
        color:pink;
    }

    #orderlist table thead tr th{
        color:pink;
    }

    .form-control{
        background: #000000;
    }
    .select2-container {
        background-color: #000000 !important;
        border-radius: 5px;
    }
    .select2-drop{
        background-color: #000000 !important;
        border-color: #333333;
        color:#666666;
    }
    .select2-search input {
        background-color: #333333 !important;
        border:none;
    }
    .select2-choice { background-color: #000000 !important; border-color:#222222 !important; height: 40px !important;}
    .select2-search { background-color: #000000 !important; margin-top: 10px;}
    .select2-arrow {
        border-left: 0px solid transparent !important;
        /* 2 */
    }

</style>
<?php
$UserModel = new Masuser();
$BranchModel = new Branch();
$Config = new Configweb_model();
$Profile = $UserModel->GetProfile();
//$items = new Items();
$branchactive = Yii::app()->session['branch'];
$brancList = $BranchModel->ComboBranchDisabled($branchactive);
//$itemlist = $items->GetItemSell();
$PatientModel = new Patient();
//$PatientList = $PatientModel->GetPatientAll();

$sell_id = "IVN" . $Config->RandstrgenNumber(5) . trim(time());
?>

<div id="mainsell">
    <div class="row" style="margin:0px;">
        <div class="col-md-3 col-lg-2" style="padding:0px;">
            <div class="well well-sm">
                รหัสขาย
                <input type="text" class="form-control" id="sellcode" value="<?php echo $sell_id ?>" readonly="readonly" style=" color:  #000000; font-weight: bold;"/>
                <div style=" display: none;">
                    สาขา
                    <?php echo $brancList ?>
                </div>
                พนักงานขาย
                <select id="employee" class="form-control">
                    <option value="">== เลือก ==</option>
                    <?php foreach ($employee as $em): ?>
                        <option value="<?php echo $em['id'] ?>" <?php echo ($em['id'] == $Profile['id']) ? "selected" : ""; ?>><?php echo $em['name'] . " " . $em['lname'] ?></option>
                    <?php endforeach; ?>
                </select>
                <!--
                <input type="text" class="form-control" id="user" readonly="readonly" value="<?php //echo $Profile['name'] . " " . $Profile['lname']                                                                                                                                                        ?>"/>
                -->
            </div>
            <div class="well well-sm" style="margin-bottom:0px;">
                เลือกตาม
                <input type="radio" name="typebuy" id="typebuy" value="0" checked="checked"/> ลูกค้า
                <div style=" display: none;">
                    <input type="radio" name="typebuy" id="typebuy" value="1"/> พนักงาน
                    <input type="hidden" id="pid" />
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <input type="text" id="name" placeholder="ชื่อ" class="form-control"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <input type="text" id="lname" placeholder="สกุล" class="form-control"/>
                    </div>
                </div>
                <div class="row" style=" margin-top: 10px;">
                    <div class="col-md-12 col-lg-12">
                        <button type="button" class="btn btn-warning btn-block" onclick="searchpatient()"><i class="fa fa-search"></i> ค้นหา(Enter)</button>
                    </div>
                </div>
                <?php
                /*
                  $this->widget(
                  'booster.widgets.TbSelect2', array(
                  'name' => 'card',
                  'id' => 'card',
                  'data' => CHtml::listData($PatientList, 'card', 'name'),
                  'options' => array(
                  'placeholder' => 'สมาชิก',
                  'width' => '100%',
                  'allowClear' => true,
                  )
                  )
                  );
                 *
                 */
                ?>
                <div class="well well-sm" id="patientbox" style="margin-top:10px; margin-bottom:0px;background:#333333;">
                    <div id="font-18" style="color:#7cb902;">
                        <div id="patient"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="well well-sm" style="margin-bottom:0px;" id="boxcentersell">
                <div class="row" style="margin:0px;">
                    <div class="col-md-12 col-lg-12" style="padding:0px;">
                        ชื่อสินค้า
                        <?php
                        $this->widget(
                                'booster.widgets.TbSelect2', array(
                            'name' => 'itemcode',
                            'id' => 'itemcode',
                            'data' => CHtml::listData($productlist, 'product_id', 'detail'),
                            'options' => array(
                                'placeholder' => 'ค้นหาสินค้า',
                                'width' => '100%',
                                'allowClear' => true,
                            )
                                )
                        );
                        ?>
                        <!--
                        <div id="_item"></div>
                        -->
                    </div>
                </div>
                <div class="row" style="margin:0px;">
                    <div class="col-md-12 col-lg-12" style="padding-right:0px; padding:0px; padding-top: 5px;">
                        รายละเอียดสินค้า
                        <input type="hidden" id="typeproduct"/>
                        <input type="hidden" id="productname"/>
                        <div style="position: relative;">
                            <div id="detailproduct" class="well well-sm" style="margin:0px; height:50px; background:#000000; color:yellow; overflow: auto; font-size:12px; overflow: hidden;">

                            </div>
                            <div style=" position: absolute; width: 100px; height: 100%; right: 0px; top: 0px;  background: #222222; z-index: 100; text-align: center;">
                                สต๊อก<br/>
                                <div id="stock" style="font-size:20px; color: #ff3300;">-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin:0px;">
                    <div class="col-md-3 col-lg-3" style="padding-left:0px; padding-top: 5px;">
                        จำนวน
                        <input type="text" class="form-control input-sm" id="number"   onKeyUp="if (this.value * 1 != this.value)
                                    this.value = '';" style=" text-align: center;"/>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding-left:0px; padding-top: 5px;">
                        ราคา
                        <input type="text" class="form-control input-sm" id="pricevalue"  onKeyUp="if (this.value * 1 != this.value)
                                    this.value = '';" style=" text-align: center;"/>
                    </div>
                    <div class="col-md-3 col-lg-3" style="padding:0px; padding-top: px;">
                        <button type="button" class="btn btn-sm btn-info btn-block" id="btnaddproduct" onclick="sell()" style="margin-top: 25px;"><i class="fa fa-plus"></i> เพิ่มสินค้า</button>
                    </div>
                </div>
                <div class="row" style="margin:0px; margin-top: 5px;">
                    <div class="col-md-12 col-lg-12" style="padding:0px;">
                        <div class="panel panel-default" style="margin-bottom: 0px;">
                            <div class="panel-heading" id="heading-panels"><i class="fa fa-bars"></i> รายการขาย</div>
                            <div id="orderlist" style="background:#000000;"><h3 style=" text-align: center;">ยังไม่มีรายการขาย</h3></div>
                            <div class="panel-footer">
                                รวม
                                <div class="pull-right" id="showtotal" style=" color: #ff3300; font-weight: bold; padding-right: 10px; border-radius: 0px;">0.-</div>
                            </div>
                        </div>
                        <div style=" margin-top: 5px;">รายละเอียด อื่น ๆ</div>
                        <textarea class="form-control" id="comment" rows="2"></textarea>
                    </div>
                </div>

                <!--
                <div id="box-money">
                    <label>การคิดส่วนลด</label>
                    <input type="radio" name="typedistcount" id="typedistcount" value="0" checked="checked" onclick="CalculatorDistcount()"/> บาท
                    <input type="radio" name="typedistcount" id="typedistcount" value="1" onclick="CalculatorDistcount()"/> เปอร์เซ็นต์
                    <div class="row" style=" margin: 0px; margin-bottom: 10px;">
                        <div class="col-md-4 col-lg-4" style=" padding: 5px;">
                            ใส่จำนวน
                        </div>
                        <div class="col-md-6 col-lg-6" style=" padding: 0px;">
                            <input type="text" name="distcoutvalue" id="distcoutvalue" style=" text-align: center; font-weight: bold; font-size: 24px;" class=" form-control"  onkeyUp="CalculatorDistcount()" value="0"/>
                        </div>
                        <div class="col-md-2 col-lg-2" style=" padding: 5px;">
                            <p id="unitdistcount">บาท</p>
                        </div>
                    </div>
                    <div class="row" style=" margin: 0px; margin-bottom: 10px;">
                        <div class="col-md-4 col-lg-4" style=" padding: 5px;">
                            ส่วนลด
                        </div>
                        <div class="col-md-6 col-lg-6" style=" padding: 0px;">
                            <input type="text" class="form-control" id="distcount" style=" text-align: center; font-weight: bold; font-size: 24px;" value="0" readonly="readonly"/>
                        </div>
                        <div class="col-md-2 col-lg-2" style=" padding: 5px;">
                            บาท
                        </div>
                    </div>
                </div>
                -->

                <input type="hidden" name="distcoutvalue" id="distcoutvalue" style=" text-align: center; font-weight: bold; font-size: 24px;" class=" form-control"  onkeyUp="CalculatorDistcount()" value="0"/>
                <input type="hidden" class="form-control" id="distcount" style=" text-align: center; font-weight: bold; font-size: 24px;" value="0" readonly="readonly"/>

                <input type="hidden" id="_total" value="0">
                <!-- เอาไปบันทึก -->
                <input type="hidden" id="_totalfinal" value="0">
                <!--<h1 id="totalfinal" style=" color: #ffcc00;">0</h1>-->

                <div style=" margin-top: 5px;">การชำระเงิน</div>
                <div class="row" style="margin:0px;">
                    <div class="col-md-3 col-lg-3" style=" padding: 0px;">
                        <div class="checkboxtpayment">
                            <input type="radio" name="payments" id="radio1" class="radio" value="1" onclick="setpayment('1')" checked style=" display: none;"/>
                            <label for="radio1">เงินสด</label>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4" style=" padding: 0px;">
                        <div class="checkboxtpayment">
                            <input type="radio" name="payments" id="radio2" class="radio" value="2" onclick="setpayment('2')" style=" display: none;"/>
                            <label for="radio2">โอน</label>
                        </div>
                    </div>
                    <!-- จ่ายแบบโอน -->
                    <div id="box-payment" style=" margin-top: 5px;"></div>
                    <div class="col-md-3 col-lg-3" style=" padding: 0px; display: none;">
                        <div class="checkboxtpayment">
                            <input type="radio" name="payments" id="radio3" class="radio" value="3" onclick="setpayment('3')" style=" display: none;"/>
                            <label for="radio3">บัตรเครดิต</label>
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3" style=" padding: 0px; display: none;">
                        <div class="checkboxtpayment">
                            <input type="radio" name="payments" id="radio4" class="radio" value="4" onclick="setpayment('4')" style=" display: none;"/>
                            <label for="radio4">ผ่อนจ่าย</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="well well-sm" style=" text-align: left; background: #333333; margin-bottom: 0px; border-radius: 0px;">
                <!--<div id="text-payment">รับเงิน</div>-->
                <input type="hidden" class="form-control" id="income" onkeypress="return chkNumber()" style=" text-align: center; font-weight: bold; font-size: 24px;" onkeyup="Income(this.value)" placeholder="ตัวเลขเท่านั้น..." value="0"/>

                <!--เงินทอน-->
                <input type="hidden" class="form-control" id="change" readonly="readonly" style=" text-align: center; color: #33cc00; font-weight: bold; font-size: 24px; background: #333333;" value="0"/>

                <div class="row" style=" margin: 0px;">
                    <div class="col-lg-6 col-md-6">
                        <button type="button" class="btn btn-success btn-block" id="btncheckbill" onclick="Check_bill()">
                            <i class="fa fa-save"></i> บันทึกรายการ</button>

                        <button type="button" class="btn btn-default btn-block disabled" id="btnprintbill" style="margin-top:0px;display:none;" onclick="PrintBill('<?php echo $sell_id ?>')">
                            <i class="fa fa-file-o"></i> ใบเสร็จ</button>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <?php $url = Yii::app()->createUrl('sell/bill', array("sell_id" => $sell_id)) ?>
                        <button type="button" class="btn btn-danger btn-block" id="btn-bg-danger" onclick="javascript:window.location.reload()"><i class="fa fa-remove"></i> จบการขาย</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-3 col-lg-4" style="padding:0px;" id="boxrightsells">
            <div class="panel panel-default" style="margin-bottom:0px;">
                <div class="panel-heading" style='color:pink'>
                    การขายวันนี้
                </div>
                <div id="reporttoday"></div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">รวม</div>
                        <div class="col-md-6 col-lg-6" style="text-align:right;">
                            <div id="sumtoday"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
POPUP patient
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popuppatient" data-backdrop="static">
    <div class="modal-dialog modal-lg large" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ข้อมูลลูกค้า</h4>
            </div>
            <div class="modal-body" style=" margin: 0px;">
                <div id="popupbodypatient"></div>
            </div>
        </div>
    </div>
</div>

<!--
POPUP EDIT NUMBER
-->
<div class="modal fade" tabindex="-1" role="dialog" id="popupeditnumber">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">แก้ไขจำนวน</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="_id"/>
                <input type="text" class="form-control" id="newnumber" style=" text-align: center;" onKeyUp="if (this.value * 1 != this.value)
                            this.value = '';" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-block" onclick="UpdateNumber()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    //loaditems();
    Setscreen();
    loadorder();
    historyselltoday();
    sumreporttoday();
    $(document).ready(function() {
        $("#wrapper").toggleClass("toggled");
        $(".breadcrumb").hide();
        /*
         $("#card").change(function () {
         var card = $("#card").val();
         var url = "<?php //echo Yii::app()->createUrl('sell/patient')                                                                                                                                                                         ?>";
         var data = {card: card};
         $.post(url, data, function (datas) {
         $("#patient").html(datas);
         });
         });
         */
    });
    function Setscreen() {
        var width = window.innerWidth;
        if (width >= 768) {
            var height = window.innerHeight;
            var boxsell = $("#box-sell").height();
            var contentboxsell = $("#content-boxsell").height();
            var screenfull = ((contentboxsell - boxsell) - 123);
            var patientbox = height - 415;
            var orderlist = height - 570; //340
            var boxrightsell = height - 160; //61
            var boxcentersell = height - 120;
            var boxreporttoday = height - 145;
            $("#patient").css({'height': patientbox, 'overflow': 'auto'});
            $("#orderlist").css({'height': orderlist, 'overflow': 'auto'});
            $("#boxrightsell").css({'height': boxrightsell, 'overflow': 'auto'});
            $("#boxcentersell").css({'height': boxcentersell, 'overflow': 'auto'});
            $("#reporttoday").css({'height': boxreporttoday, 'overflow': 'auto'});
        } else {
            $("#mainsell").html("<center><h4>ขนาดหน้าจอไม่รองรับการแสดงผล ...!</h4></center>");
        }
    }

    function sell() {
        var url = "<?php echo Yii::app()->createUrl('sell/sell') ?>";
        var itemcode = $("#itemcode").val();
        var sellcode = $("#sellcode").val();
        var branch = $("#branch").val();
        var pid = $("#pid").val();
        var number = parseInt($("#number").val());
        var employee = $("#employee").val();
        var promotion = "";
        var promotion_id = "";
        var typeproduct = $("#typeproduct").val();
        var price = $("#pricevalue").val();
        var productname = $("#productname").val();
        var datesell = $("#datesell").val();
        var data = {
            itemcode: itemcode,
            sellcode: sellcode,
            pid: pid,
            branch: branch,
            number: number,
            promotion: promotion,
            promotion_id: promotion_id,
            employee: employee,
            price: price,
            productname: productname,
            typeproduct: typeproduct,
            datesell: datesell
        };
        if (itemcode == "") {
            //alert("กรุณาเลือกสินค้า ...");
            swal("แจ้งเตือน!", "กรุณาเลือกสินค้า ...!", "warning");
            return false;
        }

        if (employee == "") {
            //alert("ยังไม่ได้เลือกพนักงานขาย ...");
            swal("แจ้งเตือน!", "ยังไม่ได้เลือกพนักงานขาย ...!", "warning");
            return false;
        }

        if (number == "" || number <= 0) {
            //alert("กรุณาใส่จำนวน ...");
            swal("แจ้งเตือน!", "กรุณาใส่จำนวนให้ถูกต้อง ...!", "warning");
            return false;
        }

        if (price == "") {
            //alert("ยังไม่ได้ใส่ราคา ...");
            swal("แจ้งเตือน!", "ยังไม่ได้ใส่ราคา ...!", "warning");
            return false;
        }

        var UrlCheckStock = "<?php echo Yii::app()->createUrl('sell/checkstock') ?>";
        var datacheck = {product_id: itemcode, branch: branch};
        $.post(UrlCheckStock, datacheck, function(stock) {
            if (parseInt(number) <= parseInt(stock)) {
                $.post(url, data, function(datas) {
                    Notify(itemcode);
                    //$("#orderlist").html(datas);
                    //loaditems();
                    loadorder();
                    $("#distcoutvalue").val(0);
                    CalculatorDistcount();
                    ResetTxt();
                    $("#pricevalue").val("");
                    //$("#card").attr("disabled", true);
                });
            } else {
                //alert("ยอดคงเหลือในสต๊อกไม่พอกับจำนวนขาย คงเหลือทั้งหมดจำนวน " + stock);
                swal("แจ้งเตือน!", "ยอดคงเหลือในสต๊อกไม่พอกับจำนวนขาย ...!", "warning");
                return false;
            }
        });
    }

    function confirmOrder() {
        var url = "<?php echo Yii::app()->createUrl('sell/logsell') ?>";
        var typebuy = $('input[name=typebuy]:checked').val();
        var itemcode = $("#itemcode").val();
        var sellcode = $("#sellcode").val();
        var branch = $("#branch").val();
        var pid = $("#pid").val();
        var total = $("#_total").val();
        var income = $("#income").val();
        var change = $("#change").val();
        var distcount = $("#distcount").val();
        var totalfinal = $("#_totalfinal").val();
        var employee = $("#employee").val();
        var payment = $('input[name=payments]:checked').val();
        var comment = $("#comment").val();
        var datesell = $("#datesell").val();
        //alert(branch);
        var accounts;
        if (payment == 2) {
            var account = $("#account").val();
            if (account == "") {
                //alert("กรุณาเลือกบัญชี...");
                swal("แจ้งเตือน!", "กรุณาเลือกบัญชี ...!", "warning");
                return false;
            } else {
                accounts = account;
            }
        } else {
            accounts = "";
        }
        var data = {
            itemcode: itemcode,
            sellcode: sellcode,
            pid: pid,
            branch: branch,
            total: total,
            income: income,
            change: change,
            distcount: distcount,
            totalfinal: totalfinal,
            typebuy: typebuy,
            employee: employee,
            payment: payment,
            account: accounts,
            comment: comment,
            datesell: datesell
        };
        $.post(url, data, function(datas) {
            PrintBill(sellcode);
            $("#btncheckbill").removeClass("btn btn-default");
            $("#btncheckbill").addClass("btn btn-default disabled");
            $("#btncheckbill").hide();
            $("#btnprintbill").removeClass("btn btn-default disabled");
            $("#btnprintbill").addClass("btn btn-default");
            $("#btnprintbill").show();
            $("#btnaddproduct").removeClass("btn btn-default btn-block");
            $("#btnaddproduct").addClass("btn btn-default btn-block disabled");
            $("#pid").attr("disabled", true);
            $("#itemcode").attr("disabled", true);
            $("#number").attr("disabled", true);
            $("#branch").attr("disabled", true);
            $("#income").attr("disabled", true);
            //$("#orderlist").html(datas);
            //loaditems();
            //loadorder();
        });
    }

    function PrintBill(sellcode) {
        var branch = $("#branch").val();
        var url = "<?php echo Yii::app()->createUrl('sell/bill') ?>" + "?sell_id=" + sellcode + "&branch=" + branch;
        //Update 20200215
        //PopupBill(url, sellcode);
        window.location = url;
    }

    function loaditems() {
        var url = "<?php echo Yii::app()->createUrl('sell/comboproduct') ?>";
        var branch = $("#branch").val();
        var data = {branch: branch};
        $.post(url, data, function(datas) {
            $("#_item").html(datas);
        });
    }

    function loadorder() {
        //var loader = '<i class="fa-li fa fa-spinner fa-spin"></i>';
        var url = "<?php echo Yii::app()->createUrl('sell/loadorder') ?>";
        var sell_id = $("#sellcode").val();
        var branch = $("#branch").val();
        var data = {sell_id: sell_id, branch: branch};
        //$("#orderlist").html(loader);
        $.post(url, data, function(datas) {
            $("#orderlist").html(datas);
            Calculator();
        });
    }

    function CalculatorDistcount() {
        var typecal = $('input[name=typedistcount]:checked').val();
        var totals = $("#_total").val();
        var total = parseInt(totals);
        var distcoutvalue = parseInt($("#distcoutvalue").val());
        var distcount;
        if (totals == "" || totals == "0") {
            alert("ยังไม่มีรายการ ...!");

            $("#distcoutvalue").val(0);
            return false;
        }
        if ($("#distcoutvalue").val() != "") {
            $("#distcount").val(0);
            if (typecal == "0") {
                distcount = distcoutvalue;
                $("#unitdistcount").html("บาท");
            } else if (typecal == "1") {
                distcount = ((distcoutvalue * total) / 100);
                $("#unitdistcount").html("%");
            }
            $("#distcount").val(distcount);
            Calculator();
        } else {
            //$("#distcoutvalue").val(0);
            CalculatorDistcount();
        }

    }

    function Calculator() {
        var url = "<?php echo Yii::app()->createUrl('sell/calculator') ?>";
        var sellcode = $("#sellcode").val();
        var branch = $("#branch").val();
        var data = {sell_id: sellcode, branch: branch};
        var distcount = $("#distcount").val();
        $.post(url, data, function(response) {
            var datas = jQuery.parseJSON(response);
            $("#_total").val(datas.total);
            //$("#total").text(formatThousands(datas.total) + ".-");
            $("#showtotal").text(formatThousands(datas.total) + ".-");
            $("#_totalfinal").val(datas.total - distcount);
            $("#totalfinal").text(formatThousands(datas.total - distcount) + ".-");
        });
    }

    function Income(value) {
        var totalfinal = parseInt($("#_totalfinal").val());
        var income = parseInt(value);
        if (income < totalfinal || isNaN(income)) {
            $("#change").val(0);
        } else {
            var changes = parseInt((income - totalfinal));
            $("#change").val(changes);
        }
    }

    function formatThousands(n, dp) {
        var s = '' + (Math.floor(n)), d = n % 1, i = s.length, r = '';
        while ((i -= 3) > 0) {
            r = ',' + s.substr(i, 3) + r;
        }
        return s.substr(0, i + 3) + r + (d ? '.' + Math.round(d * Math.pow(10, dp || 2)) : '');
    }

    //พิมพ์ใบเสร็จ
    function Bills() {
        var url = "<?php echo Yii::app()->createUrl('sell/bill') ?>";
        var sell_id = "<?php echo $sell_id ?>";
        var branch = $("#branch").val();
        var data = {sell_id: sell_id, branch: branch};
        $.post(url, data, function(datas) {
            //$("#popupbill").modal();
            //PrintElem("#bodybill");
            //$("#bodybill").html(datas);
            //PopupBill(datas);
            alert(datas);
        });
    }

    //ชำระเงิน
    function Check_bill() {
        var totalfinal = parseInt($("#_totalfinal").val());
        var income = parseInt($("#income").val());
        var distcoutvalue = $("#distcoutvalue").val();
        var numberordertotal = $("#numberordertotal").val();
        if (distcoutvalue == "") {
            $("#distcoutvalue").val(0);
            CalculatorDistcount();
        }

        if (numberordertotal <= 0 || numberordertotal == "") {
            swal("แจ้งเตือน!", "ยังไม่มีรายการสินค้า ...!", "warning");
            $("#income").focus();
            return false;
        }


        //update 2018-09-10
        /*
         if (isNaN(income) || income <= 0) {
         swal("แจ้งเตือน!", "ยังไม่ได้รับเงินจากลูกค้า ใส่จำนวนเงินที่ช่องรับเงิน ...!", "warning");
         $("#income").focus();
         return false;
         }

         if (income < totalfinal) {
         swal("แจ้งเตือน!", "ไม่พอจ่ายค่าสินค้า ...!", "warning");
         $("#income").focus();
         return false;
         }
         */

        confirmOrder();
    }

    function PopupBill(url, title) {
        // Fixes dual-screen position
        //                        Most browsers      Firefox
        var w = 800;
        var h = 600;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }

    function Notify(itemcode) {
        $.notify({
            // options
            icon: 'glyphicon glyphicon-check',
            title: 'เพิ่มสินค้า ' + itemcode,
            message: ' ในรายการขายสำเร็จ'
        }, {
            // settings
            element: 'body',
            position: null,
            type: "success",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 1031,
            delay: 2000,
            timer: 1000
        });
    }

    function Getdetailproduct(product_id) {
        var url = "<?php echo Yii::app()->createUrl('sell/detailproduct') ?>";
        var data = {product_id: product_id};
        $.post(url, data, function(datas) {
            //alert(datas);
            $("#itemcode").val(datas.product_id);
            $("#typeproduct").val(datas.producttype);
            $("#detailproduct").html(datas.productdetail + '<bt/>วิธีใช้ : ' + datas.size);
            $("#productname").val(datas.productname);
        }, 'json');
    }

    function searchpatient() {
        var typebuy = $('input[name=typebuy]:checked').val();
        var url = "<?php echo Yii::app()->createUrl('sell/searchpatient') ?>";
        var name = $("#name").val();
        var lname = $("#lname").val();
        var data = {name: name, lname: lname, typebuy: typebuy};
        if (name == "" && lname == "") {
            alert("กรุณากรอกอย่างน้อย  1 ช่อง...");
            $("#name").focus();
            return false;
        }
        $("#patient").html("<center>กำลังประมวลผล ...</center>");
        $.post(url, data, function(datas) {
            $("#popuppatient").modal();
            $("#popupbodypatient").html(datas);
            $("#patient").html("");
        });
    }

    function selectPatient(pid) {
        $("#pid").val(pid);
        var typebuy = $('input[name=typebuy]:checked').val();
        var url = "<?php echo Yii::app()->createUrl('sell/patient') ?>";
        var data = {pid: pid, typebuy: typebuy};
        $.post(url, data, function(datas) {
            $("#patient").html(datas);
            $("#popuppatient").modal("hide");
            $("#name").val("");
            $("#lname").val("");
        });
    }

    function PopupEditNumber(id, number, promotion) {
        if (promotion == "") {
            $("#_id").val(id);
            $("#newnumber").val(number);
            $("#popupeditnumber").modal();
        } else {
            alert("รายการจัดโปรโมชั่นไม่สามารถแก้ไขจำนวนได้...");
            return false;
        }
    }

    function UpdateNumber() {
        var url = "<?php echo Yii::app()->createUrl('sell/updatenumber') ?>";
        var id = $("#_id").val();
        var number = $("#newnumber").val();
        if (number == "") {
            alert("กรุณากรอกจำนวน ...");
            return false;
        }
        var data = {id: id, number: number};
        $.post(url, data, function(datas) {
            loadorder();
            $("#distcoutvalue").val(0);
            CalculatorDistcount();
            $("#popupeditnumber").modal("hide");
            $("#newnumber").val("");
            $("#_id").val("");
        });
    }

    function setprivilege(money) {
        $("#distcoutvalue").val(money);
        $("#distcoutvalue").attr("disabled", true);
        CalculatorDistcount();
    }

    function setpayment(type) {
        if (type == 1 || type == 3 || type == 4) {
            $("#text-payment").html("รับเงิน");
            $("#box-payment").hide();
            $("#box-money").show();
            $("#box-change").show();
        } else if (type == 2) {
            var url = "<?php echo Yii::app()->createUrl('sell/payment') ?>";
            var sell_id = "<?php echo $sell_id ?>";
            var data = {sell_id: sell_id};
            $.post(url, data, function(datas) {
                $("#text-payment").html("จำนวนโอน");
                $("#box-change").hide();
                $("#box-money").hide();
                $("#box-payment").show();
                $("#box-payment").html(datas);
            });
        }
    }

    function historyselltoday() {
        var url = "<?php echo Yii::app()->createUrl('sell/reporttoday') ?>";
        var date_sell = $("#datesell").val();
        var data = {datesell: date_sell};
        $.post(url, data, function(datas) {
            $("#reporttoday").html(datas);
        });
    }

    function sumreporttoday() {
        var url = "<?php echo Yii::app()->createUrl('sell/sumreporttoday') ?>";
        var data = {};
        $.post(url, data, function(datas) {
            $("#sumtoday").html(datas);
        });
    }

    function ResetTxt() {
        $("#itemcode").select2("val", "");
        $("#typeproduct").val("");
        $("#detailproduct").text("");
        $("#productname").val("");
        $("#number").val("");
        $("#stock").html("-");
    }

    document.addEventListener("keydown", function(event) {
        if (event.which == '13') {
            searchpatient();
        }
    });
    $(document).ready(function() {
        $("#itemcode").change(function() {
            var url = "<?php echo Yii::app()->createUrl('sell/detailproduct') ?>";
            var product_id = $("#itemcode").val();
            var data = {product_id: product_id};
            $.post(url, data, function(datas) {
                //alert(datas);
                $("#itemcode").val(datas.product_id);
                $("#typeproduct").val(datas.producttype);
                $("#detailproduct").html(datas.productdetail + '<br/>วิธีใช้ : ' + datas.size);
                $("#productname").val(datas.productname);
                $("#stock").html(datas.stock);
            }, 'json');
        });

        $("#datesell").change(function() {
            historyselltoday();
        });
    });

</script>


