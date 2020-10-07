<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaran */

$this->title = 'Detail Data Penerimaan Pembayaran : ' . $retVal = ($model->jenis_penerimaan) ? 'Penjualan Barang' : 'Penjualan Harta Tetap';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayarans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penerimaan-pembayaran-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penerimaan Pembayaran', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_penerimaan_pembayaran_penjualan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penerimaan_pembayaran_penjualan], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah anda yakin akan menghapus data ini?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah No. Penjualan', ['update-dua', 'id' => $model->id_penerimaan_pembayaran_penjualan], ['class' => 'btn btn-primary']) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-money-check-alt"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                        'attributes' => [
                            // 'id_penerimaan_pembayaran_penjualan',
                            [
                                'attribute' => 'tanggal_penerimaan_pembayaran',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal_penerimaan_pembayaran, true);
                                }
                            ],
                            [
                                'attribute' => 'jenis_penerimaan',
                                'value' => function ($model) {
                                    if ($model->jenis_penerimaan == 1) {
                                        # code...
                                        return 'Penjualan Barang';
                                    } elseif ($model->jenis_penerimaan == 2) {
                                        # code...
                                        return 'Penjualan Harta Tetap';
                                    }
                                }
                            ],
                            'id_penjualan',
                            [
                                'attribute' => 'cara_bayar',
                                'value' => function ($model) {
                                    if ($model->cara_bayar == 1) {
                                        # code...
                                        return 'Tunai';
                                    } elseif ($model->cara_bayar == 2) {
                                        # code...
                                        return 'Transfer';
                                    } elseif ($model->cara_bayar == 3) {
                                        # code...
                                        return 'Giro';
                                    }
                                }
                            ],
                            'id_kas_bank',
                            [
                                'attribute' => 'nominal',
                                'value' => function ($model) {
                                    return ribuan($model->nominal);
                                }
                            ],
                            'keterangan:ntext',
                        ],
                    ]) ?>

                </div>
            </div>
        </div>
    </div>
</div>