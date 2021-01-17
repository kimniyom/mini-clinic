<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/assets/ckeditor/ckfinder/ckfinder.js"></script>

<?php
$title = "สร้างฟอร์ม";
$this->breadcrumbs = array(
    $title,
);

$web = new Configweb_model();
?>

<div class="wells" style="width:100%; margin-bottom: 10px;">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <label for="textArea">ใบรับรองแพทย์</label>
            <textarea id="form_confirm" name="form_confirm" rows="20" class="form-control"><?php echo $form['form_confirm'] ?></textarea>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <label for="textArea">ใบส่งตัว</label>
            <textarea id="form_refer" name="form_refer" rows="20" class="form-control"><?php echo $form['form_refer'] ?></textarea>
        </div>
    </div>
    <div class="row" style=" margin-top: 10px;">
        <div class="col-md-3 col-lg-3">
            <button type="button" class="btn btn-success" onclick="save()" style=" margin-top: 0px;">
                <i class="fa fa-save"></i>
                บันทึกข้อมูล
            </button>
        </div>
    </div>
</div>

<script>
    //Modify By Kimniyom
    CKEDITOR.replace('form_confirm', {
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
        uiColor: '#eeeeee'
    });

    CKEDITOR.replace('form_refer', {
        image_removeLinkByEmptyURL: true,
        toolbar: [
            '/',
            {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat']},
            {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
            '/',
            {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
            {name: 'colors', items: ['TextColor', 'BGColor']},
            {name: 'tools', items: ['Maximize', 'ShowBlocks']}
        ],
        uiColor: '#eeeeee'
    });
</script>

<script type="text/javascript">
    function save() {
        var url = "<?php echo Yii::app()->createUrl('site/saveform') ?>";
        var form_confirm = CKEDITOR.instances.form_confirm.getData();
        var form_refer = CKEDITOR.instances.form_refer.getData();
        var data = {
            form_confirm: form_confirm,
            form_refer: form_refer
        };

        $.post(url, data, function(success) {

        });
    }

</script>
