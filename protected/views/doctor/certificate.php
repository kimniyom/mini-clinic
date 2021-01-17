<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/template-black.css" />
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/system-black.css" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap-cyborg.css" type="text/css" media="all" />

        <style type="text/css">
            #form_confirm{
                padding: 20px;
                padding-left: 45px;
                background: #ffffff;
                font-family: Thsarabun;
                width: 768px;
                position: relative;
            }

            @media print {
                body {
                    font-family: Thsarabun;
                }
                .name {
                    font-size: 20px;
                }
                .nickname {
                    font-size: 45px;
                }
                #form_confirm{
                    padding-top: 10px;
                    padding: 20px;
                    padding-left: 50px;
                    background: #ffffff;
                    font-family: Thsarabun;
                }
                #form_confirm p{
                    font-family: Thsarabun;
                }
                .pNumber{
                    color:#ffffff;
                }
            }
        </style>

        <?php
        $Config = new Configweb_model();
        ?>
    </head>
    <body>
        <!--
        <button type="button" onclick="printDiv('form_confirm')" id="btn-print">พิพม์</button>
        -->
        <div id="form_confirm">
            <div id="year" style=" position: absolute; right: 80px; top: 174px; font-family: Thsarabun; font-size: 20px;"><?php echo (substr($datas['createdate'], 0, 4) + 543) ?></div>
            <div id="month" style=" position: absolute; right: 80px; top: 174px; font-family: Thsarabun; font-size: 20px; width: 250px;  text-align: center;"><?php echo $Config->MonthFullArrays()[(substr($datas['createdate'], 5, 2))] ?></div>
            <div id="day" style=" position: absolute; right: 275px; top: 174px; font-family: Thsarabun; font-size: 20px; width: 100px;  text-align: center;"><?php echo (int) substr($datas['createdate'], -2) ?></div>

            <div id="age" style=" position: absolute; right: 120px; top: 248px; font-family: Thsarabun; font-size: 20px;"><?php echo $datas['age'] ?></div>
            <div id="patientname" style=" position: absolute; right: 230px; top: 248px; font-family: Thsarabun; font-size: 20px; width: 250px; text-align: center;"><?php echo $datas['patient_name'] ?></div>

            <div id="year_" style=" position: absolute; right: 80px; top: 285px; font-family: Thsarabun; font-size: 20px;"><?php echo (substr($datas['createdate'], 0, 4) + 543) ?></div>
            <div id="month_" style=" position: absolute; right:80px; top: 285px; font-family: Thsarabun; font-size: 20px; width: 250px; text-align: center;"><?php echo $Config->MonthFullArrays()[(substr($datas['createdate'], 5, 2))] ?></div>
            <div id="day_" style=" position: absolute; right: 260px; top: 285px; font-family: Thsarabun; font-size: 20px; width: 100px;  text-align: center;"><?php echo (int) substr($datas['createdate'], -2) ?></div>
            <div id="card" style=" position: absolute; right: 380px; top: 285px; font-family: Thsarabun; font-size: 20px; width: 190px; text-align: center;"><?php echo $datas['id_card'] ?></div>

            <div id="comment" style="position: absolute; left: 135px; top: 323px; height: 50px; font-family: Thsarabun; font-size: 20px; width: 650px; text-align: left;"><?php echo $datas['comment'] ?></div>

            <div id="datestart" style=" position: absolute; right: 125px; top: 398px; font-family: Thsarabun; font-size: 20px; width: 190px;  text-align: center;"><?php echo($datas['datestart'] != "0000-00-00") ? $Config->thaidatefull($datas['datestart']) : "-"; ?></div>
            <div id="daytotal" style=" position: absolute; right: 447px; top: 398px; font-family: Thsarabun; font-size: 20px; width: 50px;  text-align: center;"><?php echo($datas['day']) ? $datas['day'] : "-"; ?></div>

            <div id="comment" style=" position: absolute; left: 100px; top: 437px;font-family: Thsarabun; font-size: 20px; width: 500px;  text-align: center;"><?php echo($datas['dateend'] != "0000-00-00") ? $Config->thaidatefull($datas['dateend']) : "-"; ?></div>
            <div style=" width: 30%; float: right; text-align: center; right: 100px; padding-top: 530px; position: absolute; font-size: 20px;">
                ลงชื่อ ...........................................................<br/>
                (<?php echo $company['memager'] ?>)<br/>
                แพทย์ผู้ตรวจ
            </div>

            <?php
            $companyAddress = $company['address'];
            $companyTel = $company['tel'];
            $companyName = $company['companyname'];
            $presidentName = $company['memager'];
            $presidentNumber = $company['presidentnumber'];
            $str = str_replace('$employee', $datas['patient_name'], $form['form_confirm']);
            $str1 = str_replace('$clinicName', $companyName, $str);
            $str2 = str_replace('$clinicAddress', $companyAddress, $str1);
            $str3 = str_replace('$clinicTel', $companyTel, $str2);
            $str4 = str_replace('$presidentName', $presidentName, $str3);
            $str5 = str_replace('$presidentNumber', $presidentNumber, $str4);

            echo $str5;
            ?>
        </div>

        <script type="text/javascript">
            printDiv("form_confirm");
            function printDiv(divName) {
                //var printContents = document.getElementById(divName).innerHTML;
                //var originalContents = document.body.innerHTML;

                //document.body.innerHTML = printContents;

                window.print();

                //document.body.innerHTML = originalContents;
            }
        </script>
    </body>
</html>