<style type="text/css">
.bg-menu {
    background: rgba(212, 114, 215, 1);
    background: -moz-linear-gradient(top, rgba(212, 114, 215, 1) 0%, rgba(155, 105, 178, 1) 55%, rgba(62, 74, 150, 1) 100%);
    background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(212, 114, 215, 1)), color-stop(55%, rgba(155, 105, 178, 1)), color-stop(100%, rgba(62, 74, 150, 1)));
    background: -webkit-linear-gradient(top, rgba(212, 114, 215, 1) 0%, rgba(155, 105, 178, 1) 55%, rgba(62, 74, 150, 1) 100%);
    background: -o-linear-gradient(top, rgba(212, 114, 215, 1) 0%, rgba(155, 105, 178, 1) 55%, rgba(62, 74, 150, 1) 100%);
    background: -ms-linear-gradient(top, rgba(212, 114, 215, 1) 0%, rgba(155, 105, 178, 1) 55%, rgba(62, 74, 150, 1) 100%);
    background: linear-gradient(to bottom, rgba(212, 114, 215, 1) 0%, rgba(155, 105, 178, 1) 55%, rgba(62, 74, 150, 1) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#d472d7', endColorstr='#3e4a96', GradientType=0);
    background-repeat: no-repeat;
    background-attachment: fixed;
}
</style>
<?php
$config = new Configweb_model();
$report = new Report();
$month = date("m");
$sql = "select l.*,e.name,e.lname from loglogin l inner join employee e on l.user_id = e.id where l.branch != '99' order by l.id desc limit 10";
$loglogin = Yii::app()->db->createCommand($sql)->queryAll();
?>
<script>
var socket = io.connect("<?php echo $config->LinkNode() ?>");
socket.on('connect', function() {
    $("#statusserver").html("<span class='text-success'><i class='fa fa-check'></i> Server Online</span>");
});

socket.on('disconnect', function() {
    console.log('check 2', socket.connected);
    $("#statusserver").html("<span class='text-danger'><i class='fa fa-remove'></i> Server Offline</span>");
});

$(document).ready(function() {
    $(".breadcrumb").hide();
    $("#m-left").hide();
    $("#m-left-logo").show();
    /*
     var w = window.innerWidth;
     if (w > 768) {
     $("#wrapper").toggleClass("toggled");
     }
     */
});

function popupseq(name) {
    var url = "https://translate.google.com.vn/translate_tts?ie=UTF-8&q=เชิญคุณ" + name +
        "เข้าห้องตรวจ&tl=th&client=tw-ob";
    newwindow = window.open(url, 'rametseq', 'height=50,width=50');
    //if (window.focus) {
    //newwindow.focus();
    setTimeout(function() {
        newwindow.close();
    }, 10000);
    //}
    //return false;
}
</script>


