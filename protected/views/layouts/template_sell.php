<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="">
        <meta name="author" content="">
        <title>
            <?php
            $web = new Configweb_model();
            echo $web->get_webname();
            ?>
        </title>
        <style type="text/css">
            body{
                overflow-x: hidden;
            }

            body table tbody tr td{
                /*color: #ff9900;*/
            }

            body table tbody tr td a{
                color: #ff9900;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/template-black.css"/>
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/system-black.css"/>
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap-cyborg.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome.css"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome-animation.css"/>

        <script src="<?= Yii::app()->baseUrl; ?>/assets/perfect-scrollbar/js/perfect-scrollbar.js"></script>

        <!-- Sweetalert -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

        <!--SELECT2 Combobox-->
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/select2-master/dist/css/select2.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/select2-bootstrap-theme-master/dist/select2-bootstrap.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/select2-master/dist/js/select2.js" type="text/javascript"></script>

        <!-- Notify-->
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/css/animate.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/notify/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>

        <script type = "text/javascript" >
            $(document).ready(function() {
                var user = "<?php echo Yii::app()->user->id ?>";
                if (user == '') {
                    window.location = "<?php echo Yii::app()->createUrl('site/login') ?>";
                }
            });

            function chkNumber(ele) {
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar < '0' || vchar > '9') && (vchar != '.'))
                    return false;
                //ele.onKeyPress = vchar;
            }

            function PopupCenter(url, title) {
                var w = 1000;
                var h = 760;
                var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
                var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

                var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
                var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

                var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                var top = ((height / 2) - (h / 2)) + dualScreenTop;
                var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

                // Puts focus on the newWindow
                if (window.focus) {
                    newWindow.focus();
                }
            }

        </script>
    </head>

    <body>
        <nav class="navbar navbar-default" role="navigation" id="nav-head" style=" display: none; margin-bottom: 0px;"></nav>
        <!-- Page Content -->
        <div id="page-content-wrapper" style="padding:0px;">
            <nav class="navbar navbar-inverse" role="navigation" id="nav-bar">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="<?php echo Yii::app()->createUrl('site/index') ?>" class="navbar-brand"><i class="fa fa-chevron-left"></i> menu</a>

                        <a class="navbar-brand" href="#" id="text-head-nav" style=" font-family: Th;font-size:28px; color: pink;">
                            (ขายหน้าร้าน)
                        </a>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse">
                        <?php if (!Yii::app()->user->isGuest) {
                            ?>
                            <ul class="nav navbar-nav navbar-right">
                                <li style="padding-top:20px; margin-right: 10px;">วันที่ขาย</li>
                                <li style="padding-top:10px;">

                                    <?php
                                    $this->widget('booster.widgets.TbDatePicker', array(
                                        //'model' => $model,
                                        //'attribute' => 'birth',
                                        'value' => date("Y-m-d"),
                                        'id' => 'datesell',
                                        'name' => 'datesell',
                                        'options' => array(
                                            'language' => 'th',
                                            'type' => 'date',
                                            'format' => 'yyyy-mm-dd',
                                            'autoclose' => true,
                                        ),
                                            )
                                    );
                                    ?>
                                </li>
                                <li>
                                    <a href="#" style=" color: pink;"><font id="font-th"><i class="fa fa-calendar-o"></i> วันที่ : <?php echo $web->thaidate(date("Y-m-d")) ?></font></a>
                                </li>
                                <li>
                                    <a href="<?= Yii::app()->createUrl('site/logout/') ?>" style=" color: pink;">
                                        <span class="glyphicon glyphicon-off"></span>
                                        <font id="font-th">ออกจากระบบ</font>
                                    </a>
                                </li>
                            </ul>
                        <?php } ?>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>

            <div class="container-fluid" style="padding: 0px; padding-bottom: 0px;">
                <div class="row" style="margin: 5px 0px 0px 0px;">
                    <div class="col-lg-12" style=" padding-left: 5px; padding-right: 5px;"><?php echo $content; ?></div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

        <!-- Menu Toggle Script -->
        <script type="text/javascript">
            setnavbar();
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            function setnavbar() {
                var w = window.innerWidth;
                if (w <= 786) {
                    $("#nav-bar").addClass('navbar-fixed-top');
                    $("#nav-head").show();
                    $("#text-head-nav").text("คลินิก");
                }
            }
            //ascrollto();

            $(document).ready(function() {
                $("#datesell").removeClass('ct-form-control');
                $("#datesell").addClass('form-control');
            });
        </script>

    </body>
</html>
