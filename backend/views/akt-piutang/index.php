<?php

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
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_penjualan',
            // 'no_order_penjualan',
            // [
            //     'attribute' => 'tanggal_order_penjualan',
            //     'value' => function ($model) {
            //         return tanggal_indo($model->tanggal_order_penjualan, true);
            //     }
            // ],
            // [
            //     'attribute' => 'id_sales',
            //     'value' => function ($model) {
            //         if (!empty($model->sales->nama_sales)) {
            //             # code...
            //             return $model->sales->nama_sales;
            //         } else {
            //             # code...
            //         }
            //     }
            // ],
            // [
            //     'attribute' => 'id_mata_uang',
            //     'value' => function ($model) {
            //         if (!empty($model->mata_uang->mata_uang)) {
            //             # code...
            //             return $model->mata_uang->mata_uang;
            //         } else {
            //             # code...
            //         }
            //     }
            // ],
            'no_penjualan',
            [
                'attribute' => 'tanggal_penjualan',
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
            //'tanggal_penjualan',
            //'no_faktur_penjualan',
            //'tanggal_faktur_penjualan',
            //'ongkir',
            //'pajak',
            // 'total',
            //'bayar',
            // 'kekurangan',
            // [
            //     'attribute' => 'kekurangan',
            //     'format' => 'raw',
            //     'value' => function ($model) {
            //         return 0;
            //     }
            // ],
            //'jenis_bayar',
            // 'jumlah_tempo',
            // 'tanggal_tempo',
            [
                'attribute' => 'jumlah_tempo',
                'label' => 'Jumlah Tempo',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->jumlah_tempo . ' hari';
                }
            ],
            [
                'attribute' => 'tanggal_tempo',
                'label' => 'Tanggal Tempo',
                'format' => 'raw',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_tempo);
                }
            ],
            [
                'attribute' => 'total',
                'label' => 'Total',
                'format' => 'raw',
                'value' => function ($model) {
                    $sum_nominal_penerimaan = Yii::$app->db->createCommand("SELECT SUM(nominal) from akt_penerimaan_pembayaran WHERE id_penjualan = '$model->id_penjualan'")->queryScalar();
                    if($sum_nominal_penerimaan == null ) {
                        return ribuan($model->total);
                    } else {
                        return ribuan($model->total - $sum_nominal_penerimaan);
                    }
                }
            ],
            //'id_kas_bank',
            //'materai',
            //'id_penagih',
            //'id_pengirim',
            //'tanggal_antar',
            //'pengantar',
            //'penerima',
            //'keterangan_antar:ntext',
            //'tanggal_terima',
            // [
            //     'attribute' => 'status',
            //     'format' => 'raw',
            //     'filter' => array(
            //         1 => 'Order Penjualan',
            //         2 => 'Penjualan',
            //         3 => 'Pengiriman',
            //         4 => 'Completed',
            //     ),
            //     'value' => function ($model) {
            //         if ($model->status == 1) {
            //             # code...
            //             return "<span class='label label-default'>Order Penjualan</span>";
            //         } elseif ($model->status == 2) {
            //             # code...
            //             return "<span class='label label-warning'>Penjualan</span>";
            //         } elseif ($model->status == 3) {
            //             # code...
            //             return "<span class='label label-primary'>Pengiriman</span>";
            //         } elseif ($model->status == 4) {
            //             # code...
            //             return "<span class='label label-success'>Completed</span>";
            //         }
            //     }
            // ],

            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'header' => 'Actions',
            //     'headerOptions' => ['style' => 'color:#337ab7'],
            //     'template' => "{view}",
            //     'buttons' => [
            //         'view' => function ($url, $model) {
            //             return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail</button>', $url, [
            //                 'title' => Yii::t('app', 'lead-view'),
            //             ]);
            //         },

            //         'update' => function ($url, $model) {
            //             return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
            //                 'title' => Yii::t('app', 'lead-update'),
            //             ]);
            //         },
            //         'delete' => function ($url, $model) {
            //             return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
            //                 'title' => Yii::t('app', 'lead-delete'),
            //                 'data' => [
            //                     'confirm' => 'Anda yakin ingin menghapus data?',
            //                     'method' => 'post',
            //                 ],
            //             ]);
            //         },

            //     ],
            //     'urlCreator' => function ($action, $model, $key, $index) {
            //         if ($action === 'view') {
            //             $url = 'index.php?r=akt-penjualan/view&id=' . $model->id_penjualan;
            //             return $url;
            //         }

            //         if ($action === 'update') {
            //             $url = 'index.php?r=akt-penjualan/update&id=' . $model->id_penjualan;
            //             return $url;
            //         }

            //         if ($action === 'delete') {
            //             $url = 'index.php?r=akt-penjualan/delete&id=' . $model->id_penjualan;
            //             return $url;
            //         }
            //     }
            // ],
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