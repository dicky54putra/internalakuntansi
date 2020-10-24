<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktGudang */

$this->title = 'Detail Gudang : ' . $model->kode_gudang;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Gudangs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
?>
<div class="akt-gudang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Gudang', ['index']) ?></li>
        <li class="active"><?= $model->kode_gudang ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_gudang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_gudang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-home"></span> Gudang</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_gudang',
                                'kode_gudang',
                                'nama_gudang',
                                [
                                    'attribute' => 'status_aktif_gudang',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_aktif_gudang == 2) {
                                            return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                        } else if ($model->status_aktif_gudang == 1) {
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