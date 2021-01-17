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
                padding-bottom: 10px;
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

            ul li {list-style-type: none;}
        </style>
    </head>
    <body>
        <?php
        $Config = new Configweb_model();
        $Branch = $detail['branch'];
        $logo = Logo::model()->find("branch = '$Branch'")['logo'];
        $store = Branch::model()->find("id = '$Branch'");
        ?>
        <div id="bill" style=" background: #ffffff; padding: 50px; padding-top: 20px; padding-bottom: 120px;">
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
                            ลูกค้า : คุณ <?php echo $detail['name'] . " " . $detail['lname'] ?>
                        </td>
                        <td style=" padding: 5px; text-align: right;">
                            <div class="pull-right">
                                วันที่ : <?php echo $Config->thaidate($detail['service_date']) ?><br/>
                                เลขที่ : <?php echo $detail['service_id'] ?>
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
                        <th style=" text-align: center; width: 10%;">จำนวน</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;">1</td>
                        <td colspan="2">
                            <b>หัตถการ</b>
                            <?php echo ($procedure['procedure']) ? $procedure['procedure'] : "-"; ?>
                        </td>
                    </tr>
                    <?php
                    $total = 0;
                    if ($detail['pricedrug'] != "") {
                        $total = $detail['pricedrug'];
                    } else {
                        $total = 0;
                    }
                    $i = 1;

                    //foreach ($listdetail as $rs):
                    //$i++;
                    ?>
                    <!--
                        <tr>
                            <td style=" text-align: center;"><?php //echo $i      ?></td>
                            <td><?php //echo $rs['detail']      ?></td>
                            <td style=" text-align: center;"><?php //echo $rs['number']      ?></td>
                        </tr>
                    -->
                    <tr>
                        <td style=" text-align: center;">2</td>
                        <td><b>ค่ารักษา + ค่ายา</b></td>
                        <td style=" text-align: center;"><?php echo number_format($total, 2) ?></td>
                    </tr>
                    <?php //endforeach; ?>
                    <tr>
                        <td>
                            <div id="fullpaper"></div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="text-align: center;">รวม</td>
                        <td style="font-weight: bold; text-align: center;">
                            (<?php echo $Config->Convert($total) ?>)
                        </td>
                        <td style="text-align: right;">
                            <?php echo number_format($total, 2); ?>

                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <b style="font-size: 16px;">วันนัด <?php echo ($detail['appoint']) ? $Config->thaidate($detail['appoint']) : "ไม่มี"; ?></b><br/>
                            <font style="color:red;">*กรณีที่ท่านมาตามนัดไม่ได้ให้โทรแจ้งคลินิกก่อนถึงเวลานัดหมาย</font>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div style=" text-align: center; width: 30%; float: right;">
                ผู้รับเงิน<br/><br/>
                <hr style=" margin-bottom: 10px;"/>
                <?php echo $detail['empname'] . " " . $detail['emplname'] ?><br/>
            </div>
        </div>

        <script type="text/javascript">
            //alert("1234");
            setPaper();
            function prints() {
                window.print();
            }

            function setPaper() {
                var box = document.getElementById('bill').offsetHeight;
                var A4 = 842;
                var full = (A4 - box);
                $("#fullpaper").css({'height': full});
                prints();
                //prints();
            }
        </script>
    </body>
</html>


