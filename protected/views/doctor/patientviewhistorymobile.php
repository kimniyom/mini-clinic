<?php
/* @var $this PatientController */
/* @var $model Patient */
/*
  $this->breadcrumbs = array(
  //'Patients' => array('index'),
  $model->name . " " . $model->lname,
  );
 *
 */

$MasuserModel = new Masuser();
$config = new Configweb_model();
$branchModel = new Branch();
$CheckBodyModel = new Checkbody();
$Author = $MasuserModel->GetDetailUser($model['emp_id']);

$checkbody = $CheckBodyModel->Getdetail($service_id);

if (isset($model['birth'])) {
    $Age = $config->get_age($model['birth']);
} else {
    $Age = "-";
}
?>
<style type="text/css">
    #font-16{
        color: #339900;
    }
    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    #btn-left{
        text-align: left;
        margin: 0px;
        border-radius: 0px;
        border: 0px;
        border-bottom: #e6e6e6 solid 1px;
        font-size: 18px;
    }

    #btn-left:hover{
        background: none;
    }

    .tabpatient ul li a{
        border-radius: 0px;
        padding: 5px;
    }

    .modal-wide .modal-dialog {
        width: 950px; /* or whatever you wish */
    }

    .modal-wide .modal-body {
        max-height:70%;
        overflow-y: auto;
    }

    #listservice table{
        font-size: 16px;
    }

    #listservice table tbody tr td{
        padding: 1px;
        padding-right: 5px;
    }

    #listservice table thead tr th{
        padding: 1px;
    }

    table thead th{
        background: #eeeeee;
    }

    table tfoot td{
        background: #eeeeee;
    }

</style>


