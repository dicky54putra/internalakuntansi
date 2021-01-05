<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktReturPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Retur Pembelian';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_retur_pembelian',
            [
                'attribute' => 'tanggal_retur_pembelian',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_retur_pembelian, true);
                }
            ],
            [
                'attribute' => 'id_pembelian',
                'label' => 'No. Penerimaan',
                'value' => function ($model) {
                    if (!empty($model->pembelian->no_pengiriman)) {
                        # code...
                        return $model->pembelian->no_pengiriman;
                    } else {
                        # code...
                    }
                }
            ],
            [
                'attribute' => 'status_retur',
                'format' => 'raw',
                'filter' => array(
                    1 => "Pengajuan",
                    2 => "Di Terima",
                ),
                'value' => function ($model) {
                    if ($model->status_retur == 1) {
                        # code...
                        return "<span class='label label-default'>Pengajuan</span>";
                    } elseif ($model->status_retur == 2) {
                        # code...
                        return "<span class='label label-success'>Di Terima</span>";
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
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
            'heading' => '<span class="glyphicon glyphicon-repeat"></span> ' . $this->title,
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
