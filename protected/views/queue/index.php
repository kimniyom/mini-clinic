<style type="text/css">
    table{background: #FFFFFF;}
</style>

<?php
$this->breadcrumbs = array('คิวการรักษา',);
$WebConfig = new Configweb_model();
?>

<button type="button" class="btn btn-success" onclick="loaddata()"><i class="fa fa-refresh"></i> Refresh</button>
<div class=" pull-right"><h4>วันที่ : <?php echo $WebConfig->thaidate(date("Y-m-d")) ?></h4></div>
<div id="resultservice" style=" margin-top: 10px;"></div>
<script type="text/javascript">
    /******** NODE JS ********/
    var branch = "<?php echo Yii::app()->session['branch'] ?>";
    var id = "seqemployeedoctorramet";
    loaddata(id);
    var socket = io.connect('<?php echo $WebConfig->LinkNode() ?>');

    function loaddata(id) {
        var url = "<?php echo Yii::app()->createUrl('queue/seqdoctor') ?>";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            socket.emit(id, datas, function(success) {});
        });
    }

    socket.on(id, function(data) {
        $("#resultservice").html(data);
    });
</script>


