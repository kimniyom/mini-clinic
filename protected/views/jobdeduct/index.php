<?php
$this->breadcrumbs = array(
    'พนักงาน' => array('employee/index'),
    'Jobs',
);

$yearnow = date("Y");
$month = Month::model()->findAll();
$yearNow = date("Y");
$monthNow = date("m");
if (strlen($monthNow) < 2) {
    $monthNows = "0" . $monthNow;
} else {
    $monthNows = $monthNow;
}
?>
<div class="well well-sm" style=" margin: 0px;">
    <h4>บันทึกรายการหัก (<?php echo $employee['name'] . " " . $employee['lname'] ?>)</h4>
    <div class="row" style=" margin: 0px; margin-bottom: 10px;">
        <div class="col-lg-3 col-md-3 col-sm-6">
            เลือกปี พ.ศ.
            <select id="year" class="form-control" onchange="getjob()">
                <?php for ($i = $yearnow; $i >= ($yearnow - 1); $i--): ?>
                    <option value="<?php echo $i ?>"><?php echo $i + 543 ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-6">
            ประจำเดือน
            <select id="month" class="form-control" onchange="getjob()">
                <?php foreach ($month as $m): ?>
                    <option value="<?php echo $m['id'] ?>" <?php echo ($monthNows == $m['id']) ? "selected" : ""; ?>><?php echo $m['month_th'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="row" style="margin:0px;">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <label>รายการ</label>
            <input type="text" class="form-control" id="commision"/>
        </div>
    </div>
    <div class="row" style="margin:0px;">
        <div class="col-sm-6 col-md-2 col-lg-2">
            <label>ยอด</label>
            <input type="text" class="form-control" id="result" onkeyUp="if (this.value * 1 != this.value) {
                        this.value = '';
                    } else {
                        calculatorpercent()
                    }" style=" text-align: center;"/>
        </div>
        <div class="col-sm-3 col-md-2 col-lg-2">
            <button type="button" class="btn btn-default" style=" margin-top: 25px;" onclick="savecommision()"><i class="fa fa-save"></i> บันทึก</button>
        </div>
    </div>

    <div id="resultjob"></div>

</div>
<script type="text/javascript">
    getjob();

    function savecommision() {
        var url = "<?php echo Yii::app()->createUrl('jobdeduct/create') ?>";
        var employee = "<?php echo $employee['id'] ?>";
        var commision = $("#commision").val();
        var year = $("#year").val();
        var month = $("#month").val();
        var result = $("#result").val();

        if (commision == "" || result == "") {
            alert("ยังไม่ได้เลือกรายการ ...");
            return false;
        }
        var data = {employee: employee, commision: commision,result: result, year: year, month: month};
        $.post(url, data, function (datas) {
            getjob();
        });
    }

    function getjob() {
        var url = "<?php echo Yii::app()->createUrl('jobdeduct/getjob') ?>";
        var employee = "<?php echo $employee['id'] ?>";
        var year = $("#year").val();
        var month = $("#month").val();
        var data = {employee: employee, year: year, month: month};
        $.post(url, data, function (datas) {
            $("#resultjob").html(datas);
        });
    }
</script>