<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisBankPajak */

$this->title = $model->id_mitra_bisnis_bank_pajak;
$this->params['breadcrumbs'][] = ['label' => 'Akt Mitra Bisnis Bank Pajaks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-mitra-bisnis-bank-pajak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_mitra_bisnis_bank_pajak], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_mitra_bisnis_bank_pajak], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_mitra_bisnis_bank_pajak',
            'id_mitra_bisnis',
            'nama_bank',
            'no_rekening',
            'atas_nama',
            'npwp',
            'pkp',
            'tanggal_pkp',
            'no_nik',
            'atas_nama_nik',
            'pembelian_pajak',
            'penjualan_pajak',
        ],
    ]) ?>

</div>
