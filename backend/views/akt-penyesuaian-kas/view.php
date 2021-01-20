<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianKas */

$this->title = 'Detail Daftar Penyesuaian Kas : ' . $model->no_transaksi;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penyesuaian-kas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penyesuaian Kas', ['index']) ?></li>
        <li class="active">Detail Daftar Penyesuaian Kas : <?= $model->no_transaksi ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_penyesuaian_kas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penyesuaian_kas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-tasks"></span> Detail Daftar Penyesuaian Kas</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'no_transaksi',
                                [
                                    'attribute' => 'tanggal',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal, true);
                                    }
                                ],
                                [
                                    'attribute' => 'id_akun',
                                    'value' => function ($model) {
                                        return $model->akun->nama_akun;
                                    }
                                ],

                                [
                                    'attribute' => 'tipe',
                                    'value' => function ($model) {
                                        if ($model->tipe == 1) {
                                            return 'Penambahan Kas';
                                        } else if ($model->tipe == 2) {
                                            return 'Pengurangan Kas';
                                        }
                                    }
                                ],
                                'no_referensi',
                                [
                                    'attribute' => 'id_kas_bank',
                                    'value' => function ($model) {
                                        return $model->kas_bank->kode_kas_bank;
                                    }
                                ],
                                [
                                    'attribute' => 'id_mata_uang',
                                    'value' => function ($model) {
                                        return $model->mata_uang->mata_uang;
                                    }
                                ],
                                [
                                    'attribute' => 'jumlah',
                                    'value' => function ($model) {
                                        return ribuan($model->jumlah, true);
                                    }
                                ],
                                'keterangan:ntext',
                            ],
                        ]) ?>

                    </div>