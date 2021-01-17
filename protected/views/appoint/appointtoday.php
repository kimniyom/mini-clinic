<style type="text/css">
    .alam{
        background: red;
        color:#FFFFFF;
    }
    .alam a{
        color: #FFFFFF;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
        $("#p_product").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            "iDisplayLength": 10, // กำหนดค่า default ของจำนวน record
            "bFilter": true // แสดง search box
                    //"sScrollY": "400px", // กำหนดความสูงของ ตาราง
        });
    });
</script>

<?php
$this->breadcrumbs = array(
	"นัดวันนี้",
);

$web = new Configweb_model();
$Alert = new Alert();
$AppointModel = new Appoint();
$alam = $Alert->Getalert()['alert_product'];
?>

<div class="panel panel-default" style=" margin-bottom: 0px;">
    <div class="panel-heading" style=" padding-bottom: 15px; padding-right: 5px; background: none;">
        <i class="fa fa-carlendar"></i> นัดหมายวันนี้
    </div>
    <div class="panel-body">

        <table class="table" id="p_appointover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>วันนัด</th>
                    <th>ลูกค้า</th>
                    <th style=" text-align: center;">เบอร์โทรศัพท์</th>
                    <th>ประเภทนัด</th>
                    <th>พนักงานนัด</th>
                    <th>สาขา</th>

                </tr>
            </thead>
            <tbody>
                <?php
$i = 0;
foreach ($appoint as $last):
	$i++;
	?>
											                    <tr>
											                        <td><?php echo $i ?></td>
											                        <td><?php echo $web->thaidate($last['appoint']) ?></td>
											                        <td><?php echo $last['name'] . " " . $last['lname']; ?></td>
											                        <td style=" text-align: center;"><?php echo $last['tel']; ?></td>
			                                                        <td><?php echo $AppointModel->Typeappoint($last['type']) ?></td>
										                            <td><?php echo $last['emp_name'] . " " . $last['emp_lname']; ?></td>
				                                                    <td><?php echo $last['branchname'] ?></td>


											                    </tr>
											                    <?php
endforeach;
?>
            </tbody>
        </table>
    </div>
</div>



<script type="text/javascript">

    Setscreen();
    function Setscreen() {
        var boxsell = $(window).height();
        //var contentboxsell = $("#content-boxsell").height();
        var screenfull = (boxsell - 290);
        $("#p_appointover").dataTable({
            //"sPaginationType": "full_numbers", // แสดงตัวแบ่งหน้า
            "bLengthChange": false, // แสดงจำนวน record ที่จะแสดงในตาราง
            //"iDisplayLength": 50, // กำหนดค่า default ของจำนวน record
            //"scrollCollapse": true,
            "paging": false,
            "bFilter": true, // แสดง search box
            "sScrollY": screenfull, // กำหนดความสูงของ ตาราง
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'ส่งออก excel'
                }
            ]
        });
    }


</script>


