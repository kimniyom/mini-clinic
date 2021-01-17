
<?php
$branchModel = Branch::model()->find("id = '$branch'");
$this->breadcrumbs = array(
    'ข้อมูลสาขา' => Yii::app()->createUrl('branch/index'),
    "LOGO",
    $branchModel['branchname']
);
?>

<div class="well well-sm">
    <h4 style=" font-size: 20px; color: #ff0000;">
        <i class="fa fa-smile-o"></i> จัดการโลโก้ร้าน สาขา <?php echo $branchModel['branchname'] ?>
    </h4>
</div>


        <div class="row" style=" margin: 0px;">
            <div class="col-lg-6">

                <div class="upload">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $logo['logo']; ?>" class="img-resize" style="max-width:80px;"/>
   
                    <form id="upload" method="post" action="<?= Yii::app()->createUrl('backend/logo/saveuploads', array("branch" => $branch)) ?>" enctype="multipart/form-data" style=" background: none;">
                    <div id="drop">
                        เลือกรูปภาพ<br/>
                        <a class="btn btn-primary"><i class="fa fa-picture-o"></i> Browse</a>
                        <input type="file" name="upl" />
                    </div>

                    <ul style="background: #2e3134;">
                        <!-- The file uploads will be shown here -->
    
                    </ul>

                </form>
                </div>
                <ul style=" font-size: 16px; color: #ff3300;">
                        <li>อัพโหลดได้เฉพาะ .jpg , .png</li>
                        <li>อัพโหลดได้ไม่เกินครั้งละ 1MB</li>
                        <li>อัพโหลดได้ไม่เกินครั้งละ 1 ไฟล์</li>
                </ul>
            </div>
        </div>


<?php
if (empty($logo)) {
    echo "<div class='well'><center>ไม่มีข้อมูล</center></div>";
}
?>
</div>

<script type="text/javascript">
       $(function () {

        var ul = $('#upload ul');
        $('#drop a').click(function () {
            // Simulate a click on the file input button
            // to show the file browser dialog
            $(this).parent().find('input').click();
        });

        // Initialize the jQuery File Upload plugin
        $('#upload').fileupload({

            // This element will accept file drag/drop uploading
            dropZone: $('#drop'),

            // This function is called when a file is added to the queue;
            // either via the browse button, or via drag/drop:

            add: function (e, data) {

                var tpl = $('<li class="working"><input type="text" value="0" data-width="36" data-height="36"' +
                        ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

                // Append the file name and file size
                //data.files[0].name
                tpl.find('p').text("")
                        .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

                // Add the HTML to the UL element
                data.context = tpl.appendTo(ul);

                // Initialize the knob plugin
                tpl.find('input').knob();

                // Listen for clicks on the cancel icon
                tpl.find('span').click(function () {

                    if (tpl.hasClass('working')) {
                        jqXHR.abort();
                    }

                    tpl.fadeOut(function () {
                        tpl.remove();
                    });

                });

                //Automatically upload the file once it is added to the queue
                //var jqXHR = data.submit();

                var jqXHR = data.submit()
                        .success(function (result, textStatus, jqXHR) {
                            if (result == "error") {
                                data.context.addClass('error');
                            }

                        })
                        //.error(function (jqXHR, textStatus, errorThrown) {alert(jqXHR); return false;})
                        .complete(function (result, textStatus, jqXHR) {
                            window.location.reload();
                        });
            },

            progress: function (e, data) {
                var type = data.files[0].type;
                var size = data.files[0].size;
                if (size <= "1000000") {
                    // Calculate the completion percentage of the upload
                    var progress = parseInt(data.loaded / data.total * 100, 10);

                    // Update the hidden input field and trigger a change
                    // so that the jQuery knob plugin knows to update the dial
                    data.context.find('input').val(progress).change();

                    if (progress == 100) {
                        data.context.removeClass('working');
                    } else {
                        data.context.addClass('error');
                    }
                } else {
                    data.context.addClass('error');
                }

            },

            fail: function (e, data) {
                // Something has gone wrong!
                data.context.addClass('error');
            }

        });

        // Prevent the default action when a file is dropped on the window
        $(document).on('drop dragover', function (e) {
            e.preventDefault();
        });

        // Helper function that formats the file sizes
        function formatFileSize(bytes) {
            if (typeof bytes !== 'number') {
                return '';
            }

            if (bytes >= 1000000000) {
                return (bytes / 1000000000).toFixed(2) + ' GB';
            }

            if (bytes >= 1000000) {
                return (bytes / 1000000).toFixed(2) + ' MB';
            }

            return (bytes / 1000).toFixed(2) + ' KB';
        }

    });

    function delete_logo(id) {
        var r = confirm("คุณแน่ใจหรือไม่ ...");
        var url = "<?php echo Yii::app()->createUrl('backend/logo/delete') ?>";
        var data = {id: id};
        if (r == true) {
            $.post(url, data, function (success) {
                window.location.reload();
            });
        }
    }
</script>
