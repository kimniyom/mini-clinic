<style type="text/css">
    .modal .large {
        width: 90%;
    }
</style>

<?php
/* @var $this ProductTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'คิวการรักษา / ตรวจร่างกาย',
);

$WebConfig = new Configweb_model();
?>

<script type="text/javascript">
    $(document).ready(function() {
        nodeloadtable();
        //loadservicesuccess();
        //loadseqdoctor();
    });


    /******** NODE JS ********/
    var socket = io.connect('<?php echo $WebConfig->LinkNode() ?>');
    function nodeloadtable() {
        var url = "http://122.154.239.66/clinic-ramet/index.php?r=queue/getdata";
        var branch = "1";
        var id = "seqemployeeramet";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            //$("#datas").html(datas);
            socket.emit(id, datas);
            ReautoloadseqDoctor();
        });
    }

    function ReautoloadseqDoctor() {
        var url = "http://122.154.239.66/clinic-ramet/index.php?r=queue/seqdoctor";
        var branch = "1";
        var id = "seqemployeedoctorramet";
        var data = {a: 1};
        $.post(url, data, function(datas) {
            //$("#resultservice").html(datas);
            socket.emit(id, datas, function(success) {
            });
        });
    }

    //ท่อส่งข้อมูลไป server
    var branch = "1";
    var id = "seqemployeeramet";
    socket.on(id, function(data) {
        $("#resultseqemployee").html(data);
    });

    var idsuccess = "seqsuccessramet";
    socket.on(idsuccess, function(data) {
        $("#servicesuccess").html(data);
    });

    var idseqdoctor = "seqemployeedoctorramet";
    socket.on(idseqdoctor, function(data, fn) {
        $("#resultservice").html(data);
    });

</script>

