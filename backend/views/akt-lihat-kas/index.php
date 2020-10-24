<?php

use backend\models\AktPembayaranBiaya;
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktLevelHargaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Kas Bank';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-level-harga-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Kas Bank</li>
    </ul>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-building"></span> Daftar Kas Bank</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <div id="stok" class="tab-pane fade in active">
                            <table class="table" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama Kas/Bank</th>
                                        <th>Saldo</th>
                                        <th>Kas Masuk Bulan ini</th>
                                        <th>Kas Keluar Bulan ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($model_kas as $kas) {
                                        $kel = Yii::$app->db->createCommand("SELECT SUM(nominal) from akt_pembayaran_biaya where id_kas_bank = " . $kas['id_kas_bank'] . " AND date_format(tanggal_pembayaran_biaya, '%Y-%m') = '" . date('Y-m') . "'")->queryScalar();
                                        $mas = Yii::$app->db->createCommand("SELECT SUM(nominal) from akt_penerimaan_pembayaran where id_kas_bank = " . $kas['id_kas_bank'] . " AND date_format(tanggal_penerimaan_pembayaran, '%Y-%m') = '" . date('Y-m') . "'")->queryScalar();
                                    ?>
                                        <tr>
                                            <td> <?= $no++ ?> </td>
                                            <td> <?= $kas['kode_kas_bank'] ?> </td>
                                            <td> <?= $kas['keterangan'] ?> </td>
                                            <td> <?= $kas['simbol'] . '. ' . ribuan($kas['saldo']) ?> </td>
                                            <td> <?= $kas['simbol'] . '. ' . ribuan($mas) ?> </td>
                                            <td> <?= $kas['simbol'] . '. ' . ribuan($kel) ?> </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>