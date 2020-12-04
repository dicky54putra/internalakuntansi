<?php

use backend\models\AktAkun;
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Laporan Daftar Akun';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Akuntansi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['cetak-laporan-daftar-akun'], ['class' => 'btn btn-default', 'target' => '_blank']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_akun',
            [
                'attribute' => 'jenis',
                'format' => 'raw',
                'filter' => array(
                    1 => 'Harta',
                    2 => 'Kewajiban',
                    3 => 'Modal',
                    4 => 'Pendapatan',
                    5 => 'Pendapatan Lain',
                    6 => 'Pengeluaran Lain',
                    7 => 'Biaya Atas Pendapatan',
                    8 => 'Pengeluaran Operasional',
                ),
                'value' => function ($model) {
                    $j = $model->jenis;
                    if ($j == 1) {
                        return 'Harta';
                    } elseif ($j == 2) {
                        return 'Kewajiban';
                    } elseif ($j == 3) {
                        return 'Modal';
                    } elseif ($j == 4) {
                        return 'Pendapatan';
                    } elseif ($j == 5) {
                        return 'Pendapatan Lain';
                    } elseif ($j == 6) {
                        return 'Pengeluaran Lain';
                    } elseif ($j == 7) {
                        return 'Biaya Atas Pendapatan';
                    } else {
                        return 'Pengeluaran Operasional';
                    }
                }
            ],
            [
                'attribute' => 'klasifikasi',
                'value' => function ($model) {
                    return $model->akt_klasifikasi->klasifikasi;
                }
            ],
            'kode_akun',
            'nama_akun',
            [
                'attribute' => 'header',
                'filter' => array(
                    1 => 'Header',
                    0 => 'Bukan Header',
                ),
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->header == 1) {
                        return '<input type="checkbox" checked disabled class="checkbox">';
                    } else {
                        return '<input type="checkbox" disabled class="checkbox">';;
                    }
                }
            ],
            [
                'attribute' => 'parent',
                'value' => function ($model) {
                    if (!empty($model->parent)) {
                        $akt_akun = AktAkun::findOne($model->parent);
                        return $akt_akun->nama_akun;
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'klasifikasi',
                'value' => function ($model) {
                    return $model->akt_klasifikasi->klasifikasi;
                }
            ],
            [
                'attribute' => 'saldo_normal',
                'format' => 'raw',
                'filter' => array(
                    1 => 'Debet',
                    2 => 'Kredit',
                ),
                'value' => function ($model) {
                    if ($model->saldo_normal == 1) {
                        return 'Debet';
                    } else if ($model->saldo_normal == 2) {
                        return 'Kredit';
                    }
                }
            ],

        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [

            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        // parameters from the demo form
        //'bordered' => $bordered,
        //'striped' => $striped,
        //'condensed' => $condensed,
        //'responsive' => $responsive,
        //'hover' => $hover,
        //'showPageSummary' => $pageSummary,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-check"></span> ' . $this->title,
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false,
            'target' => GridView::TARGET_BLANK
        ],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Akun',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>