<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalKas */

$this->title = 'Tambah Daftar Saldo Awal Kas';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Kas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-saldo-awal-kas-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_kas_bank' => $data_kas_bank,
    ]) ?>

</div>