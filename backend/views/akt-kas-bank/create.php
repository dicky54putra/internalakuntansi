<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKasBank */

$this->title = 'Tambah Kas Bank';
// $this->params['breadcrumbs'][] = ['label' => 'Data Kas Banks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-kas-bank-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kas Bank', ['akt-kas-bank/index']) ?></li>
        <li class="active">Tambah Kas Bank</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'nomor' => $nomor,
    ]) ?>

</div>
