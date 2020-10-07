<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktMataUang */

$this->title = 'Detail Daftar Mata Uang : ' . $model->kode_mata_uang;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-mata-uang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Mata Uang', ['index']) ?></li>
        <li class="active">Detail Daftar Mata Uang</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_mata_uang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_mata_uang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-usd"></span> Detail Mata Uang</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_mata_uang',
                                'kode_mata_uang',
                                'mata_uang',
                                'simbol',
                                'kurs',
                                'fiskal',
                                // 'rate_type',
                                [
                                    'attribute' => 'rate_type',
                                    'filter' => array(1 => 'Normal', 2 => 'Reverse'),
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->rate_type == 1) {
                                            return '<p class="text-primary" style="font-weight:bold;"> Normal </p> ';
                                        } else if ($model->rate_type == 1) {
                                            return '<p class="text-success" style="font-weight:bold;"> Reserve </p> ';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'status_default',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_default == 2) {
                                            return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                        } else if ($model->status_default == 1) {
                                            return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                    </div>