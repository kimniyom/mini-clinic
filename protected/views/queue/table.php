<style type="text/css">
    .modal.large {
        width: 80%;
    }
    .box-all{
        height: 50px;
        width: 50px;
        margin: 0px;
    }
</style>
<?php
        $i = 0;
        foreach ($seq as $rs):
            $i++;
            if ($rs['images']) {
                $pathImg = Yii::app()->baseUrl."/uploads/profile/".$rs['images'];
            } else {
                $pathImg = Yii::app()->baseUrl."/images/No_image.jpg";
            }
            
            $rss = Checkbody::model()->find('service_id=:service_id', array(':service_id'=>$rs['id']));
            ?>
            <div class="media">
                <div class="media-left">
                    <div class="container-card set-views-card box-all">
                        <div class="img-wrapper">
                            <img class="img-responsive img-polaroid" style="height:50px;" src="<?php echo $pathImg ?>" alt="...">    
                        </div>
                    </div>
                </div>
                <div class="media-body">
                <button type="button" class="btn btn-danger pull-right" onclick="deleteservice('<?php echo $rs['id']?>')"><i class="fa fa-trash"></i></button>
                    <h4 class="media-heading" style="font-size:18px;"><?php echo $rs['name'] . ' ' . $rs['lname'] ?>(อายุ : <?php echo $rs['age'] ?> ปี)</h4>
                    อาการมารับบริการ : <?php echo $rss['cc'] ?>
                </div>
                
            </div>
        <?php endforeach; ?>

<script type="text/javascript">
    function deleteservice(id){
        var r = confirm("Are you sure...?");
        if(r == true){
            var url = "<?php echo Yii::app()->createUrl('queue/deleteservice')?>";
            var data = {id: id};
            $.post(url,data,function(datas){
                nodeloadtable();
                //loadtable();
            });
        }
    }
</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        var w = $(window).width();
        var screenfull = (boxsell - 155);
        if(w >= 768){
            $("#seqemployee").css({'height':screenfull,"overflow":"auto"});
        }
        
    }
</script>
