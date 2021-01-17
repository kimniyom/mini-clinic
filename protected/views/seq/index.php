<style type="text/css">
    table{
        background: #FFFFFF;
    }

    #listpatient{
        width: 100%;
        border-bottom: solid 3px #ffffff;
    }

    #listpatient h4{
        font-size: 48px;
    }

    #listpatient .media-left{
        display: none;
    }

    .media-heading{
        padding-left: 20px;
        color: yellow;
    }

    #cc{
        font-size: 30px;
        padding-left: 20px;
    }
</style>

<?php
/* @var $this ProductTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'คิวการรักษา',
);

$WebConfig = new Configweb_model();
?>
<div id="player"></div>
<script type="text/javascript">
        function popupseq(name) {
        var url = "https://translate.google.com.vn/translate_tts?ie=UTF-8&q=เชิญคุณ"+name+"เข้าห้องตรวจ&tl=th&client=tw-ob";
        //newwindow=window.open(url,'rametseq','height=50,width=50');
        newwindow=window.open(url,'_blank');
        //if (window.focus) {
            //newwindow.focus();
            setTimeout(function(){
               newwindow.close();
             },40000);
        //}
            //return false;
  }
</script>

<div class=" pull-right"><h4>วันที่ : <?php echo $WebConfig->thaidate(date("Y-m-d")) ?></h4></div>

<!--<div id="seqramet" style=" margin-top: 10px;"></div>-->
<div class="row">
    <div class="col-md-6 col-lg-6">
        <iframe id="video" src="https://www.youtube.com/embed/LeUkwkKPed4?mute=1;autoplay=1;&loop=1&playlist=LeUkwkKPed4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <div class="col-md-6 col-lg-6">
        <h4 style="font-size: 48px; padding-left: 20px; color:red;">คิวรอตรวจ</h4>
        <div id="resultservice" style=" margin-top: 10px;"></div>
    </div>
</div>
<script type="text/javascript">
    setscreen();
    /******** NODE JS ********/
    var branch = "<?php echo Yii::app()->session['branch'] ?>";
    var id = "seqemployeedoctorramet";
    loaddata(id);
    var socket = io.connect('<?php echo $WebConfig->LinkNode() ?>');


    function loaddata(id) {
        var url = "<?php echo Yii::app()->createUrl('queue/seqdoctor') ?>";
        var data = {a: 1};
        $.post(url, data, function (datas) {
            socket.emit(id, datas,function(success){
            });
        });
    }

    socket.on(id, function (data) {
        $("#resultservice").html(data);
    });

    socket.on('seqramet', function (data) {
        $("#seqramet").html(data);
        if(data){
            //popupseq(data);
            getAudio('เชิญคุณ'+data+'เข้าห้องตรวจ');
        }
    });

    function getAudio(txt){
        jQuery.ajax({
            url:"<?php echo Yii::app()->createUrl('seq/getseq') ?>",
            type:'post',
            data:'txt='+txt,
            success:function(result){
                jQuery('#player').html(result);
            }
        });
    }

    function setscreen(){
        var h = window.innerHeight;
        $("#video").css({'width': '100%','height': h-5});
        $("#resultservice").css({'height': h-120,'overflow': 'auto'});
    }
</script>


