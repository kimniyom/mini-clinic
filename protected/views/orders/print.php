<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>
            <?php
            $web = new Configweb_model();
            echo "order-" . $order_id;
            ?>
        </title>

        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/template.css"/>

        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/system.css"/>

        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap-theme.css" type="text/css" media="all" />
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

        <style type="text/css">
            table, td, th {
              

            }

    #tablelistorder tr th{
        border: 1px solid black;
        background-color: #000000;
        white-space: nowrap;
        border-collapse: collapse;
        letter-spacing: 1pt;
        color:#eeeeee;
        padding: 5px;
    }

    #tablelistorder tr td{
         border: 1px solid black;
        padding: 2px 5px;
        font-size: 16px;
        white-space: nowrap;
        border-collapse: collapse;
        letter-spacing: 1pt;
    }
    #tablelistorder tfoot tr td{
         border: 1px solid black;
        font-weight: bold;
        white-space: nowrap;
        padding: 2px 5px;
        border-collapse: collapse;
        background-color: #eeeeee;

    }

    #tablelistorder tfoot tr th{
         border: 1px solid black;
        font-weight: bold;
        white-space: nowrap;
        padding: 2px 5px;
        background-color: #eeeeee;
        border-collapse: collapse;
        color: #eeeeee;
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

    </head>
    <body>
        <?php
        $companySell = Companycenter::model()->find("id = '1'");
        $Thaibath = new Thaibaht();
        ?>
        <div style=" position: fixed; left: 20px; top: 20px; z-index: 100;">
            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $logo ?> " style="width: 100px;" />
        </div>
        <div style="border-radius: 0px; padding: 0px; background: #FFFFFF; border: #000000 solid 0px; position: relative;" id="printorder">
           
            <div style=" text-align: center; margin-bottom: 10px; font-size: 18px;">
                <h4 style=" margin-bottom: 0px; font-size: 24px; color: #000; font-weight: bold;"><?php echo $BranchModel['branchname']; ?></h4><br/>
                <?php echo $BranchModel['address']; ?><br/>
                <?php echo $BranchModel['contact']; ?><br/>
                <h4 style=" margin: 0px; font-size: 24px; color: #000; font-weight: bold;">ใบสั่งซื้อสินค้า</h4>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div style="background: #eeeeee; border-radius: 10px; border: #111111 solid 1px; padding: 5px;">
                    <table id="companysell">
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
                <div>
                    <div style=" padding: 0px;height: 100px; float: right; margin-right: 20px;" id="companysellbarcode">
                        <div style="background: #eeeeee; border-radius: 10px; border: #111111 solid 1px; padding: 5px;">
                            <table id="box-ordercode" style="width: 100%;">
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
                                    <td style=" text-align: right;"><?php echo date_format(date_create($order['create_date']),'d/m/Y') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            

<table style="width: 100%; margin-top: 10px;" id="tablelistorder">
                        <thead>
                            <tr>
                                <th style="text-align: center;">#</th>
                                <th>รหัสสินค้า</th>
                                <th>สินค้า</th>
                                <th>จำนวน</th>
                                <th>หน่วยนับ</th>
                                <th style="text-align: right;">ราคา/หน่วย</th>
                                <th style="text-align: right;">ส่วนลด</th>
                                <th style="text-align: right;">จำนวนเงิน</th>
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
                <td style="text-align: center; border-top: 0px; border-bottom: 0px;"><?php echo $i ?></td>
                <td style="border: 0px;"><?php echo $rs['product_id'] ?></td>
                <td style="border: 0px;"><?php echo $rs['product_nameclinic'] ?></td>
                <td style=" text-align: center;border: 0px;">
                    <?php echo number_format($rs['number']) ?>
                    <?php if($order['status'] == "0"){ ?>
                    <i class="fa fa-pencil text-warning" style=" cursor: pointer;" onclick="popupeditnumber('<?php echo $rs['id'] ?>', '<?php echo $rs['number'] ?>', '<?php echo $rs['product_id'] ?>','<?php echo $rs['distcountprice'] ?>')"></i>
                <?php } ?>
                </td>
                <td style=" text-align: center;border: 0px;"><?php echo $rs['unitname'] ?></td>
                <td style=" text-align: right;border: 0px;"><?php echo number_format($sumrow, 2) ?></td>
                <td style=" text-align: right;border-top: 0px; border-bottom: 0px;"><?php echo ($rs['distcountprice']) ? $rs['distcountprice'] : "" ?></td>
                <td style=" text-align: right;border-top: 0px; border-bottom: 0px;"><?php echo number_format($rs['pricetotal'], 2) ?></td>
                
            </tr>
        <?php endforeach; ?>
        <?php 
            if($i < 14){
                $row = (14 - $i);
            }
            for($j=0;$j<=$row;$j++){
        ?>
        <tr>
            <td style="border-top:0px; border-bottom: 0px;"></td>
            <td colspan="5" style="color: #ffffff; border-top:0px; border-bottom: 0px;">
                3
            </td>
            <td style="border-top:0px;border-bottom: 0px;"></td>
            <td style="border-top:0px;border-bottom: 0px;"></td>
        </tr>
        <?php } ?>

    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" rowspan="5" valign="top">
                หมายเหตุ
            </td>
        </tr>
        <tr>
            <td style="text-align: right; ">รวมเงิน</td>
            <td style=" text-align: right; "><?php echo number_format($sumAll, 2) ?></td>
           
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
            <th colspan="6" style=" text-align: center; padding: 10px 5px;background: #111111;">
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
            </th>
            <th style="background: #111111;text-align: right;">รวมเงินทั้งสิ้น</th>
            <th style=" text-align: right; background: #111111;"><?php echo number_format(sprintf('%.2f', $priceCovert), 2); ?></th>
            
        </tr>
    </tfoot>
    </table>
    <div  style=" width: 100%; height: 10px;"></div>

                <div style="float: left; width: 30%; height: 100px; border: #000000 solid 1px; padding: 5px; position: relative; font-size: 20px; text-align: center; margin-right: 20px;">
                สินค้าอยู่ในสภาพถูกต้องครบถ้วน<br/><br/><br/>
                <div style="position: fixed; width: 100%; bottom: 5px; text-align: center; border-top: #000000 dotted 1px; height: 30px;">
                    คลังสินค้า / ผู้ตรวจสอบ<br/>
                    วันที่ ............./................../................
                </div>
            </div>
            <div style="float: left; width: 30%; height: 100px; border: #000000 solid 1px; padding: 5px; position: relative; font-size: 20px; text-align: center; margin-left: 10px;">
                <font style=" color: #FFFFFF;">1</font><br/><br/><br/>
                <div style="position: fixed; width: 100%; bottom: 5px; text-align: center; border-top: #000000 dotted 1px; height: 30px;">
                    ผู้ส่งของ<br/>
                    วันที่ ............./................../................
                </div>
            </div>
            <div style="float: right; width: 30%; height: 100px; border: #000000 solid 1px; padding: 5px; position: relative; font-size: 20px; text-align: center;">
                <?php echo $companySell['companyname'] ?><br/><br/><br/>
                <div style="position: fixed; width: 100%; bottom: 5px; text-align: center; border-top: #000000 dotted 1px; height: 30px;">
                    ผู้มีอำนาจลงนาม<br/>
                    วันที่ ............./................../................
                </div>
            </div>

        </div>

        <script type="text/javascript">

            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    </body>
    <html


