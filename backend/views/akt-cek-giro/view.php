<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktMitraBisnis;
use backend\models\AktMataUang;
use backend\models\AktKasBank;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCekGiro */

$this->title = 'Detail Daftar Cek/Giro : '. $model->no_transaksi;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-cek-giro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Cek/Giro', ['index']) ?></li>
        <li class="active">Detail Daftar Cek/Giro : <?= $model->no_transaksi ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_cek_giro], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_cek_giro], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-list-alt"></span> Daftar Cek/Giro</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_transaksi',
            'no_cek_giro',
            [
                'attribute' => 'tanggal_terbit',
                'value' => function($model){
                    return tanggal_indo($model->tanggal_terbit,true);
                }
            ],
            [
                'attribute' => 'tanggal_effektif',
                'value' => function($model){
                    return tanggal_indo($model->tanggal_effektif,true);
                }
            ],
            [
                'attribute' => 'tipe',
                'value' => function($model){
                    if($model->tipe == 1 ) {
                        return 'Cheque';
                    } else {
                        return 'Giro';
                    }
                }
            ],
            [
                'attribute' => 'in_out',
                'value' => function($model){
                    if($model->in_out == 1 ) {
                        return 'In';
                    } else {
                        return 'Out';
                    }
                }
            ],
            [
                'attribute' => 'id_bank_asal',
                'value' => function($model){
                   $mata_uang = AktKasBank::findOne($model->id_bank_asal);
                   return $mata_uang['keterangan'];
                }
            ],
            [
                'attribute' => 'id_mata_uang',
                'value' => function($model){
                   $mata_uang = AktMataUang::findOne($model->id_mata_uang);
                   return $mata_uang['mata_uang'];
                }
            ],
            [
                'attribute' => 'jumlah',
                'value' => function($model){
                    return ribuan($model->jumlah,true);
                }
            ],
            'cabang_bank',
            [
                'attribute' => 'tanggal_kliring',
                'value' => function($model){
                    return tanggal_indo($model->tanggal_kliring,true);
                }
            ],
            'bank_kliring',
            [
                'attribute' => 'id_penerbit',
                'value' => function($model){
                   $penerbit = AktMitraBisnis::findOne($model->id_penerbit);
                   return $penerbit['nama_mitra_bisnis'];
                }
            ],
            [
                'attribute' => 'id_penerima',
                'format' => 'html',
                'value' => function($model){
                    if($model->id_penerima == null ) {
                        return '<p style="color:red;">not set </p>';
                    }
                   $penerima = AktMitraBisnis::findOne($model->id_penerima);
                   return $penerima['nama_mitra_bisnis'];
                }
            ],
        ],
    ]) ?>

</div>
