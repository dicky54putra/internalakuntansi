<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPegawai */

$this->title = 'Detail Pegawai : ' . $model->nama_pegawai;
//$this->params['breadcrumbs'][] = ['label' => 'Akt Pegawais', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pegawai-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pegawai', ['akt-pegawai/index']) ?></li>
        <li class="active"><?= $model->nama_pegawai ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-pegawai/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_pegawai], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pegawai], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-user-tie"></span> Pegawai</div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_pegawai',
                            'kode_pegawai',
                            'nama_pegawai',
                            'alamat:ntext',
                            [
                                'attribute' => 'id_kota',
                                'format' => 'raw',
                                'label' => 'Kota',
                                'value' => function ($model) {
                                    return $model->akt_kota->nama_kota;
                                }
                            ],
                            [
                                'attribute' => 'kode_pos',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->kode_pos != null ) {
                                        return $model->kode_pos;
                                    } else if ($model->kode_pos == null ) {
                                        return '<p style="color:red;"> Belum diset </p>';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'telepon',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->telepon != null ) {
                                        return $model->telepon;
                                    } else if ($model->telepon == null ) {
                                        return '<p style="color:red;"> Belum diset </p>';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'handphone',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->handphone != null ) {
                                        return $model->handphone;
                                    } else if ($model->handphone == null ) {
                                        return '<p style="color:red;"> Belum diset </p>';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'email',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->email != null ) {
                                        return $model->email;
                                    } else if ($model->email == null ) {
                                        return '<p style="color:red;"> Belum diset </p>';
                                    }
                                }
                            ],
                            [
                                'attribute' => 'status_aktif',
                                'format' => 'html',
                                'value' => function ($model) {
                                    if ($model->status_aktif == 0) {
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