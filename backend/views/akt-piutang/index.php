<?php

use backend\models\AktPenerimaanPembayaran;
use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Piutang';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_penjualan',
            [
                'attribute' => 'tanggal_penjualan',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_penjualan, true);
                }
            ],
            [
                'attribute' => 'id_customer',
                'value' => function ($model) {
                    if (!empty($model->customer->nama_mitra_bisnis)) {
                        # code...
                        return $model->customer->nama_mitra_bisnis;
                    } else {
                        # code...
                    }
                }
            ],
            [
                'attribute' => 'jumlah_tempo',
                'label' => 'Jumlah Tempo',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->jenis_bayar == 2) {
                        return $model->jumlah_tempo . ' hari';
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'tanggal_tempo',
                'label' => 'Tanggal Tempo',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->tanggal_tempo)) {
                        return tanggal_indo($model->tanggal_tempo);
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'total',
                'label' => 'Total',
                'format' => 'raw',
                'value' => function ($model) {
                    $penerimaan_pembayaran = AktPenerimaanPembayaran::find()->select(['nominal'])->where(['id_penjualan' => $model->id_penjualan])->one();
                    $kekurangan_pembayaran = empty($penerimaan_pembayaran) ? $model->total - $penerimaan_pembayaran['nominal'] : $model->total - $penerimaan_pembayaran['nominal'] + $model->uang_muka;
                    return ribuan(abs($kekurangan_pembayaran));
                }
            ],
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
        //'showPageSummary' => $pageSummary,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-shopping-cart"></span> ' . $this->title,
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