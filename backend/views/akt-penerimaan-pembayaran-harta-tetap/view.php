<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaranHartaTetap */

$this->title = $model->id_penerimaan_pembayaran_harta_tetap;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayaran Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penerimaan-pembayaran-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penerimaan_pembayaran_harta_tetap], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penerimaan_pembayaran_harta_tetap], [
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
            'id_penerimaan_pembayaran_harta_tetap',
            'tanggal_penerimaan_pembayaran',
            'id_penjualan_harta_tetap',
            'cara_bayar',
            'id_kas_bank',
            'nominal',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
