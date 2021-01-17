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
$Profile = $UserModel->GetProfile();
$web = new Configweb_model();
$branchModel = new Branch();
echo $web->get_webname();
?>
        </title>
        <style type="text/css">
            body{
                overflow-x: hidden;
            }
        </style>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/system.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/themes/backend/bootstrap/css/bootstrap-slate.css" type="text/css" media="all" />


        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/assets/gallery_img/dist/magnific-popup.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/assets/DataTables-1.10.7/media/css/dataTables.bootstrap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/assets/DataTables-1.10.7/extensions/TableTools/css/dataTables.tableTools.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome.css"/>
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome-animation.css"/>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/themes/backend/css/simple-sidebar.css"/>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/assets/perfect-scrollbar/css/perfect-scrollbar.css"/>
        <link rel="stylesheet" href="<?=Yii::app()->baseUrl;?>/css/card-css/card-css.css"/>
        <!-- Bootstrap CheckBox
        <link rel="stylesheet" href="<?//php echo Yii::app()->baseUrl; ?>/css/bootstrap-checkbox/awesome-bootstrap-checkbox.css" type="text/css" media="all" />
        -->
        <!--
        <script src="<?//= Yii::app()->baseUrl; ?>/themes/backend/js/jquery-1.9.1.js" type="text/javascript"></script>
        <script src="<?//= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        -->
        <!-- Magnific Popup core CSS file -->
        <script type="text/javascript" charset="utf-8"src="<?=Yii::app()->baseUrl;?>/assets/gallery_img/dist/jquery.magnific-popup.js"></script>
        <!-- Data table  -->
        <script type="text/javascript" charset="utf-8"src="<?=Yii::app()->baseUrl;?>/assets/DataTables-1.10.7/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8"src="<?=Yii::app()->baseUrl;?>/assets/DataTables-1.10.7/media/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" charset="utf-8"src="<?=Yii::app()->baseUrl;?>/assets/DataTables-1.10.7/extensions/TableTools/js/dataTables.tableTools.js"></script>
        <!-- highcharts -->
        <script src="<?=Yii::app()->baseUrl;?>/assets/highcharts/highcharts.js"></script>
        <!--
        <script src="<?//= Yii::app()->baseUrl; ?>/assets/highcharts/themes/dark-unica.js"></script>
        -->
        <script src="<?=Yii::app()->baseUrl;?>/assets/perfect-scrollbar/js/perfect-scrollbar.js"></script>

        <!-- Uploadify -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/lib/uploadify/uploadify.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/uploadify/jquery.uploadify.js" type="text/javascript"></script>

        <script type="text/javascript">

            $(document).ready(function () {
                Ps.initialize(document.getElementById('sidebar-wrapper'));
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
                var h = 600;
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

    <body style="/*background:url('<?//php echo Yii::app()->baseUrl; ?>images/line-bg-advice.png')repeat-x fixed #fdfbfc;*/">
        <!--<div class="container" style="margin-bottom:5%;">-->
        <nav class="navbar navbar-default" role="navigation" style="z-index:1; border-radius:0px; margin-bottom:0px;"></nav>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="border-radius:0px; margin-bottom:0px; background: #2a323b;;">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#menu-toggle" class="navbar-brand" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <a class="navbar-brand" style=" margin-top: 0px; padding-top: 10px;">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $web->get_logoweb(); ?>" height="24px"/>
                    </a>
                    <a class="navbar-brand" href="#" style=" font-family: Th;font-size:28px;">
                        <?php echo $web->get_webname(); ?>(Admin)
                    </a>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li <?php
if (Yii::app()->session['navmenu'] == '1') {
	echo "class='active'";
}
?> onclick="set_navbar('1')">
                            <a href="<?php echo Yii::app()->createUrl('backend/backend') ?>">
                                <span class="glyphicon glyphicon-home"></span>
                                <font id="font-th">หน้าหลัก</font></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-signal"></span>
                                <font id="font-th">รายงาน </font><b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"> - รายงานยอดขาย</a></li>
                                <li><a href="#"> - รายงานการขายสินค้า</a></li>
                                <li><a href="#"> - รายงานการขายสินค้า(แยกประเภท)</a></li>
                                <li><a href="#"> - รายงานรายได้ กำไร ขาดทุน</a></li>
                                <li><a href="#"> - รายงานการขายของพนักงาน</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="fa fa-gear"></span>
                                <font id="font-th">ตั้งค่าระบบ </font><b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo Yii::app()->createUrl('backend/typeproduct/from_add_type') ?>"> - ประเภทสินค้า</a></li>
                                <li><a href="<?php echo Yii::app()->createUrl('diag/index') ?>"> - หัตถการทางการแพทย์</a></li>
                                <li><a href="<?php echo Yii::app()->createUrl('occupation/index') ?>"> - อาชีพ</a></li>
                            </ul>
                        </li>

                        <li <?php
if (Yii::app()->session['navmenu'] == '2') {
	echo "class='active'";
}
?> onclick="set_navbar('2')">
                            <a href="#">
                                <span class="glyphicon glyphicon-book"></span>
                                <font id="font-th">คู่มือการใช้งาน</font></a>
                        </li>
                    </ul>
                    <?php if (!Yii::app()->user->isGuest) {?>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="<?=Yii::app()->createUrl('site/logout/')?>">
                                    <span class="glyphicon glyphicon-off"></span>
                                    <font id="font-th">ออกจากระบบ</font>
                                </a>
                            </li>
                        </ul>
                    <?php }?>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>

        <div id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper">
                <!-- ###################### USER #################-->
                <div class="panel panel-default" id="panel-head">
                    <div class=" panel-heading" id="panel">
                        <img src="<?=Yii::app()->baseUrl;?>/images/use-icon.png" style="border-radius:20px; padding:2px; border:#FFF solid 2px;"> ผู้ใช้งาน
                    </div>
                    <div class="panel-body">
                        User : <?php echo Yii::app()->user->name ?><br>
                        สถานะ : <?php echo Yii::app()->session['status'] . ' (' . $Profile['status'] . ')'; ?><br/>
                        สาขา ​: <?php echo Yii::app()->session['branch'] . " " . $branchModel->Getbranch(Yii::app()->session['branch']) ?>
                    </div>
                    <div class="panel-footer" style="border-bottom:solid 1px #eeeeee; border-radius:0px;">
                        <a href="<?=Yii::app()->createUrl('employee/view', array('id' => $Profile['id']));?>">ข้อมูลส่วนตัว</a>
                    </div>
                </div>
                <!-- ส่วนของ ผู้ดูแลระบบ -->

                <!-- ตั้งค่าร้านค้า -->
                <?php if (Yii::app()->session['status'] == '1') {?>
                    <a href="<?php echo Yii::app()->createUrl('branch/index') ?>">
                        <div id="listmenu">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/clinic-icon.png"
                                 height="32px"
                                 style="border-radius:20px; padding:2px; border:#FFF solid 2px; background: #FFFFFF;"/>
                            ข้อมูลสาขา
                        </div>
                    </a>
                <?php }?>
                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/Login-icon.png"
                             height="32px"
                             style="border-radius:20px; padding:2px; border:#FFF solid 2px;"/>
                        ผู้ใช้งานระบบ
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <?php if (Yii::app()->session['status'] == '1') {?>
                            <a href="<?=Yii::app()->createUrl('statusUser/index')?>" class="list-group-item">
                                <i class="fa fa-user"></i> สถานะ
                            </a>
                        <?php }?>
                        <a href="<?=Yii::app()->createUrl('Masuser/index')?>" class="list-group-item">
                            <i class="fa fa-user"></i> รายชื่อผู้ใช้งาน
                        </a>

                    </div>
                </div>

                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/users-icon.png"
                             height="32px"
                             style="border-radius:20px; padding:2px; border:#FFF solid 2px;"/>
                        ข้อมูลพนักงาน
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <?php if (Yii::app()->session['status'] == '1') {?>
                            <a href="<?=Yii::app()->createUrl('position/index')?>" class="list-group-item">
                                <i class="fa fa-user"></i> ตำแหน่งพนักงาน
                            </a>
                        <?php }?>
                        <a href="<?=Yii::app()->createUrl('employee/index')?>" class="list-group-item">
                            <i class="fa fa-group"></i> รายชื่อพนักงาน
                        </a>
                    </div>
                </div>
                <!-- ตั้งค่าร้านค้า -->
                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $web->get_logoweb(); ?>"
                             height="32px"
                             style="border-radius:20px; padding:2px; border:#FFF solid 2px;"/>
                        ข้อมูลร้านค้า
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <a href="<?=Yii::app()->createUrl('backend/contact')?>" class="list-group-item">
                            <i class="fa fa-phone-square"></i> ข้อมูลติดต่อ
                        </a>
                        <!--
                        <a href="<?//= Yii::app()->createUrl('backend/about') ?>" class="list-group-item">
                            <i class="fa fa-user-secret"></i> เกี่ยวกับเรา
                        </a>
                        <a href="<?//= Yii::app()->createUrl('backend/banner') ?>" class="list-group-item">
                            <i class="fa fa-image"></i>  จัดการภาพ Banner
                        </a>
                        -->
                        <a href="<?=Yii::app()->createUrl('backend/logo')?>" class="list-group-item">
                            <i class="fa fa-smile-o"></i>  จัดการ โลโก้ เว็บ
                        </a>
                        <a href="<?=Yii::app()->createUrl('backend/web')?>" class="list-group-item">
                            <i class="fa fa-text-height"></i>  จัดการ ชื่อเว็บ
                        </a>
                        <!--
                        <a href="<?//= Yii::app()->createUrl('backend/howtoorder') ?>" class="list-group-item">
                            <i class="fa fa-book"></i>  วิธีการสั่งซื้อ
                        </a>
                        -->
                    </div>
                </div>
                <!-- List Menu Admin-->
                <!--
                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?//= Yii::app()->baseUrl; ?>/images/system-icon.png" style="border-radius:20px; padding:2px; border:#FFF solid 2px;">
                        ตั้งค่าระบบ
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <a href="<?//= Yii::app()->createUrl('backend/typeproduct/from_add_type') ?>"
                           class="list-group-item"><i class="fa fa-folder-open"></i> ประเภทสินค้า</a>
                        <a href="<?//= Yii::app()->createUrl('diag/index') ?>"
                           class="list-group-item"><span class="fa fa-dot-circle-o"></span>  รายการหัตถการ</a>
                        <a href="<?//= Yii::app()->createUrl('occupation/index') ?>"
                           class="list-group-item"><span class="fa fa-calendar"></span>  อาชีพ</a>
                        <a href="<?//= Yii::app()->createUrl('backend/transport') ?>"
                           class="list-group-item"><span class="fa fa-truck"></span>  ช่องทางการจัดส่ง</a>
                    </div>
                </div>
                -->
                <!-- List รายชื่อ สินค้า -->
                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?=Yii::app()->baseUrl;?>/images/shipping-box-icon.png" style="border-radius:20px; padding:2px; border:#FFF solid 2px;">
                        คลังสินค้า
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <?php
$produce_type = $product_model->_get_product_type();
foreach ($produce_type as $produce_types):
?>
                            <a href="<?php echo Yii::app()->createUrl('backend/product/Getproduct/type_id/' . $produce_types['type_id']) ?>"
                               class="list-group-item">
                                <span class="label" style=" background: #24282d;"><?php echo $product_model->get_count_product_type($produce_types['type_id']); ?></span>
                                <?php echo $produce_types['type_name']; ?>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>

                <!-- ทะเบียนผู้ป่วย-->
                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?=Yii::app()->baseUrl;?>/images/patients-icon.png" style="border-radius:20px; padding:2px; border:#FFF solid 2px;">
                        ทะเบียนลูกค้า
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <a href="<?=Yii::app()->createUrl('gradcustomer/index')?>"
                           class="list-group-item"><i class="fa fa-group"></i> ประเภทลูกค้า</a>
                        <a href="<?=Yii::app()->createUrl('patient/index')?>"
                           class="list-group-item"><i class="fa fa-plus"></i> เพิ่มทะเบียนลูกค้า</a>
                        <a href="<?=Yii::app()->createUrl('backend/product/index')?>"
                           class="list-group-item"><i class="fa fa-search"></i> ค้นหาลูกค้า</a>
                    </div>
                </div>

                <!-- บทความ -->
                <!--
                <div class="panel panel-default" id="panel-head">
                    <div class="panel-heading" id="panel">
                        <img src="<?//= Yii::app()->baseUrl; ?>/images/blog-icon.png" style="border-radius:20px; padding:2px; border:#FFF solid 2px; width: 32px;">
                        บทความ
                        <span class="pull-right clickable"><i class="glyphicon glyphicon-chevron-down"></i></span>
                    </div>
                    <div class="list-group">
                        <a href="<?//php echo Yii::app()->createUrl('backend/article/create') ?>" class="list-group-item">
                            <i class="fa fa-plus"></i> สร้างบทความ
                        </a>
                    </div>
                    <div class="list-group">
                        <a href="<?//php echo Yii::app()->createUrl('backend/article') ?>" class="list-group-item">
                            <i class="fa fa-newspaper-o"></i> บทความทั้งหมด
                        </a>
                    </div>
                </div>

                <br/><br/>
                -->
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper" style="padding:0px;">
                <nav class="navbar navbar-default" role="navigation" style="margin-bottom:10px; border-radius: 0px; padding-top: 3px;">
                    <ul class="nav nav-pills pull-right" style="margin:5px;">
                        <?php if ($product_model->stockproductalert() > 0) {
	$classalertproduct = "fa fa-bell faa-flash animated faa-slow text-danger";
} else {
	$classalertproduct = "fa fa-bell";
}
?>
                        <?php if ($product_model->stockitemalert() > 0) {
	$classalertitem = "fa fa-bell faa-flash animated text-danger";
} else {
	$classalertitem = "fa fa-bell";
}
?>
                        <li><a href="<?php echo Yii::app()->createUrl('backend/stock/expireproduct') ?>"><i class="<?php echo $classalertproduct ?>"></i> สินค้าใกล้หมด <span class="badge"><?php echo $product_model->stockproductalert(); ?> </span></a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('backend/stock/expireitem') ?>"><i class="<?php echo $classalertitem ?>"></i> สินค้าใกล้หมดอายุ <span class="badge"><?php echo $product_model->stockitemalert(); ?> </span></a></li>
                        <li><a href="#"><i class="fa fa-calendar text-success"></i> ลูกค้าใกล้ถึงวันนัด <span class="badge"><?php echo $order_model->count_wait_inform(); ?> </span></a></li>
                    </ul>
                </nav>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">

                            <ol class="breadcrumb well well-sm" style=" margin-bottom: 10px; margin-top: 0px; border-radius: 0px;">

                                <?php if (isset($this->breadcrumbs)): ?>
                                    <?php
$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink' => CHtml::link('<i class=" glyphicon glyphicon-home"></i> หน้าหลัก', Yii::app()->createUrl('backend/backend')),
	'links' => $this->breadcrumbs,
));
?><!-- breadcrumbs -->
                                <?php endif?>
                            </ol>
                            <?php
echo $content;
?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- popup -->
        <div id="overlay_popup">
            <center>
                <div id="show_slip"></div><br/>
            </center>
        </div>

        <!-- Menu Toggle Script -->
        <script>
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
        </script>
    </body>
</html>
