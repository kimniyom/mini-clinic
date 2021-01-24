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
            #form_refer{
                padding: 20px;
                padding-top: 0px;
                padding-bottom: 0px;
                padding-left: 50px;
                background: #ffffff;
                font-family: Thsarabun;
                width: 768px;
                position: relative;
                color: #000000;
            }

            @media print {
                body {
                    font-family: Thsarabun;
                    color: #000000;
                }
                .name {
                    font-size: 20px;
                }
                .nickname {
                    font-size: 50px;
                }
                #form_refer{
                    color: #000000;
                    padding: 20px;
                    padding-top: 0px;
                    padding-bottom: 0px;
                    padding-left: 50px;
                    background: #ffffff;
                    font-family: Thsarabun;
                }

                #form_refer p{
                    font-family: Thsarabun;
                    color: #000000;
                }
            }
        </style>
        <?php
        $Config = new Configweb_model();
        ?>
    </head>
    <body>
        <div id="form_refer">

            <div id="year" style=" position: absolute; right: 90px; top: 135px; font-family: Thsarabun; font-size: 18px;"><?php echo (substr($datas['date_refer'], 0, 4) + 543) ?></div>
            <div id="month" style=" position: absolute; right: 86px; top: 135px; font-family: Thsarabun; font-size: 18px; width: 250px;  text-align: center;"><?php echo $Config->MonthFullArrays()[(substr($datas['date_refer'], 5, 2))] ?></div>
            <div id="day" style=" position: absolute; right: 258px; top: 135px; font-family: Thsarabun; font-size: 18px; width: 100px;  text-align: center;"><?php echo (int) substr($datas['date_refer'], -2) ?></div>

            <!--
                ###### เรียน ########
            -->
            <div id="year" style=" position: absolute; left: 90px; top: 170px; font-family: Thsarabun; font-size: 18px; width: 500px;"><?php echo $datas['sendto'] ?></div>

            <div id="patientname" style=" position: absolute; right: 180px; top: 240px; font-family: Thsarabun; font-size: 18px; width: 250px; text-align: center;"><?php echo $datas['name'] ?></div>

            <div id="age_" style=" position: absolute; left: 45px; top: 275px; font-family: Thsarabun; font-size: 18px; width: 100px; text-align: center;"><?php echo $datas['age'] ?></div>

            <div id="address" style=" position: absolute; left: 170px; top: 275px; font-family: Thsarabun; font-size: 18px; width: 370px; text-align: center;"><?php echo $datas['address'] ?></div>

            <div id="tel_" style=" position: absolute; right: 50px; top: 275px; font-family: Thsarabun; font-size: 18px; width: 100px;  text-align: center;"><?php echo $datas['tel'] ?></div>

            <div id="servicedate" style=" position: absolute; left: 300px; top: 310px; font-family: Thsarabun; font-size: 20px; width: 50px; text-align: center;"><?php echo (int) substr($datas['date_refer'], -2) ?></div>

            <div id="servicemonth" style=" position: absolute; left: 400px; top: 310px; font-family: Thsarabun; font-size: 18px; width: 160px;text-align: center;"><?php echo $Config->MonthFullArrays()[(substr($datas['date_refer'], 5, 2))] ?></div>

            <div id="serviceday" style=" position: absolute; right: 60px; top: 310px; font-family: Thsarabun; font-size: 18px; width: 100px; text-align: center;"><?php echo (substr($datas['date_refer'], 0, 4) + 543) ?></div>

            <div id="comment" style=" position: absolute; left: 70px; top: 377px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;"><?php echo $datas['history'] ?></div>


            <div id="lab" style=" position: absolute; left: 70px; top: 475px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;"><?php echo $datas['lab'] ?></div>

            <div id="diag" style=" position: absolute; left: 70px; top: 575px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;"><?php echo $datas['diag'] ?></div>

            <div id="service" style=" position: absolute; left: 70px; top: 675px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;"><?php echo $datas['treat'] ?></div>

            <div id="refer" style=" position: absolute; left: 260px; top: 775px; height: 25px; font-family: Thsarabun; font-size: 18px; width: 440px; text-align: left;"><?php echo $datas['cause'] ?></div>

            <div id="etc" style=" position: absolute; left: 150px; top: 775px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 550px; text-align: left;"><?php echo $datas['etc'] ?></div>
            <!-- Footer -->

            <div id="year" style=" position: absolute; right: 110px; top: 970px; font-family: Thsarabun; font-size: 18px; width: 200px; text-align: center;"><?php echo $Config->thaidatefull($datas['date_refer']) ?></div>

            <?php //echo $form['form_refer'] ?>

            <?php
            $companyAddress = $company['address'];
            $companyTel = $company['tel'];
            $companyName = $company['companyname'];
            $presidentName = $company['memager'];
            $presidentNumber = $company['presidentnumber'];
            $str = $form['form_refer'];
            $str1 = str_replace('$clinicName', $companyName, $str);
            $str2 = str_replace('$clinicAddress', $companyAddress, $str1);
            $str3 = str_replace('$clinicTel', $companyTel, $str2);
            $str4 = str_replace('$presidentName', $presidentName, $str3);
            $str5 = str_replace('$presidentNumber', $presidentNumber, $str4);

            echo $str5;
            ?>

            <br/><br/><br/><br/><br/>
            <div style=" position: absolute; bottom: 0px; right: 100px; text-align: center;">
                <p><span style="font-size:16px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:18px">ลงชื่อ</span>........................................................<span style="font-size:18px">แพทย์ผู้รักษา</span></span></p>

                <p><span style="font-size:16px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</span><span style="font-size:18px">(<span style="font-size:16px">..............</span></span><span style="font-size:16px"><?php echo $presidentName ?>.............</span><span style="font-size:18px">)</span></p>

                <p><span style="font-size:16px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span style="font-size:18px">วันที่</span>......................................................................</span></p>

            </div>
        </div>

        <script type="text/javascript">
            window.print();
            function printDiv(divName) {
                $("#btn-print").hide();
                //var printContents = document.getElementById(divName).innerHTML;
                //var originalContents = document.body.innerHTML;

                //document.body.innerHTML = printContents;

                window.print();

                //document.body.innerHTML = originalContents;
            }
        </script>
    </body>
</html>