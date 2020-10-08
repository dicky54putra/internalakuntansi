<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferKas */

$this->title = 'Detail Daftar Transfer Kas : ' . $model->no_transfer_kas;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-transfer-kas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Item', ['index']) ?></li>
        <li class="active">Detail Daftar Transfer Kas : <?= $model->no_transfer_kas?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_transfer_kas], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_transfer_kas], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-book"></span> Daftar Transfer Kas</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_transfer_kas',
            [
                'attribute' => 'tanggal',
                'value' => function($model){
                    return tanggal_indo($model->tanggal,true);
                }
            ],
            [
                'attribute' => 'id_asal_kas',
                'value' => function($model){
                    return $model->kas_bank->keterangan;
                }
            ],
            [
                'attribute' => 'id_tujuan_kas',
                'value' => function($model){
                    $tujuan_kas = Yii::$app->db->createCommand("SELECT keterangan FROM akt_kas_bank WHERE id_kas_bank = '$model->id_tujuan_kas'")->queryScalar();
                    return $tujuan_kas;
                }
            ],
            [
                'attribute' => 'jumlah1',
                'value' => function($model){
                    return ribuan($model->jumlah1, true);
                }
            ],
            'keterangan:ntext',
        ],
    ]) ?>

</div>
