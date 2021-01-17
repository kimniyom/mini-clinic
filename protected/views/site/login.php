<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php
        /* @var $this SiteController */
        /* @var $model LoginForm */
        /* @var $form CActiveForm  */

        $this->pageTitle = Yii::app()->name . ' - Login';
        $this->breadcrumbs = array(
            'Login',
        );

        $webconfig = new Configweb_model();
        $webname = $webconfig->get_webname();
        ?>
        <title><?php echo $webname ?></title>

        <style type="text/css">
            html,body{
                /*
                background:url('images/bg.jpg') fixed center no-repeat;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                */
                /*background: #266697; #132448*/
                background: -moz-radial-gradient(center, ellipse cover, #266697 0%, #132448 100%);
                background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, #266697), color-stop(100%, #132448));
                background: -webkit-radial-gradient(center, ellipse cover, #266697 0%, #132448 100%);
                background: -o-radial-gradient(center, ellipse cover, #266697 0%, #132448 100%);
                background: -ms-radial-gradient(center, ellipse cover, #266697 0%, #132448 100%);
                background: radial-gradient(ellipse at center, #266697 0%, #132448 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#266697', endColorstr='#132448', GradientType=1 );
                background-repeat: no-repeat;
                background-attachment: fixed;
                /*
                background: rgba(212,114,215,1);
                background: -moz-linear-gradient(top, rgba(212,114,215,1) 0%, rgba(155,105,178,1) 55%, rgba(62,74,150,1) 100%);
                background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(212,114,215,1)), color-stop(55%, rgba(155,105,178,1)), color-stop(100%, rgba(62,74,150,1)));
                background: -webkit-linear-gradient(top, rgba(212,114,215,1) 0%, rgba(155,105,178,1) 55%, rgba(62,74,150,1) 100%);
                background: -o-linear-gradient(top, rgba(212,114,215,1) 0%, rgba(155,105,178,1) 55%, rgba(62,74,150,1) 100%);
                background: -ms-linear-gradient(top, rgba(212,114,215,1) 0%, rgba(155,105,178,1) 55%, rgba(62,74,150,1) 100%);
                background: linear-gradient(to bottom, rgba(212,114,215,1) 0%, rgba(155,105,178,1) 55%, rgba(62,74,150,1) 100%);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d472d7', endColorstr='#3e4a96', GradientType=0 );
                background-repeat: no-repeat;
                background-attachment: fixed;
                */
            }
            input[type='text']{
                border:none;
                background: #132448;
                color: #ffffff;
            }

            input[type='password']{
                border:none;
                background: #132448;
                color: #ffffff;
            }
        </style>
        <!--
        <link rel="stylesheet" type="text/css" href="<?php //echo Yii::app()->request->baseUrl;                     ?>/css/bootstrap/css/bootstrap.css" media="screen, projection" />
        -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/backend/bootstrap/css/bootstrap-slate.css" media="screen, projection" />

    </head>
    <body>

        <div class="container" style="text-align: center;text-align: left; margin-top: 30px;">

            <div class="row">
                <div class="col-xs-0 col-sm-3 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="well" style=" margin: 10px; margin-bottom: 30px; box-shadow: #000000 0px 0px 0px 0px; border:#ffb8d8 solid 0px; background:none;">
                        <center>
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/icon.png" style=" width: 100px;"/>
                        </center>
                        <h3 style=" text-align: center; color: #ffffff;"><?php echo $webname ?></h3>
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'login-form',
                            'enableClientValidation' => true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                        ));
                        ?>

                        <p class="note" style="text-align: center; color: #ff0000;">Fields with <span class="required">*</span> are required.</p>

                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $form->labelEx($model, 'username'); ?>
                                <?php echo $form->textField($model, 'username', array('class' => 'form-control input-lg')); ?>
                                <p style="color: #ff0000;"><?php echo $form->error($model, 'username', array("style" => 'color:red')); ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <?php echo $form->labelEx($model, 'password'); ?>
                                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control input-lg')); ?>
                                <p style="color:#ff0000;"><?php echo $form->error($model, 'password', array("style" => 'color:red')); ?></p>
                            </div>
                        </div>
                        <hr style="border-color:#ffffff;"/>
                        <div class="row buttons">
                            <div class="col-lg-12">
                                <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-info btn-block btn-lg')); ?>
                            </div>
                        </div>

                        <?php $this->endWidget(); ?>
                    </div>
                    <div class="col-xs-0 col-sm-3 col-md-4 col-lg-4"></div>
                </div>
            </div>
            <center>*ติดต่อผู้จัดการร้านถ้าต้องการใช้งานระบบ</center>
            <center>v.2019</center>
        </div>
    </body>
</html>


