<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalKas */

$this->title = 'Ubah Data Saldo Awal Kas : ' . $model->no_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Kas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_saldo_awal_kas, 'url' => ['view', 'id' => $model->id_saldo_awal_kas]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-saldo-awal-kas-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Kas', ['index']) ?></li>
        <li><?= Html::a('Detail Data Saldo Awal Kas : ' . $model->no_transaksi, ['view', 'id' => $model->id_saldo_awal_kas]) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_kas_bank' => $data_kas_bank,
    ]) ?>

</div>