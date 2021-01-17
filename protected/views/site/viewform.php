<style type="text/css">
    #form_confirm{
        padding: 20px;
        padding-left: 45px;
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
            color: #000000;
        }
        .nickname {
            font-size: 45px;
            color: #000000;
        }
        #form_confirm{
            padding-top: 10px;
            padding: 20px;
            padding-left: 50px;
            background: #ffffff;
            font-family: Thsarabun;
            color: #000000;
        }
        #form_confirm p{
            font-family: Thsarabun;
            color: #000000;
        }
    }
</style>
<body>
    <button type="button" onclick="printDiv('form_confirm')" id="btn-print">พิมพ์</button>
    <div id="form_confirm">
        <div id="year" style=" position: absolute; right: 80px; top: 174px; font-family: Thsarabun; font-size: 20px;">2563</div>
        <div id="month" style=" position: absolute; right: 80px; top: 174px; font-family: Thsarabun; font-size: 20px; width: 250px;  text-align: center;">ธันวาคม</div>
        <div id="day" style=" position: absolute; right: 275px; top: 174px; font-family: Thsarabun; font-size: 20px; width: 100px;  text-align: center;">2</div>

        <div id="age" style=" position: absolute; right: 120px; top: 288px; font-family: Thsarabun; font-size: 20px;">29</div>
        <div id="patientname" style=" position: absolute; right: 230px; top: 288px; font-family: Thsarabun; font-size: 20px; width: 250px; text-align: center;">มานพ   สมดี</div>

        <div id="year_" style=" position: absolute; right: 80px; top: 325px; font-family: Thsarabun; font-size: 20px;">2563</div>
        <div id="month_" style=" position: absolute; right:80px; top: 325px; font-family: Thsarabun; font-size: 20px; width: 250px; text-align: center;">ธันวาคม</div>
        <div id="day_" style=" position: absolute; right: 260px; top: 325px; font-family: Thsarabun; font-size: 20px; width: 100px;  text-align: center;">2</div>
        <div id="card" style=" position: absolute; right: 380px; top: 325px; font-family: Thsarabun; font-size: 20px; width: 190px; text-align: center;">1530600027345</div>

        <div id="comment" style="position: absolute; left: 135px; top: 363px; height: 50px; font-family: Thsarabun; font-size: 20px; width: 650px; text-align: left;">fyutyuturtyutyuyfyufututuftutfutfyufyuกด่เาด่้ระ่้าสิ้พะร้่าร้่รพะ้่นพ้่รพะห้่รนพะ้่นหพระ้่นะรห้่หพะร้่นพะหร้fufu1530600027345</div>

        <div id="datestart" style=" position: absolute; right: 125px; top: 438px; font-family: Thsarabun; font-size: 20px; width: 190px;  text-align: center;">5 กุมภาพันธ์ 2563</div>
        <div id="daytotal" style=" position: absolute; right: 447px; top: 438px; font-family: Thsarabun; font-size: 20px; width: 50px;  text-align: center;">2</div>

        <div id="comment" style=" position: absolute; left: 100px; top: 477px;font-family: Thsarabun; font-size: 20px; width: 500px;  text-align: center;">7 กุมภาพันธ์ 2563</div>
        <?php echo $form['form_confirm'] ?>
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