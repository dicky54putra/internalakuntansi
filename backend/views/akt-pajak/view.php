<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPajak */

$this->title = 'Detail Pajak : '.$model->nama_pajak;
//$this->params['breadcrumbs'][] = ['label' => 'Daftar Pajak', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pajak-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Pajak', ['akt-pajak/index']) ?></li>
        <li class="active">Detail Pajak</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-pajak/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_pajak], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pajak], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="box">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-hand-holding-usd"></span> Pajak</div>
    <div class="panel-body">
    <div class="col-md-12" style="padding: 0;">
    <div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_pajak',
            'kode_pajak',
            'nama_pajak',
            [
                'attribute' => 'id_akun_pembelian',
                'value' => function ($model) {
                    $nama_akun = Yii::$app->db->createCommand("SELECT nama_akun FROM akt_akun WHERE id_akun = '$model->id_akun_pembelian'")->queryScalar();
                    return $nama_akun;
                }
            ],
            [
                'attribute' => 'id_akun_penjualan',
                'value' => function ($model) {
                    $nama_akun = Yii::$app->db->createCommand("SELECT nama_akun FROM akt_akun WHERE id_akun = '$model->id_akun_penjualan'")->queryScalar();
                    return $nama_akun;
                }
            ],
            'presentasi_npwp',
            'presentasi_non_npwp',
        ],
    ]) ?>
    </div>

</div>
