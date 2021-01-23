<link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/lib/ckeditor/skins/prestige/editor.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/lib/ckeditor/ckeditor.js"></script>
<style type="text/css">
    .form-control{
        background: #111111;
    }
    .row{
        margin-top: 10px;
    }

    .select2-container {
        background-color: #111111 !important;
    }
    .select2-drop{
        background-color: #111111 !important;
        border-color: #333333;
        color:#666666;
    }
    .select2-search input {
        background-color: #222222 !important;
        border:none;
    }
    .select2-choice { background-color: #111111 !important; border-color:#222222 !important; height: 40px !important;}
    .select2-search { background-color: #111111 !important; margin-top: 10px;}
    .select2-arrow {
        border-left: 0px solid transparent !important;
        /* 2 */
    }

</style>
<?php
$title = "เพิ่มสินค้า";
$this->breadcrumbs = array(
    //"คลังสินค้า" => Yii::app()->createUrl('store/index'),
    "รายการสินค้า" => array('index'),
    $title,
);

$web = new Configweb_model();
$BranchModel = new Branch();
?>

<div class="wells" style="width:100%; margin-bottom: 10px;">

    <div class="row" style=" margin: 0px;">
        <div class="col-md-3 col-lg-3" id="p-left">
            <div class="well" style=" border:#666666 dashed 2px; text-align: center; cursor: pointer;"
                 onclick="GetImages();">
                <i class="fa fa-image fa-5x" style=" color: #cccccc;"></i><br/>
                <i class="fa fa-plus"></i> <font id="font-20">เพิ่มรูปสินค้า</font>
            </div>
            <div id="load_images_product"></div>
        </div>
        <div class="col-md-9 col-lg-9" id="p-right">
            <label for="">หมวดสินค้า*</label><br/>
            <?php
            $this->widget('booster.widgets.TbSelect2', array(
                //'model' => $model,
                'asDropDownList' => true,
                //'attribute' => 'itemid',
                'name' => 'producttype',
                'id' => 'producttype',
                'data' => CHtml::listData(ProductType::model()->findAll("upper is null"), 'id', 'type_name'),
                //'value' => $model,
                'options' => array(
                    'allowClear' => true,
                    //$model,
                    //'oid',
                    //'tags' => array('clever', 'is', 'better', 'clevertech'),
                    'placeholder' => '== หมวดสินค้า ==',
                    'width' => '50%',
                //'tokenSeparators' => array(',', ' ')
                ),
            ));
            ?><br/>
            <div class="row">
                <div class="col-lg-6">
                    <div id="boxsubproducttype" style=" width: 100%;">
                        <label for="">ประเภทสินค้า*</label>
                        <select id="subproducttype" class="form-control">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-6">
                    <label for="">รหัสสินค้า*</label>
                    <input type="text" id="_product_id" name="product_id" class="form-control" style="width:40%;" onkeyup="setcode()" value="<?php echo $productidAuto ?>"/>
                    <input type="hidden" id="product_id" name="product_id" class="form-control" style="width:40%;" value="<?php echo $productidAuto ?>"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <label for="">ชื่อตามฉลาก*</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" style="width:100%;" required="required"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <label for="">ชื่อใช้เรียกในคลินิก*</label>
                    <input type="text" id="product_nameclinic" name="product_nameclinic" class="form-control" style="width:100%;" required="required"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <label for="">หน่วยนับ*</label>
                    <?php
                    $this->widget('booster.widgets.TbSelect2', array(
                        //'model' => $model,
                        'asDropDownList' => true,
                        //'attribute' => 'itemid',
                        'name' => 'unit',
                        'id' => 'unit',
                        'data' => CHtml::listData(Unit::model()->findAll(""), 'id', 'unit'),
                        //'value' => $model,
                        'options' => array(
                            'allowClear' => true,
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => '== หน่วยนับ ==',
                            'width' => '100%',
                        //'tokenSeparators' => array(',', ' ')
                        ),
                    ));
                    ?>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label for="">ราคาต้นทุน*</label>
                    <input type="number" id="costs" name="costs" class="form-control" onkeypress="return chkNumber()" required="required"/>
                </div>
                <div class="col-md-6 col-lg-3">
                    <label for="">ราคาขาย*</label>
                    <input type="text" id="product_price" name="product_price" class="form-control" onkeypress="return chkNumber()" required="required"/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <label for="">บริษัท(suppliers)</label><br/>
                    <?php
                    $this->widget('booster.widgets.TbSelect2', array(
                        //'model' => $model,
                        'asDropDownList' => true,
                        //'attribute' => 'itemid',
                        'name' => 'company',
                        'id' => 'company',
                        'data' => CHtml::listData(CenterStockcompany::model()->findAll(""), 'id', 'company_name'),
                        //'value' => $model,
                        'options' => array(
                            'allowClear' => true,
                            //$model,
                            //'oid',
                            //'tags' => array('clever', 'is', 'better', 'clevertech'),
                            'placeholder' => '== บริษัท ==',
                            'width' => '100%',
                        //'tokenSeparators' => array(',', ' ')
                        )
                    ));
                    ?>
                </div>
                <div class="col-lg-5" style=" padding-top: 22px;">
                    <div class="well well-sm" style=" text-align: center;">
                        <input type="radio" id="private" name="private" value="0" checked="checked"/> คลินิกมองเห็น
                        &nbsp;&nbsp;<input type="radio" id="private" name="private" value="1"/> คลินิกมองไม่เห็น
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <label for="textArea">รายละเอียด</label>
                    <textarea id="product_detail" name="product_detail" rows="3" class="form-control" required="required" style="background: #111111 !important;"></textarea>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <label for="textArea">วิธีใช้*</label>
                    <textarea id="product_size" name="product_size" rows="3" class="form-control input-sm" required="required"></textarea>
                </div>
            </div>

            <div class="row" style=" margin-top: 10px;">
                <div class="col-md-5 col-lg-5">
                    <div class="well well-sm" style=" text-align: left;">
                        <input type="radio" id="status" name="status" value="0" checked="checked"/> ผลิต
                        &nbsp;&nbsp;<input type="radio" id="status" name="status" value="1"/> เลิกผลิต
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr style=" margin-top: 0px; padding-top: 0px;"/>
    <div class="row" style=" margin: 0px;">
        <div class="col-md-9 col-lg-9">
            <center><font style=" color: #ff0033; display: none;" id="f_error">กรอกข้อมูลไม่ครบ ..?</font></center>
        </div>
        <div class="col-md-3 col-lg-3">
            <button type="button" class="btn btn-success pull-right" onclick="save_product()" style=" margin-top: 0px;">
                <i class="fa fa-save"></i>
                บันทึกข้อมูล
            </button>
        </div>
    </div>
</div>

<!--
    ##### Model Images #####
-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="popupImages" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="font-18">เลือกรูปภาพ</h4>
            </div>
            <div class="modal-body" style="height: 400px; overflow: auto;">
                <form id="upload" method="post" action="<?= Yii::app()->createUrl('backend/images/miniupload') ?>" enctype="multipart/form-data">
                    <div id="drop">
                        เลือกรูปภาพ<br/>
                        <a class="btn btn-primary"><i class="fa fa-picture-o"></i> Browse</a>
                        <input type="file" name="upl" multiple />
                    </div>

                    <ul style="">
                        <!-- The file uploads will be shown here -->
                    </ul>

                </form>

                <font id="font-16">* อัพโหลดได้ครั้งละไม่เกิน 5 ภาพ,นามสกุลไฟล์ .jpg,ขนาดไม่เกิน 1 MB </font>
                <hr/>
                <div id="load_images"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary" onclick="GetvalImg()">เลือกรูปภาพ</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

    //Modify By Kimniyom
    CKEDITOR.replace('product_detail', {
        image_removeLinkByEmptyURL: true,
        //toolbar: 'mini',
        //extraPlugins: 'image',
        //removeDialogTabs: 'link:upload;image:Upload',
        //filebrowserBrowseUrl: 'imgbrowse/imgbrowse.php',
        //filebrowserUploadUrl: 'ckupload.php',
        toolbar: [
            //{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
            //{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
            //{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
            //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            '/',
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
            //{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
            //{ name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
            '/',
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']}
            //{ name: 'others', items: [ '-' ] },
            //{ name: 'about', items: [ 'About' ] }
        ],
        //uiColor: '#eeeeee',
        //filebrowserBrowseUrl: "<?php //echo Yii::app()->baseUrl;                                                                               ?>/assets/ckeditor/ckfinder/ckfinder.html",
        //filebrowserImageBrowseUrl: "<?php //echo Yii::app()->baseUrl;                                                                               ?>/assets/ckeditor/ckfinder/ckfinder.html?Type=Images",
        //filebrowserFlashBrowseUrl: "<?php //echo Yii::app()->baseUrl;                                                                               ?>/assets/ckeditor/ckfinder/ckfinder.html?Type=Flash",
        //filebrowserUploadUrl: "<?php //echo Yii::app()->baseUrl;                                                                               ?>/assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files",
        //filebrowserImageUploadUrl: "<?php //echo Yii::app()->baseUrl;                                                                               ?>/assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images",
        //filebrowserFlashUploadUrl: "<?php //echo Yii::app()->baseUrl;                                                                               ?>/assets/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash"
    });</script>

<script type="text/javascript">
    checkheight();
    //loadimagesProduct();
    $(document).ready(function() {
        $("#producttype").change(function() {
            var type_id = $("#producttype").val();
            var url = "<?php echo Yii::app()->createUrl('producttype/getsubproduct') ?>";
            var data = {type_id: type_id};
            $.post(url, data, function(datas) {
                $("#boxsubproducttype").html(datas);
            });
        });
    });

    function setcode() {
        var _product_id = $("#_product_id").val();
        $("#product_id").val(_product_id);
    }

    function GetImages() {
        var product_id = $("#product_id").val();
        if (product_id != '') {
            load_data();
            $("#popupImages").modal();
        } else {
            alert("กรุณาใส่รหัสสินค้าก่อนเพิ่มรูปภาพ");
            return false;
        }
    }

    function save_product() {
        var url = "<?php echo Yii::app()->createUrl('centerstockproduct/save_product') ?>";
        var product_name = $("#product_name").val();
        var product_nameclinic = $("#product_nameclinic").val();
        var company = $("#company").val();
        var type_id = $("#producttype").val();
        var subproducttype = $("#subproducttype").val();
        var product_price = $("#product_price").val();
        var product_id = $("#product_id").val();
        var product_detail = CKEDITOR.instances.product_detail.getData();
        var costs = $("#costs").val();
        var unit = $("#unit").val();
        var private = $("input:radio[name=private]:checked").val();
        var status = $("input:radio[name=status]:checked").val();
        var product_size = $("#product_size").val();
        if (subproducttype == '' || product_id == '' || product_name == '' || product_price == '' || unit == '') {
            $("#f_error").show().delay(5000).fadeOut(500);
            return false;
        }

        var data = {
            product_id: product_id,
            product_name: product_name,
            product_nameclinic: product_nameclinic,
            company: company,
            type_id: type_id,
            subproducttype: subproducttype,
            product_price: product_price,
            product_detail: product_detail,
            costs: costs,
            unit: unit,
            private: private,
            status: status,
            product_size: product_size
        };

        $.post(url, data, function(success) {
            window.location = "<?php echo Yii::app()->createUrl('centerstockproduct/detail?product_id=') ?>" + product_id;
        });
    }

    function load_data() {
        $("#load_images").html("<center><i class=\"fa fa-spinner fa-spin\"></i></center>");
        var url = "<?php echo Yii::app()->createUrl('backend/images/loadimages') ?>";
        var data = {};
        $.post(url, data, function(datas) {
            $("#load_images").html(datas);
        });
    }

    function loadimagesProduct() {
        $("#load_images_product").html("<center><i class=\"fa fa-spinner fa-spin\"></i></center>");
        var url = "<?php echo Yii::app()->createUrl('backend/product/get_images') ?>";
        var productID = $("#product_id").val();
        var data = {product_id: productID};
        $.post(url, data, function(datas) {
            $("#load_images_product").html(datas);
            checkheight();
        });
    }

    function delete_images(id) {
        var r = confirm("คุณแน่ใจหรือไม่ ...?");
        var url = "<?php echo Yii::app()->createUrl('centerstockproduct/delete_images') ?>";
        var productID = $("#product_id").val();
        var data = {id: id, product_id: productID};

        if (r == true) {
            $.post(url, data, function(datas) {
                load_data();
                loadimagesProduct();
            });
        }
    }

    function checkheight() {
        var p_left = $("#p-left").height();
        var p_right = $("#p-right").height();
        //alert(p_left + " - " + p_right);
        if (p_left > p_right) {
            $("#p-right").removeClass("p-right");
            $("#p-left").addClass("p-left");
        } else {
            $("#p-left").removeClass("p-left");
            $("#p-right").addClass("p-right");
        }
    }
</script>

<script type="text/javascript">
    Setscreen();
    function Setscreen() {
        var screen = $(window).height();
        var w = window.innerWidth;
        var screenfull = (screen - 170);
        if (w >= 786) {
            $("#p-left").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
            $("#p-right").css({'height': screenfull, 'overflow': 'auto', 'padding-bottom': '25px'});
        } else {
            $("#p-right").css({'border': 'none'});
        }
        //$("#patientbox").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF'});
        //$("#boxorders").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF', 'overflow': 'auto', 'padding-left': '10px'});
    }

</script>
<script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/script.js" type="text/javascript"></script>

