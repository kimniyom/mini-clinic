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
        #form_confirm{
            color: #000000;
            padding: 20px;
            padding-top: 0px;
            padding-bottom: 0px;
            padding-left: 50px;
            background: #ffffff;
            font-family: Thsarabun;
        }

        #form_confirm p{
            font-family: Thsarabun;
            color: #000000;
        }
    }
</style>
<body>
    <button type="button" onclick="printDiv('form_refer')" id="btn-print">พิมพ์</button>
    <div id="form_refer">

        <div id="year" style=" position: absolute; right: 90px; top: 182px; font-family: Thsarabun; font-size: 18px;">2563</div>
        <div id="month" style=" position: absolute; right: 86px; top: 182px; font-family: Thsarabun; font-size: 18px; width: 250px;  text-align: center;">ธันวาคม</div>
        <div id="day" style=" position: absolute; right: 258px; top: 182px; font-family: Thsarabun; font-size: 18px; width: 100px;  text-align: center;">2</div>

        <!--
            ###### เรียน ########
        -->
        <div id="year" style=" position: absolute; left: 90px; top: 217px; font-family: Thsarabun; font-size: 18px; width: 500px;">ท่านผู้บริหารโรงพยาลตากสินมหาราช</div>



        <div id="patientname" style=" position: absolute; right: 180px; top: 287px; font-family: Thsarabun; font-size: 18px; width: 250px; text-align: center;">มานพ   สมดี</div>

        <div id="age_" style=" position: absolute; left: 45px; top: 322px; font-family: Thsarabun; font-size: 18px; width: 100px; text-align: center;">29</div>

        <div id="address" style=" position: absolute; left: 170px; top: 322px; font-family: Thsarabun; font-size: 18px; width: 370px; text-align: center;">1530600027345</div>

        <div id="tel_" style=" position: absolute; right: 50px; top: 322px; font-family: Thsarabun; font-size: 18px; width: 100px;  text-align: center;">0821684717</div>

        <div id="servicedate" style=" position: absolute; left: 300px; top: 357px; font-family: Thsarabun; font-size: 20px; width: 50px; text-align: center;">5</div>

        <div id="servicemonth" style=" position: absolute; left: 400px; top: 357px; font-family: Thsarabun; font-size: 18px; width: 160px;text-align: center;">กุมภาพันธ์</div>

        <div id="serviceday" style=" position: absolute; right: 60px; top: 357px; font-family: Thsarabun; font-size: 18px; width: 100px; text-align: center;">2563</div>

        <div id="comment" style=" position: absolute; left: 70px; top: 424px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;">ไอมีเสมหะ</div>


        <div id="lab" style=" position: absolute; left: 70px; top: 522px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;">ไม่มีตรวจ</div>

        <div id="diag" style=" position: absolute; left: 70px; top: 622px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;">วินิจฉัย</div>

        <div id="service" style=" position: absolute; left: 70px; top: 722px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 640px; text-align: left;">การรักษา</div>

        <div id="refer" style=" position: absolute; left: 260px; top: 788px; height: 25px; font-family: Thsarabun; font-size: 18px; width: 440px; text-align: left;">สาเหตุที่ส่งตัว</div>

        <div id="etc" style=" position: absolute; left: 150px; top: 822px; height: 50px; font-family: Thsarabun; font-size: 18px; width: 550px; text-align: left;">อื่น ๆแ้ดด้ด้ด่</div>

        <div id="year" style=" position: absolute; right: 180px; top: 990px; font-family: Thsarabun; font-size: 18px; width: 200px; text-align: center;">2 ธันวาคม 2563</div>

        <?php echo $form['form_refer'] ?>
    </div>

    <script type="text/javascript">
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