<?php
$this->breadcrumbs = array(
    //''=>array('index'),
    'รายงานรายรับ  - รายจ่ายทั้งหมด',
);
$yearnow = date("Y");
?>
<div class="row" style=" margin: 0px;">
    <div class="col-lg-3">
        เลือกปี พ.ศ.
        <select id="year" class="form-control">
            <?php for ($i = $yearnow; $i >= ($yearnow - 1); $i--): ?>
                <option value="<?php echo $i ?>"><?php echo $i + 543 ?></option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="col-lg-2" style=" padding-top: 20px;">
        <button type="button" class="btn btn-default btn-block" onclick="getreport()"><i class='fa fa-search'></i> ตกลง</button>
    </div>
</div>

<div id="boxreport" class="wells" style=" margin-top: 10px; background: none;margin-bottom: 0px; border: 0px; box-shadow: 0px; padding: 0px;">
    <div id="showreport" style=" margin: 0px;"></div>
</div>
<script type="text/javascript">
    getreport();
    function getreport() {
        var url = "<?php echo Yii::app()->createUrl('report/datareportcostprofitcenter') ?>";
        var year = $("#year").val();
        var data = {year: year};
        $.post(url, data, function (datas) {
            $("#showreport").html(datas);
        });
    }
</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var screen = $(window).height();
        var w = window.innerWidth;
        if (w >= 768) {
            var screenfull = (screen - 170);
            $("#boxreport").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '0px'});
            //$("#patientbox").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF'});
            //$("#boxorders").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF', 'overflow': 'auto', 'padding-left': '10px'});
        }
    }
</script>