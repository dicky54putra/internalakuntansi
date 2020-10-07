<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnisPembelianPenjualan */

$this->title = $model->id_mitra_bisnis_pembelian_penjualan;
$this->params['breadcrumbs'][] = ['label' => 'Akt Mitra Bisnis Pembelian Penjualans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-mitra-bisnis-pembelian-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_mitra_bisnis_pembelian_penjualan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_mitra_bisnis_pembelian_penjualan], [
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
            'id_mitra_bisnis_pembelian_penjualan',
            'id_mitra_bisnis',
            'id_mata_uang',
            'termin_pembelian',
            'tempo_pembelian',
            'termin_penjualan',
            'tempo_penjualan',
            'batas_hutang',
            'batas_frekuensi_hutang',
            'id_akun_hutang',
            'batas_piutang',
            'batas_frekuensi_piutang',
            'id_akun_piutang',
        ],
    ]) ?>

</div>
