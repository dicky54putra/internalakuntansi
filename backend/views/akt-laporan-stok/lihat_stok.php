<?php

use backend\models\AktGudang;
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lihat Stok';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-item-stok-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Stok', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'pageSummary' => 'Total',
                'header' => '#',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],

            // 'id_item_stok',
            [
                'attribute' => 'id_item',
                'label' => 'Nama Barang',
                'value' => function ($model) {
                    if (!empty($model->item->nama_item)) {
                        # code...
                        return $model->item->nama_item;
                    } else {
                        # code...
                    }
                }
            ],
            [
                'attribute' => 'id_gudang',
                'label' => 'Nama Gudang',
                'value' => function ($model) {
                    if (!empty($model->gudang->nama_gudang)) {
                        # code...
                        return $model->gudang->nama_gudang;
                    } else {
                        # code...
                    }
                }
            ],
            'location',
            [
                'class' => 'kartik\grid\FormulaColumn',
                'attribute' => 'qty',
                'value' => 'qty',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM,
            ],
            [
                'class' => 'kartik\grid\FormulaColumn',
                'attribute' => 'hpp',
                'value' => function($model) {
                    return $model->hpp;
                },
                'format' => 'decimal',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM,
            ],
            [
                'class' => 'kartik\grid\FormulaColumn',
                'attribute' => 'min',
                'value' => 'min',
                'pageSummary' => true,
                'pageSummaryFunc' => GridView::F_SUM,
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
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
        'showPageSummary' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="fa fa-file-text"></span> ' . $this->title,
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
                'filename' => $this->title,
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>