<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKasBank */

$this->title = 'Detail Kas Bank : ' . $model->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Kas Banks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-kas-bank-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kas Bank', ['index']) ?></li>
        <li class="active">Detail Kas Bank</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_kas_bank], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_kas_bank], [
            'class' => 'btn btn-danger hidden',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-building"></span> Kas Bank</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_kas_bank',
                                'kode_kas_bank',
                                'keterangan:ntext',
                                [
                                    'attribute' => 'jenis',
                                    'value' => function ($model) {
                                        if ($model->jenis == 1) {
                                            return "Cash";
                                        } else {
                                            return "Bank";
                                        }
                                    }

                                ],
                                'akt_mata_uang.mata_uang',
                                'saldo',
                                'total_giro_keluar',
                                'akt_akun.nama_akun',
                                [
                                    'attribute' => 'status_aktif',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_aktif == 2) {
                                            return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                        } else if ($model->status_aktif == 1) {
                                            return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>