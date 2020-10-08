<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AbsensiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Produksi';
?>

<div class="absensi-index">
<h2><?= Html::encode($this->title) ?></h2>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file"></span> Laporan Produksi</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                    <table>
                        <tr>
                            <td> <?= Html::a('<span class="fa fa-file"></span> Laporan Detail Produksi', ['index-detail'] ) ?> </td>
                        </tr>
                        <tr>
                            <td> <?= Html::a('<span class="fa fa-file"></span> Laporan Rekap Produksi per Item', ['index-item'] ) ?> </td>
                        </tr>
                        <tr>
                            <td> <?= Html::a('<span class="fa fa-file"></span> Laporan Rekap Pemakaian Bahan', ['index-bahan'] ) ?> </td>
                        </tr>
                        <tr>
                            <td> <?= Html::a('<span class="fa fa-file"></span> Laporan Daftar BOM', ['index-bom'] ) ?> </td>
                        </tr>
                        <tr>
                            <td> <?= Html::a('<span class="fa fa-file"></span> Laporan Rekap Hasil Produksi', ['index-produksi'] ) ?> </td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>