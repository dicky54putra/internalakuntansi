<?php

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
            // 'saldo_akun',
            // 'header',
            // 'parent',
            // 'jenis',
            // 'klasifikasi',
            // 'status_aktif',

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