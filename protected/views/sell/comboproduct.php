<select id="itemcodes" class="form-control" onchange="Getdetailproduct(this.value)">
    <option value="">ค้นหาสินค้า/หัตถการ</option>
    <?php foreach($itemlist as $rs): ?>
    <option value="<?php echo $rs['product_id'].'||'.$rs['detail'].'||'.$rs['type'].'||'.$rs['product_price'].'||'.$rs['product_name'] ?>"><?php echo $rs['detail'].' ราคา '.$rs['product_price'] ?></option>
    <?php endforeach;?>
</select>

<script type="text/javascript">
    $(document).ready(function () {
        $("#itemcodes").select2({
            //placeholder: "ชื่อสินค้า",
            allowClear: false,
            multiple: false, 
            maximumSelectionSize: 1,
        });
    });
</script>
