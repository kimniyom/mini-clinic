<style type="text/css">
    .patient-hover:hover{
        border: #cccccc solid 5px;
        cursor: pointer;
    }

    table{
        font-size: 20px;
    }
</style>
<?php
$webconfig = new Configweb_model();
if ($patient) {
    ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <td></td>
                <th>ชื่อ</th>
                <th>สกุล</th>
                <th>เลขบัตร</th>
                <th>อายุ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patient as $rs): ?>
                <tr onclick="Getpatient('<?php echo $rs['id'] ?>')" style="cursor: pointer;">
                    <td><i class="fa fa-arrow-left text-warning"></i></td>
                    <td><?php echo $rs['name'] ?></td>
                    <td><?php echo $rs['lname'] ?></td>
                    <td><?php echo ($rs['card']) ? $rs['card'] : "-"; ?></td>
                    <td><?php echo ($rs['birth']) ? "(" . $webconfig->get_age($rs['birth']) . " ปี)" : "-"; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php } else { ?>
    <center><h2>ไม่พบข้อมูล ...! </h2></center>
<?php } ?>


