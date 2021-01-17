<style type="text/css">

    .box-img-service div {
        font-size: 0;
    }

    .box-img-service a {
        font-size: 16px;
        overflow: hidden;
        display: inline-block;
        margin-bottom: 8px;
        width: calc(50% - 4px);
        margin-right: 8px;
    }

    .box-img-service a:nth-of-type(2n) {
        margin-right: 0;
    }

    @media screen and (min-width: 50em) {
        .box-img-service a {
            width: calc(25% - 6px);
        }

        .box-img-service a:nth-of-type(2n) {
            margin-right: 8px;
        }

        .box-img-service a:nth-of-type(4n) {
            margin-right: 0;
        }
    }

    .box-img-service a:hover img {
        transform: scale(1.15);
    }

    .box-img-service figure {
        margin: 0;
    }

    .box-img-service img {
        border: none;
        max-width: 100%;
        height: auto;
        display: block;
        background: #ccc;
        transition: transform .2s ease-in-out;
    }

    .p a {
        display: inline;
        font-size: 13px;
        margin: 0;
    }

    .p {
        text-align: center;
        font-size: 13px;
        padding-top: 100px;
    }


    .thumbnail a:hover img {
        transform: scale(1.15);
    }

    .thumbnail a:nth-of-type(2n) {
        margin-right: 0;
    }

    #img-service{
        height:100px;
    }

    @media screen and (max-width: 800px) {
        #img-service{
            height: 200px;
        }
    }

    @media screen and (max-width: 1024px) {
        #img-service{
            height: 100px;
        }
    }
</style>
<?php
$web = new Configweb_model();
$branchModel = new Branch();
$Pername = new Pername();
$UserModel = new Masuser();
$Profile = $UserModel->GetProfileByID($service['user_id']);
$oid = $patient['oid'];
$shotname = $Pername->find("oid = '$oid' ")['pername'];

$gradcustomer = Gradcustomer::model()->find($patient['type'])
?>
<center>
    <div class="well" style=" width: 90%; background: #ffffff;">
        <center>
            <h2>ประวัติการรักษา</h2>
            <h4>
                วันที่: <?php echo $web->thaidate($service['service_date']) ?> รหัสบริการ <?php echo $service['id'] ?><br/>
                ผู้ตรวจ : <?php echo $Profile['name'] . " " . $Profile['lname']; ?>
            </h4>
        </center>
        <div style="text-align: left;">
            <h4><i class="fa fa-user"></i> ข้อมูลลูกค้า</h4>


            PID
            <p class="label" id="font-18">
                <?php echo $patient['pid'] ?>
            </p>
            ชื่อ - สกุล 
            <p class="label" id="font-18">
                <?php echo Pername::model()->find("oid = '$patient->oid'")['pername'] ?>
                <?php echo $patient['name'] . ' ' . $patient['lname'] ?></p><br/>
            เลขบัตรประชาชน <p class="label" id="font-18"><?php echo $patient['card'] ?></p>
            เพศ <p class="label" id="font-18"><?php
                if ($patient['sex'] == 'M') {
                    echo "ชาย";
                } else {
                    echo "หญิง";
                }
                ?></p>

            เกิดวันที่ <p class="label" id="font-18"><?php
                if (isset($patient['birth'])) {
                    echo $web->thaidate($patient['birth']);
                } else {
                    echo "-";
                }
                ?></p>
            อายุ <p class="label" id="font-18"><?php
                if (isset($patient['birth'])) {
                    echo $web->get_age($patient['birth']);
                } else {
                    echo "-";
                }
                ?></p> ปี <br/>
            อาชีพ <p class="label" id="font-18"><?php
                $occ = $patient['occupation'];
                echo Occupation::model()->find("id = '$occ' ")['occupationname'];
                ?></p>
            ประเภทลูกค้า <p class="label" id="font-18"><?php
                echo $gradcustomer['grad'];
                ?></p>    <hr/>

            <h4><i class="fa fa-child"></i> ตรวจร่างกาย</h4>

            น้ำหนัก <p class="label" id="font-18"><?php echo $checkbody['weight'] ?></p>
            ส่วนสูง <p class="label" id="font-18"><?php echo $checkbody['height'] ?></p>
            อุณหภมูมิร่างกาย <p class="label" id="font-18"><?php echo $checkbody['btemp'] ?></p>
            อัตราการเต้นชองชีพจร <p class="label" id="font-18"><?php echo $checkbody['pr'] ?></p>
            อัตราการหายใจ <p class="label" id="font-18"><?php echo $checkbody['rr'] ?></p><br/>
            ความดันโลหิต <p class="label" id="font-18"><?php echo $checkbody['ht'] ?></p>
            รอบเอว <p class="label" id="font-18"><?php echo $checkbody['waistline'] ?></p>
            อาการสำคัญ <p class="label" id="font-18"><?php echo $checkbody['cc'] ?></p><br/>

            <hr/>

            <h4><i class="fa fa-file"></i> ผลการตรวจ</h4>
            ผลการตรวจ : <?php echo $service['service_result'] ?><br/>
            ราคา : <?php echo number_format($service['price_total'], 2) ?> บาท<br/>
            comment : <?php echo $service['comment'] ?><br/>

            <hr/>


            <h4><i class="fa fa-medkit"></i> ยา / สินค้า</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style=" text-align: center;">#</th>
                        <th>รายการ</th>
                        <th style="text-align: center;">จำนวน</th>
                        <th style=" text-align: center;">ราคา / หน่วย</th>
                        <th style=" text-align: center;">ราคา</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $sum = 0;
                    foreach ($drug as $rs): $i++;
                        $sum = $sum + ($rs['number'] * $rs['product_price']);
                        ?>
                        <tr>
                            <td style=" width: 5%; text-align: center;"><?php echo $i ?></td>
                            <td><?php echo $rs['product_name'] ?></td>
                            <td style=" width: 5%; text-align: center;"><?php echo $rs['number'] ?></td>
                            <td style=" text-align: right;"><?php echo number_format($rs['product_price'], 2) ?></td>
                            <td style=" text-align: right;"><?php echo number_format($rs['number'] * $rs['product_price'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td style=" text-align: center; font-weight: bold;" colspan="4">รวม</td>
                        <td style="text-align: right; font-weight: bold;"><?php echo number_format($sum, 2) ?></td>
                    </tr>
                </tfoot>
            </table>

            <hr/>
            <h4><i class="fa fa-calendar"></i> วันนัด : <?php
                if (!empty($appoint['appoint']))
                    echo $web->thaidate($appoint['appoint']);
                else
                    echo "-";
                ?></h4>
            <hr/>

            <h4><i class="fa fa-image"></i> รูปภาพ</h4>
            <div class="box-img-service">
                <div>
                    <?php
                    foreach ($images as $img):
                        ?>

                        <a class="fancybox" rel="gallery1" href="<?php echo Yii::app()->baseUrl; ?>/uploads/img_service/<?php echo $img['images'] ?>">
                            <figure>
                                <div class="img-wrapper">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/img_service/<?php echo $img['images'] ?>" alt="" class="img-responsive" id="img-service">
                                </div>
                            </figure>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <hr/>
        <center><h2>รวมค่าใช้จ่าย <?php echo number_format($service['price_total'] + $sum, 2) ?> บาท</h2></center>
    </div>
</center>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox({
            openEffect: 'none',
            closeEffect: 'none'
        });

    });
</script>
