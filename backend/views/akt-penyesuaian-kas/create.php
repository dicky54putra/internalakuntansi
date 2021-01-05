<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianKas */

$this->title = 'Tambah Daftar Penyesuaian Kas';
?>
<div class="akt-penyesuaian-kas-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penyesuaian Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun
    ]) ?>

</div>