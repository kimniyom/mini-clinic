<?php
/* @var $this LogloginController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'ประวัติการเข้าใช้งาน',
);

?>
<table class="table" id="loglogin">
    <thead>
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>พนักงาน</th>
            <th>สาขา</th>
            <th>วันที่</th>
            <th>สถานะ</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=0;foreach($datas as $rs): $i++;?>
        <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $rs['username'] ?></td>
            <td><?php echo $rs['name']." ".$rs['lname'] ?></td>
            <td><?php echo $rs['branchname'] ?></td>
            <td><?php echo $rs['date'] ?></td>
            <td><?php echo $rs['status'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function(){
       $("#loglogin").dataTable();
    });
</script>

