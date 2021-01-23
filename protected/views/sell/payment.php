<div class="col-md-5 col-lg-5" style="padding-left:0px;">
    <select id="account" class="form-control" onchange="getpremise()">
        <option value="">== เลือกบัญชี ==</option>
        <?php foreach ($banklist as $rs): ?>
            <option value="<?php echo $rs['accountnumber'] ?>"><?php echo $rs['accountnumber'] . ' ' . $rs['bankname'] ?></option>
        <?php endforeach; ?>
    </select>
</div>

<div id="box-slip" style="display:none;">
    <form id="upload" method="post" action="<?php echo Yii::app()->createUrl('sell/uploadtmpslip', array('sell_id' => $sell_id)) ?>" enctype="multipart/form-data" style=" margin-top: 10px;">
        <div id="drop">
            หลักฐานการโอนเงิน<br/>
            <a class="btn btn-primary"><i class="fa fa-picture-o"></i> Browse</a>
            <input type="file" name="upl" />
        </div>

        <ul style="">
            <!-- The file uploads will be shown here -->
        </ul>
    </form>
</div>
<!--
<button type="button" class="btn btn-success btn-lg btn-block" style=" margin-top: 10px;" onclick="Check_bill_transfer()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
-->
