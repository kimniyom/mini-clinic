<?php
$Config = new Configweb_model();
?>
<?php if ($patient) { ?>
    <div class="row">
        <?php foreach ($patient as $rs): ?>
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-default" style=" margin-bottom: 5px;">
                    <div class="panel-heading">
                        <?php if ($typebuy != 1) { ?>เลข CN <?php echo $rs['cn'] ?> <?php } else { ?>
                            พนักงาน
                        <?php } ?>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <?php if ($rs['images']) { ?>
                                    <img src="<?php echo Yii::app()->baseUrl ?>/uploads/profile/<?php echo $rs['images'] ?>" style=" max-height: 150px;" class="img-responsive"/>
                                <?php } else { ?>
                                    <img src="<?php echo Yii::app()->baseUrl ?>/images/No_image.jpg" style=" max-height: 150px;" class="img-responsive"/>
                                <?php } ?>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                <div class="list-group">
                                    <div class="list-group-item">ชื่อ - สกุล : <?php echo $rs['name'] . ' ' . $rs['lname'] ?></div>
                                    <div class="list-group-item">สาขาลงทะเบียน : <?php echo $rs['branchname'] ?></div>
                                    <div class="list-group-item">อายุ : <?php echo ($rs['birth']) ? $Config->get_age($rs['birth']) : "-"; ?></div>
                                    <?php if ($typebuy == "0") { ?>
                                        <div class="list-group-item">ประเภท : <?php echo Gradcustomer::model()->find("id=:id", array(":id" => $rs['type']))['grad']; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-success btn-block" onclick="selectPatient('<?php echo $rs['pid'] ?>', '<?php echo $typebuy ?>')"><i class="fa fa-check"></i> เลือก</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php } else { ?>
    <center><h2>ไม่พบข้อมูล ...! </h2></center>
<?php } ?>


