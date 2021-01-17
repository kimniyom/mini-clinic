<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        <script src="<?= Yii::app()->baseUrl; ?>/themes/backend/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <style type="text/css">
            body{
                padding: 20px;
                font-size: 12px;
            }
            #bill table {
                background: #ffffff;
                color: #666666;
                font-size: 12px;
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
        </style>
    </head>
    <body>
        <div id="form_confirm">
            <div id="content">
                <?php
                $User = new Masuser();
                $BranchModel = new Branch();
                $Config = new Configweb_model();
                $Employee = Employee::model()->find("id=:id", array(":id" => $detail['user_id']));
                $Branch = $detail['branch'];
                $store = Branch::model()->find("id = '$Branch'");
                $pid = $logsell['pid'];
                if ($logsell['typebuy'] == "0") {
                    $patient = Patient::model()->find("pid = '$pid' ");
                    $text = "ลูกค้า";
                } else {
                    $patient = Employee::model()->find("pid = '$pid' ");
                    $text = "พนักงาน";
                }
                $logo = Logo::model()->find("branch = '$Branch '")['logo'];
                ?>

                <div id="bill" style=" background: #ffffff; border: #000 solid 0px;padding: 50px; padding-top: 10px;">
                    <div style=" text-align: center; color: #999999; font-size: 20px;">ใบเสร็จ / Receipt</div>
                    <hr/>
                    <div id="head-bill" style=" text-align: left;">
                        <div style=" float: left">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $logo ?>" style=" width: 48px;"/>
                        </div>
                        <div style=" float: left; padding-left: 10px;">
                            <b><?php echo $Config->get_webname(); ?></b><br/>
                            ที่อยู่ <?php echo $store['address'] ?><br/>
                            <?php echo $store['contact'] ?>
                        </div>
                    </div>


                    <div style="divleft">
                        <table style=" border: #cccccc solid 1px; width: 100%;">
                            <tr>
                                <td style=" width: 60%; border-right: #cccccc solid 1px; padding: 5px;">

                                    <?php echo $text ?> :  <?php
                                    if (isset($patient['name'])) {
                                        echo "คุณ " . $patient['name'] . " " . $patient['lname'];
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>
                                <td style=" padding: 5px; text-align: right;">
                                    <div class="pull-right">
                                        วันที่ : <?php echo $Config->thaidate($detail['date_sell']) ?><br/>
                                        รหัสบิล : <?php echo $detail['sell_id'] ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br/>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">#</th>
                                <th colspan="2">รายการ</th>
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
                                    <td style=" text-align: center;"><?php echo $i ?></td>
                                    <td colspan="2"><?php echo $rs['product_name'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td style=" text-align: right; font-weight: bold;">รวม</td>
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

                    <div style=" text-align: center; width: 150px; float: left;">
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
                    <div style=" text-align: center; width: 150px; float: right;">
                        ผู้ออกใบเสร็จ<br/><br/>
                        <?php echo $Employee['name'] . " " . $Employee['lname'] ?><br/>
                        (<?php echo Position::model()->find("id=:id", array(":id" => $Employee['position']))['position'] ?>)
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row" id="btn-footer">
                <div class="col-md-6 col-lg-6 col-sm-6" style=" text-align: center;">
                    <a href="<?php echo Yii::app()->createUrl('sell/index') ?>" style=" text-decoration: none;">
                        <button class="btn btn-default btn-block btn-lg">กลับไปหน้าขาย</button></a>
                </div>
                <div class="col-md-6 col-lg-6 col-sm-6" style=" text-align: center;">
                    <button class="btn btn-info btn-block btn-lg" onclick="prints()"><i class="fa fa-print"></i> พิมพ์ใบเสร็จ</button>
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
