<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AbsensiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Laporan Stok';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <table class="table">
                            <tr class="hidden">
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Lihat Stok', ['lihat-stok']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Penyesuaian Stok', ['laporan-penyesuaian-stok']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Stok Masuk', ['laporan-stok-masuk']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Stok Keluar', ['laporan-stok-keluar']) ?></td>
                            </tr>
                            <tr>
                                <td><?= Html::a('<span class="fa fa-file-text"></span> Laporan Transfer Stok', ['laporan-transfer-stok']) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>