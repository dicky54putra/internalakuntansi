<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\JurnalTransaksiDetail;
use backend\models\AktAkun;
/* @var $this yii\web\View */
/* @var $model backend\models\JurnalTransaksi */

$this->title = $model->nama_transaksi;
\yii\web\YiiAsset::register($this);
?>
<div class="jurnal-transaksi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Jurnal Transaksi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_jurnal_transaksi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_jurnal_transaksi], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-chart-bar"></span> Jurnal Transaksi</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_jurnal_transaksi',
                                // 'nama_transaksi',
                            ],
                        ]) ?>

                        <div class="">
                            <p>
                                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Jurnal Transaksi Detail', ['jurnal-transaksi-detail/create', 'id' => $model->id_jurnal_transaksi], ['class' => 'btn btn-success']) ?>
                            </p>

                            <table class="table" style="width:100%;margin-top:20px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipe</th>
                                        <th>Akun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_jurnal = JurnalTransaksiDetail::find()->where(['id_jurnal_transaksi' => $model->id_jurnal_transaksi])->asArray()->all();
                                    foreach ($query_jurnal as $key => $data) {

                                        $akun = AktAkun::findOne($data['id_akun']);
                                    ?>
                                        <tr>
                                            <td><?= $no++ . '.' ?></td>
                                            <td><?= $data['tipe']  ?></td>
                                            <td><?= $akun->nama_akun; ?></td>
                                            <td>
                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['jurnal-transaksi-detail/update', 'id' => $data['id_jurnal_transaksi_detail']], ['class' => 'btn btn-primary']) ?>
                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['jurnal-transaksi-detail/delete', 'id' => $data['id_jurnal_transaksi_detail']], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>