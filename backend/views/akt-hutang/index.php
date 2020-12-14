<?php

use backend\models\AktPembayaranBiaya;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Hutang';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-index">

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
            ['class' => 'yii\grid\SerialColumn'],

            'no_pembelian',
            [
                'attribute' => 'tanggal_pembelian',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'headerOptions' => ['style' => 'color:#337ab7'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'value'     => function ($model) {

                    return tanggal_indo($model->tanggal_pembelian, true);
                }
            ],
            [
                'attribute' => 'id_customer',
                'label' => 'Customer',
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
                'attribute' => 'jatuh_tempo',
                'label' => 'Jumlah Tempo',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->jenis_bayar == 2) {
                        return $model->jatuh_tempo . ' hari';
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'tanggal_tempo',
                'label' => 'Tanggal Tempo',
                'format' => 'raw',
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
                    if ($model->tanggal_tempo != null) {

                        return tanggal_indo($model->tanggal_tempo, true);
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
                    $pembayaran_biaya = AktPembayaranBiaya::find()->select(['nominal'])->where(['id_pembelian' => $model->id_pembelian])->one();
                    $kekurangan_pembayaran = empty($pembayaran_biaya) ? $model->total - $pembayaran_biaya['nominal'] : $model->total - $pembayaran_biaya['nominal'] + $model->uang_muka;
                    return ribuan(abs($kekurangan_pembayaran));
                }
            ],

        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [

            // '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fa fa-list-alt"></i>  ' . $this->title,
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data Pembelian',
                'showPageSummary' => true,
            ]

        ],

    ]); ?>
</div>