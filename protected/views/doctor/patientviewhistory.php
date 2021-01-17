
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
        font-size: 20px;
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
    <div title="ประวัติการรับบริการ | วันที่ <?php echo $config->thaidate($Modelservice['service_date']) ?> | <?php echo 'คุณ ' . $model['name'] . " " . $model['lname'] . " | ลูกค้า " . Gradcustomer::model()->find('id=:id', array(':id' => $model['type']))['grad'] . ' | อายุ ' . $Age . ' ปี' ?> <?php echo $authors ?>"
         data-options="region:'north'"
         style="height:120px; padding: 0px; padding-bottom: 0px; overflow: hidden;background:url('<?php echo Yii::app()->baseUrl ?>/images/preview.png') bottom right #06506F;">
        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12 col-sm-12" style="font-size: 20px; color:#ffffff;">
                คุณ <font id="font-16" style="font-size:30px; color:yellow;"><?php echo $model['name'] . " " . $model['lname'] ?></font><br/>
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

    <!--
    <div data-options="region:'south',split:true" title="ภาพถ่าย" style="height:145px; padding: 0px;">
        <div id="show_saved_img" style=" margin-left: 0px;"></div>
    </div>
    -->
    <div data-options="region:'west',split:false" title="เมนู" style="width:300px;background:url('<?php echo Yii::app()->baseUrl ?>/images/wave-background.png') top center;">

        <div class="row" style=" margin: 0px;">
            <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="$('#popupadddrug').window('open')" id="btn-left" style=" padding-top: 20px; padding-bottom: 20px;"><i class="fa fa-medkit text-success"></i> จ่ายยา / สินค้า</button>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" id="btn-left"  onclick="openpopupservicedetaildrug()" style=" text-align: center;  padding-top: 20px; padding-bottom: 20px;"><i class="fa fa-eye"></i></button>
            </div>
        </div>

        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" text-align: center; padding: 0px; background: #ffffff;">
                <h3>รวมค่าใช้จ่าย </h3>
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
                                <tr style="color: <?php echo ($rs['type'] == 2) ? "red;font-size:30px;" : ""; ?>">
                                    <td style=" text-align: center;"><?php echo $i ?></td>
                                    <td><?php echo $rs['detail'] ?></td>
                                    <td style="color: <?php echo ($rs['type'] == 2) ? "red;font-size:24px;" : ""; ?>"><?php echo $rs['method'] ?></td>
                                    <td style=" text-align: center;"><?php echo $rs['number'] ?></td>
                                    <!--
                                                                            <td style="text-align: right;">​<?php //echo number_format($rs['price'], 2)                                                                   ?></td>
                                                                            <td style="text-align: right;">​<?php //echo number_format($rs['total'], 2)                                                                   ?></td>
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
                                    วันนัด <?php echo ($Modelservice['appoint'] != "") ? $config->thaidate($Modelservice['appoint']) . " เวลา " . $Modelservice['appoint_hours'] . "." . $Modelservice['appoint_minute'] . " น." : "-"; ?>
                                    <?php echo ($Modelservice['appoint'] != "") ? "<br/>การนัด " . $Modelservice['appoint_detail'] : ""; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="background: #FFFFFF;">
                                    ใบรับรองแพทย์
                                    <?php
                                    if ($certifiate) {
                                        $linkcertificate = $link = Yii::app()->createUrl('doctor/printcetificate', array("service_id" => $service_id));
                                        ?>
                                        <button type="button" class="btn btn-success" onclick="PopupCenter('<?php echo $linkcertificate ?>', 'ใบรับรองแพทย์')">พิพม์ใบรับรองแพทย์</button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-warning" onclick="createCer()">ออกใบรับรองแพทย์</button>
                                    <?php } ?>
                                    <br/>
                                    ใบส่งตัวรักษาต่อ
                                    <?php
                                    if ($refer) {
                                        $linkrefer = $link = Yii::app()->createUrl('doctor/printrefer', array("service_id" => $service_id));
                                        ?>
                                        <button type="button" class="btn btn-info" onclick="PopupCenter('<?php echo $linkrefer ?>', 'ใบรับรองแพทย์')">พิพม์ใบส่งตัว</button>
                                    <?php } else { ?>
                                        -
                                    <?php } ?>
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

                    เบอร์โทรศัพท์ <p class="label" id="font-16"><?php
                        if (isset($model['tel'])) {
                            echo ($model['tel']);
                        } else {
                            echo "-";
                        }
                        ?></p>
                    ที่อยู่ <p class="label" id="font-16"><?php
                        if (isset($model['contact'])) {
                            echo $model['contact'];
                        } else {
                            echo "-";
                        }
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

                    <hr style="margin: 0px;"/>
                </div>
                <!--ประวัติครั้งล่าสุด-->
                <p style=" color: #ff0000; font-weight: bold; font-size: 20px;">ประวัติครั้งล่าสุด</p>
                <table class="table table-bordered" style=" color: #000066; font-size: 20px; background: #ced6c7">
                    <tr>
                        <th style=" width: 150px;">ประวัติการรักษา</th>
                        <td><?php echo ($lastserviceDetail['detail'] != "") ? $lastserviceDetail['detail'] : "-"; ?></td>
                    </tr>
                    <tr>
                        <th>ตรวจร่างกาย</th>
                        <td><?php echo ($lastserviceDetail['comment'] != "") ? $lastserviceDetail['comment'] : "-"; ?></td>
                    </tr>
                    <tr>
                        <th>วินิจฉัย</th>
                        <td><?php echo ($lastserviceDetail['diag'] != "") ? $lastserviceDetail['diag'] : "-"; ?></td>
                    </tr>
                    <tr>
                        <th>หัตถการ</th>
                        <td><?php echo ($lastserviceDetail['procedure'] != "") ? $lastserviceDetail['procedure'] : "-"; ?></td>
                    </tr>
                    <tr>
                        <th>นัด</th>
                        <td>
                            วันที่
                            <?php echo ($lastserviceDetail['appoint'] != "") ? $config->thaidate($lastserviceDetail['appoint']) : "-"; ?><br/>
                            สาเหตุนัด
                            <?php echo ($lastserviceDetail['appoint_detail'] != "") ? $lastserviceDetail['appoint_detail'] : "-"; ?>
                        </td>
                    </tr>
                </table>

                <p style=" color: #ff0000; font-weight: bold;font-size: 20px;"> ประวัติยาทั้งหมด</p>
                <table class="table table-bordered" style=" color: #000000; font-size: 20px; background: #e6e6e6">
                    <thead>
                        <tr>
                            <td>ชื่อยา</td>
                            <td>วิธีใช้</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drugAll as $rsDrugAll) { ?>
                            <tr>
                                <td><?php echo $rsDrugAll['product_nameclinic'] ?></td>
                                <td><?php echo $rsDrugAll['drug_method'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div title="ซักประวัติ" style="padding:10px">
                <div id="font-18">
                    <?php if (!empty($checkbody)) {
                        ?>
                        น้ำหนัก <p class="label" id="font-16"><?php echo $checkbody['weight'] ?></p> กก.
                        ส่วนสูง <p class="label" id="font-16"><?php echo $checkbody['height'] ?></p> ซม.<br/>
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

<!-- รายละเอียดการให้ยาสินค้า -->
<div id="popupdetaildrug" class="easyui-window" title="ข้อมูลการจ่ายยา / สินค้า" style="padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,cls:'c2',collapsible:false">
    <div id="bodydrugservice"></div>
</div>

<!-- จ่ายยา / สินค้า -->
<div id="popupadddrug" class="easyui-window" title="บันทึกการจ่ายยา" style="padding:10px; top:50px;"
     data-options="iconCls:'icon-save',resizable:true,modal:true,closed:true,minimizable:false,collapsible:false,cls:'c1',footer:'#popupadddrug-footer'">
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

<!-- ออกใบรับรองแพทย์ -->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="popupcertificate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-title">
                <h3 style="text-align:center;">
                    <i class="fa fa-calendar"></i> ใบรับรองแพทย์
                </h3>
            </div>
            <div class="modal-body" >
                <div>
                    <label style="width: 150px;">ชื่อ - สกุลผู้ป่วย *</label>
                    <input type="text" name="_patientname" id="_patientname" readonly="readonly" value="<?php echo $model['name'] . "   " . $model['lname'] ?>">
                </div>
                <div>
                    <label style="width: 150px;">เลขบัตรประชาชน *</label>
                    <input type="text" name="_id_card" id="_id_card" readonly="readonly" value="<?php echo $model['card'] ?>">
                </div>
                <div>
                    <label style="width: 150px;">อายุ *</label>
                    <input type="text" name="_age" id="_age" readonly="readonly" value="<?php echo $Age ?>">
                </div>
                <br/>
                <p class="text-danger">*ข้อมูลผู้ป่วยต้องครบถ้วนเท่านั้น</p>
                <br/>
                <div>
                    <label>ความเห็นแพทย์ *</label>
                    <textarea class="form-control" id="_comment" rows="5"></textarea>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4"><label>ให้หยุดพักรักษาตัว จำนวน</label></div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <select class="form-control" id="_day">
                            <option value="">ไม่ต้องหยุดพัก</option>}
                            option
                            <?php for ($i = 1; $i <= 90; $i++): ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6">
                        <label>ตั้งแต่วันที่ *</label>
                        <div class='input-group date'>
                            <input type='text' class="form-control" id='_datestart'/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6">
                        <label>ถึงวันที่ *</label>
                        <div class='input-group date'>
                            <input type='text' class="form-control" id='_dateend'/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveCertificate('0')">บันทึก</button>
            </div>
        </div>
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

    setScreen();

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

    function setScreen() {
        var h = window.innerHeight;
        $("#popupdetaildrug").css({
            'min-height': h - 40,
            'width': '95%',
            'padding': '10px',
            'top': '20px'
        });
        $("#popupadddrug").css({
            'min-height': h - 60,
            'height': h - 20,
            'width': '95%',
            'padding': '10px',
            'top': '10px'
        });
    }

    function createCer() {
        var card = "<?php echo $model['card'] ?>";
        var age = "<?php echo $Age ?>";
        if (card == "" || age == "") {
            alert("ข้อมูลผู้ป่วยไม่สมบูรณ์กรุณาอัพเดทข้อมูล...");
            return false;
        } else {
            $("#popupcertificate").modal();
        }
    }

    function saveCertificate(flag = 0) {
        var url = "<?php echo Yii::app()->createUrl('service/savecertificate') ?>";
        var service_id = "<?php echo $service_id ?>";
        var patient_name = $("#_patientname").val();
        var card = $("#_id_card").val();
        var age = $("#_age").val();
        var comment = $("#_comment").val();
        var day = $("#_day").val();
        var datestart = $("#_datestart").val();
        var dateend = $("#_dateend").val();

        var id;
        if (flag == 1) {
            id = "";
        } else {
            id = "";
        }

        var data = {
            id: id,
            service_id: service_id,
            patient_name: patient_name,
            id_card: card,
            age: age,
            comment: comment,
            day: day,
            datestart: datestart,
            dateend: dateend,
            flag: flag
        };
        if (comment == "") {
            alert("กรุณากรอก * ให้ครบ");
            return false;
        } else {
            $.post(url, data, function(datas) {
                alert("บันทึกใบรับรองแพทย์สำเร็จ...");
                window.location.reload();
            });
    }
    }

    $(document).ready(function() {
        $("#_datestart,#_dateend").datepicker({
            'locale': 'th',
            'autoclose': true,
            'format': 'yyyy-mm-dd',
            'todayHighlight': true,
            'startDate': new Date()
        });
    });

</script>
