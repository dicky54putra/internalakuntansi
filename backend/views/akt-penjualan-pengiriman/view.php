<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanPengiriman */

$this->title = $model->id_penjualan_pengiriman;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Pengirimen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penjualan-pengiriman-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penjualan_pengiriman], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penjualan_pengiriman], [
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
            'id_penjualan_pengiriman',
            'no_pengiriman',
            'tanggal_pengiriman',
            'pengantar',
            'keterangan_pengantar:ntext',
            'foto_resi',
            'id_penjualan',
            'id_mitra_bisnis_alamat',
            'penerima',
            'keterangan_penerima:ntext',
        ],
    ]) ?>

</div>
