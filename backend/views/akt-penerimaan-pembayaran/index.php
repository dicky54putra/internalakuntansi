<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenerimaanPembayaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penerimaan Pembayaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penerimaan-pembayaran-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_penerimaan_pembayaran_penjualan',
            [
                'attribute' => 'tanggal_penerimaan_pembayaran',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_penerimaan_pembayaran, true);
                }
            ],
            [
                'attribute' => 'jenis_penerimaan',
                'filter' => array(
                    1 => 'Penjualan Barang',
                    2 => 'Penjualan Harta Tetap',
                ),
                'value' => function ($model) {
                    if ($model->jenis_penerimaan == 1) {
                        # code...
                        return 'Penjualan Barang';
                    } elseif ($model->jenis_penerimaan == 2) {
                        # code...
                        return 'Penjualan Harta Tetap';
                    }
                }
            ],
            'id_penjualan',
            [
                'attribute' => 'cara_bayar',
                'filter' => array(
                    1 => 'Tunai',
                    2 => 'Transfer',
                    3 => 'Giro',
                ),
                'value' => function ($model) {
                    if ($model->cara_bayar == 1) {
                        # code...
                        return 'Tunai';
                    } elseif ($model->cara_bayar == 2) {
                        # code...
                        return 'Transfer';
                    } elseif ($model->cara_bayar == 3) {
                        # code...
                        return 'Giro';
                    }
                }
            ],
            'id_kas_bank',
            [
                'attribute' => 'nominal',
                'hAlign' => 'right',
                'value' => function ($model) {
                    return ribuan($model->nominal);
                }
            ],
            'keterangan:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail</button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=akt-penerimaan-pembayaran/view&id=' . $model->id_penerimaan_pembayaran_penjualan;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-penerimaan-pembayaran/update&id=' . $model->id_penerimaan_pembayaran_penjualan;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-penerimaan-pembayaran/delete&id=' . $model->id_penerimaan_pembayaran_penjualan;
                        return $url;
                    }
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
            'heading' => '<span class="fa fa-money-check-alt"></span> ' . $this->title,
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