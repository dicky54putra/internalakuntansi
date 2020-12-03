<?php

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
                    return $model->jatuh_tempo . ' hari';
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
                    $sum_nominal_pembayaran  = Yii::$app->db->createCommand("SELECT SUM(nominal) from akt_pembayaran_biaya WHERE id_pembelian = '$model->id_pembelian'")->queryScalar();
                    if ($sum_nominal_pembayaran  == null) {
                        return ribuan($model->total);
                    } else {
                        return ribuan($model->total - $sum_nominal_pembayaran);
                    }
                }
            ],
            // [
            //     'attribute' => 'id_sales',
            //     'label' => 'Sales',
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
            //     'label' => 'Mata Uang',
            //     'value' => function ($model) {
            //         if (!empty($model->mata_uang->mata_uang)) {
            //             # code...
            //             return $model->mata_uang->mata_uang;
            //         } else {
            //             # code...
            //         }
            //     }
            // ],
            // [
            //     'attribute' => 'status',
            //     'format' => 'raw',
            //     'filter' => array(
            //         // 1 => 'Order pembelian',
            //         // 2 => 'pembelian',
            //         // 3 => 'Pengiriman',
            //         4 => 'Completed',
            //     ),
            //     'value' => function ($model) {
            //         if ($model->status == 1) {
            //             # code...
            //             return "<span class='label label-default'>Order pembelian</span>";
            //         } elseif ($model->status == 2) {
            //             # code...
            //             return "<span class='label label-warning'>pembelian</span>";
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
            //             $url = 'index.php?r=akt-pembelian/view&id=' . $model->id_pembelian;
            //             return $url;
            //         }

            //         if ($action === 'update') {
            //             $url = 'index.php?r=akt-pembelian/update&id=' . $model->id_pembelian;
            //             return $url;
            //         }

            //         if ($action === 'delete') {
            //             $url = 'index.php?r=akt-pembelian/delete&id=' . $model->id_pembelian;
            //             return $url;
            //         }
            //     }
            // ],

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