<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCabang */

$this->title = 'Detail Daftar Cabang : ' . $model->kode_cabang;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-cabang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Cabang', ['index']) ?></li>
        <li class="active">Detail Daftar Cabang</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_cabang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_cabang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-flag-checkered"></span> Detail Daftar Cabang</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_cabang',
                                'kode_cabang',
                                'nama_cabang',
                                'nama_cabang_perusahaan',
                                'alamat',
                                'telp',
                                'fax',
                                'npwp',
                                'pkp',
                                // 'id_customer',
                                // [
                                //     'attribute' => 'id_customer',
                                //     'label' => 'Customer',
                                //     'format' => 'raw',
                                //     'value' => function ($model) {
                                //         return $model->mitra_bisnis->nama_mitra_bisnis;
                                //     }
                                // ]
                                // // 'id_foto',
                            ],
                        ]) ?>

                    </div>
                </div>