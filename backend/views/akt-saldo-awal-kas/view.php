<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalKas */

$this->title = 'Detail Data Saldo Awal Kas : ' . $model->no_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Kas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-saldo-awal-kas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>

        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_saldo_awal_kas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-bank"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                        'attributes' => [
                            // 'id_saldo_awal_kas',
                            'no_transaksi',
                            [
                                'attribute' => 'tanggal_transaksi',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal_transaksi, true);
                                }
                            ],
                            [
                                'attribute' => 'id_kas_bank',
                                'value' => function ($model) {
                                    if (!empty($model->kas_bank->keterangan)) {
                                        # code...
                                        return $model->kas_bank->keterangan;
                                    }
                                }
                            ],
                            [
                                'attribute' => 'jumlah',
                                'hAlign' => 'right',
                                'value' => function ($model) {
                                    return ribuan($model->jumlah);
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