<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/template.css"/>
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/system.css"/>
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        <script src="<?= Yii::app()->baseUrl; ?>/themes/backend/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <style type="text/css">
            body{
                padding: 20px;
                font-size: 16px;
                font-family: Th;
            }
            #bill table {
                background: #ffffff;
                color: #666666;
                font-size: 12px;
                border-collapse: collapse;
            }

            #bill{
                color: #666666;
                padding-bottom: 60px;
            }

            #divleft{
                width: 40%;
                border: #cccccc solid 1px; padding:5px;
                float: left;
            }

            #divright{
                float: right;
                width: 40%;
                border: #cccccc solid 1px; padding:5px;
            }
            #form_confirm{
                padding: 20px;
                background: #ffffff;
                font-family: Thsarabun;
                width: 768px;
                position: relative;
                margin: auto;
            }

            .table-order tbody tr td{
                border-collapse: collapse !important;
                border: solid 1px #000000 !important;
                padding: 2px 5px  !important;
                font-size: 16px;
            }

            .table-order tbody tr td{
                border-collapse: collapse !important;
                border: solid 1px #000000 !important;
                padding: 2px 5px  !important;
                border-bottom: 0px !important;
                border-top: 0px !important;
                font-size: 16px;
            }

            .table-order thead tr th{
                border-collapse: collapse !important;
                border: solid 1px #000000 !important;
                padding: 2px 5px  !important;
                color:#ffffff !important;
                background: #000000 !important;
                font-size: 16px;
            }

            .table-order tfoot tr td{
                border-collapse: collapse !important;
                border: solid 1px #000000 !important;
                padding: 2px 5px  !important;
                font-size: 16px;

            }
            .box-patient{
                border-radius: 5px !important;
                background-color: #EEEEEE !important;
                border: solid 1px #000000 !important;
                padding: 10px !important;
                font-size: 16px;
            }

            .table-order{
                width: 100% !important;
                border: solid 1px #333333 !important;
                font-size: 16px;
            }
            .w-color{
                color: #FFFFFF  !important;
            }

            @media print {
                .table-order tbody tr td{
                    border-collapse: collapse !important;
                    border: solid 1px #000000 !important;
                    padding: 2px 5px  !important;
                    font-size: 16px;
                }

                .table-order tbody tr td{
                    border-collapse: collapse !important;
                    border: solid 1px #000000 !important;
                    padding: 2px 5px  !important;
                    border-bottom: 0px !important;
                    border-top: 0px !important;
                    font-size: 16px;
                }

                .table-order thead tr th{
                    border-collapse: collapse !important;
                    border: solid 1px #000000 !important;
                    padding: 2px 5px  !important;
                    color:#ffffff !important;
                    background: #000000 !important;
                    font-size: 16px;
                }

                .table-order tfoot tr td{
                    border-collapse: collapse !important;
                    border: solid 1px #000000 !important;
                    padding: 2px 5px  !important;
                    font-size: 16px;

                }
                .box-patient{
                    border-radius: 5px !important;
                    background-color: #EEEEEE !important;
                    border: solid 1px #000000 !important;
                    padding: 10px !important;
                    font-size: 16px;
                }

                .table-order{
                    width: 100% !important;
                    border: solid 1px #333333 !important;
                    font-size: 16px;
                }
                .w-color{
                    color: #FFFFFF  !important;
                }
            }
        </style>
    </head>
    <body>
        <div id="form_confirm">
            <div style=" padding: 20px; padding-left: 50px;">
                <div class="row" id="btn-footer">
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3" style=" text-align: center;">
                        <a href="<?php echo Yii::app()->createUrl('sell/index') ?>" style=" text-decoration: none;">
                            <button class="btn btn-default btn-block btn-lg">กลับไปหน้าขาย</button></a>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3" style=" text-align: center;">
                        <button class="btn btn-info btn-block btn-lg" onclick="prints()"><i class="fa fa-print"></i> พิมพ์ใบเสร็จ</button>
                    </div>
                </div>
            </div>
            <div id="content">
                <?php
                $User = new Masuser();
                $BranchModel = new Branch();
                $Config = new Configweb_model();
                $Employee = Employee::model()->find("id=:id", array(":id" => $detail['user_id']));
                $Branch = $detail['branch'];
                $store = Companycenter::model()->find("id = '1'");
                $pid = $logsell['pid'];
                if ($logsell['typebuy'] == "0") {
                    $patient = Patient::model()->find("pid = '$pid' ");
                    $text = "ลูกค้า";
                } else {
                    $patient = Employee::model()->find("pid = '$pid' ");
                    $text = "พนักงาน";
                }
                //$logo = Logo::model()->find("branch = '$Branch '")['logo'];
                ?>

                <div id="bill" style=" background: #ffffff; border: #000 solid 0px;padding: 50px; padding-top: 10px;">
                    <div style=" text-align: center; color: #999999; font-size: 24px; font-family: Th;">ใบเสร็จ / Receipt</div>
                    <hr/>
                    <div id="head-bill" style=" text-align: left;">
                        <div style=" float: left">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $store['logo'] ?>" style=" width: 48px;"/>
                        </div>
                        <div style=" float: left; padding-left: 10px; font-family: Th; font-size: 16px;">
                            <b><?php echo $store['companyname'] ?></b><br/>
                            ที่อยู่. <?php echo $store['address'] ?><br/>
                            โทร.<?php echo $store['tel'] ?>
                        </div>
                    </div>

                    <br/><br/><br/>
                    <div  style=" margin-top: 20px;">
                        <table style=" width: 100%;">
                            <tr>
                                <td style=" width: 60%;  padding: 5px;">
                                    <div style=" border-radius: 5px; background: #EEEEEE; border: solid 1px #000000; padding: 10px;" class="box-patient">
                                        <?php echo $text ?> :  <?php echo ($patient['name']) ? "คุณ " . $patient['name'] . " " . $patient['lname'] : "-"; ?><br/>
                                        โทร: <?php echo $patient['tel'] ?>
                                    </div>
                                </td>
                                <td style=" padding: 5px; text-align: right;">
                                    <div class="pull-right">
                                        <div style=" border-radius: 5px; background: #EEEEEE; border: solid 1px #000000; padding: 10px;" class="box-patient">
                                            วันที่ : <?php echo $Config->thaidate($detail['date_sell']) ?><br/>
                                            รหัสบิล : <?php echo $detail['sell_id'] ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br/>
                    <div style=" padding: 5px;">
                        <table class="table-order">
                            <thead>
                                <tr>
                                    <th style="text-align: center; width: 5%;">#</th>
                                    <th>รายการ</th>
                                    <th style=" text-align: right;">ราคา</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sum = 0;
                                $i = 0;
                                foreach ($order as $rs):
                                    $i++;
                                    $sum = $sum + $rs['product_price'];
                                    ?>
                                    <tr>
                                        <td style=" text-align: center; border-bottom: 0px; border-top: 0px;"><?php echo $i ?></td>
                                        <td style=" border-bottom: 0px; border-top: 0px;"><?php echo $rs['product_name'] ?></td>
                                        <td style=" text-align: right; border-bottom: 0px; border-top: 0px;"><?php echo number_format($rs['product_price'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php for ($j = 0; $j <= (18 - $i); $j++) { ?>
                                    <tr>
                                        <td><div class="w-color">1</div></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td style=" text-align: right; font-weight: bold;">รวมสุทธิ</td>
                                    <td style=" width: 100px; text-align: right; font-weight: bold;">
                                        <?php echo number_format($sum, 2) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center;font-weight: bold;" colspan="3">
                                        (<?php echo $Config->Convert($sum) ?>)
                                    </td>
                                </tr>
                                <?php if ($detail['comment']) { ?>
                                    <tr>
                                        <td colspan="3">
                                            <?php echo ($detail['comment']) ? "*" . $detail['comment'] : ""; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tfoot>
                        </table>
                    </div>
                    <div style=" text-align: center; width: 150px; float: left; margin-top: 20px; font-family: Th;font-size: 16px;">
                        การชำระเงิน<br/><br/>
                        <?php
                        if ($detail['payment'] == 1) {
                            echo "เงินสด";
                        } else if ($detail['payment'] == 2) {
                            echo "เงินโอน";
                        } else if ($detail['payment'] == 3) {
                            echo "บัตรเครดิต";
                        } else if ($detail['payment'] == 4) {
                            echo "ผ่อนชำระ";
                        }
                        ?>
                    </div>
                    <div style=" text-align: center; width: 150px; float: right;margin-top: 20px; font-family: Th; font-size: 16px;">
                        ผู้ออกใบเสร็จ<br/><br/>
                        <?php echo $Employee['name'] . " " . $Employee['lname'] ?><br/>
                        (<?php echo Position::model()->find("id=:id", array(":id" => $Employee['position']))['position'] ?>)
                    </div>
                </div>
            </div>


        </div>
        <script type="text/javascript">
            //alert("1234");
            //prints();
            //function prints() {
            //$("#btn-footer").hide();
            // window.print();
            //}

            function prints() {
                var divName = "content";
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>

    </body>
</html>