<input type="hidden" id="patient_id" value="<?php echo $model['id'] ?>"/>
<input type="hidden" id="service_id" value="<?php echo $service_id ?>"/>
<div class="easyui-layout" id="layouts" style=" width: 100%; margin: 0px;">
    <div title="วันที่ <?php echo $config->thaidate($Modelservice['service_date']) ?> | <?php echo 'คุณ ' . $model['name'] . " " . $model['lname'] . ' | อายุ ' . $Age . ' ปี' ?>"
         data-options="region:'north'"
         style="height:120px; padding: 0px; padding-bottom: 0px; overflow: hidden;background: #06506F;">
        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12 col-sm-12" style="font-size: 20px; color:#ffffff;">
                คุณ <font id="font-16" style="font-size:24px; color:yellow;"><?php echo $model['name'] . " " . $model['lname'] ?></font><br/>
                อาการสำคัญ <?php
                if (isset($checkbody['cc'])) {
                    echo "<font id='font-16' style=\"font-size:24px;color:yellow;\">" . $checkbody['cc'] . "</font>";
                } else {
                    echo "-";
                }
                ?>

            </div>
        </div>
    </div>

    <div data-options="region:'south'" title="" style="height:80px; padding: 0px;">
        <div id="footer-btn" style=" margin-left: 0px;">
            <div class="row" style="margin:0px;">

                <?php
                if ($flag == "counter") {
                    if ($Modelservice['status'] == "4") {
                        $link = Yii::app()->createUrl('service/bill', array("service_id" => $service_id, 'promotion' => $promotion));
                        ?>

                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6"><button type="button" class="btn btn-info btn-block" style="border-radius: 0px; border: none; text-align: center; height:75px;" id="btn-left" onclick="PopupCenter('<?php echo $link ?>', 'ใบเสร็จ')"><i class="fa fa-file fa-2x"></i> <br/>ใบเสร็จ</button></div>
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6"><button type="button" class="btn btn-danger btn-block" style="border-radius: 0px; border: none; text-align: center; height:75px;" id="btn-left" onclick="closePage()"><i class="fa fa-file fa-2x"></i> <br/>ปิดหน้านี้</button></div>
                    <?php } else { ?>
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6"><button type="button" class="btn btn-info btn-block" style="border-radius: 0px; border: none; height:75px;"  onclick="billfalse()"><i class="fa fa-file fa-2x"></i> <br/>ใบเสร็จ</button></div>
                        <div class="col-md-6 col-lg-6 col-sm-6 col-xs-6"><button type="button" class="btn btn-success btn-block" style="border-radius: 0px; height:75px;" onclick="confirmservice()"><i class="fa fa-save fa-2x"></i> <br/>บันทึก</button></div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div data-options="region:'west',split:false,hideCollapsedContent:false,collapsed:true" title="เมนู" style="width:300px;">

        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="openpopupservicedetail()" id="btn-left"><i class="fa fa-save text-primary"></i> การรักษา</button>
            </div>
        </div>

        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="openpopupservicediag()" id="btn-left"><i class="fa fa-stethoscope text-danger"></i> หัตถการ</button>
            </div>
        </div>

        <div class="row" style=" margin: 0px;">
            <div class="col-md-8 col-lg-8" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="$('#popupadddrug').window('open')" id="btn-left"><i class="fa fa-medkit text-success"></i> ยา / สินค้า</button>
            </div>
            <div class="col-md-4 col-lg-4" style=" padding: 0px;">
                <button type="button" class="btn btn-info btn-block" id="btn-left"  onclick="openpopupservicedetaildrug()" style=" text-align: center;"><i class="fa fa-eye"></i></button>
            </div>
        </div>

        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="openpopupservicedetailetc()" id="btn-left"><i class="fa fa-money"></i>  ค่าใช้จ่ายอื่น ๆ</button>
            </div>
        </div>

        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" text-align: center; padding: 0px; background: #e6e6e6;">
                <h3>รวมค่าใชจ่าย </h3>
                <div id="sumservice" style=" font-weight: bold; color: #ff0000; font-size: 24px;"></div>
                <input type="hidden" id="price_total"/>
            </div>
        </div>
        <?php
        if ($flag == "counter") {
            if ($Modelservice['status'] == "4") {
                $link = Yii::app()->createUrl('service/bill', array("service_id" => $service_id, 'promotion' => $promotion));
                ?>
                <div class="row" style=" margin: 0px;">
                    <div class="col-md-12 col-lg-12" style=" padding: 0px;"><button type="button" class="btn btn-info btn-block" style="border-radius: 0px; border: none; text-align: center;" id="btn-left" onclick="PopupCenter('<?php echo $link ?>', 'ใบเสร็จ')"><i class="fa fa-file fa-2x"></i> <br/>ใบเสร็จ</button></div>
                </div>
                <div class="row" style=" margin: 0px;">
                    <div class="col-md-12 col-lg-12" style=" padding: 0px;"><button type="button" class="btn btn-danger btn-block" style="border-radius: 0px; border: none; text-align: center;" id="btn-left" onclick="closePage()"><i class="fa fa-file fa-2x"></i> <br/>ปิดหน้านี้</button></div>
                </div>
            <?php } else { ?>
                <div class="row" style=" margin: 0px;">
                    <div class="col-md-12 col-lg-12" style=" padding: 0px;"><button type="button" class="btn btn-info btn-block" style="border-radius: 0px; border: none;"  onclick="billfalse()"><i class="fa fa-file fa-2x"></i> <br/>ใบเสร็จ</button></div>
                </div>
                <div class="row" style=" margin: 0px;">
                    <div class="col-md-12 col-lg-12" style=" padding: 0px;"><button type="button" class="btn btn-success btn-block" style="border-radius: 0px;" onclick="confirmservice()"><i class="fa fa-save fa-2x"></i> <br/>บันทึก</button></div>
                </div>
                <?php
            }
        }
        ?>

    </div>
    <div data-options="region:'center',title:'ลูกค้า<?php echo ($promotiondetail) ? "(" . $promotiondetail . ")" : ""; ?>',iconCls:'icon-ok'">
        <div class="easyui-tabs" data-options="fit:true,border:false,plain:true" id="tt">
            <div title="รายละเอียดค่าใช้จ่าย" style="padding:10px">
                <div id="listservice">
                    <p style=" color: #ff0000;">*พนักงานสามารถลบได้เฉพาะรายการสินค้าเท่านั้น</p>
                    <table class="table table-bordered table-hover" style="font-size: 20px;font-weight: bold;">
                        <thead>
                            <tr>
                                <th style="text-align: center; width: 5%;">#</th>
                                <th>รายการ</th>
                                <th>วิธีใช้</th>
                                <th style=" text-align: center; width: 10%;">จำนวน</th>
                                <!--
                                <th style=" text-align: right; width: 15%;">ราคา / หน่วย</th>

                                <th style=" text-align: center; width: 10%;">รวม</th>
                                -->
                                <th style="text-align: center;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="text-align: center;">1</td>
                                <td colspan="4">
                                    <b>หัตถการ</b>
                                    <?php echo ($procedure['procedure']) ? $procedure['procedure'] : "-"; ?>
                                </td>
                            </tr>
                            <?php
                            $sum = 0;
                            $i = 1;
                            foreach ($datalistservice as $rs):
                                $i++;
                                $sum = ($sum + $rs['total']);
                                ?>
                                <tr style="color: <?php echo ($rs['type'] == 2) ? "red;font-size:24px;" : ""; ?>">
                                    <td style=" text-align: center;"><?php echo $i ?></td>
                                    <td><?php echo $rs['detail'] ?></td>
                                    <td style="color: <?php echo ($rs['type'] == 2) ? "red;font-size:20px;" : ""; ?>"><?php echo $rs['method'] ?></td>
                                    <td style=" text-align: center;"><?php echo $rs['number'] ?></td>
                                    <!--
                                                                            <td style="text-align: right;">​<?php //echo number_format($rs['price'], 2)   ?></td>
                                                                            <td style="text-align: right;">​<?php //echo number_format($rs['total'], 2)   ?></td>
                                    -->
                                    <td style="text-align: center;">
                                        <?php if ($rs['type'] == 2) { ?>
                                            <i class="fa fa-trash-o" style=" cursor: pointer;" onclick="deleteorder('<?php echo $service_id ?>', '<?php echo $rs['item'] ?>')"></i>
                                        <?php } else { ?>
                                            <i class="fa fa-trash-o" style=" color: #eeeeee;"></i>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style=" text-align: center; font-weight: bold;" colspan="2">
                                    <?php
                                    $sumserVice = 0;
                                    $sumserVice = $Modelservice['pricedrug'];
                                    echo $config->Convert($sum + $sumserVice);
                                    ?>
                                </td>
                                <td style=" text-align: right; font-weight: bold;">รวม</td>
                                <td style="text-align: right; font-weight: bold; color: #ff0000;"><?php echo number_format($sum + $sumserVice, 2); ?></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="5" style="background: #ffffff;">
                                    วันนัด <?php echo ($Modelservice['appoint'] != "") ? $config->thaidate($Modelservice['appoint']) : "-"; ?>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="5">
                                    ราคายา
                                    <input type="text" id="sumpricedrug" value="<?php echo $sumserVice ?>" onKeyUp="if (this.value * 1 != this.value)
                                                this.value = '';" >
                                    <button class="btn btn-primary" onclick="editpriceDrug()"><i class="fa fa-pencil"></i> แก้ไข</button> <font id="status"></font>
                                    <br/>
                                    วิธีชำระเงิน
                                    <ul>
                                        <li><input type="radio" name="payment" value="1" <?php echo ($service['payment'] == "1") ? "checked='checked'" : ""; ?>/> เงินสด</li>
                                        <li><input type="radio" name="payment" value="2" <?php echo ($service['payment'] == "2") ? "checked='checked'" : ""; ?>/> เงินโอน</li>
                                    </ul>
                                </th>

                            </tr>

                        </tfoot>
                    </table>
                </div>
            </div>
            <div title="ข้อมูลลูกค้า" style="padding:10px">
                <div style="margin: 0px; background: none;" id="font-18">
                    HN
                    <p class="label" id="font-16">
                        <?php echo $model['cn'] ?>
                    </p>
                    ชื่อ - สกุล
                    <p class="label" id="font-16">
                        <?php
                        $oid = $model['oid'];
                        echo Pername::model()->find("oid = '$oid'")['pername']
                        ?>
                        <?php echo $model['name'] . ' ' . $model['lname'] ?></p><br/>
                    เลขบัตรประชาชน <p class="label" id="font-16"><?php echo $model['card'] ?></p>
                    เพศ <p class="label" id="font-16"><?php
                        if ($model['sex'] == 'M') {
                            echo "ชาย";
                        } else {
                            echo "หญิง";
                        }
                        ?></p><br/>

                    เกิดวันที่ <p class="label" id="font-16"><?php
                        if (isset($model['birth'])) {
                            echo $config->thaidate($model['birth']);
                        } else {
                            echo "-";
                        }
                        ?></p>
                    อายุ <p class="label" id="font-16"><?php echo $Age ?></p> ปี
                    อาชีพ <p class="label" id="font-16"><?php
                        $occ = $model['occupation'];
                        echo Occupation::model()->find("id = '$occ' ")['occupationname'];
                        ?></p><br/>

                    สถานที่รับบริการ <p class="label" id="font-16"><?php
                        echo "สาขา " . $branchModel->Getbranch($model['branch']);
                        ?></p>
                    ประเภทลูกค้า <p class="label" id="font-16"><?php
                        echo Gradcustomer::model()->find('id=:id', array(':id' => $model['type']))['grad'];
                        ?></p><br/>
                    วันที่ลงทะเบียน <p class="label" id="font-16"><?php
                        if (isset($model['create_date'])) {
                            echo $config->thaidate($model['create_date']);
                        } else {
                            echo "-";
                        }
                        ?></p>
                    ข้อมูลอัพเดทวันที่ <p class="label" id="font-16"><?php
                        if (isset($model['d_update'])) {
                            echo $config->thaidate($model['d_update']);
                        } else {
                            echo "-";
                        }
                        ?></p><br/>
                    ผู้บันทึกข้อูล <p class="label" id="font-16"><?php
                        $OID = $Author['oid'];
                        echo Pername::model()->find("oid = '$OID'")['pername'] . $Author['name'] . '' . $Author['lname'];
                        ?></p>
                    <br/>

                    <hr style="margin: 0px;"/>
                    ข้มูลการติดต่อ

                    <ul style=" padding-top: 5px;">
                        <?php
                        echo "<li>เบอร์โทรศัพท์ ";
                        if (isset($model['tel'])) {
                            echo ($model['tel']);
                        } else {
                            echo "-";
                        }
                        "</li>";

                        echo "<li>อีเมล์ ";
                        if (isset($model['email'])) {
                            echo ($model['email']);
                        } else {
                            echo "-";
                        }
                        "</li>";

                        echo "<li>ที่อยู่ ";
                        if (isset($model['contact'])) {
                            echo $model['contact'];
                        } else {
                            echo "-";
                        }
                        ?>

                    </ul>
                </div>
            </div>

            <div title="ซักประวัติ" style="padding:10px">
                <div id="font-18">
                    <?php if (!empty($checkbody)) {
                        ?>
                        น้ำหนัก <p class="label" id="font-16"><?php echo $checkbody['weight'] ?></p> กก.
                        ส่วนสูง <p class="label" id="font-16"><?php echo $checkbody['height'] ?></p> ซม.<br/>
                        อุณหภมูมิร่างกาย <p class="label" id="font-16"><?php echo $checkbody['btemp'] ?></p> องศา<br/>
                        อัตราการเต้นชองชีพจร <p class="label" id="font-16"><?php echo $checkbody['pr'] ?></p> ครั้ง / นาที<br/>
                        อัตราการหายใจ <p class="label" id="font-16"><?php echo $checkbody['rr'] ?></p> ครั้ง / นาที<br/>
                        ความดันโลหิต <p class="label" id="font-16"><?php echo $checkbody['ht'] ?></p><br/>
                        รอบเอว <p class="label" id="font-16"><?php echo $checkbody['waistline'] ?></p><br/>
                        อาการสำคัญ <p class="label" id="font-16"><?php
                            if (isset($checkbody['cc'])) {
                                echo $checkbody['cc'];
                            } else {
                                echo "-";
                            }
                            ?></p><br/>
                        ผู้ซักประวัติ <p class="label" id="font-16">
                            <?php
                            $usesave = $MasuserModel->GetDetailUser($checkbody['user_id']);
                            echo $usesave['name'] . " " . $usesave['lname'];
                            ?>
                        </p><br/>
                    <?php } else { ?>
                        <center>ยังไม่มีการตรวจร่างกาย</center>
                    <?php } ?>
                </div>
            </div>

            <div title="แพ้ยา" style="padding:5px" id="drug">
                <div id="result_drug" style=" padding: 0px;"></div>
            </div>
            <div title="โรคประจำตัว" style="padding:5px" id="disease">
                <div id="result_disease" style=" padding: 0px;"></div>
            </div>
            <!--
            <div title="หัตถการ" style="padding:5px" id="diag">
                <div id="result_diag" style=" padding: 0px;"></div>
            </div>
            -->
        </div>
    </div>
</div>

<!-- รายละเอียดการบันทึกข้อมูลการให้บริการ -->
<div id="popupdetailservice" class="easyui-window" title="ข้อมูลการให้บริการ" style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodydetailservice"></div>
</div>

<!-- รายละเอียดหัตถการ -->
<div id="popupdetaildiag" class="easyui-window" title="ข้อมูลหัตถการ" style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodydiagservice"></div>
</div>

<!-- รายละเอียดการให้ยาสินค้า -->
<div id="popupdetaildrug" class="easyui-window" title="ข้อมูลการจ่ายยา / สินค้า" style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodydrugservice"></div>
</div>

<!-- รายละเอียดรายการอื่น ๆ  -->
<div id="popupdetailetc" class="easyui-window" title="ข้อมูลค่าใช้จ่ายอื่น ๆ" style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodyetcservice"></div>
</div>


<!-- จ่ายยา / สินค้า -->
<div id="popupadddrug" class="easyui-window" title="บันทึกการจ่ายยา" style="width:700px;height:350px;padding:10px; top:50px;"
     data-options="iconCls:'icon-save',resizable:true,modal:true,closed:true,minimizable:false,collapsible:false,footer:'#popupadddrug-footer'">

    <div class="row" style=" margin: 0px;">
        <div class="col-md-7 col-lg-7">
            <div class="row" style=" margin: 0px 0px 10px 0px;">
                <div class="col-md-3 col-lg-3" style=" text-align: right;"><font style="color:#ff0000;"> *</font>ยา / สินค้า : </div>
                <div class="col-md-9 col-lg-9">
                    <?php
                    $items = new Items();
                    $drug = $items->GetProductSell();
                    ?>

                    <select id="druginsert" class="easyui-combobox" name="druginsert" style=" width: 100%;" required="required" data-options="required:true,prompt:'พิมพ์ชื่อยา...'" onchange="Getdrug(this.value)">
                        <option value="">== เลือกรายการ ==</option>
                        <?php foreach ($drug as $drugs): ?>
                            <option value="<?php echo $drugs['product_id'] ?>"><?php echo $drugs['product_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>
            <div class="row" style=" margin: 0px 0px 10px 0px;">
                <div class="col-md-3 col-lg-3" style=" text-align: right;">รหัส : </div>
                <div class="col-md-9 col-lg-9">
                    <input type="text"  id="drugvalue" readonly="readonly"/>
                </div>
            </div>
            <div class="row" style=" margin: 0px 0px 10px 0px;">
                <div class="col-md-3 col-lg-3" style=" text-align: right;"><font style="color:#ff0000;"> *</font>จำนวน : </div>
                <div class="col-md-4 col-lg-4">
                    <input type="text" class="easyui-numberbox" data-options="min:1,prompt:'กรอกตัวเลข...'"  id="drug_number" required="required" style=" width: 100%;"/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <p id="unit"></p>
                </div>
            </div>
            <div class="row" style=" margin: 0px; margin-top: 10px;">
                <div class="col-md-3 col-lg-3" style=" text-align: right;"><font style="color:#ff0000;"> *</font>ราคา: </div>
                <div class="col-md-3 col-lg-3">
                    <input type="text" class="easyui-numberbox" name="pricedrug" id="pricedrug" data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0.00" required="required" style=" width: 100%;"/>
                </div>
                <div class="col-md-2 col-lg-3">
                    ต่อหน่วย
                </div>
            </div>
            <div class="row" style=" margin: 0px; margin-top: 10px;">
                <div class="col-md-3 col-lg-3" style=" text-align: right;"><font style="color:#ff0000;"> *</font>ราคารวม: </div>
                <div class="col-md-4 col-lg-4">
                    <input type="text" class="easyui-numberbox" name="pricedrugtotal" id="pricedrugtotal" data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0.00" required="required" style=" width: 100%;"/>
                </div>
                <div class="col-md-3 col-lg-3">
                    <button class="btn btn-default btn-sm" onclick="calculatorDrug()">คำนวณ</button>
                </div>
            </div>


        </div>
        <div class="col-md-5 col-lg-5">
            <b>ข้อมูลยา / สินค้า</b>
            <hr/>
            <div id="detaildrug"></div>
        </div>
    </div>
    <hr/>
    <div class="row" style=" margin: 0px; margin-top: 10px;">
        <div class="col-md-5 col-lg-5" style=" text-align: right;">สต๊อก: </div>
        <div class="col-md-7 col-lg-7">
            <input type="text" class="easyui-numberbox" name="stock" id="stock" data-options="min:0"/>
        </div>
    </div>

    <div id="popupadddrug-footer" style="padding:5px; text-align: right;">
        <a id="btn" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="saveDrug()">บันทึก</a>
        <a id="btn" type="reset" href="#" class="easyui-linkbutton" onclick="resetserviceDrug()" data-options="iconCls:'icon-cancel'">ยกเลิก</a>
    </div>
</div>


<script>
    function loadimages() {
        var url = "<?php echo Yii::app()->createUrl('camera/loadimagesview') ?>";
        var service_id = $("#service_id").val();
        var data = {service_id: service_id};
        $.post(url, data, function(datas) {
            $("#show_saved_img").html(datas);
        });
    }

    function billfalse() {
        alert("กดบันทึกก่อนพิมพ์ใบเสร็จ");
        return false;
    }
</script>

<script type="text/javascript" charset="utf-8"src="<?= Yii::app()->baseUrl; ?>/js/patientviewhistory.js"></script>
<script type="text/javascript">
    /******** NODE JS ********/
    var socket = io.connect('<?php echo $config->LinkNode() ?>');
    function loadservicesuccess() {
        var url = "<?php echo Yii::app()->createUrl('queue/getservicesuccess') ?>";
        var data = {a: 1};
        var branch = "<?php echo Yii::app()->session['branch'] ?>";
        var id = "seqsuccessramet";
        $.post(url, data, function(datas) {
            //$("#servicesuccess").html(datas);
            socket.emit(id, datas, function(success) {
                if (success == true) {
                    window.location.reload();
                }
            });
        });
    }

    function closePage() {
        window.close();
    }

    function deleteorder(serviceid, productid) {
        var r = confirm("คุณแน่ใจหรือไม่ที่จะลบสินค้าออกจากรายการ...?");
        var url = "<?php echo Yii::app()->createUrl('service/deleteorder') ?>";
        var data = {serviceid: serviceid, productid: productid};
        if (r == true) {
            $.post(url, data, function(datas) {
                window.location.reload();
            });
        }
    }

    function editpriceDrug() {
        var sumprictdrug = $("#sumpricedrug").val();
        if (sumprictdrug == "") {
            alert("กรุณากรอกราคายา...");
            return false;
        }
        $("#status").text("กำลังแก้ไขข้อมูล...");
        var url = "<?php echo Yii::app()->createUrl('service/confirmpricedrug') ?>";
        var serviceId = "<?php echo $service_id ?>";
        var data = {service_id: serviceId, pricedrug: sumprictdrug};
        $.post(url, data, function(datas) {
            window.location.reload();

        });

    }
</script>
