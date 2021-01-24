<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title></title>
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
        </style>

        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        <script src="<?= Yii::app()->baseUrl; ?>/themes/backend/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    </head>
    <body>
        <?php
        $User = new Masuser();
        $BranchModel = new Branch();
        $Config = new Configweb_model();
        $Employee = Employee::model()->find("id=:id", array(":id" => $detail['user_id']));
        $Branch = $detail['branch'];
        $pid = $detail['pid'];
        $patient = Patient::model()->find("pid=:pid", array(":pid" => $pid));
        $Company = Companycenter::model()->find("id=:id", array(":id" => 1));
        ?>


        <div id="bill" style=" background: #ffffff; border: #000 solid 1px;padding: 20px;">
            <div id="head-bill" style=" text-align: left;">
                <div style=" float: left">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $Company['logo'] ?>" style=" width: 48px;"/>
                </div>
                <div style=" float: left;">
                    <h4><?php echo$Company['companyname'] ?></h4>
                    <?php echo $Company['address'] ?>
                </div>
            </div>
            <hr/>

            <div style="divleft">
                <table style=" border: #cccccc solid 1px; width: 100%;">
                    <tr>
                        <td style=" width: 60%; border-right: #cccccc solid 1px; padding: 5px;">
                            ลูกค้า : คุณ <?php echo $patient['name'] . " " . $patient['lname'] ?>
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
                        <th>รายการ</th>
                        <th style=" text-align: center; width: 15%;">ราคา / หน่วย</th>
                        <th style=" text-align: center; width: 10%;">รวม</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sum = 0;
                    $i = 0;
                    foreach ($order as $rs):
                        $i++;

                        $priceRow = ($rs['product_price'] * $rs['total']);
                        $sum = $sum + $priceRow;
                        ?>
                        <tr>
                            <td style=" text-align: center;"><?php echo $i ?></td>
                            <td><?php echo $rs['product_name'] ?></td>
                            <td style="text-align: right;">​<?php echo number_format($rs['product_price'], 2) ?></td>
                            <td style="text-align: right;">​<?php echo number_format($priceRow, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td style=" text-align: right; font-weight: bold;" colspan="3">รวม</td>
                        <td style="text-align: right;"><?php echo number_format($sum, 2); ?></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right; font-weight: bold;" colspan="3">ส่วนลด</td>
                        <td style="text-align: right;"><?php echo number_format($logsell['distcount'], 2); ?></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right; font-weight: bold;" colspan="3">ราคาหักส่วนลด</td>
                        <td style="text-align: right;"><?php echo number_format($logsell['totalfinal'], 2); ?></td>
                    </tr>
                    <tr>
                        <td style=" text-align: right; font-weight: bold;" colspan="3">ราคาสุทธิ</td>
                        <td style="text-align: right;"><?php echo number_format($logsell['income'], 2); ?></td>
                    </tr>
                </tfoot>
            </table>
            <br/>

            <div style=" text-align: right;">
                พนักงานขาย<br/>
                <?php echo $Employee['name'] . " " . $Employee['lname'] ?><br/>
            </div>
        </div>

    </body>
</html>
