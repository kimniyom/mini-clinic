<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
        $product_model = new Backend_product();
        $order_model = new Backend_orders();
        $UserModel = new Masuser();
        $MenuReport = new MenuReport();
        $MenuSetting = new MenuSetting();
        $MenuModel = new Menu();
        $AppointModel = new Appoint();
        $Profile = $UserModel->GetProfile();
        $branchModel = new Branch();
        $alet = new Alert();
        $Report = new Report();
        $ChartModel = new Chart();
        $web = new Configweb_model();
        ?>
        <title><?php echo $web->get_webname(); ?></title>

        <style type="text/css">
            body {
                overflow-x: hidden;
            }

            body table tbody tr td {
                /*color: #ff9900;*/
            }

            body table tbody tr td a {
                color: #ff9900;
            }

            .modal .mainmenu {
                width: 100%;
                margin: auto;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/template-black.css" />
        <!--
                    <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->baseUrl;                                                                                                    ?>/css/button-color.css"/>
        -->
        <link rel="stylesheet" type="text/css" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/system-black.css" />
        <!--
                    <link rel="stylesheet" href="<?php //echo Yii::app()->baseUrl;                                                                                                     ?>/themes/backend/bootstrap/css/bootstrap.css" type="text/css" media="all" />
        -->
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap-cyborg.css"
              type="text/css" media="all" />

        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/assets/gallery_img/dist/magnific-popup.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/media/css/dataTables.bootstrap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/Buttons/css/buttons.dataTables.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/Buttons/css/buttons.bootstrap.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/FixedColumns/css/fixedColumns.bootstrap.css"  type="text/css" media="all" />

        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome-4.3.0/css/font-awesome-animation.css" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/themes/backend/css/simple-sidebar-black.css" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/assets/perfect-scrollbar/css/perfect-scrollbar.css" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/css/card-css/card-css.css" />

        <!-- Bootstrap CheckBox
            <link rel="stylesheet" href="<?//php echo Yii::app()->baseUrl; ?>/css/bootstrap-checkbox/awesome-bootstrap-checkbox.css" type="text/css" media="all" />
        -->
        <!--
            <script src="<?//= Yii::app()->baseUrl; ?>/themes/backend/bootstrap/js/bootstrap.js" type="text/javascript"></script>
        -->
        <!-- Magnific Popup core CSS file -->
        <script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/assets/gallery_img/dist/jquery.magnific-popup.js"></script>
        <!-- Data table  -->
        <script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8"  src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/media/js/dataTables.bootstrap.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf-8"  src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/buttons.print.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/jszip.min.js"></script>
        <script type="text/javascript" charset="utf-8" src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8"  src="<?= Yii::app()->baseUrl; ?>/lib/DataTables-1.10.13/extensions/Scroller/js/dataTables.scroller.min.js"></script>

        <!-- highcharts -->
        <script src="<?= Yii::app()->baseUrl; ?>/lib/Highcharts-5.0.5/code/highcharts.js"></script>
        <script src="<?= Yii::app()->baseUrl; ?>/lib/Highcharts-5.0.5/code/themes/grid-light.js"></script>
        <script src="<?= Yii::app()->baseUrl; ?>/assets/perfect-scrollbar/js/perfect-scrollbar.js"></script>

        <!-- DatePicker -->
        <!--
            <link rel="stylesheet" href="<?//php echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/css/bootstrap-datepicker.css" type="text/css" media="all" />
            <script src="<?//php echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
            <script src="<?//php echo Yii::app()->baseUrl; ?>/lib/bootstrap-datepicker/locales/bootstrap-datepicker.th.min.js" type="text/javascript"></script>-->

        <!-- Sweetalert -->
        <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/sweet-alert/sweetalert.min.js" type="text/javascript"></script>

        <!-- SELECT2 Combobox -->
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/select2-master/dist/css/select2.css" type="text/css" media="all" />
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/select2-bootstrap-theme-master/dist/select2-bootstrap.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/select2-master/dist/js/select2.js" type="text/javascript"></script>

        <!--  Notify-->
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/css/animate.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/notify/bootstrap-notify/bootstrap-notify.js" type="text/javascript"></script>

        <!-- Camera
        <script src="<?php //echo Yii::app()->baseUrl;     ?>/lib/php-webcamera/scripts/webcam.js" type="text/javascript"></script>
        -->
        <!-- MiniUploads -->
        <link rel="stylesheet" href="<?= Yii::app()->baseUrl; ?>/lib/mini-upload/css/style.css" type="text/css" media="all" />
        <script src="<?php echo Yii::app()->baseUrl; ?>/lib/node_modules/socket.io-client/dist/socket.io.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var user = "<?php echo Yii::app()->user->id ?>";
                if (user == '') {
                    window.location = "<?php echo Yii::app()->createUrl('site/login') ?>";
                }

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
                var h = 760;
                var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
                var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

                var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document
                        .documentElement.clientWidth : screen.width;
                var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document
                        .documentElement.clientHeight : screen.height;

                var left = ((width / 2) - (w / 2)) + dualScreenLeft;
                var top = ((height / 2) - (h / 2)) + dualScreenTop;
                var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top +
                        ', left=' + left);

                // Puts focus on the newWindow
                if (window.focus) {
                    newWindow.focus();
                }
            }

            function ascrollto() {
                var MenuID = "<?php echo Yii::app()->session['leftmenu'] ?>";
                if (MenuID != null) {
                    var p = $('#' + MenuID);
                    var offsets = p.offset();
                    if (offsets.top > 500) {
                        var etop = $('#' + MenuID).offset().top;
                        $('#wrapper,#sidebar-wrapper,#m-left').animate({
                            scrollTop: etop
                        }, 1000);
                    }
                }

            }
        </script>

    </head>

    <body style="background:#191919; ">
        <nav class="navbar navbar-default" role="navigation" id="nav-head" style=" display: none; margin-bottom: 0px;">
        </nav>
        <div id="wrapper">
            <!-- Sidebar -->
            <div id="sidebar-wrapper" style=" margin-bottom: 0px; padding-bottom: 0px; box-shadow: none;background: url('<?php echo Yii::app()->baseUrl ?>/images/bg-black.gif');">
                <!-- ###################### USER #################-->
                <div class="panel panel-info" id="panel-head" style=" background: url('<?php echo Yii::app()->baseUrl ?>/images/bg-black.gif');">
                    <div class="panel-body" style=" text-align: center; padding-top:80px; border-bottom: #3c4754 solid 1px; background: url('<?php echo Yii::app()->baseUrl ?>/images/bg-black.gif');">
                        <?php
                        if (!empty($Profile['images'])) {
                            $img_profile = "uploads/profile/" . $Profile['images'];
                        } else {
                            $img_profile = "images/use-icon.png";
                        }
                        ?>
                        <center>
                            <img src="<?= Yii::app()->baseUrl; ?>/<?php echo $img_profile; ?>"
                                 class="img img-responsive img-circle" style=" width: 80px;">
                        </center>
                        <div id="box-profile">
                            User : <?php echo Yii::app()->user->name ?><br>
                            สถานะ : <?php echo ' (' . $Profile['status'] . ')'; ?><br />

                        </div>
                        <a href="<?= Yii::app()->createUrl('masuser/profile', array('id' => $Profile['id'])); ?>"><i
                                class="fa fa-pencil"></i> โปรไฟล์</a>
                    </div>
                </div>
                <!-- สินค้าขายดี -->
                <div id="box-profile">
                    <table class="table table-bordered" style=" background: none;">
                        <thead>
                            <tr>
                                <th colspan="3" style=" text-align: center; background: #3c4754;">
                                    <i class="fa fa-thumbs-o-up"></i> สินค้าขายดี
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $branchs = Branch::model()->findAll("id!='99'");
                            ?>
                            <?php
                            foreach ($branchs as $bs):
                                $maxsell = $Report->Getmaxsellproduct($bs['id']);
                                ?>
                                <tr>
                                    <td><?php echo $bs['branchname'] ?></td>
                                    <td><?php echo ($maxsell['product_name']) ? $maxsell['product_name'] : "-"; ?></td>
                                    <td><?php echo ($maxsell['total']) ? $maxsell['total'] : "-"; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- จำนวนลูกค้า -->
                <div id="box-profile">
                    <table class="table table-bordered" style=" background: none;">
                        <thead>
                            <tr>
                                <th colspan="2" style=" text-align: center; background: #3c4754;">
                                    <i class="fa fa-users"></i> จำนวนลูกค้าลงทะเบียน
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $resultPatient = $Report->Countpatient();
                            foreach ($resultPatient as $pt):
                                ?>
                                <tr>
                                    <td><?php echo $pt['branchname'] ?></td>
                                    <td style=" text-align: center;"><?php echo ($pt['total']) ? $pt['total'] : "-"; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div id="box-profile" style=" margin-bottom: 0px;" class="chart-box">
                    <br />
                    <p style=" text-align: center; color: #FFFFFF;">จำนวนการให้บริการ</p>
                    <div id="visitchartbranch" style=" height: 200px; margin-bottom: 0px;"></div>
                    <?php
                    $visitArr = array();
                    foreach ($branchs as $bschart):
                        $sumvisit = $Report->CountserviceAll($bschart['id']);
                        $branchName = $bschart['branchname'];
                        $visitArr[] = "['" . $branchName . "',$sumvisit]";
                    endforeach;
                    $visit = implode(",", $visitArr);
                    echo $ChartModel->BarChart("visitchartbranch", "", "", "จำนวน", "สาขา", $visit);
                    ?>
                </div>
                <div id="m-left" style=" margin-bottom: 50px;">
                    <?php if (Yii::app()->session['branch'] != "") { ?>
                        <?php if (Yii::app()->session['branch'] != "99") { ?>
                            <br />
                            <center><b style=" color: #FFFFFF;"><i class="fa fa-bell"></i> แจ้งเตือน</b></center>
                            <a href="<?php echo Yii::app()->createUrl('backend/stock/expireproduct') ?>">
                                <div id="listmenu">สินค้าใกล้หมด <span
                                        class="badge pull-right"><?php echo $alet->Countalertproduct(Yii::app()->session['branch']); ?>
                                    </span></div>
                            </a>
                            <a href="<?php echo Yii::app()->createUrl('backend/stock/expireitem') ?>">
                                <div id="listmenu">สินค้าใกล้หมดอายุ <span
                                        class="badge pull-right"><?php echo $alet->CountAlertExpire(); ?> </span></div>
                            </a>
                            <a href="<?php echo Yii::app()->createUrl('backend/stock/expire') ?>">
                                <div id="listmenu">สินค้าหมดอายุ <span class="badge pull-right"><?php echo $alet->CountExpire(); ?>
                                    </span></div>
                            </a>
                            <a href="<?php echo Yii::app()->createUrl('appoint/appointover') ?>">
                                <div id="listmenu">ลูกค้าใกล้ถึงวันนัด <span
                                        class="badge pull-right"><?php echo $AppointModel->Countover(); ?> </span></div>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper" style="padding:0px;">
                <nav class="navbar navbar-inverse" role="navigation" id="nav-bar" style=" margin-bottom: 0px;"></nav>
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="nav-bar" style=" box-shadow: #000000 0px 0px 10px 0px;">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                    data-target=".navbar-ex1-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a href="#menu-toggle" class="navbar-brand" id="menu-toggle"><i class="fa fa-bars"></i></a>
                            <a href="javascript:mainmenu()" class="navbar-brand" style="margin-top: 1px;"><i
                                    class="fa fa-th"></i> menu</a>
                            <div id="box-logo" style=" float: left; display: none;">
                                <a class="navbar-brand" style=" margin-top: 0px; padding-top: 10px;" id="logo-clinic">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/uploads/logo/<?php echo $web->get_logoweb(); ?>"
                                         height="32px" />
                                </a>
                                <a class="navbar-brand" href="#" id="text-head-nav"
                                   style=" font-family: Th;font-size:28px; color: #7cb902;">
                                       <?php echo $web->get_webname(); ?>
                                </a>
                            </div>
                        </div>
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="<?= Yii::app()->createUrl('patient/create') ?>" style=" color: #ff9900;">
                                        <span class="fa fa-plus-circle"></span>
                                        <font id="font-th">ลงทะเบียนรายใหม่</font>
                                    </a>
                                </li>
                            </ul>
                            <?php if (!Yii::app()->user->isGuest) { ?>
                                <ul class="nav navbar-nav navbar-right">

                                    <li>
                                        <a href="<?= Yii::app()->createUrl('site/logout/') ?>" style=" color: #ff9900;">
                                            <span class="glyphicon glyphicon-off"></span>
                                            <font id="font-th">ออกจากระบบ</font>
                                        </a>
                                    </li>
                                </ul>
                            <?php } ?>
                            <ul class="nav navbar-nav navbar-right">
                                <?php
                                $ReportMenu = $MenuReport->Getrolemenu($Profile['user_id']);
                                if ($ReportMenu) {
                                    ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="glyphicon glyphicon-signal" style=" color: #ff9900;"></span>
                                            <font id="font-th" style=" color: #ff9900;">รายงาน </font><b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            $ReportMenubranch = $MenuReport->Getrolemenubranch($Profile['user_id']);
                                            $ReportMenucenter = $MenuReport->Getrolemenucenter($Profile['user_id']);
                                            if ($ReportMenubranch) {
                                                ?>
                                                <li class=" active" style=" padding-left: 10px; font-weight: bold;">รายงานสาขา</li>
                                                <?php
                                                foreach ($ReportMenubranch as $rp):
                                                    $reportLink = $rp['url'];
                                                    ?>
                                                    <li><a href="<?php echo Yii::app()->createUrl($reportLink) ?>"> -
                                                            <?php echo $rp['report_name'] ?></a></li>
                                                    <?php
                                                endforeach;
                                            }
                                            ?>
                                            <?php if ($ReportMenucenter) {
                                                ?>
                                                <li class=" divider"></li>
                                                <li class=" active" style=" padding-left: 10px; font-weight: bold;">
                                                    รายงานคลังสินค้าหลัก</li>
                                                <?php
                                                foreach ($ReportMenucenter as $rpc):
                                                    $reportLinks = $rpc['url'];
                                                    ?>
                                                    <li><a href="<?php echo Yii::app()->createUrl($reportLinks) ?>"> -
                                                            <?php echo $rpc['report_name'] ?></a></li>
                                                    <?php
                                                endforeach;
                                                ?>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php
                                $Settingmenu = $MenuSetting->Getrolesetting($Profile['user_id']);
                                if ($Settingmenu) {
                                    ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="fa fa-gear" style=" color: #ff9900;"></span>
                                            <font id="font-th" style=" color: #ff9900;">ตั้งค่าระบบ </font><b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            foreach ($Settingmenu as $st):
                                                $linlsetting = $st['url'];
                                                ?>
                                                <li><a href="<?php echo Yii::app()->createUrl($linlsetting) ?>"> -
                                                        <?php echo $st['setting'] ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if (Yii::app()->session['status'] == "1") { ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <span class="fa fa-code" style=" color: #ff9900;"></span>
                                            <font id="font-th" style=" color: #ff9900;">log </font><b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo Yii::app()->createUrl('log/loglogin') ?>"> -
                                                    ประวัติผู้เข้าใช้งานระบบ</a></li>
                                        </ul>
                                    </li>
                                <?php } ?>
                            </ul>

                        </div><!-- /.navbar-collapse -->
                    </div>
                </nav>
                <ol class="breadcrumb "
                    style=" margin-bottom: 0px; margin-top: 0px; padding-top:15px;  border-radius: 0px; background: url('<?php echo Yii::app()->baseUrl ?>/images/bg-black.gif'); border-bottom: #191919 solid 0px; box-shadow: none;">
                        <?php if (isset($this->breadcrumbs)): ?>
                            <?php
                            $this->widget('zii.widgets.CBreadcrumbs', array(
                                'homeLink' => CHtml::link('<i class=" glyphicon glyphicon-home"></i> หน้าหลัก', Yii::app()->createUrl('site/index')),
                                'links' => $this->breadcrumbs,
                            ));
                            ?>
                        <!-- breadcrumbs -->
                    <?php endif ?>
                </ol>
                <div class="container-fluid" style="padding: 0px; padding-bottom: 0px;">
                    <div class="row" style="margin: 5px 0px 0px 0px;">
                        <div class="col-lg-12" style=" padding-left: 5px; padding-right: 5px;"><?php echo $content; ?></div>
                    </div>
                </div>
            </div>
            <!-- /#page-content-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- News Menu -->
        <div class="modal fade" tabindex="-1" role="dialog" id="mainmenu">
            <div class="modal-dialog mainmenu" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" style=" text-align: center;"><i class="fa fa-th"></i> MENU</h4>
                    </div>
                    <div class="modal-body" id="bodymainmenu">
                        <div class="row" style="margin: 0px;">
                            <?php
//$UserModel = new Masuser();
//$Profile = $UserModel->GetProfile();
//$MenuModel = new Menu();
                            $group = $MenuModel->GetgroupMenu();
                            foreach ($group as $groups) {

                                $rsCount = $MenuModel->GetcountRoleMenu($Profile['user_id'], $groups['group']);
                                if ($rsCount > 0) {
                                    echo $groups['groupname'];
                                }
                                ?>

                                <div class="row" style=" margin-top: 0px; padding-top: 0px; padding: 0px 10px;">
                                    <?php
                                    $product_model = new Backend_product();
                                    $AppointModel = new Appoint();

                                    $MenuSystem = $MenuModel->Getrolemenu($Profile['user_id'], $groups['group']);
                                    $alet = new Alert();
                                    $i = 0;
                                    foreach ($MenuSystem as $mn):
                                        $linkmenu = $mn['link'];
                                        $icon = $mn['icon'];
                                        $i++;
                                        ?>
                                        <?php if ($mn['id'] == $mn['menu_id']) { ?>
                                            <div class="col-md-3 col-lg-2 col-sm-3 col-xs-4" style=" margin-bottom: 0px; padding: 5px;">
                                                <a href="<?php echo Yii::app()->createUrl($linkmenu) ?>"
                                                   onclick="setactivemenu('<?php echo "M" . $i ?>')">
                                                    <div class="box-home-menu">
                                                        <center>
                                                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/<?php echo $icon ?>"
                                                                 height="48px" /><br />
                                                            <div id="text-menus" style=" width: 96%;height: 40px; overflow: hidden;">
                                                                <?php echo $mn['menu'] ?>
                                                            </div>
                                                        </center>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <!--
                                                                                                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-4" style=" margin-bottom: 0px; padding: 5px;opacity: 0.4;">
                                                                                                        <div class="box-home-menu-disabled">
                                                                                                            <center>
                                                                                                                <img src="<?php //echo Yii::app()->baseUrl;                                                                                ?>/images/<?php echo $icon ?>" height="48px"/><br/>
                                                                                                                <div id="text-menus" style=" width: 99%;height: 40px; overflow: hidden;">
                                            <?php //echo $mn['menu']   ?>
                                                                                                                </div>
                                                                                                            </center>
                                                                                                        </div>
                                                                                                    </div>
                                            -->
                                        <?php } ?>
                                    <?php endforeach; ?>
                                    <!--
                                        </div>
                                    </div>
                                    -->
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <!-- Menu Toggle Script -->
        <script type="text/javascript">
            setnavbar();
            $(document).ready(function() {
                var h = window.innerHeight;
                var m = h - 70;
                $("#bodymainmenu").css({
                    "height": m,
                    "overflow": "auto"
                });
            });

            function mainmenu() {
                $("#mainmenu").modal();
            }
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#wrapper").toggleClass("toggled");
            });

            function set_navbar(id) {
                var url = "<?php echo Yii::app()->createUrl('backend/backend/set_navbar') ?>";
                var data = {
                    id: id
                };
                $.post(url, data, function(success) {
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

            $(document).on('click', '.panel-heading span.clickable', function(e) {
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
                var data = {
                    menu: id
                };
                $.post(url, data, function() {

                });
            }

            function setnavbar() {
                var w = window.innerWidth;
                if (w <= 786) {
                    $("#nav-bar").addClass('navbar-fixed-top');
                    $("#nav-head").show();
                    $("#text-head-nav").text("คลินิก");
                    $("#box-logo").show();
                    $("#logo-clinic").hide();
                    $(".chart-box").hide();
                } else {
                    $("#box-logo").hide();
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