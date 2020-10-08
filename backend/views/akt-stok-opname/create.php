<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpname */

$this->title = 'Tambah Data Stok Opname';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Opnames', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-stok-opname-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Opname', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_akun' => $data_akun,
        'data_pegawai' => $data_pegawai,
    ]) ?>

</div>