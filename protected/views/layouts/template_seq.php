<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="description" content="">
        <meta name="author" content="">
        <title>
            <?php
$product_model = new Backend_product();
$order_model = new Backend_orders();
$UserModel = new Masuser();
$MenuReport = new MenuReport();
$MenuSetting = new MenuSetting();
$MenuModel = new Menu();
$AppointModel = new Appoint();
$Profile = $UserModel->GetProfile();
$web = new Configweb_model();
$branchModel = new Branch();
$alet = new Alert();
$Report = new Report();
$ChartModel = new Chart();
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

            .modal .mainmenu {
                width: 100%;
                margin:auto;
            }

        </style>
        <link rel="stylesheet" type="text/css" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/template-black.css"/>
        <!--
                <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->baseUrl;                                         ?>/css/button-color.css"/>
        -->
        <link rel="stylesheet" type="text/css" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/system-black.css"/>
        <!--
                <link rel="stylesheet" href="<?php //echo Yii::app()->baseUrl;                                          ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        -->
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/themes/backend/bootstrap/css/bootstrap-cyborg.css" type="text/css" media="all" />

        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/assets/gallery_img/dist/magnific-popup.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/media/css/dataTables.bootstrap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/Buttons/css/buttons.dataTables.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/Buttons/css/buttons.bootstrap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/FixedColumns/css/fixedColumns.bootstrap.css" type="text/css" media="all" />

        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome.css"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome-animation.css"/>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/simple-sidebar-black.css"/>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/assets/perfect-scrollbar/css/perfect-scrollbar.css"/>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/css/card-css/card-css.css"/>

        <!-- Bootstrap CheckBox
        <link rel="stylesheet" href="<?//php echo Yii::app()->baseUrl; ?>/css/bootstrap-checkbox/awesome-bootstrap-checkbox.css" type="text/css" media="all" />
        -->
        <!--

        <script src="<?//= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        -->
        <!-- Magnific Popup core CSS file -->
        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/assets/gallery_img/dist/jquery.magnific-popup.js"></script>
        <!-- Data table  -->
        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/media/js/dataTables.bootstrap.js"></script>

        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/jszip.min.js"></script>
        <script type="text/javascript" charset="utf-8"src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8"src="<?=Yii::app()->baseUrl;?>/lib/DataTables-1.10.13/extensions/Scroller/js/dataTables.scroller.min.js"></script>

        <!-- highcharts -->
        <script src="<?=Yii::app()->baseUrl;?>/lib/Highcharts-5.0.5/code/highcharts.js"></script>
        <script src="<?=Yii::app()->baseUrl;?>/lib/Highcharts-5.0.5/code/themes/grid-light.js"></script>
        <!--
        <script src="<?//= Yii::app()->baseUrl; ?>/assets/highcharts/themes/dark-unica.js"></script>
        -->
        <script src="<?=Yii::app()->baseUrl;?>/assets/perfect-scrollbar/js/perfect-scrollbar.js"></script>

        <!-- DatePicker -->
        <!--
        <link rel="stylesheet" href="<?//php echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/css/bootstrap-datepicker.css" type="text/css" media="all" />
        <script src="<?//php echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="<?//php echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js" type="text/javascript"></script>-->

        <!-- Sweetalert -->
        <!-- FancyBox -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

        <!-- Uploadify
        <link rel="stylesheet" href="<?php //echo Yii::app()->baseUrl;                                      ?>/lib/uploadify/uploadify.css" type="text/css" media="all" />
        <script src="<?php //echo Yii::app()->baseUrl;                                      ?>/lib/uploadify/jquery.uploadify.js" type="text/javascript"></script>
        -->
        <!--
            SELECT2 Combobox
        -->
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/select2-master/dist/css/select2.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/select2-bootstrap-theme-master/dist/select2-bootstrap.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/select2-master/dist/js/select2.js" type="text/javascript"></script>

        <!--
            Notify
        -->
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/css/animate.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/notify/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>

        <!-- Camera -->
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/php-webcamera/scripts/webcam.js" type="text/javascript"></script>

        <!-- MiniUploads -->
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/lib/mini-upload/css/style.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/node_modules/socket.io-client/dist/socket.io.js"></script>


    </head>

    <body style="background:#191919">
<?php echo $content; ?>

        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.knob.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.fileupload.js" type="text/javascript"></script>


    </body>
</html>
