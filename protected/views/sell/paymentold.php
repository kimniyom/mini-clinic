<label>บัญชี</label>
<div class="row" style="margin:0px;">
    <div class="col-md-4 col-lg-4" style="padding-left:0px;">
        <select id="account" class="form-control" onchange="getpremise()">
            <option value="">== เลือกบัญชี ==</option>
            <?php foreach ($banklist as $rs): ?>
                <option value="<?php echo $rs['accountnumber'] ?>"><?php echo $rs['accountnumber'] . ' ' . $rs['bankname'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<div id="box-slip" style="display:none;">
    <form id="upload" method="post" action="<?php echo Yii::app()->createUrl('sell/uploadtmpslip', array('sell_id' => $sell_id)) ?>" enctype="multipart/form-data" style=" margin-top: 10px;">
        <div id="drop">
            หลักฐานการโอนเงิน<br/>
            <a class="btn btn-primary"><i class="fa fa-picture-o"></i> Browse</a>
            <input type="file" name="upl" />
        </div>

        <ul style="">
            <!-- The file uploads will be shown here -->
        </ul>
    </form>
</div>
<!--
<button type="button" class="btn btn-success btn-lg btn-block" style=" margin-top: 10px;" onclick="Check_bill_transfer()"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
-->
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
                            //window.location.reload();
                            loadtmpslip();
                        });
            },

            progress: function (e, data) {
                var type = data.files[0].type;
                var size = data.files[0].size;

                if (type == "image/jpeg" && size <= "1000000") {
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

    function loadtmpslip() {
        var url = "<?php echo Yii::app()->createUrl('sell/loadtmpslip') ?>";
        var sell_id = "<?php echo $sell_id ?>";
        var data = {sell_id: sell_id};
        $.post(url, data, function (datas) {
            $("#box-slip").html(datas);
        });
    }
    
    function getpremise(){
        /*
        var account = $("#account").val();
        if(account == ""){
            $("#box-slip").hide();
        } else {
            $("#box-slip").show();
        }
        */
    }

    //ชำระเงิน
    function Check_bill_transfer() {
        var totalfinal = parseInt($("#_totalfinal").val());
        var income = parseInt($("#income").val());
        var account = $("#account").val();
        if(account == ""){
            swal("แจ้งเตือน!", "ยังไม่เลือกบัญชี ...!", "warning");
            return false;
        }
        if (totalfinal <= 0) {
            swal("แจ้งเตือน!", "ยังไม่มีรายการสินค้า ...!", "warning");
            $("#income").focus();
            return false;
        }

        /*
        if (isNaN(income) || income <= 0) {
            swal("แจ้งเตือน!", "ยังไม่ได้ใส่จำนวนโอน ...!", "warning");
            $("#income").focus();
            return false;
        }

        if (income < totalfinal) {
            swal("แจ้งเตือน!", "ไม่พอจ่ายค่าสินค้า ...!", "warning");
            $("#income").focus();
            return false;
        }
        */
        
        confirmOrder();

    }

    function confirmOrder() {
        var url = "<?php echo Yii::app()->createUrl('sell/logselltransfer') ?>";
        var typebuy = $('input[name=typebuy]:checked').val();
        var itemcode = $("#itemcode").val();
        var sellcode = $("#sellcode").val();
        var branch = $("#branch").val();
        var pid = $("#pid").val();
        var total = $("#_total").val();
        var income = $("#income").val();
        var totalfinal = $("#_totalfinal").val();
        var account = $("#account").val();
        var employee = $("#employee").val();
        var data = {
            itemcode: itemcode,
            sellcode: sellcode,
            pid: pid,
            branch: branch,
            total: total,
            income: income,
            totalfinal: totalfinal,
            typebuy: typebuy,
            account: account,
            employee: employee
        };
        $.post(url, data, function (datas) {
            swal("success", "บันทึกรายการแล้ว", "success");
            window.location.reload();
        });
    }
</script>