<div id="p-box" style=" margin-top: 0px;">
    <?php if (Yii::app()->session['branch'] != "") {
        ?>
    <div class="row" style=" margin: 0px; padding: 0px;">
        <div class="col-md-12 col-lg-8" id="home-left">
            <div id="statusserver"><span class='text-danger'><i class='fa fa-remove'></i> Server Offline</span></div>
            <!--
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-cog"></i> เมนู</div>
                    <div class="panel-body">
                -->
            <?php
                $UserModel = new Masuser();
                $Profile = $UserModel->GetProfile();
                $MenuModel = new Menu();
                foreach ($group as $groups) {

                    $rsCount = $MenuModel->GetcountRoleMenu($Profile['user_id'], $groups['group']);
                    if ($rsCount > 0) {
                        echo " <h4>" . $groups['groupname'] . "</h4>";
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
                <div>
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
                                                    <img src="<?php //echo Yii::app()->baseUrl;                                 ?>/images/<?php //echo $icon   ?>" height="48px"/><br/>
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
            <hr />
            <div class="row" style=" margin: 0px;">
                <div class="panel panel-default" style=" margin-bottom: 0px;">
                    <div class=" panel-heading">ให้บริการล่าสุด</div>
                    <ul class=" list-group" style=" margin-bottom: 0px;">
                        <?php
                            $lastService = $report->LastserviceAll(10);
                            foreach ($lastService as $ls):
                                ?>
                        <li class=" list-group-item">
                            <?php echo "(" . $ls['service_date'] . ") " . $ls['name'] . ' ' . $ls['lname'] ?>
                            <span class=" badge"><?php echo $ls['branchname'] ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <hr />
            <div class="row" style=" margin: 0px;">
                <div class="col-sm-6 col-md-6 col-lg-6" style=" padding: 0px;">
                    <div class="well" style=" margin: 0px; margin-bottom: 10px;">
                        <h4 style="color: #ff9900; font-size: 18px; text-align: center;">
                            <i class="fa fa-cart-arrow-down"></i> ยอดวันนี้
                            <hr />
                            <?php echo number_format($incomtoday, 2) ?> บาท
                        </h4>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" style=" padding: 0px;">
                    <div class="well" style=" margin: 0px; margin-bottom: 10px;">
                        <h4 style="color: #ff9900; font-size: 18px; text-align: center;">
                            <i class="fa fa-calendar"></i> ยอดทั้งเดือน
                            <hr />
                            <?php echo number_format($incomtomonth, 2) ?> บาท
                        </h4>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" style=" padding: 0px;">
                    <div class="well" style=" margin: 0px; margin-bottom: 10px; text-align: center;">
                        <h4 style="color: #ff9900; font-size: 18px;">
                            <i class="fa fa-user"></i> การให้บริการวันนี้
                            <hr />
                            <?php echo number_format($countservice) ?> ครั้ง
                        </h4>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-6" style=" padding: 0px;">
                    <div class="well" style=" margin: 0px; margin-bottom: 10px;">
                        <h4 style="color: #ff9900; font-size: 18px;text-align: center;">
                            <i class="fa fa-user"></i> การเข้าใช้งานวันนี้
                            <hr />
                            <?php echo number_format($countloginnow) ?> ครั้ง
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-4" id="home-right">
            <?php if (Yii::app()->session['branch'] != '') { ?>

            <div class="row">
                <div class="col-md-6 col-lg-6 col-xs-6" style=" margin-bottom: 20px;">
                    <a href="<?php echo Yii::app()->createUrl('backend/stock/expireproduct') ?>">
                        <span class="badge"
                            style=" position: absolute;top:0px; left: 10px; background: <?php echo ($alet->Countalertproduct(Yii::app()->session['branch']) > 0) ? "#000000;" : "#111111;"; ?>">
                            <?php echo $alet->Countalertproduct(Yii::app()->session['branch']); ?>
                        </span>
                        <div
                            class="<?php echo ($alet->Countalertproduct(Yii::app()->session['branch']) > 0) ? "btn btn-danger" : "btn btn-default"; ?> btn-block">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/alert-icon.png" height="48px" /><br />
                            สินค้าใกล้หมด
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6" style=" margin-bottom: 20px;">
                    <a href="<?php echo Yii::app()->createUrl('backend/stock/expireitem') ?>">
                        <span class="badge"
                            style=" position: absolute;top:0px; left: 10px; background: <?php echo ($alet->CountAlertExpire() > 0) ? "#000000;" : "#111111;"; ?>">
                            <?php echo $alet->CountAlertExpire(); ?>
                        </span>
                        <div
                            class="<?php echo ($alet->CountAlertExpire() > 0) ? "btn btn-danger" : "btn btn-default"; ?> btn-block">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/alert-icon.png" height="48px" /><br />
                            สินค้าใกล้หมดอายุ
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6">
                    <a href="<?php echo Yii::app()->createUrl('backend/stock/expire') ?>">
                        <span class="badge"
                            style=" position: absolute;top:0px; left: 10px; background: <?php echo ($alet->CountExpire() > 0) ? "#000000;" : "#111111;"; ?>">
                            <?php echo $alet->CountExpire(); ?>
                        </span>
                        <div
                            class="<?php echo ($alet->CountExpire() > 0) ? "btn btn-danger" : "btn btn-default"; ?> btn-block">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/alert-icon.png" height="48px" /><br />
                            สินค้าหมดอายุ
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6" style=" margin-bottom: 20px;">
                    <a href="<?php echo Yii::app()->createUrl('appoint/appointover') ?>">
                        <span class="badge"
                            style=" position: absolute;top:0px; left: 10px; background: <?php echo ($AppointModel->Countover() > 0) ? "#000000;" : "#111111;"; ?>">
                            <?php echo $AppointModel->Countover(); ?>
                        </span>
                        <div
                            class="<?php echo ($AppointModel->Countover() > 0) ? "btn btn-danger" : "btn btn-default"; ?> btn-block">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/alert-icon.png" height="48px" /><br />
                            นัดลูกค้า
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-6" style=" margin-bottom: 20px;">
                    <a href="<?php echo Yii::app()->createUrl('repair') ?>">
                        <span class="badge"
                            style=" position: absolute;top:0px; right: 0px; background: <?php echo ($alet->AlertRepair() > 0) ? "#ff0033;" : "#111111;"; ?>">
                            <?php echo $alet->AlertRepair(); ?>
                        </span>
                        <div class="btn btn-default btn-block">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/alert-icon.png" height="48px" /><br />
                            แจ้งเตือนซ่อม - บำรุง
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-lg-6 col-xs-6" style=" margin-bottom: 20px;">
                    <a href="<?php echo Yii::app()->createUrl('returnproduct/view') ?>">
                        <span class="badge"
                            style=" position: absolute;top:0px; right: 0px; background: <?php echo ($alet->AlertreturnProduct() > 0) ? "#ff0033;" : "#111111;"; ?>">
                            <?php echo $alet->AlertreturnProduct(); ?>
                        </span>
                        <div class="btn btn-default btn-block">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/alert-icon.png" height="48px" /><br />
                            แจ้งเตือนส่งคืนสินค้า
                        </div>
                    </a>
                </div>

            </div>

            <?php } else { ?>

            <?php } ?>
            <div class="panel panel-default">
                <div class="panel-heading">การให้บริการ เดือน <?php echo $config->MonthFullArray()[(int) $month] ?>
                </div>
                <div class="panel-body" style=" padding: 10px;">
                    <div id="chartstatistics" style=" height: 80px;"></div>
                </div>
            </div>
            <div class="panel panel-default" style=" margin-bottom: 0px;">
                <div class="panel-heading">ผู้ใช้งานล่าสุด</div>
                <ul class=" list-group">
                    <?php foreach ($loglogin as $lg): ?>
                    <li class=" list-group-item">
                        <?php echo $lg['name'] . ' ' . $lg['lname'] ?>
                        <span class=" badge"><?php echo $lg['date'] ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <center>
        <br /><br />
        <h1><i class="fa fa-info-circle" style=" color: #ff9900;"></i></h1>
        <h4>
            ไม่ได้กำหนดสิทธ์การใช้งาน ...! ติดต่อผู้จัดการหรือผู้ดูแลระบบ
        </h4>
    </center>
    <?php } ?>
</div>

<script type="text/javascript">
Setscreen();

function Setscreen() {
    var screen = $(window).height();
    var w = window.innerWidth;
    //var contentboxsell = $("#content-boxsell").height();
    var screenfull = (screen - 63);
    if (w > 1024) {
        $("#home-left").css({
            'height': screenfull,
            'overflow': 'auto',
            'padding-bottom': '25px',
            'border': 'solid #3c4754 0px',
            'padding-top': '10px',
            'background': '#333333',
            'border-radius': '20px 0px 0px 20px'
        });
        $("#home-right").css({
            'height': screenfull,
            'overflow': 'auto',
            'padding-bottom': '25px',
            'border': 'solid #3c4754 0px',
            'padding-top': '10px',
            'background': '#666666',
            'border-left': 'none'
        });
        //$("#patientbox").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF'});
        //$("#boxorders").css({'height': screenfull, 'background': '#00bca5', 'color': '#FFFFFF', 'overflow': 'auto', 'padding-left': '10px'});
    }
}

$(function() {
    Highcharts.chart('chartstatistics', {
        chart: {
            type: 'bar'
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        xAxis: {
            categories: ['คน', 'ครั้ง'],
            title: {
                text: null
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: '',
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            }
        },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'top',
            x: -40,
            y: 80,
            floating: true,
            borderWidth: 1,
            backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) ||
                '#FFFFFF'),
            shadow: true
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'จำนวน',
            colorByPoint: true,
            data: [ < ? php echo $countserviceh ? > , < ? php echo $countvisit ? > ]
        }]
    });
});
</script>