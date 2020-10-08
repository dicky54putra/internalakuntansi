<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <?= Html::a('<span class="logo-mini">GSS</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo', 'style' => 'background-color: #1a2226;']) ?>

    <nav class="navbar navbar-static-top" style="background-color: #1a2226;" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">


                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= "upload/" . Yii::$app->user->identity->foto ?>" class="user-image" alt="User Image" />
                        <span class="hidden-xs"><?= Yii::$app->user->identity->nama ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= "upload/" . Yii::$app->user->identity->foto ?>" class="img-circle" alt="User Image" />
                            <p>
                                <?= Yii::$app->user->identity->nama ?>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="index.php?r=login/profile&id=<?= Yii::$app->user->identity->id ?>" class="btn btn-default">Profile</a>
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    'Keluar',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-danger']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</header>