<?php
    $config = new Configweb_model();
?>
<script type="text/javascript">
                    reloadseqemployee();
                    var socket = io.connect('<?php echo $config->LinkNode() ?>');

                    function reloadclient() {
                        nodeloadtable();
                    }

                    function reloadseqemployee() {
                        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
                        var id = "seqemployeeramet";
                        var data = {
                            a: 1
                        };
                        $.post(url, data, function(datas) {
                            socket.emit(id, datas);
                        });
                    }

                    function nodeloadtable() {
                        var url = "<?php echo Yii::app()->createUrl('queue/getdata') ?>";
                        var id = "seqemployeeramet";
                        var data = {
                            a: 1
                        };
                        $.post(url, data, function(datas) {
                            socket.emit(id, datas);
                            ReautoloadseqDoctor();
                            loadservicesuccess();
                        });
                    }

                    function ReautoloadseqDoctor() {
                        var url = "<?php echo Yii::app()->createUrl('queue/seqdoctor') ?>";
                        var id = "seqemployeedoctorramet";
                        var data = {
                            a: 1
                        };
                        $.post(url, data, function(datas) {
                            //$("#resultservice").html(datas);
                            socket.emit(id, datas, function(success) {
                                if (success == true) {
                                    loadservicesuccess();
                                }
                            });

                            //window.close();
                        });
                    }


                    //สั่งหน้าจอ seqemployee ทำงาน ในส่งน function loadservicesuccess
                    function loadservicesuccess() {
                        var url = "<?php echo Yii::app()->createUrl('queue/getservicesuccess') ?>";
                        var data = {
                            a: 1
                        };
                        var id = "seqsuccessramet";
                        $.post(url, data, function(datas) {
                            alert('success');
                            //$("#servicesuccess").html(datas);
                            socket.emit(id, datas, function(success) {
                                if (success == true) {
                                    closewindow();
                                }
                                //console.log(success);
                                //$("#btn-confirm").hide();
                                //$("#btn-close").show();
                            });

                            //closewindow();
                        });
                    }

                    function closewindow() {
                        window.close();
                    }

    </script>