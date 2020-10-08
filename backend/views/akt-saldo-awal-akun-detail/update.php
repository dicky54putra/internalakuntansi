<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalAkunDetail */

$this->title = 'Ubah Saldo Awal Akun ';
?>
<div class="akt-saldo-awal-akun-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Akun', ['index']) ?></li>
        <li><?= Html::a('Detail Data Saldo Awal Akun ', ['akt-saldo-awal-akun/view', 'id' => $model->id_saldo_awal_akun]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
    ]) ?>

</div>
