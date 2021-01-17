<style type="text/css">
    table tbody tr td{
        padding: 0px;
    }
    .modal.large {
        width: 80%;
    }

    .box-all{
        height: 50px;
        width: 50px;
        margin: 0px;
    }
    #listpatient:hover{
        opacity:0.5;
    }

</style>

<?php
$serviceModel = new Service();
$i = 0;
foreach ($seq as $rs):
    $i++;
    if ($rs['images']) {
        $pathImg = Yii::app()->baseUrl . "/uploads/profile/" . $rs['images'];
    } else {
        $pathImg = Yii::app()->baseUrl . "/images/No_image.jpg";
    }
    $link = Yii::app()->createUrl('doctor/patientviewhistory', array("id" => $rs['patient_id'], "service_id" => $rs['service_id'], "flag" => "counter", "promotion" => $rs['promotion']));
    $linkMobile = Yii::app()->createUrl('doctor/patientviewhistorymobile', array("id" => $rs['patient_id'], "service_id" => $rs['service_id'], "flag" => "counter", "promotion" => $rs['promotion']));
    ?>
    <div class="desktop">
        <div class="media" onclick="PopupCenter('<?php echo $link ?>', 'รายละเอียดการรักษา')" style="cursor:pointer;" id="listpatient">
            <div class="media-left">
                <div class="container-card set-views-card box-all">
                    <div class="img-wrapper">
                        <img class="img-responsive img-polaroid" style="height:50px;" src="<?php echo $pathImg ?>" alt="...">
                    </div>
                </div>
            </div>
            <div class="media-body">
                <h4 class="media-heading" style="font-size:18px;"><?php echo $rs['name'] . ' ' . $rs['lname'] ?>(อายุ : <?php echo $rs['age'] ?> ปี)</h4>
                <p>ค่าใช้จ่าย : <?php echo number_format($serviceModel->SUMservice($rs['service_id']), 2) ?>
                    วันที่ : <?php echo $rs['service_date'] ?>
                </p>
            </div>
        </div>
    </div>
    <div class="mobile">
        <div class="media" onclick="PopupCenter('<?php echo $linkMobile ?>', 'รายละเอียดการรักษา')" style="cursor:pointer;" id="listpatient">
            <div class="media-left">
                <div class="container-card set-views-card box-all">
                    <div class="img-wrapper">
                        <img class="img-responsive img-polaroid" style="height:50px;" src="<?php echo $pathImg ?>" alt="...">
                    </div>
                </div>
            </div>
            <div class="media-body">
                <h4 class="media-heading" style="font-size:18px;"><?php echo $rs['name'] . ' ' . $rs['lname'] ?>(อายุ : <?php echo $rs['age'] ?> ปี)</h4>
                <p>ค่าใช้จ่าย : <?php echo number_format($serviceModel->SUMservice($rs['service_id']), 2) ?>
                    วันที่ : <?php echo $rs['service_date'] ?>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var w = $(window).width();
        var screenfull = (boxsell - 155);
        if (w >= 768) {
            $(".desktop").show();
            $(".mobile").hide();
            $("#seqsuccess").css({'height': screenfull, "overflow": "auto"});
        } else {
            $(".mobile").show();
            $(".desktop").hide();
        }

    }
</script>
