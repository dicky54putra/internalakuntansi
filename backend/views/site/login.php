<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use pa3py6aka\yii2\ModalAlert;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$path = \Yii::getAlias("@web");
$frontend = \Yii::getAlias("@frontend");

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span style='color: #000000;' class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback pass'],
    'inputTemplate' => "{input}<span style='color: #000000;' class='glyphicon glyphicon-lock form-control-feedback'></span> ",
];
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Teko:wght@400&display=swap');

    ::placeholder {
        color: black !important;
        opacity: 0.5 !important;
        /* Firefox */
    }

    .form {
        width: 100%;
        border-radius: 30px;
        color: black;
        padding-left: 20px;
        background-color: rgba(255, 255, 255, 0.7);
        margin-top: 1.5em;
        margin-bottom: 1em;
        border-color: linear-gradient(329deg, rgba(60, 141, 188, 1) 0%, rgba(22, 194, 230, 1) 100%);
        ;
    }

    .btn {
        width: 100%;
        border-radius: 30px;
        padding-left: 20px;
        background: linear-gradient(329deg, rgba(60, 141, 188, 1) 0%, rgba(22, 194, 230, 1) 100%);
        outline: none;
        margin-top: 1.5em;
        margin-bottom: 1em;
        border: transparent;
    }

    .btn:hover {
        width: 100%;
        border-radius: 30px;
        padding-left: 20px;
        background: linear-gradient(329deg, rgba(22, 194, 230, 1) 0%, rgba(60, 141, 188, 1) 100%);
        margin-top: 1.5em;
        margin-bottom: 1em;
        border: transparent;
    }

    .btn:active {
        /* border: none !important; */
        outline: none !important;
        border: none !important;
        background: linear-gradient(329deg, rgba(22, 194, 230, 1) 0%, rgba(60, 141, 188, 1) 100%);
    }

    .login-box-body {
        border-radius: 30px;
        /* background: rgb(13, 55, 79); */
        background: rgba(255, 255, 255, 1);
        /* background: linear-gradient(329deg, rgba(13, 55, 79, 0.6) 0%, rgba(8, 140, 167, 0.6) 100%);
        padding: 0 !important;
        -webkit-box-shadow: 0px 0px 44px -15px rgba(0, 0, 0, 1);
        -moz-box-shadow: 0px 0px 44px -15px rgba(0, 0, 0, 1); */
        box-shadow: 0px 0px 44px -15px rgba(0, 0, 0, 1);
        animation: aa 10s infinite;
    }

    /* .login-box-body .formnya {
        margin: 0 !important;
        border-radius: 0 30px 30px 0;
        background: #fff;
    } */

    span#showpwd {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: black;
    }

    .center {
        margin-top: 60px;
        color: #fff;
    }

    .info a {
        color: black;
    }

    .info a:hover {
        color: rgba(60, 141, 188, 1);
    }

    .gss {
        font-size: 3em;
        font-family: 'Teko', sans-serif;
    }

    @media (max-device-width: 990px) {
        .login-page {
            margin-top: 10%;
            background: #fff;
        }

        .login-box {
            width: 80% !important;
        }

        .login-box-body {
            border-radius: 30px;
            background: transparent !important;
            padding: 0 !important;
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }

        .login-box-body .formnya {
            border-radius: 30px;
            background: #fff;
        }

        .center {
            display: none;
        }

        .bgss {
            font-size: 3em;
        }
    }
</style>
<div class="login-box" style="width: 35%; ">
    <?= ModalAlert::widget([
        'popupCssClass' => 'my-custom-class',
        // 'popupView' => '@app/views/common/my-custom-alert',
    ]) ?>

    <div class="login-box-body" style="height:100%;">

        <div align="center">
            <div class="row">
                <div class="col-md-12 formnya" style="margin-left:0px;">
                    <div class="row" style="left: auto; margin: 10px;">
                        <div class="col-md-1"></div>
                        <div class="col-md-10" style="margin-top: 0px; margin-bottom: 10px; color: black;">
                            <p>WELCOME TO</p>
                            <h2 style="color: black; margin-top: 10px;" class="gss"><b>GSS</b> ACCOUNTING</h2>
                            <small>Silahkan login untuk mengakses fitur-fitur</small><br>
                            <small>akuntansi yang luar biasa</small>

                            <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
                            <div class="form-group has-feedback pass field-loginform-username required">
                                <input type="text" id="loginform-username" class="form-control pass form" name="LoginForm[username]" placeholder="Username" aria-required="true" autofocus>
                                <!-- <span class='glyphicon glyphicon-user form-control-feedback' style="margin-right: 10px;"></span> -->
                                <p class="help-block help-block-error"></p>
                            </div>
                            <div class="form-group has-feedback pass field-loginform-password required">
                                <input type="password" id="loginform-password" class="form-control pass form" name="LoginForm[password]" placeholder="Password" aria-required="true">
                                <div id="eye" onclick="eyeSee()">
                                    <span id="showpwd" class='glyphicon glyphicon-eye-close' style="margin-right: 10px;"></span>
                                </div>
                                <p class="help-block help-block-error"></p>
                            </div>

                            <div class="form-group">
                                <?= Html::submitButton('MASUK', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            </div>
                        </div>
                        <div class="col-md-1"></div>

                        <br>
                    </div>
                    <div class="row" style="margin-top: -50px;">
                        <div class="col-lg-12 info">
                            <p>About Developer</p>
                            <a href="https://www.facebook.com/garudasaranasejahtera"><i class="fa fa-facebook"></i></a> &nbsp;
                            <a href="https://www.instagram.com/gss_software/"><i class="fa fa-instagram"></i></a> &nbsp;
                            <a href="http://gss-accounting.com"><i class="fa fa-globe"></i></a> &nbsp;
                            <a href="mailto:informasi@klikgss.com"><i class="fa fa-envelope"></i></a> &nbsp;
                            <a href="https://api.whatsapp.com/send?phone=6289668303824"><i class="fa fa-whatsapp"></i></a>
                        </div>
                    </div>

                </div>


                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>

</div>


<?php

$script = <<< JS
$(document).ready(function() {
        $("#showpwd").on("click", function() {
            $(this).toggleClass("glyphicon-eye-open glyphicon-eye-close");
            $('#loginform-password').attr("type", function(index, attr) {
                return attr == "password" ? "text" : "password"
            });
        });
    })

JS;

$this->registerJs($script);

?>