<?php

use backend\models\AktItem;
use backend\models\AktGudang;
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktLevelHargaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Lihat Stok';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-level-harga-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                // 'contentOptions' => ['class' => 'kartik-sheet-style'],
                // 'pageSummary' => 'Total',
                // 'header' => '#',
                // 'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'attribute' => 'id_item',
                'format' => 'raw',
                'label' => 'Kode Barang',
                'value' => function ($model) {
                    $akt_item = AktItem::find()->where(['id_item' => $model->id_item])->one();
                    if (!empty($akt_item->kode_item)) {
                        return $akt_item->kode_item;
                    }
                }
            ],
            [
                'attribute' => 'id_item',
                'format' => 'raw',
                'label' => 'Nama Barang',
                'value' => function ($model) {
                    $akt_item = AktItem::find()->where(['id_item' => $model->id_item])->one();
                    if (!empty($akt_item->nama_item)) {
                        return $akt_item->nama_item;
                    }
                }
            ],
            [
                'attribute' => 'id_gudang',
                'format' => 'raw',
                'label' => 'Gudang',
                'value' => function ($model) {
                    $akt_gudang = AktGudang::find()->where(['id_gudang' => $model->id_gudang])->one();
                    if (!empty($akt_gudang->nama_gudang)) {
                        return  $akt_gudang->nama_gudang;
                    }
                }
            ],
            'location',
            [
                'class' => 'kartik\grid\FormulaColumn',
                'attribute' => 'qty',
                'format' => 'raw',
                'value' =>  function ($model) {
                    if ($model->qty < $model->min) {
                        return '<p class="label label-danger">' . $model->qty . '</p>';
                    } else {
                        return '<p class="label label-success">' . $model->qty . '</p>';
                    }
                },
                // 'pageSummary' => true,
                // 'pageSummaryFunc' => GridView::F_SUM,
            ],
            // [
            //     'class' => 'kartik\grid\FormulaColumn',
            //     'attribute' => 'hpp',
            //     'value' => 'hpp',
            //     'pageSummary' => true,
            //     'pageSummaryFunc' => GridView::F_SUM,
            // ],
            // [
            //     'class' => 'kartik\grid\FormulaColumn',
            //     'attribute' => 'min',
            //     'value' => 'min',
            //     'pageSummary' => true,
            //     'pageSummaryFunc' => GridView::F_SUM,
            // ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        // 'showPageSummary' => true,
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
            'heading' => '<span class="fa fa-cube"></span> Level Harga',
            'before' => '<span class="label label-danger">Merah</span> Low Stock    <span class="label label-success">Hijau</span>: Normal Stock'
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
                'filename' => 'Level Harga',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>