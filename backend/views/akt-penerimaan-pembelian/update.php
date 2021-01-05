<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembelian */

$this->title = 'Ubah Data Penerimaan Pembelian';
// $this->params['breadcrumbs'][] = ['label' => 'D Penerimaan Pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_penerimaan_pembelian, 'url' => ['view', 'id' => $model->id_penerimaan_pembelian]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penerimaan-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penerimaan Pembelian', ['akt-penerimaan-pembelian/index']) ?></li>
        <li class="active">Ubah Data Penerimaan Pembelian</li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
            'nomor' => $nomor,
    ]) ?>

</div>
