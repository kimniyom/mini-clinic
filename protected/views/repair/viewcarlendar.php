<div class="list-group">
    <?php foreach ($repair as $rs): ?>
        <?php if (Yii::app()->session['branch'] != '99') { ?>
            <a href="javascript:popuprepair('<?php echo $rs['id'] ?>')" class="list-group-item">
                <label>รายการ:</label> <?php echo $rs['object'] ?><br/>
                <label>รายละเอียด:</label> <?php echo $rs['detail'] ?>
            </a>
        <?php } else { ?>
            <div class="list-group-item">
               <label>รายการ:</label> <?php echo $rs['object'] ?><br/>
                <label>รายละเอียด:</label> <?php echo $rs['detail'] ?>
            </div>
        <?php } ?>
    <?php endforeach; ?>
</div>


