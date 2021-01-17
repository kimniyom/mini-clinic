<script type="text/javascript">
    function save_type() {
        $("#loading").addClass("fa fa-spinner fa-spin");
        var url = "<?php echo Yii::app()->createUrl('backend/typeproduct/save_type') ?>";
        var type_id = $("#type_id").val();
        var type_name = $("#type_name").val();
        var upper = $("#upper").val();
        var level = $('input[name=level]:checked').val();

        var data = {
            type_id: type_id,
            type_name: type_name,
            upper: upper,
            level: level
        };
        if (type_name == "") {
            $("#loading").removeClass("fa fa-spinner fa-spin");
            $("#loading").addClass("fa fa-plus");
            $("#type_name").focus();
            return false;
        }

        $.post(url, data, function (success) {
            window.location.reload();
        });

    }

    function delete_type(type_id) {
        var r = confirm("ต้องการลบข้อมูล ใช่ หรือ ไม่ ...?");
        if (r === true) {
            var url = "<?php echo Yii::app()->createUrl("backend/typeproduct/delete") ?>";
            var data = {type_id: type_id};

            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }

    function Check(type_id) {
        var url = "<?php echo Yii::app()->createUrl("backend/typeproduct/checkproduct") ?>";
        var data = {type_id: type_id};

        $.post(url, data, function (datas) {
            if (datas > 0) {
                alert("มีสินค้าในประเภทนี้ไม่สามารถทำรายการได้");
                return false;
            } else {
                //alert("TRUE");
                delete_type(type_id);
            }
        });
    }
</script>

<?php
if ($uppername) {
    $this->breadcrumbs = array(
        'ประเภทสินค้า' => Yii::app()->createUrl('backend/typeproduct/from_add_type'),
        $uppername
    );
} else {
    $this->breadcrumbs = array(
        'ประเภทสินค้า'
    );
}
?>

<div class="panel panel-default">
    <div class="panel-heading">จัดการประเภทสินค้า</div>
    <div class="panel-body">
        <div class="row" style="margin: 0px;">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <label>รหัส</label>
                <input class="form-control input-sm" id="type_id" name="type_id" type="text" value="<?php echo $type_id; ?>" readonly="readonly"/>
            </div>
        </div>
        <div class="row" style="margin: 0px;">
            <div class="col-sm-12 col-lg-12">
                <label>ประเภท</label>
                <input class="form-control input-sm" id="type_name" name="type_name" type="text" placeholder="ชื่อประเภทสินค้า ..."/>
            </div>
        </div>
        <br/>
        <div class="row" style="margin: 0px;">
            <div class="col-sm-12 col-lg-12">
                <label>มีเมนูย่อย</label>
                <input type="radio" name="level" id="level" value="1"/>
                <label>ไม่มีเมนูย่อย</label>
                <input type="radio" name="level" id="level" value="0" checked="checked"/>
            </div>
        </div>

        <input type="hidden" id="upper" value="<?php echo $upper ?>"/>

    </div>
    <div class="panel-footer">
        <div class="btn btn-default" onclick="save_type();"><i class=" glyphicon glyphicon-plus" id="loading"></i> เพิ่มข้อมูล</div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">ประเภทสินค้า</div>
    <table class="table table-bordered" id="product_type">
        <thead>
            <tr>
                <th>รหัส</th>
                <th>ประเภท</th>
                <th style="text-align: center;">Staus</th>
                <th style=" text-align: center;">เมนูจัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($type as $rs): ?>
                <tr>
                    <td><?php echo $rs['type_id'] ?></td>
                    <td>
                        <?php if ($rs['sublevel'] == '0') { ?>
                            <?php echo $rs['type_name'] ?>
                        <?php } else { ?>
                            <a href="<?php echo Yii::app()->createUrl('backend/typeproduct/from_add_type', array('upper' => $rs['id'])) ?>">
                                <?php echo $rs['type_name'] ?>
                            </a>
                        <?php } ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($rs['active'] == 1)
                            echo "<i class='fa fa-check text-success'></i> Active";
                        else
                            echo "<i class='fa fa-remove text-danger'></i> Unactive";
                        ?>
                    </td>
                    <td style=" text-align: center;">
                        <a href="<?php echo Yii::app()->createUrl('backend/typeproduct/edit', array('id' => $rs['id'], 'upper' => $rs['upper'])) ?>">
                            <div class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i> แก้ไข</div></a>
                        <div class="btn btn-danger btn-xs" onclick="Check('<?php echo $rs['type_id'] ?>')"><i class="glyphicon glyphicon-trash"></i> ลบ</div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
