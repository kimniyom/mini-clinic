<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
        <link rel="stylesheet" type="text/css" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/template-black.css"/>
        <!--
                <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->baseUrl;       ?>/css/button-color.css"/>
        -->
        <link rel="stylesheet" type="text/css" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/system-black.css"/>
        <!--
                <link rel="stylesheet" href="<?php //echo Yii::app()->baseUrl;        ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
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

        <!-- highcharts -->
        <script src="<?=Yii::app()->baseUrl;?>/lib/Highcharts-5.0.5/code/highcharts.js"></script>
        <script src="<?=Yii::app()->baseUrl;?>/lib/Highcharts-5.0.5/code/themes/gray.js"></script>
        <!--
        <script src="<?//= Yii::app()->baseUrl; ?>/assets/highcharts/themes/dark-unica.js"></script>
        -->
        <script src="<?=Yii::app()->baseUrl;?>/assets/perfect-scrollbar/js/perfect-scrollbar.js"></script>

        <!-- DatePicker -->
        <!--
        <link rel="stylesheet" href="<?php //echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/css/bootstrap-datepicker.css" type="text/css" media="all" />
        <script src="<?php //echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="<?php //echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js" type="text/javascript"></script>
            -->
        <!-- Sweetalert -->
        <!-- FancyBox -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.min.js" type="text/javascript"></script>



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
        <script type = "text/javascript" >
            $(document).ready(function () {
                var user = "<?php echo Yii::app()->user->id ?>";
                if (user == '') {
                    window.location = "<?php echo Yii::app()->createUrl('site/login') ?>";
                }

                //Ps.initialize(document.getElementById('sidebar-wrapper'));
                /*
                 $(document).bind("contextmenu", function (e) {
                 return false;
                 });
                 */
            });

            function chkNumber(ele) {
                var vchar = String.fromCharCode(event.keyCode);
                if ((vchar < '0' || vchar > '9') && (vchar != '.'))
                    return false;
                //ele.onKeyPress = vchar;
            }

            function PopupCenter(url, title) {
                // Fixes dual-screen position
                //                        Most browsers      Firefox
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

    <body style="/*background: url('<?php //echo Yii::app()->baseUrl;        ?>/images/bg_ap.png');*/ /*background: #fbfbfb;*//* background:url('<?//php echo Yii::app()->baseUrl; ?>images/line-bg-advice.png')repeat-x fixed #fdfbfc;*/">
        <!--<div class="container" style="margin-bottom:5%;"> #2a323b-->
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
                                <li style="padding-top:10px;">
                                วันที่ขาย
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
                                    <a href="<?=Yii::app()->createUrl('site/logout/')?>" style=" color: pink;">
                                        <span class="glyphicon glyphicon-off"></span>
                                        <font id="font-th">ออกจากระบบ</font>
                                    </a>
                                </li>
                            </ul>
                        <?php }?>
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>
            <ol class="breadcrumb " style=" margin-bottom: 0px; margin-top: 0px; border-radius: 0px; background: #191919; border-bottom: #191919 solid 1px; box-shadow: #000000 0px 0px 10px 0px;">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink' => CHtml::link('<i class=" glyphicon glyphicon-home"></i> หน้าหลัก', Yii::app()->createUrl('site/index')),
	'links' => $this->breadcrumbs,
));
?><!-- breadcrumbs -->
                <?php endif?>
            </ol>
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
            $("#menu-toggle").click(function (e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            function set_navbar(id) {
                var url = "<?php echo Yii::app()->createUrl('backend/backend/set_navbar') ?>";
                var data = {id: id};
                $.post(url, data, function (success) {
                    //window.location.reload();
                });
            }

            function Checkprivilege() {
                var prilege = "<?php echo Yii::app()->session['branch'] ?>";
                if (prilege == "") {
                    window.location = "<?php echo Yii::app()->createUrl('site/index') ?>";
                }
            }
            /*
             $(function () {
             $(".dropdown").hover(
             function () {
             $('.dropdown-menu', this).stop(true, true).fadeIn("fast");
             $(this).toggleClass('open');
             $('b', this).toggleClass("caret caret-up");
             },
             function () {
             $('.dropdown-menu', this).stop(true, true).fadeOut("fast");
             $(this).toggleClass('open');
             $('b', this).toggleClass("caret caret-up");
             });
             });
             */

            $(document).on('click', '.panel-heading span.clickable', function (e) {
                var $this = $(this);
                if (!$this.hasClass('panel-collapsed')) {
                    $this.parents('.panel').find('.list-group').slideDown();
                    $this.addClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                } else {
                    $this.parents('.panel').find('.list-group').slideUp();
                    $this.removeClass('panel-collapsed');
                    $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                }
            });

            function setactivemenu(id) {
                var url = "<?php echo Yii::app()->createUrl('site/setactivemenu') ?>";
                var data = {menu: id};
                $.post(url, data, function () {

                });
            }

            function setnavbar() {
                var w = window.innerWidth;
                if (w <= 786) {
                    $("#nav-bar").addClass('navbar-fixed-top');
                    $("#nav-head").show();
                    $("#text-head-nav").text("หมอรเมศ");
                }
            }
            //ascrollto();
        </script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.knob.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/mini-upload/js/jquery.fileupload.js" type="text/javascript"></script>
    </body>
</html>
