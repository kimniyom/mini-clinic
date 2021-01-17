<table>
    <tr>
        <td>ฐานข้อมูล</td>
        <td></td>
    </tr>
    <?php
    for ($i = 0; $i <= count($db) - 1; $i++):
        if ($i > 1) {
            ?>
            <tr>
                <td><?php echo $db[$i] ?></td>
                <td><a href="<?php echo Yii::app()->baseUrl ?>/db/<?php echo $db[$i] ?>" target="_bank"><i class="fa fa-download"></i> Download</a></td>
            </tr>
        <?php } ?>
    <?php endfor; ?>
</table>

