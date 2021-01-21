<style type="text/css">
    table, td, th {
      border: 1px solid black;

    }

    #tablelistorder tr th{
        background-color: #000000;
        white-space: nowrap;
         border-collapse: collapse;
         letter-spacing: 1pt;
    }

    #tablelistorder tr td{
        padding: 2px 5px;
        font-size: 16px;
        white-space: nowrap;
        border-collapse: collapse;
        letter-spacing: 1pt;
    }
    #tablelistorder tfoot tr td{
        font-weight: bold;
        white-space: nowrap;
        padding: 2px 5px;
        background-color: #000000;
    }

    .box-supplier table tr td{
        padding: 2px 2px 2px 10px;
        border:none;
        border-collapse: collapse;
    }

    #companysell{
        width: 100%;
        letter-spacing: 0.5pt;
    }
    #companysell td{
        border-collapse: collapse;
        letter-spacing: 0.5pt;
    }

    #box-ordercode td{
        border-collapse: collapse;
        padding-bottom: 11px;
        letter-spacing: 0.5pt;
    }
</style>

<?php
$this->breadcrumbs = array(
    'ใบสั่งสินค้า' => array('index', 'branch' => $order['branch']),
    $order['order_id'],
);
$companySell = Companycenter::model()->find("id = '1'");
$Thaibath = new Thaibaht();
$order_id = $order['order_id'];
$ItemModel = new CenterStockitem();
?>


<!--
    ##### ENDPOPUP  ListORder ######
-->

