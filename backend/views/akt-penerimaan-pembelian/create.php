<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembelian */

$this->title = 'Buat Data Penerimaan Pembelian';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penerimaan-pembelian-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penerimaan Pembelian', ['akt-penerimaan-pembelian/index']) ?></li>
        <li class="active">Buat Data Penerimaan Pembelian</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
            'nomor' => $nomor,
    ]) ?>

</div>
