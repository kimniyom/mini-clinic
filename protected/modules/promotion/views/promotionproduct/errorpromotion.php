<?php
$this->breadcrumbs = array(
    'โปรโมชั่น' => array('index'),
    '!error',
);
?>

<div class="alert alert-danger">
    สินค้ามีการจัดโปรโมชั่นอยู่แล้วแก้ไขข้อมูลโปรโมชั่นเดิมเป็น "ไม่ใช้" เพื่อสร้างใหม่<br/>
    <?php echo CenterStockproduct::model()->find("product_id=:product_id", array(":product_id" => $promotion['product_id']))['product_nameclinic']; ?> (<?php echo $promotion['promotionname'] ?>)
    ราคาเดิม <del><?php echo $promotion['priceold'] ?></del> ราคาโปรโมชั่น <?php echo number_format($promotion['price']) ?><br/>
    <button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i> แก้ไขโปรโมชั่นเดิม</button>
</div>