<style type="text/css">
    .patient-hover:hover{
        border: #cccccc solid 5px;
        cursor: pointer;
    }
</style>
<?php
$webconfig = new Configweb_model();
if ($patient) {
    ?>
    
    <div class="row" style=" margin: 0px;">
        <?php foreach ($patient as $rs): ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4" style=" text-align: center;">
                    <div class="patient-hover" onclick="Getpatient('<?php echo $rs['id'] ?>')">
                        <?php if ($rs['images']) { ?>
                            <img src="<?php echo Yii::app()->baseUrl ?>/uploads/profile/<?php echo $rs['images'] ?>" style=" max-height: 150px;" class="img-responsive"/>
                        <?php } else { ?>
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/No_image.jpg" style=" max-height: 150px;" class="img-responsive"/>
                        <?php } ?>
                    </div>
                <?php echo $rs['name'] . ' ' . $rs['lname'] ?>
                <?php echo ($rs['birth']) ? "(" . $webconfig->get_age($rs['birth']) . " ปี)" : ""; ?>
                สาขา : <?php echo $rs['branchname'] ?>
                <!--
                <button type="button" class="btn btn-success btn-block" onclick=""><i class="fa fa-check"></i> เลือก</button>
                -->
            </div>
        <?php endforeach; ?>
    </div>
<?php } else { ?>
    <center><h2>ไม่พบข้อมูล ...! </h2></center>
<?php } ?>


