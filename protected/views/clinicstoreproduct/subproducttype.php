<script type="text/javascript">
    Getcomboproduct();
    settexbox();
    $(document).ready(function () {
        $("#subproducttype").select2({
            allowClear: true,
            theme: "bootstrap"
        });

        $("#subproducttype").change(function () {
            var subproducttype = $("#subproducttype").val();
            var branch = $("#branch").val();
            var url = "<?php echo Yii::app()->createUrl('clinicstoreproduct/getproductinsubtype') ?>";
            var data = {subproducttype: subproducttype, branch: branch};
            $.post(url, data, function (datas) {
                $("#boxproduct").html(datas);
            });
        });
    });

    function Getcomboproduct() {
        var subproducttype = $("#subproducttype").val();
        var branch = $("#branch").val();
        var url = "<?php echo Yii::app()->createUrl('clinicstoreproduct/getproductinsubtype') ?>";
        var data = {subproducttype: subproducttype, branch: branch};
        $.post(url, data, function (datas) {
            $("#boxproduct").html(datas);
        });
    }
</script>

<select id="subproducttype" class="form-control">
    <?php foreach ($type as $rs): ?>
        <option value="<?php echo $rs['id'] ?>"><?php echo $rs['type_name'] ?></option>
    <?php endforeach; ?>
</select>