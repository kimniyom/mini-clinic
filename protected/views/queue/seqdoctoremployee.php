<style type="text/css">
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

    .patient-detail{
        font-size: 16px;
        color: #ffcc33;
    }
</style>
<?php
$i = 0;
if ($seq) {
    foreach ($seq as $rs):
        $i++;
        if ($rs['images']) {
            $pathImg = Yii::app()->baseUrl . "/uploads/profile/" . $rs['images'];
        } else {
            $pathImg = Yii::app()->baseUrl . "/images/No_image.jpg";
        }

        $rss = Checkbody::model()->find('service_id=:service_id', array(':service_id' => $rs['id']));
        $fullName = $rs['name'] . ' ' . $rs['lname'];
        ?>
        <div class="media" id="listpatient" onclick="SendSeq('<?php echo $fullName ?>')">
            <a href="<?php echo Yii::app()->createUrl('doctor/patientview', array('id' => $rs['patient_id'], 'service_id' => $rs['id'], "promotion" => $rs['promotion'])) ?>" target="_blank">
                <div class="media-left">
                    <div class="container-card set-views-card box-all">
                        <div class="img-wrapper">
                            <img class="img-responsive img-polaroid" style="height:50px;" src="<?php echo $pathImg ?>" alt="...">
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $rs['name'] . ' ' . $rs['lname'] ?>(อายุ : <?php echo $rs['age'] ?> ปี)</h4>
                    <font id="cc">อาการมารับบริการ : <?php echo $rss['cc'] ?></font>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
<?php } else { ?>
    <center>=== ไม่มีข้อมูล ===</center>
<?php } ?>

<script type="text/javascript">
    function deleteservice(id) {
        var r = confirm("Are you sure...?");
        if (r == true) {
            var url = "<?php echo Yii::app()->createUrl('queue/deleteservice') ?>";
            var data = {id: id};
            $.post(url, data, function(datas) {
                nodeloadtable();
                //loadtable();
            });
        }
    }
</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var w = $(window).width();
        var screenfull = (boxsell - 155);
        if (w >= 768) {
            $("#seqdoctor").css({'height': screenfull, "overflow": "auto"});
        }
    }

    //เรียกชื่อ
    function SendSeq(name) {
        socket.emit('seqramet', name, function(success) {});
    }
</script>
