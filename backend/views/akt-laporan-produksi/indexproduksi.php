<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AbsensiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Laporan Rekap Hasil Produksi';
?>
<div class="absensi-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Laporan Produksi', ['akt-laporan-produksi/index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <div class="box">
        <div class="box-header">
            <div style="padding: 0;">
                <div class="box-body">
                    <?= Html::beginForm(['lap']) ?>
                    <input type="hidden" name="type" value="5">
                    <div class="form-group">
                        <label for="">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Print', ['class' => 'btn btn-success']) ?>
                    </div>
                    <?= Html::endForm(); ?>
                </div>
            </div>
        </div>
    </div>
</div>