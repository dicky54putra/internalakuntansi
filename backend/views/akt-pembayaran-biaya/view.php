<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiaya */

$this->title = $model->id_pembayaran_biaya;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembayaran Biayas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pembayaran-biaya-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pembayaran_biaya], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pembayaran_biaya], [
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
            'id_pembayaran_biaya',
            'tanggal_pembayaran_biaya',
            'id_pembelian',
            'cara_bayar',
            'id_kas_bank',
            'nominal',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
