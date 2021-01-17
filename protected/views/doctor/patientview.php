<?php
/*
  $this->breadcrumbs = array(
  //'Patients' => array('index'),
  $model['name'] . " " . $model['lname'],
  );
 */
$MasuserModel = new Masuser();
$config = new Configweb_model();
$branchModel = new Branch();
$CheckBodyModel = new Checkbody();
$Author = $MasuserModel->GetDetailUser($service['user_id']);

$checkbody = $CheckBodyModel->Getdetail($service_id);
if (isset($model['birth'])) {
    $Age = $config->get_age($model['birth']);
} else {
    $Age = "";
}

if ($model['sex'] == "M") {
    $sex = "ชาย";
} else if ($model['sex'] == "F") {
    $sex = "หญิง";
} else {
    $sex = "";
}
?>
<link rel="stylesheet" href="<?php echo Yii::app()->baseUrl ?>/css/patientview.css"/>

<input type="hidden" id="typeEnter">
<input type="hidden" id="patient_id" value="<?php echo $model['id'] ?>" />
<input type="hidden" id="service_id" value="<?php echo $service_id ?>" />
<div class="easyui-layout" id="layouts" style=" width: 100%; margin: 0px; position: relative;">
    <div title="<?php echo 'คุณ ' . $model['name'] . " " . $model['lname'] . " | ลูกค้า " . Gradcustomer::model()->find('id=:id', array(':id' => $model['type']))['grad'] . ' | อายุ ' . $Age . ' ปี' ?>"
         data-options="region:'north'" style="height:120px; padding: 0px; padding-bottom: 0px; overflow: hidden;background:url('<?php echo Yii::app()->baseUrl ?>/images//wave-background.png') bottom right #06506F">
        <div class="row" style=" margin: 0px;">
            <div class="col-md-10 col-lg-10 col-sm-8 col-xs-8" id="font-18" style=" font-size: 20px; color:yellow;">
                คุณ <font id="font-16" style=" font-size: 36px; font-weight: bold; color: #ffffff;"><?php echo $model['name'] . " " . $model['lname'] ?></font>
                <br />
                อาการสำคัญ
                <?php
                if (isset($checkbody['cc'])) {
                    echo "<font id='font-16' style='font-size:20px; color:#ffffff;'>" . $checkbody['cc'] . "</font>";
                } else {
                    echo "-";
                }
                ?>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-4 col-xs-4">
                <div id="alamName" class="btn" onclick="SendSeq('<?php echo $model['name'] . " " . $model['lname'] ?>')">
                    <i class="fa fa-bell-o fa-2x"></i> <br/>เรียกซ้ำ
                </div>
            </div>
        </div>
    </div>

    <!--
    <div data-options="region:'south',split:true" title="ภาพถ่าย" style="height:165px; padding: 0px;">
        <div id="show_saved_img" style=" margin-left: 0px;"></div>
    </div>
    -->
    <div data-options="region:'east',split:false,hideCollapsedContent:false,collapsed:false" title="ประวัติการรับบริการ" style="width:180px;" id="bg-appoint">
        <div id="history"></div>
    </div>

    <div data-options="region:'west',split:false,hideCollapsedContent:false,collapsed:false" title="เมนู" style="width:300px; position: relative; background:url('<?php echo Yii::app()->baseUrl ?>/images/preview.png') bottom right #06506F;" id="bg-appoint">
        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="openpopupservice()" id="btn-left"><i class="fa fa-save"></i> บันทึกการรักษา</button>
            </div>
            <!--
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2" style=" padding: 0px;">
                <button type="button" class="btn btn-info btn-block" onclick="openpopupservicedetail()" id="btn-left"
                        style=" text-align: center;"><i class="fa fa-eye"></i></button>
            </div>
            -->
        </div>

        <div class="row" style=" margin: 0px; display: none;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="$('#popupadddiag').dialog('open')"
                        id="btn-left"><i class="fa fa-stethoscope text-danger"></i> หัตถการ</button>
            </div>
        </div>

        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="popupSavedrug()" id="btn-left"><i class="fa fa-medkit"></i> จ่ายยา / สินค้า</button>
            </div>
            <!--
            <div class="col-md-2 col-lg-2" style=" padding: 0px;">
                <button type="button" class="btn btn-info btn-block" id="btn-left"  onclick="openpopupservicedetaildrug()" style=" text-align: center;"><i class="fa fa-eye"></i></button>
            </div>
            -->
        </div>

        <!-- บันทึกการนัด -->
        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="popupAppoint()" id="btn-left"><i class="fa fa-calendar"></i> ลงวันนัด
                    <span class="pull-right" id="dateappoint"></span>
                </button>
            </div>
        </div>

        <!-- ใบรับรองแพทย์ -->
        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="popupcertificate()" id="btn-left"><i class="fa fa-book"></i> ใบรับรองแพทย์</button>
            </div>
        </div>

        <!-- ใบส่งตัว -->
        <div class="row" style=" margin: 0px;">
            <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="popupRefer()" id="btn-left"><i class="fa fa-ambulance"></i> ใบส่งตัวรักษาต่อ</button>
            </div>
        </div>

        <div class="row" style=" margin: 0px; display: none;">
            <div class="col-md-10 col-lg-10" style=" padding: 0px;">
                <button type="button" class="btn btn-default btn-block" onclick="$('#popupaddetc').window('open')"
                        id="btn-left"><i class="fa fa-money"></i> ค่าใช้จ่ายอื่น ๆ</button>
            </div>
            <div class="col-md-2 col-lg-2" style=" padding-top: 0px;">
                <button type="button" class="btn btn-info btn-block" id="btn-left" onclick="openpopupservicedetailetc()"
                        style=" text-align: center;"><i class="fa fa-eye"></i></button>
            </div>
        </div>
        <div style=" background: #ffffff; margin-top: 0px; padding-top: 20px;">
            <div style="text-align: center; font-size: 24px;">ค่ารักษา + ค่ายา</div>
            <div id="sumTxt" style="font-size: 30px; text-align: center; padding-bottom: 10px;">0</div>
        </div>
        <!--
        <button type="button" class="btn btn-default btn-block" onclick="camera()" id="btn-left"><i class="fa fa-camera text-danger"></i> ถ่ายรูป</button>
        -->
        <?php if ($service['status'] != '3' || $service['status'] != '4') { ?>
            <div style=" width: 100%; position: absolute; bottom: 0px;">
                <div class="row" style=" margin: 0px;" id="btn-confirm">
                    <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                        <button type="button" class="btn btn-success btn-block" style=" border-radius: 0px; font-size: 20px;"
                                onclick="doctorconfirm()">
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/Save-icon.png" /><br />ยืนยันรายการ
                        </button>
                    </div>
                </div>
                <div class="row" style=" margin: 0px; display: none;" id="btn-close">
                    <div class="col-md-12 col-lg-12" style=" padding: 0px;">
                        <button type="button" class="btn btn-danger btn-block" style=" border-radius: 0px;"
                                onclick="closewindow()">ปิดหน้านี้
                            <img src="<?php echo Yii::app()->baseUrl ?>/images/error.png" />
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!--
        <span class="easyui" style=" bottom: 0px; position: absolute; border-top: #cccccc solid 1px; width: 100%; padding: 5px; color: #ff0000;">
            สัญลักษณ์ <i class="fa fa-ellipsis-v text-success"></i> คือ ดูข้อมูล
        </span>
        -->
    </div>
    <div data-options="region:'center',title:'ลูกค้า<?php echo ($promotiondetail) ? "(" . $promotiondetail . ")" : ""; ?>',iconCls:'icon-ok'" >
        <div class="easyui-tabs" data-options="fit:true,border:false,plain:true" id="tt">
            <div title="ข้อมูลลูกค้า" style="padding:10px;">
                <div style="margin: 0px; background: none; font-size: 24px;" id="font-18">
                    HN
                    <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php
                        echo $model['cn'];
                        $oid = $model['oid'];
                        ?>
                    </p>
                    ชื่อ - สกุล
                    <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php echo Pername::model()->find("oid = '$oid'")['pername'] ?>
                        <?php echo $model['name'] . ' ' . $model['lname'] ?></p><br />
                    เลขบัตรประชาชน <p class="label" id="font-16" style=" font-size: 22px;"><?php echo $model['card'] ?></p>
                    เพศ
                    <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php
                        if ($model['sex'] == 'M') {
                            echo "ชาย";
                        } else {
                            echo "หญิง";
                        }
                        ?>
                    </p><br />

                    เกิดวันที่
                    <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php
                        if (isset($model['birth'])) {
                            echo $config->thaidate($model['birth']);
                        } else {
                            echo "-";
                        }
                        ?>
                    </p>
                    อายุ <p class="label" id="font-16" style=" font-size: 22px;"><?php echo $Age ?></p> ปี
                    อาชีพ <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php
                        $occ = $model['occupation'];
                        echo Occupation::model()->find("id = '$occ' ")['occupationname'];
                        ?>
                    </p><br />
                    เบอร์โทรศัพท์
                    <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php
                        if (isset($model['tel'])) {
                            echo ($model['tel']);
                        } else {
                            echo "-";
                        }
                        ?>
                    </p>

                    ที่อยู่
                    <p class="label" id="font-16" style=" font-size: 22px;">
                        <?php
                        if (isset($model['contact'])) {
                            echo ($model['contact']);
                        } else {
                            echo "-";
                        }
                        ?>
                    </p>
                    ข้อมูลอัพเดทวันที่
                    <p class="label" id="font-16">
                        <?php
                        if (isset($model['d_update'])) {
                            echo $config->thaidate($model['d_update']);
                        } else {
                            echo "-";
                        }
                        ?>
                    </p>
                    <br/>
                    <!--ประวัติครั้งล่าสุด-->
                    <p style=" color: #ff0000; font-weight: bold;">ประวัติครั้งล่าสุด</p>
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

                    <p style=" color: #ff0000; font-weight: bold;"> ประวัติยาทั้งหมด</p>
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
            </div>
            <div title="ซักประวัติ" style="padding:10px;">
                <div id="font-18">
                    <?php if (!empty($checkbody)) { ?>
                        น้ำหนัก <p class="label" id="font-16"><?php echo ($checkbody['weight']) ? $checkbody['weight'] : "-" ?></p> กก.
                        ส่วนสูง <p class="label" id="font-16"><?php echo ($checkbody['height']) ? $checkbody['height'] : "" ?></p> ซม.<br />
                        อุณหภมูมิร่างกาย <p class="label" id="font-16"><?php echo ($checkbody['btemp']) ? $checkbody['btemp'] : "-" ?></p> องศา<br/>
                        อัตราการเต้นชองชีพจร <p class="label" id="font-16"><?php echo ($checkbody['pr']) ? $checkbody['pr'] : "-" ?></p> ครั้ง / นาที<br/>
                        อัตราการหายใจ <p class="label" id="font-16"><?php echo ($checkbody['rr']) ? $checkbody['rr'] : "-" ?></p> ครั้ง / นาที<br/>
                        ความดันโลหิต <p class="label" id="font-16"><?php echo ($checkbody['ht']) ? $checkbody['ht'] : "-" ?></p><br/>
                        รอบเอว <p class="label" id="font-16"><?php echo ($checkbody['waistline']) ? $checkbody['waistline'] : "-" ?></p><br/>
                        <hr/>
                        <div style=" font-size: 24px; font-weight: bold;">
                            อาการสำคัญ <p style=" color: #cc3300;"><?php echo ($checkbody['cc']) ? $checkbody['cc'] : "-"; ?></p>
                        </div>
                        <br />
                        ผู้ซักประวัติ <p class="label" id="font-16">
                            <?php
                            $usesave = $MasuserModel->GetDetailUser($checkbody['user_id']);
                            echo $usesave['name'] . " " . $usesave['lname'];
                            ?>
                        </p>
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

        </div>
    </div>
</div>

<div id="popupaddservice" class="easyui-window" title="บันทึกการรักษา" data-options="iconCls:'icon-save',resizeable:false,modal:true,closed:true,minimizable:false,collapsible:false,cls:'c6',footer:'#popupaddservice-footer'">
    <div class="row" style=" margin: 0px 0px 10px 0px;">
        <div class="col-md-3 col-lg-3" style=" text-align: left;font-size: 18px;">
            <font style="color: #ff0000;">*</font>ประวัติการเจ็บป่วย :
        </div>
        <div class="col-md-9 col-lg-9">
            <textarea type="text" class="easyui-textbox" data-options="multiline:true,prompt:'ประวัติการเจ็บป่วย...'"
                      style="height:100px; width: 100%;" id="service_detail" rows="5"></textarea>
        </div>
    </div>
    <div class="row" style=" margin: 0px 0px 10px 0px;">
        <div class="col-md-3 col-lg-3" style=" text-align: left;font-size: 18px;">ตรวจร่างกาย : </div>
        <div class="col-md-9 col-lg-9">
            <textarea type="text" class=" easyui-textbox" data-options="multiline:true,prompt:'ตรวจร่างกาย...'"
                      style="height:100px; width: 100%;" id="service_comment" rows="5"></textarea>
        </div>
    </div>
    <div class="row" style=" margin: 0px 0px 10px 0px;">
        <div class="col-md-3 col-lg-3" style=" text-align: left;font-size: 18px;">วินิจฉัย : </div>
        <div class="col-md-9 col-lg-9">
            <textarea type="text" class="easyui-textbox" data-options="multiline:true,prompt:'วินิจฉัย...'"
                      style="height:100px; width: 100%;" id="service_diag" rows="5"></textarea>
        </div>
    </div>

    <div class="row" style=" margin: 0px 0px 10px 0px; display: none;">
        <div class="col-md-3 col-lg-3" style=" text-align: left; font-size: 18px;">
            <font style="color: #ff0000;">*</font>ราคา :
        </div>
        <div class="col-md-4 col-lg-4">
            <input type="text" class="easyui-numberbox" id="service_price" style="font-size: 18px;"
                   data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0" />
        </div>
    </div>
    <div id="popupaddservice-footer" style="padding:5px; text-align: right;">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-8 col-xs-8">
                <a id="btn-save" class="btn btn-success btn-block btn-lg" href="javascript:saveserviceDetail()"
                   class="easyui-linkbutton" data-options="iconCls:'icon-save'" style=" margin-top: 5px;">บันทึก(Enter)</a>
                <a id="btn-update" class="btn btn-warning btn-block btn-lg" href="javascript:updateserviceDetail()"
                   class="easyui-linkbutton" data-options="iconCls:'icon-save'" style=" margin-top: 5px;">บันทึก</a>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-4 col-xs-4">
                <a id="btn" class="btn btn-danger btn-block btn-lg" href="#" onclick="$('#popupaddservice').window('close')"
                   class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" style=" margin-top: 5px;">ปิด</a>
            </div>
        </div>
    </div>
</div>

<!-- หัตถการ -->
<div id="popupadddiag" class="easyui-window" title="บันทึกหัตถการ"
     style="width:500px;height:200px;padding:10px; top:50px;"
     data-options="iconCls:'icon-save',resizable:true,modal:true,closed:true,minimizable:false,collapsible:false,footer:'#popupadddiag-footer'">
    <div class="row" style=" margin: 0px 0px 10px 0px;">
        <div class="col-md-3 col-lg-3" style=" text-align: right;">
            <font style="color:#ff0000;">*</font>หัตถการ :
        </div>
        <div class="col-md-9 col-lg-9">
            <?php
            $diag = Diag::model()->findAll('');
            ?>
            <select id="diaginsert" class="easyui-combobox" name="diaginsert" style=" width: 100%;" required="required"
                    data-options="required:true">
                <option value="">== หัตถการ ==</option>
                <?php foreach ($diag as $d): ?>
                    <option value="<?php echo $d['diagcode'] ?>"><?php echo $d['diagname'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row" style=" margin: 0px; margin-top: 10px;">
        <div class="col-md-3 col-lg-3" style=" text-align: right;">
            <font style="color:#ff0000;"> *</font>ราคา :
        </div>
        <div class="col-md-3 col-lg-3">
            <input type="text" class="easyui-numberbox" name="pricediag" id="pricediag"
                   data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0.00" required="required" />
        </div>
    </div>
    <div id="popupadddiag-footer" style="padding:5px; text-align: right;">
        <a id="btn" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="savediag()">บันทึก</a>
        <a id="btn" type="reset" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'"
           onclick="resetformdiag()">ยกเลิก</a>
    </div>
</div>

<!-- จ่ายยา / สินค้า -->
<div id="popupadddrug" class="easyui-window" title="บันทึกการจ่ายยา"
     data-options="iconCls:'icon-save',resizable:true,modal:true,closed:true,minimizable:false,collapsible:false,cls:'c1',footer:'#popupadddrug-footer'">
    <div class="row" style=" margin: 0px; font-size: 20px;">
        <div class="col-md-5 col-lg-5 col-sm-5 well" style="padding: 5px; padding-bottom: 20px; border: none;  background-image: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12);">
            <div class="row" style=" margin: 0px 0px 10px 0px;">
                <div class="col-md-12 col-lg-12">
                    <font style="color: #ff0000;"> *</font><span style="color:#ffffff;">ยา / สินค้า :</span>
                    <?php
                    $items = new Items();
                    $drug = $items->GetProductSell();
                    ?>
                    <select id="druginsert" class="easyui-combobox" name="druginsert"
                            style=" width: 100%; font-size: 24px;" required="required"
                            data-options="required:true,prompt:'พิมพ์ชื่อยา...'" onchange="Getdrug(this.value)">
                        <option value=""></option>
                        <?php foreach ($drug as $drugs): ?>
                            <option value="<?php echo $drugs['product_id'] ?>"><?php echo $drugs['product_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row" style=" margin: 0px 0px 10px 0px; display: none;">
                <div class="col-md-12 col-lg-12">
                    รหัส :<br />
                    <input type="text" id="drugvalue" readonly="readonly" />
                </div>
            </div>
            <div class="row" style=" margin: 0px 0px 10px 0px;">
                <div class="col-md-12 col-lg-12">
                    <font style="color:#ff0000;"> *</font><span style="color:#ffffff;">วิธีใช้</span>
                    <textarea type="text" class="easyui-textbox" data-options="multiline:true,prompt:'วิธีใช้...'"
                              style="height:100px; width: 100%;" id="drug_method" rows="5"></textarea>
                </div>
            </div>
            <div class="row" style=" margin: 0px 0px 10px 0px;">
                <div class="col-md-12 col-lg-12">
                    <font style="color:#ff0000;"> *</font><span style="color:#ffffff;">จำนวน : (<font id="unit"></font>)</span>
                    <input type="text" class="easyui-numberbox" data-options="min:1,prompt:'กรอกตัวเลข...'"
                           id="drug_number" required="required" style=" width: 100%; font-size: 20px;" />
                </div>
            </div>
            <div class="row" style=" margin: 0px 0px 0px 0px; font-size: 14px; color:#ffffff;">
                <div class="col-md-12 col-lg-12">
                    <p>ข้อมูลยา / สินค้า</p>
                    <div id="detaildrug"></div>
                    <br />
                    <a id="btn-save-drug" class="btn btn-danger btn-block btn-lg" data-options="iconCls:'icon-save'"
                       onclick="saveDrug()">เพิ่มรายการ(Enter) <i class="fa fa-chevron-right pull-right"></i></a>
                </div>
            </div>

            <hr />
            <div class="row" style=" margin: 0px; margin-top: 10px;">
                <div class="col-md-7 col-lg-7">
                    <span style="color:#ffffff;">สต๊อก</span>
                    <input type="text" class="easyui-numberbox" name="stock" id="stock" data-options="min:0" />
                </div>
            </div>

            <div class="row" style=" margin: 0px; margin-top: 10px; display: none;">
                <div class="col-md-12 col-lg-12">
                    <font style="color:#ff0000;"> *</font>ราคา / ต่อหน่วย:
                    <input type="text" class="easyui-numberbox" name="pricedrug" id="pricedrug"
                           data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0.00" required="required"
                           style=" width: 100%;" />
                </div>
            </div>
            <div class="row" style=" margin: 0px; margin-top: 10px; display: none;">
                <div class="col-md-9 col-lg-9">
                    <font style="color:#ff0000;"> *</font>ราคารวม:
                    <input type="text" class="easyui-numberbox" name="pricedrugtotal" id="pricedrugtotal"
                           data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0.00" required="required"
                           style=" width: 100%;" />
                </div>
                <div class="col-md-3 col-lg-3">
                    <button class="btn btn-default btn-sm" style="margin-top: 30px;"
                            onclick="calculatorDrug()">คำนวณ</button>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-lg-7 col-sm-7" id="drug-right">
            <div class="well" style="background-image: linear-gradient(to right top, #f4375a, #f64151, #f64b48, #f65440, #f55e37); border: none; color: #ffffff;">
                <b>รายการยา</b>
                <div id="bodydrugservice"></div>
                <hr />
                <?php if ($lastService != 0) { ?>
                    <button type="button" class="btn btn-default" onclick="getService()"><i
                            class='fa fa-refresh'></i> Remed ยา(F2)</button>
                    <hr />
                <?php } else { ?>
                    <p style="font-size:16px;">ไม่มีประวัติยาเดิม</p>
                <?php } ?>
            </div>
            <div class="well" style="background-image: linear-gradient(to right top, #11c5ef, #00b4f5, #00a1f9, #008bf7, #1173ef); border: none;">
                <span style=" color: #ffffff;">หัตถการ</span>
                <textarea type="text" class="easyui-textbox" data-options="multiline:true,prompt:'หัตถการ...'"
                          style="height:100px; width: 100%;" id="service_procedure" rows="5"></textarea>
            </div>
            <div class="well" style="background-image: linear-gradient(to right top, #172a4d, #231e37, #211523, #170b13, #000000); border: none;">
                <span style=" color: #ffffff;">รวมราคายา + ค่ารักษา (Ctrl)</span><br/>
                <input type="text" id="sumprictdrug"  onKeyUp="if (this.value * 1 != this.value)
                            this.value = '';"
                       style="font-size: 24px; height: 50px; text-align: center; width: 100%; color:red;" />
            </div>

        </div>

        <div id="popupadddrug-footer" style="padding:5px; text-align: right;">
            <div class="row">
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8">
                    <button type="button" class="btn btn-success btn-block btn-lg" onclick="ConfirmOrderDrug()"><i
                            class='fa fa-save'></i> ยืนยันรายการยา</button>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-4 col-xs-4">
                    <a id="btn-update-drug" class="btn btn-danger btn-block btn-lg" onclick="$('#popupadddrug').window('close')"
                       data-options="iconCls:'icon-cancel'">ปิด</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- อื่น ๆ -->
<div id="popupaddetc" class="easyui-window" title="ค่าใช้จ่ายอื่น ๆ"
     style="width:700px;height:300px;padding:10px; top:50px;"
     data-options="iconCls:'icon-save',resizable:true,modal:true,closed:true,minimizable:false,collapsible:false,footer:'#popupaddetc-footer'">

    <div class="row" style=" margin: 0px;">
        <div class="row" style=" margin: 0px 0px 10px 0px;">
            <div class="col-md-3 col-lg-3" style=" text-align: right;">รายละเอียด : </div>
            <div class="col-md-9 col-lg-9">
                <textarea type="text" class=" easyui-textbox" data-options="multiline:true,prompt:'อื่น ๆ...'"
                          style="height:100px; width: 100%;" id="detail_etc" rows="5"></textarea>
            </div>
        </div>
        <div class="row" style=" margin: 0px; margin-top: 10px;">
            <div class="col-md-12 col-lg-12">
                ราคา :
                <input type="text" class="easyui-numberbox" name="price_etc" id="price_etc"
                       data-options="min:0,precision:2,prompt:'กรอกตัวเลข...'" value="0.00" required="required" />
            </div>
        </div>
    </div>

    <div id="popupaddetc-footer" style="padding:5px; text-align: right;">
        <a id="btn" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="saveetc()">บันทึก</a>
        <a id="btn" type="reset" href="#" class="easyui-linkbutton" data-options="iconCls:'icon-cancel'">ยกเลิก</a>
    </div>
</div>

<!-- รายละเอียดการบันทึกข้อมูลการให้บริการ -->
<div id="popupdetailservice" class="easyui-window" title="ข้อมูลการให้บริการ"
     style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodydetailservice"></div>
</div>

<!-- รายละเอียดหัตถการ -->
<div id="popupdetaildiag" class="easyui-window" title="ข้อมูลหัตถการ"
     style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodydiagservice"></div>
</div>

<!-- รายละเอียดการให้ยาสินค้า -->
<div id="popupdetaildrug" class="easyui-window" title="ข้อมูลการจ่ายยา / สินค้า"
     style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodydrugservice"></div>
</div>

<!-- รายละเอียดรายการอื่น ๆ  -->
<div id="popupdetailetc" class="easyui-window" title="ข้อมูลค่าใช้จ่ายอื่น ๆ"
     style="width:700px;height:500px;padding:0px; top:50px;"
     data-options="resizable:true,modal:true,closed:true,minimizable:false,collapsible:false">
    <div id="bodyetcservice"></div>
</div>

<!-- popup ประวัติแพ้ยา / โรคประจำตัว -->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="popuphomepage">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>แพ้ยา</h4>
                <ul class="list-group">
                    <?php foreach ($rsPatientDrug as $rsDg): ?>
                        <li class="list-group-item">- <?php echo $rsDg['drug'] ?></li>
                    <?php endforeach; ?>
                </ul>
                <hr />
                <h4>โรคประจำตัว</h4>
                <ul class="list-group">
                    <?php foreach ($rsPatientDisease as $rsDs): ?>
                        <li class="list-group-item">- <?php echo $rsDs['disease'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="savePopup()">ตกลง</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- popup ลงวันนัด -->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="popupappoint">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="bg-appoint">
            <div class="modal-title">
                <h3 style="text-align:center;">
                    <i class="fa fa-calendar"></i> วันนัด
                </h3>
            </div>
            <div class="modal-body" >
                <div class="row">
                    <div class='col-sm-6'>
                        <div class="form-group">
                            <label>เลือกวันที่</label>
                            <div class='input-group date'>
                                <input type='text' class="form-control" id='appoint'/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <label>สาเหตุนัด</label>
                        <textarea id="appoint_detail" class="form-control" rows="5"><?php echo $service['appoint_detail'] ?></textarea>
                    </div>
                </div>
                <div class="row" style=" margin-bottom: 10px;">
                    <div class="col-md-12 col-lg-12">
                        <br/>
                        <label>เวลา</label><br/>
                        ชั่วโมง
                        <select id="appoint_hours" style=" height: 40px; border-radius: 5px; font-size: 18px; padding: 5px;">
                            <?php
                            $hoursNow = date("H");
                            for ($h = 0; $h <= 23; $h++):
                                if (strlen($h) < 2) {
                                    $hours = "0" . $h;
                                } else {
                                    $hours = $h;
                                }
                                ?>
                                <?php if ($service['appoint_hours'] != "") { ?>
                                    <option value="<?php echo $hours ?>" <?php echo ($hours == $service['appoint_hours']) ? "selected" : ""; ?>><?php echo $hours ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $hours ?>" <?php echo ($h == $hoursNow) ? "selected" : ""; ?>><?php echo $hours ?></option>
                                <?php } ?>
                            <?php endfor; ?>
                        </select>
                        นาที
                        <select id="appoint_minute" style=" height: 40px; border-radius: 5px; font-size: 18px; padding: 5px;">
                            <?php
                            $minuteNow = date("i");
                            for ($m = 0; $m <= 59; $m++):
                                if (strlen($m) < 2) {
                                    $minute = "0" . $m;
                                } else {
                                    $minute = $m;
                                }
                                ?>
                                <?php if ($service['appoint_minute'] != "") { ?>
                                    <option value="<?php echo $minute ?>" <?php echo ($minute == $service['appoint_minute']) ? "selected" : ""; ?>><?php echo $minute ?></option>
                                <?php } else { ?>
                                    <option value="<?php echo $minute ?>" <?php echo ($m == $minuteNow) ? "selected" : ""; ?>><?php echo $minute ?></option>
                                <?php } ?>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveAppoint()">ลงวันนัด</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->



<!--
    ################### ใบรับรองแพทย์ ################
-->

<!-- popup ลงวันนัด -->
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
                    <textarea class="form-control" id="_comment" rows="5"><?php echo $certificate['comment'] ?></textarea>
                </div>
                <br/>
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-4"><label>ให้หยุดพักรักษาตัว จำนวน</label></div>
                    <div class="col-md-4 col-lg-4 col-sm-4">
                        <select class="form-control" id="_day">
                            <option value="">ไม่จำเป็นต้องหยุดพัก</option>
                            <?php for ($i = 1; $i <= 90; $i++): ?>
                                <option value="<?php echo $i ?>" <?php echo($certificate['day'] == $i) ? "selected" : ""; ?>><?php echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-6">
                        <label>ตั้งแต่วันที่ *</label>
                        <div class='input-group date'>
                            <input type='text' class="form-control" id='_datestart' value="<?php echo $certificate['datestart'] ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-sm-6">
                        <label>ถึงวันที่ *</label>
                        <div class='input-group date'>
                            <input type='text' class="form-control" id='_dateend' value="<?php echo $certificate['dateend'] ?>" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?php if ($certificate) { ?>
                    <button type="button" class="btn btn-primary" onclick="saveCertificate('1')">แก้ไข</button>
                <?php } else { ?>
                    <button type="button" class="btn btn-primary" onclick="saveCertificate('0')">บันทึก</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<!--
    ################### ใบส่งตัวลูกค้า ################
-->

<!-- popup ใบส่งตัว -->
<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="popuprefer">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-title">
                <h3 style="text-align:center;">
                    <i class="fa fa-calendar"></i> ใบส่งตัวรักษาต่อ
                </h3>
            </div>
            <div class="modal-body">
                <div>
                    <label style="width: 150px;">ชื่อ - สกุลผู้ป่วย *</label>
                    <input type="text" name="_refer_patientname" id="_refer_patientname" readonly="readonly" value="<?php echo $model['name'] . "   " . $model['lname'] ?>">
                </div>
                <div>
                    <label style="width: 150px;">อายุ *</label>
                    <input type="text" name="_refer_age" id="_refer_age" readonly="readonly" value="<?php echo $Age ?>">
                    <label>เพศ</label>
                    <?php echo $sex ?>
                    <input type="hidden" name="_refer_sex" id="_refer_sex" readonly="readonly" value="<?php echo $model['sex'] ?>">
                </div>
                <div>
                    <label style="width: 150px;">โทรศัพท์</label>
                    <input type="text" name="_refer_phone" id="_refer_phone" readonly="readonly" value="<?php echo $model['tel'] ?>">
                </div>
                <div>
                    <label style="width: 150px;">ที่อยู่ *</label>
                    <textarea style=" width: 400px;" id="_address" readonly="readonly" name="_address"><?php echo str_replace("#", " ", $model['contact']) ?></textarea>
                </div>

                <br/>
                <p class="text-danger">*ข้อมูลผู้ป่วยต้องครบถ้วนเท่านั้น</p>
                <div>
                    <label style="width: 150px;">เรียน *</label>
                    <input type="text" name="_sendto" id="_sendto" style=" width: 400px;" value="<?php echo $refer['sendto'] ?>">
                </div>
                <br/>
                <div>
                    <label>ประวัติการเจ็บป่วยในปัจจุบัน *</label>
                    <textarea class="form-control" id="_history" readonly="readonly"><?php echo $refer['history'] ?></textarea>
                </div>
                <br/>
                <div>
                    <label>ผล lab / ผล Xray </label>
                    <textarea class="form-control" id="_lab"><?php echo $refer['lab'] ?></textarea>
                </div>
                <br/>
                <div>
                    <label>การวินิจฉัยโรค *</label>
                    <textarea class="form-control" id="_diag" readonly="readonly"><?php echo $refer['diag'] ?></textarea>
                </div>
                <br/>
                <div>
                    <label>การรักษาพยาบาล *</label>
                    <textarea class="form-control" id="_treat"><?php echo $refer['treat'] ?></textarea>
                </div>
                <br/>
                <div>
                    <label>อื่น ๆ </label>
                    <textarea class="form-control" id="_etc"><?php echo $refer['etc'] ?></textarea>
                </div>
                <br/>
                <div>
                    <label>สาเหตุที่ส่งตัว </label>
                    <textarea class="form-control" id="_cause"><?php echo $refer['cause'] ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <?php if ($refer) { ?>
                    <button type="button" class="btn btn-primary" onclick="saveRefer('1')">แก้ไข</button>
                <?php } else { ?>
                    <button type="button" class="btn btn-primary" onclick="saveRefer('0')">บันทึก</button>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!--
##### Modal Serveice Remet#######
-->
<div class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="popupServiceRemet" style=" z-index: 500000;">
    <div class="modal-dialog modal-lg" role="document" style=" z-index: 500000;">
        <div class="modal-content" style=" z-index: 500000;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Remed</h4>
            </div>
            <div class="modal-body" id="bodySeviceRemet">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/js/patientview.js"></script>
<script type="text/javascript">
                    reloadseqemployee();
                    setScreen();
                    loaddetaildrug();
                    popuphome(1);
                    sumAll();
                    getAppoint();
                    var socket = io.connect('<?php echo $config->LinkNode() ?>');

                    function reloadclient() {
                        nodeloadtable();
                    }

                    function reloadseqemployee() {
                        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
                        var id = "seqemployeeramet";
                        var data = {
                            a: 1
                        };
                        $.post(url, data, function(datas) {
                            socket.emit(id, datas);
                            //ReautoloadseqDoctor();
                            //loadservicesuccess();
                        });
                    }

                    function nodeloadtable() {
                        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
                        var id = "seqemployeeramet";
                        var data = {
                            a: 1
                        };
                        $.post(url, data, function(datas) {
                            socket.emit(id, datas);
                            ReautoloadseqDoctor();
                            loadservicesuccess();
                        });
                    }

                    function ReautoloadseqDoctor() {
                        var url = "<?php echo Yii::app()->createUrl('queue/seqdoctor') ?>";
                        var id = "seqemployeedoctorramet";
                        var data = {
                            a: 1
                        };
                        $.post(url, data, function(datas) {
                            //$("#resultservice").html(datas);
                            socket.emit(id, datas, function(success) {
                                if (success == true) {
                                    loadservicesuccess();
                                }
                            });

                            //window.close();
                        });
                    }


                    //สั่งหน้าจอ seqemployee ทำงาน ในส่งน function loadservicesuccess
                    function loadservicesuccess() {
                        var url = "<?php echo Yii::app()->createUrl('queue/getservicesuccess') ?>";
                        var data = {
                            a: 1
                        };
                        var id = "seqsuccessramet";
                        $.post(url, data, function(datas) {
                            //alert('success');
                            //$("#servicesuccess").html(datas);
                            socket.emit(id, datas, function(success) {
                                if (success == true) {
                                    closewindow();
                                }
                                //console.log(success);
                                //$("#btn-confirm").hide();
                                //$("#btn-close").show();
                            });

                            //closewindow();
                        });
                    }

                    function closewindow() {
                        window.close();
                    }

                    function setScreen() {
                        var h = window.innerHeight;
                        $("#popupaddservice").css({
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

                    function openpopupservice() {
                        $("#typeEnter").val(2);
                        var url = "<?php echo Yii::app()->createUrl('service/checkdetail') ?>";
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {
                            service_id: serviceId
                        };
                        $.post(url, data, function(datas) {

                            if (datas.detail) {
                                $('#service_detail').textbox({
                                    value: datas.detail
                                });
                                $('#service_comment').textbox({
                                    value: datas.comment
                                });
                                $('#service_diag').textbox({
                                    value: datas.diag
                                });
                                $('#service_procedure').textbox({
                                    value: datas.procedure
                                });
                                $("#service_price").numberbox({
                                    value: datas.price
                                });
                                $("#btn-save").hide();
                                $("#btn-update").show();
                                $('#popupaddservice').dialog('open');
                            } else {
                                resetserviceDetail();
                                $("#btn-update").hide();
                                $("#btn-save").show();
                                $('#popupaddservice').dialog('open');

                                $('#service_detail').textbox('clear').textbox('textbox').focus();
                            }
                        }, 'json');
                        //$('#popupaddservice').dialog('open');
                    }

                    function checkDetailService() {
                        var url = "<?php echo Yii::app()->createUrl('service/checkdetail') ?>";
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {
                            service_id: serviceId
                        };
                        $.post(url, data, function(datas) {
                            if (datas.detail) {
                                $('#service_detail').textbox({
                                    value: datas.detail
                                });
                                $('#service_comment').textbox({
                                    value: datas.comment
                                });
                                $('#service_diag').textbox({
                                    value: datas.diag
                                });
                                $('#service_procedure').textbox({
                                    value: datas.procedure
                                });
                                $("#service_price").numberbox({
                                    value: datas.price
                                });

                                //เก็บลงในใบส่งตัว
                                $("#_history").val(datas.detail);
                                $("#_diag").val(datas.diag);
                            }
                        }, 'json');
                    }


                    $('#popupaddservice').window({
                        collapsible: false,
                        minimizable: false,
                        maximizable: false,
                        resizeable: false
                    });

                    $("#popupadddrug").window({
                        collapsible: false,
                        minimizable: false,
                        maximizable: false,
                        resizeable: false
                    });

                    function popuphome() {
                        var popup = "<?php echo $service['popup'] ?>";
                        if (popup != 1) {
                            $('#popuphomepage').modal();
                        }
                        checkDetailService();//เช็คข้อมูลการรักษา
                    }

                    function savePopup() {
                        var url = "<?php echo Yii::app()->createUrl('service/savepopup') ?>";
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {
                            service_id: serviceId
                        };
                        $.post(url, data, function(datas) {
                            window.location.reload();
                        });
                    }

                    function remedDrug(serviceId) {
                        var url = "<?php echo Yii::app()->createUrl('patientdrug/remed') ?>";
                        var serviceIdNew = "<?php echo $service_id ?>";
                        var data = {
                            service_id: serviceId,
                            service_id_new: serviceIdNew
                        };
                        $.post(url, data, function(datas) {
                            //alert(datas)
                            //sweetAlert("Warning...", datas, "warning");
                            if (datas != 0) {
                                swal({
                                    title: datas,
                                    type: "warning",
                                    showCancelButton: false,
                                    confirmButtonText: "OK",
                                    closeOnConfirm: false
                                });
                            }
                            loaddetaildrug();
                            //window.location.reload();
                        }, 'json');
                        $("#popupServiceRemet").modal("hide");
                        var t = $('#druginsert').combogrid('textbox').focus();
                        t.focus();
                    }

                    function ConfirmOrderDrug() {
                        var sumprictdrug = $("#sumprictdrug").val();
                        var countDrug = $("#countdrug").val();
                        var service_procedure = $("#service_procedure").val();
                        //if(countDrug <= 0){
                        //sweetAlert("Warning...", "ยังไม่มีรายการยา!", "warning");
                        //return false;
                        //}
                        if (sumprictdrug == "") {
                            //alert("กรุณากรอกราคายา...");
                            sweetAlert("Warning...", "กรุณากรอกราคายา / ค่ารักษา!", "warning");
                            return false;
                        }

                        var url = "<?php echo Yii::app()->createUrl('service/confirmpricedrug') ?>";
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {
                            service_id: serviceId,
                            pricedrug: sumprictdrug,
                            service_procedure: service_procedure
                        };
                        $.post(url, data, function(datas) {
                            //loaddetaildrug();
                            $('#popupadddrug').window('close');
                            sumAll();
                        });
                    }

                    function sumAll() {
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {
                            service_id: serviceId,
                        };
                        var url = "<?php echo Yii::app()->createUrl('service/sumservice') ?>";
                        $.post(url, data, function(datas) {
                            $("#sumTxt").text(datas);
                        });
                    }

                    function popupAppoint() {
                        var servicedetail = $("#service_detail").val();
                        if (servicedetail == "") {
                            //alert("ยังไม่ได้บันทึกประวัติการรักษา");
                            sweetAlert("Opp...", "ยังไม่ได้บันทึกประวัติการรักษา!", "warning");
                            return false;
                        } else {
                            $("#popupappoint").modal();
                        }
                    }

                    function saveAppoint() {
                        //var day = $("#appoint-day").val();
                        //var month = $("#appoint-month").val();
                        //var year = $("#appoint-year").val();
                        //var appoint = (year + "-" + month + "-" + day);
                        var appoint = $("#appoint").val();
                        var appoint_detail = $("#appoint_detail").val();
                        var appoint_hours = $("#appoint_hours").val();
                        var appoint_minute = $("#appoint_minute").val();
                        var serviceId = "<?php echo $service_id ?>";
                        var url = "<?php echo Yii::app()->createUrl('service/saveappoint') ?>";
                        var data = {
                            service_id: serviceId,
                            appoint: appoint,
                            appoint_detail: appoint_detail,
                            appoint_hours: appoint_hours,
                            appoint_minute: appoint_minute
                        };
                        if (appoint == "") {
                            sweetAlert("Oops...", "ยังไม่ได้เลือกวันนัด!", "warning");
                            return false;
                        }

                        $.post(url, data, function(datas) {
                            if (datas == 1) {
                                //alert("ลงวันนัดสำเร็จ");
                                sweetAlert("Success...", "ลงวันนัดสำเร็จ!", "success");
                                //$("#dateappoint").text(appoint);
                                getAppoint();
                                $("#popupappoint").modal("hide");
                            } else {
                                //alert("เกิดข้อผิดพลาด...");
                                sweetAlert("Oops...", "เกิดข้อผิดพลาด!", "error");
                                return false;
                            }
                        });
                    }

                    function getAppoint() {
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {service_id: serviceId};
                        var url = "<?php echo Yii::app()->createUrl('service/getappoint') ?>";
                        $.post(url, data, function(res) {
                            //console.log(res);
                            $("#dateappoint").text(res);
                        });
                    }

                    $(document).ready(function() {
                        $("#appoint").val('<?php echo $service['appoint'] ?>');
                        $("#appoint,#_datestart,#_dateend").datepicker({
                            'locale': 'th',
                            'autoclose': true,
                            'format': 'yyyy-mm-dd',
                            'todayHighlight': true,
                            'startDate': new Date()
                        });

                        //$('#sumprictdrug').textbox('textbox').css({'font-size': '24px','color': 'red'});
                        $('#druginsert').textbox('textbox').css({'font-size': '24px', 'color': 'blue'});
                        var w = window.innerWidth;
                        if (w < 768) {
                            $("#drug-right").css({'padding': '0px'});
                        }

                        //$("#drug_number").textbox('textbox').css({'font-size': '24px','color': 'red'});
                    });

                    /*
                     $(document).keypress(function(event){
                     var keycode = (event.keyCode ? event.keyCode : event.which);
                     if(keycode == '13'){
                     var typeEnter = $("#typeEnter").val();
                     if(typeEnter == 1){
                     saveDrug();
                     }

                     if(typeEnter == 2){
                     saveserviceDetail();
                     }
                     }


                     });
                     */

                    function saveDrug() {
                        calculatorDrug();
                        var url = "index.php?r=patientdrug/saveservicedrug";
                        var druginsert = $('#druginsert').val();
                        var drug_number = parseInt($('#drug_number').val());
                        var pricedrug = $('#pricedrug').val();
                        var pricedrugtotal = $("#pricedrugtotal").val();
                        var patient_id = $("#patient_id").val();
                        var service_id = $("#service_id").val();
                        var stock = parseInt($("#stock").val());
                        var drugvalue = $("#drugvalue").val();
                        var drug_method = $("#drug_method").val();
                        if (stock == "" || stock == "0") {
                            alert("ไม่มีสินค้า");
                            resetserviceDrug();
                            var t = $('#druginsert').combogrid('textbox').focus();
                            t.focus();
                            return false;
                        }

                        if (drug_number > stock) {
                            alert("สินค้ามีจำนวนไม่พอ");
                            return false;
                        }
                        var data = {
                            drug: drugvalue,
                            number: drug_number,
                            price: pricedrug,
                            total: pricedrugtotal,
                            service_id: service_id,
                            patient_id: patient_id,
                            drug_method: drug_method
                        };
                        //alert(druginsert + " | " + drug_number + " | " + pricedrug + "|" + pricedrugtotal);
                        if (drugvalue == "") {
                            var t = $('#druginsert').combogrid('textbox').focus();
                            t.focus();
                            sweetAlert("Oops...", "กรอกข้อมูล * ไม่ครบ!", "error");
                            return false;
                        }
                        if (isNaN(drug_number)) {
                            alert("กรุณาใส่จำนวน...");
                            $('#drug_number').numberbox('clear').numberbox('textbox').focus();
                            return false;
                        }

                        $.post(url, data, function(datas) {

                            resetserviceDrug();
                            //$("#popupadddrug").window('close');
                            loaddetaildrug();
                            var t = $('#druginsert').combogrid('textbox').focus();
                            t.focus();
                            //Success();
                        });

                    }

                    function popupSavedrug() {
                        $("#typeEnter").val(1);
                        $('#popupadddrug').window('open');
                        var t = $('#druginsert').combogrid('textbox').focus();
                        t.focus();
                    }


//KEY
                    document.addEventListener("keydown", function(event) {
                        console.log(event.which);
                        if (event.which == '13') {
                            var typeEnter = $("#typeEnter").val();
                            if (typeEnter == 1) {
                                saveDrug();
                            }

                            if (typeEnter == 2) {
                                saveserviceDetail();
                            }
                        }

                        if (event.which == '113') { //f2

                            var typeEnter = $("#typeEnter").val();
                            if (typeEnter == 1) {
                                getService();
                                //remedDrug('<?php //echo $lastService                                                          ?>');
                                //var t = $('#druginsert').combogrid('textbox').focus();
                                //t.focus();
                            }
                        }

                        if (event.which == '17') { //Ctrl
                            var typeEnter = $("#typeEnter").val();
                            if (typeEnter == 1) {
                                $("#sumprictdrug").focus();
                            }
                        }
                    });

                    function popupcertificate() {
                        var card = "<?php echo $model['card'] ?>";
                        var age = "<?php echo $Age ?>";
                        if (card == "" || age == "") {
                            alert("ข้อมูลผู้ป่วยไม่สมบูรณ์กรุณาอัพเดทข้อมูล...");
                            return false;
                        } else {
                            $("#popupcertificate").modal();
                        }
                    }

                    function saveCertificate(flag) {
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
                            id = "<?php echo $certificate['id'] ?>";
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

                    function popupRefer() {
                        $("#popuprefer").modal();
                    }

                    function saveRefer(flag) {
                        var url = "<?php echo Yii::app()->createUrl('service/saverefer') ?>";
                        var service_id = "<?php echo $service_id ?>";
                        var patient_name = $("#_refer_patientname").val();
                        var age = $("#_refer_age").val();
                        var sendto = $("#_sendto").val();
                        var address = $("#_address").val();
                        var phone = $("#_refer_phone").val();
                        var sex = $("#_refer_sex").val();
                        var history = $("#_history").val();
                        var lab = $("#_lab").val();
                        var diag = $("#_diag").val();
                        var treat = $("#_treat").val();
                        var etc = $("#_etc").val();
                        var cause = $("#_cause").val();
                        var id;
                        if (flag == 1) {
                            id = "<?php echo $refer['id'] ?>";
                        } else {
                            id = "";
                        }

                        var data = {
                            id: id,
                            service_id: service_id,
                            patient_name: patient_name,
                            age: age,
                            tel: phone,
                            sex: sex,
                            address: address,
                            sendto: sendto,
                            history: history,
                            lab: lab,
                            diag: diag,
                            treat: treat,
                            etc: etc,
                            cause: cause,
                            flag: flag
                        };
                        if (sendto == "" || history == "" || diag == "" || treat == "") {
                            alert("กรุณากรอก * ให้ครบ");
                            return false;
                        } else {
                            $.post(url, data, function(datas) {
                                alert("บันทึกใบส่งตัวสำเร็จ...");
                                window.location.reload();
                            });
                        }
                    }

                    //Function ดึงวันที่ให้บริการย้อนหลังเพื่อ Remat ยา
                    function getService() {
                        $("#popupServiceRemet").modal();
                        var url = "<?php echo Yii::app()->createUrl('service/getserviceremat') ?>";
                        var patientId = "<?php echo $model['id'] ?>";
                        var serviceId = "<?php echo $service_id ?>";
                        var data = {patientId: patientId, serviceId: serviceId};
                        $.post(url, data, function(res) {

                            $("#bodySeviceRemet").html(res);
                            //console.log(res);
                        });
                    }

                    //เรียกชื่อ
                    function SendSeq(name) {
                        socket.emit('seqramet', name, function(success) {});
                    }
</script>
