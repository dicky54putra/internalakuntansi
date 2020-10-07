<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSales */

$this->title = 'Detail Sales : ' . $model->nama_sales;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Sales', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-sales-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Sales', ['akt-sales/index']) ?></li>
        <li class="active"><?= $model->nama_sales ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-sales/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_sales], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_sales], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-street-view"></span> Sales</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_sales',
                                'kode_sales',
                                'nama_sales',
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