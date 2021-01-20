<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKasBank */

$this->title = 'Ubah Kas Bank: ' . $model->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Data Kas Banks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_kas_bank, 'url' => ['view', 'id' => $model->id_kas_bank]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-kas-bank-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kas bank', ['akt-kas-bank/index']) ?></li>
        <li class="active">Ubah Kas bank</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