<div class="row" style=" margin: 0px; background: #222222; padding-top: 5px;">
    <div class="col-md-9 col-lg-9" style=" margin: 0px; padding: 0px;">
        <div class="row" style=" margin: 0px; padding: 0px;">
            <div class="col-md-3 col-lg-3 col-sm-6" style=" margin-bottom: 5px;">
                <a href="<?php echo Yii::app()->createUrl('orders/print', array("order_id" => $order_id)) ?>" target="_blank">
                    <button type="button" class="btn btn-default btn-block">
                        <i class="fa fa-print"></i> พิมพ์ใบสั่งซื้อ
                    </button>
                </a>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-6" style=" margin-bottom: 5px;">
                <a href="<?php echo Yii::app()->createUrl('orders/bill', array("order_id" => $order_id)) ?>" target="_blank">
                    <button type="button" class="btn btn-default btn-block">
                        <i class="fa fa-print"></i> พิมพ์ใบส่งของ
                    </button>
                </a>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-6" style=" margin-bottom: 5px;">
                <div class="dropdown">
                    <?php if ($order['status'] == '0') { ?>
                    <button class="btn btn-danger btn-block" type="button" id="btnstatus" onclick="Confirmorder('<?php echo $order_id ?>')">
                        ยืนยันการสั่งซื้อ
                    </button>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row" style="margin: 0px;">
    <div class="col-lg-9 col-md-12" style=" padding: 0px;">

        <div id="boxordersss">
            <div class="well" style=" border-radius: 0px;  margin-bottom: 0px; position: relative;" id="boxorders">
                <div style=" text-align: center; margin-bottom: 10px; font-family: Th;">
                    <h4 style=" margin-bottom: 0px;"><?php echo $BranchModel['branchname']; ?></h4><br/>
                    <div style=" font-size: 20px;">
                        <?php echo $BranchModel['address']; ?><br/>
                        <?php echo $BranchModel['contact']; ?>
                    </div>
                    <h4 style=" margin: 0px; font-family: Th; font-size: 24px;">ใบสั่งซื้อสินค้า</h4>
                </div>

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <div class="box-supplier">
                            <table id="companysell" >
                                <tr>
                                    <td>ผู้ขาย : <?php echo $supplier['company_name'] ?></td>
                                </tr>
                                <tr>
                                    <td>ที่อยู่ : <?php echo $supplier['address'] ?></td>
                                </tr>
                                <tr>
                                    <td>
                                        เลขประจำตัวผู้เสียภาษี : <?php echo($supplier['taxnumber']) ? $supplier['taxnumber'] : "-"; ?> 
                                    </td>
                                </tr>
                                <tr>
                                    <td>โทร. <?php echo $supplier['tel'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div style=" padding: 0px;height: 100px; width: 200px; float: right;" id="box-ordercode-right">
                            <table id="box-ordercode">
                                <tr>
                                    <td style=" text-align: center;" colspan="2" class="barcodes">
                                        รหัสสั่งซื้อเลขที่ 
                                        <div style="text-align: center; margin-left: 10px;" id="<?php echo $order['order_id'] ?>"></div>
                                        <?php
                                        echo $order['order_id'];
                                        /*
                                        $optionsArray = array(
                                            'elementId' => $order['order_id'], 
                                            'value' => $order['order_id'],
                                            'type' => 'code39', 
                                            'settings' => array(
                                                'barWidth' => "1",
                                                'barHeight' => "20",
                                            ),
                                        );
                                        $this->widget('ext.Yii-Barcode-Generator.Barcode', $optionsArray);
                                        */
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>วันที่สั่งซื้อ  </td>
                                    <td style=" text-align: right;"><?php echo $order['create_date'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <hr/>
            <label>สินค้า</label>
            <p style="font-size:12px;">รายการสินค้าที่ระบุในใบสั่งซื้อ</p>
                <div class="table-responsive">
                    <table style=" width: 100%;" class="" id="tablelistorder">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>รหัสสินค้า</th>
                                <th>สินค้า</th>
                                <th>จำนวน</th>
                                <th>หน่วยนับ</th>
                                <th>ราคา/หน่วย</th>
                                <th>ส่วนลด</th>
                                <th>จำนวนเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
        <?php
        $sumproduct = 0;
        $sumdistcount = 0;
        $sumrow = 0;
        $sumAll = 0;
        $i = 0;
        $taxresult = 0;
        foreach ($orderlist as $rs):
            $i++;
            $sumrow = ($rs['costs'] * $rs['number']);
            $sumAll = ($sumAll + $sumrow);
            $sumproduct = ($sumproduct + $rs['pricetotal']);
            $sumdistcount = ($sumdistcount + $rs['distcountprice']);

            //vat
            if ($vat == 1) {
                $tax = ($sumproduct * 7) / 100;
                $taxresult = number_format($tax, 2);
            } else if ($vat == 2) {
                $tax = ($sumproduct * 7) / 107;
                $taxresult = number_format($tax, 2);
            } else {
                $tax = 0;
                $taxresult = 0;
            }
            ?>
            <tr>
                <td style="text-align: center;"><?php echo $i ?></td>
                <td><?php echo $rs['product_id'] ?></td>
                <td><?php echo $rs['product_nameclinic'] ?></td>
                <td style=" text-align: center;">
                    <?php echo number_format($rs['number']) ?>
                    <?php if($order['status'] == "0") ?>
                    <i class="fa fa-pencil text-warning" style=" cursor: pointer;" onclick="popupeditnumber('<?php echo $rs['id'] ?>', '<?php echo $rs['number'] ?>', '<?php echo $rs['product_id'] ?>','<?php echo $rs['distcountprice'] ?>')"></i>
                </td>
                <td style=" text-align: center;"><?php echo $rs['unitname'] ?></td>
                <td style=" text-align: right;"><?php echo number_format($sumrow, 2) ?></td>
                <td style=" text-align: right;"><?php echo ($rs['distcountprice']) ? $rs['distcountprice'] : "" ?></td>
                <td style=" text-align: right;"><?php echo number_format($rs['pricetotal'], 2) ?></td>
                
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" rowspan="5">
                หมายเหตุ
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">รวมเงิน</td>
            <td style=" text-align: right;"><?php echo number_format($sumAll, 2) ?></td>
           
        </tr>
        <tr>
            <td style="text-align: right;">ส่วนลด</td>
            <td style=" text-align: right;"><?php echo number_format($sumdistcount, 2) ?></td>
           
        </tr>
        <tr>
            <td style="text-align: right;">
                <?php if ($vat == 2) { ?>
                    ยอดก่อนรวมภาษี
                <?php } else { ?>
                    ยอดหลังหักส่วนลด
                <?php } ?>
            </td>
            <td style=" text-align: right;">
                <?php
                if ($vat == 2) {
                    echo number_format($sumproduct - $taxresult, 2);
                } else {
                    echo number_format($sumproduct, 2);
                }
                ?>
            </td>
           
        </tr>
        <tr>
            <td style="text-align: right;">ภาษีมูลค่าเพิ่ม 7 %</td>
            <td style=" text-align: right;">
                <?php
                echo $taxresult;
                ?>
            </td>
            
        </tr>

        <tr>
            <td colspan="6" style=" text-align: center;background: #111111;">
                <?php
                //$pricetotal = number_format(($priceresult + $tax), 2);
                if ($vat == 2) {
                    $totalResult = $sumproduct;
                } else {
                    $totalResult = ($sumproduct + $taxresult);
                }
                $priceresult = $totalResult;
                $pricetotal = number_format(($priceresult), 2);
                $priceCovert = str_replace(",", "", $pricetotal);
                if (substr($priceCovert, -2) == "00") {
                    $priceCoverts = str_replace(".00", "", $priceCovert);
                } else {
                    $priceCoverts = $priceCovert;
                }

                echo "(" . $Thaibath->convert($priceCoverts) . ")";
                ?>
            </td>
            <td style="background: #111111;text-align: right;">รวมเงินทั้งสิ้น</td>
            <td style=" text-align: right; background: #111111;"><?php echo number_format(sprintf('%.2f', $priceCovert), 2); ?></td>
            
        </tr>

        <input type="hidden" name="priceresult" id="priceresult" value="<?php echo $priceresult ?>">
    </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12">
        <h4 style="font-family: Th;">สถานะ</h4>
        <div class="well" style=" text-align: center; text-align: left;">
                <?php if ($order['status'] == '0') { ?>
                    <h4 style="font-family: Th;"><i class="fa fa-check text-success"></i> สร้างใบสั่งซื้อ</h4>
                    <h4 style="font-family: Th;"><i class="fa fa-remove text-danger"></i> ยืนยันรายการ</h4>
                <?php } else { ?>
                    <h4 style="font-family: Th;"><i class="fa fa-check text-success"></i> สร้างใบสั่งซื้อ</h4>
                    <h4 style="font-family: Th;"><i class="fa fa-check text-success"></i> ยืนยันรายการ</h4>
                <?php } ?>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="popupeditnumber">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">แก้ไขจำนวนสินค้า</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id"/>
                แก้ไขจำนวน
                <input type="text" class="form-control" id="newsnumber" onKeyUp="if (this.value * 1 != this.value)
                            this.value = '';"/>
                <input type="hidden" class="form-control" id="product_id"/>
                <input type="hidden" class="form-control" id="distcountrow"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-block" onclick="editnumber()"><i class="fa fa-save"></i> บันทึก</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    function Confirmorder(order_id) {
        var r = confirm("ตรวจสอบข้อมูลก่อนยืนยันรายการ หลังจากนี้จะไม่สมารถทำรายการได้...?");
        if(r == true){
            var url = "<?php echo Yii::app()->createUrl('orders/confirmorder') ?>";
            var data = {order_id: order_id};
            
            $.post(url, data, function (datas) {
                window.location.reload();
            });
        }
    }

    function updatestatus(status) {
        var url = "<?php echo Yii::app()->createUrl('orders/updatestatus') ?>";
        var order_id = "<?php echo $order_id ?>";
        var data = {order_id: order_id, status: status};
        $.post(url, data, function (datas) {
            window.location.reload();
        });

    }
</script>

<script type="text/javascript">

    Setscreen();
    function Setscreen() {
        var screen = window.innerHeight;
        var w = window.innerWidth;
        if (w > 786) {
            var screenfull = (screen - 150);
            $("#boxorders").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
        } else {
            $(".barcodes").css({'text-align': 'left'});
            $("#box-ordercode-right").css({'float': 'left', 'width': '100%', 'border-top': 'none'});
            $("#box-ordercode").css({'border-top': 'none'});
        }
    }

    function Adddistcount() {
        var url = "<?php echo Yii::app()->createUrl('orders/adddistcount') ?>";
        var order_id = "<?php echo $order_id ?>";
        var distcount = $("#distcount").val();
        if (distcount == "") {
            alert("กรุณากรอกส่วนลด");
            return false;
        }
        var data = {order_id: order_id, distcount: distcount};
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }

    function popupeditnumber(id, number, product_id,distcount) {
        $("#popupeditnumber").modal();
        $("#newsnumber").val(number);
        $("#distcountrow").val(distcount);
        $("#id").val(id);
        $("#product_id").val(product_id);
    }

    function editnumber() {
        var url = "<?php echo Yii::app()->createUrl('orders/editnumber') ?>";
        var id = $("#id").val();
        var product_id = $("#product_id").val();
        var newsnumber = $("#newsnumber").val();
        var distcount = $("#distcountrow").val();
        var data = {id: id, newsnumber: newsnumber, product_id: product_id,distcount};
        $.post(url, data, function (datas) {
            window.location.reload();
        });
    }
</script>


