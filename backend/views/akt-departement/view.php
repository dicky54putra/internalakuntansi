<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktDepartement */

$this->title = 'Detail Daftar Departemen : '.$model->kode_departement;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Departements', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-departement-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Departement', ['akt-departement/index']) ?></li>
        <li class="active">Detail Daftar Departemen</li>
    </ul>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-departement/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_departement], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_departement], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-clipboard-list"></span> Daftar Departement</div>
    <div class="panel-body">
    <div class="col-md-12" style="padding: 0;">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_departement',
            'kode_departement',
            'nama_departement',
            'keterangan:ntext',
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
