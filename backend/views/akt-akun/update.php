<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktAkun */

$this->title = 'Ubah Akun: ' . $model->nama_akun;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Akuns', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_akun, 'url' => ['view', 'id' => $model->id_akun]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-akun-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Akun', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
        'sum_kas_bank' => $sum_kas_bank,
    ]) ?>

</div>