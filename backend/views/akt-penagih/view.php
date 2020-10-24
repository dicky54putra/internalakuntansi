<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenagih */

$this->title = 'Detail Penagih : ' . $model->nama_penagih;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penagihs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penagih-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Penagih', ['akt-penagih/index']) ?></li>
        <li class="active"><?= $model->nama_penagih ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-penagih/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_penagih], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penagih], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-address-book"></span> Penagih</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_penagih',
                                'kode_penagih',
                                'nama_penagih',
                                'alamat:ntext',
                                [
                                    'attribute' => 'id_kota',
                                    'format' => 'raw',
                                    'label' => 'Kota',
                                    'value' => function ($model) {
                                        return $model->akt_kota->nama_kota;
                                    }
                                ],
                                'kode_pos',
                                'telepon',
                                'handphone',
                                'email:email',
                                [
                                    'attribute' => 'status_aktif',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_aktif == 2) {
                                            return '<p class="btn btn-sm btn-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                        } else if ($model->status_aktif == 1) {
                                            return '<p class="btn btn-sm btn-success" style="font-weight:bold;"> Aktif </p> ';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                    </div>