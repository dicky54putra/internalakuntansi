<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCabang */

$this->title = 'Detail Daftar Proyek : ' . $model->kode_proyek;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-cabang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Proyek', ['akt-proyek/index']) ?></li>
        <li class="active">Detail Daftar Proyek</li>
    </ul>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-proyek/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_proyek], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_proyek], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-gavel"></span> Daftar Proyek</div>
    <div class="panel-body">
    <div class="col-md-12" style="padding: 0;">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_proyek',
            'kode_proyek',
            'nama_proyek',
            'id_pegawai',
            'id_mitra_bisnis',
            [
                'attribute' => 'status_aktif',
                'format' => 'html',
                'value' => function($model) {
                    if($model->status_aktif == 2 ) {
                        return '<p class="btn btn-sm btn-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                    } else if($model->status_aktif == 1) {
                        return '<p class="btn btn-sm btn-success" style="font-weight:bold;"> Aktif </p> ';
                    }
                }
            ],
        ],
    ]) ?>
</div>
</div>
