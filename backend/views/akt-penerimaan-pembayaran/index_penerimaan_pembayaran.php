<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penerimaan';
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

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-truck"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs" id="tabForRefreshPage">
                            <li class="active"><a data-toggle="tab" href="#data-pembelian"><span class="fa fa-box"></span> Data Penjualan Barang Dagang</a></li>
                            <li><a data-toggle="tab" href="#data-penjualan-harta-tetap"><span class="fa fa-box"></span> Data Penjualan Harta Tetap</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="data-pembelian" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12" style="overflow: auto;">
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
                                                //     'attribute' => 'id_customer',
                                                //     'value' => function ($model) {
                                                //         if (!empty($model->customer->nama_mitra_bisnis)) {
                                                //             # code...
                                                //             return $model->customer->nama_mitra_bisnis;
                                                //         } else {
                                                //             # code...
                                                //         }
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
                                                        if (!empty($model->tanggal_penjualan)) {
                                                            # code...
                                                            return tanggal_indo($model->tanggal_penjualan, true);
                                                        } else {
                                                            # code...
                                                        }
                                                    }
                                                ],
                                                'no_faktur_penjualan',
                                                [
                                                    'attribute' => 'tanggal_faktur_penjualan',
                                                    'value' => function ($model) {
                                                        if (!empty($model->tanggal_faktur_penjualan)) {
                                                            # code...
                                                            return tanggal_indo($model->tanggal_faktur_penjualan, true);
                                                        } else {
                                                            # code...
                                                        }
                                                    }
                                                ],

                                                [
                                                    // 'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => array(
                                                        1 => 'Lunas',
                                                        2 => 'Belum Lunas',
                                                    ),
                                                    'value' => function ($model) {
                                                        $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $model->id_penjualan]);
                                                        $sum_nominal = $query->sum('nominal');
                                                        if ($model->total + $model->uang_muka == $sum_nominal) {
                                                            return "<span class='label label-success'>Lunas</span>";
                                                        } else if ($model->total + $model->uang_muka > $sum_nominal) {
                                                            return "<span class='label label-warning'>Belum Lunas</span>";
                                                        } else if ($model->total + $model->uang_muka < $sum_nominal) {
                                                            return "<span class='label label-info'>Kelebihan</span>";
                                                        }
                                                    }
                                                ],

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
                                                            $url = 'index.php?r=akt-penerimaan-pembayaran/view-penerimaan-pembayaran&id=' . $model->id_penjualan;
                                                            return $url;
                                                        }

                                                        if ($action === 'update') {
                                                            $url = 'index.php?r=akt-penerimaan-pembayaran/update-penerimaan-pembayaran&id=' . $model->id_penjualan;
                                                            return $url;
                                                        }

                                                        if ($action === 'delete') {
                                                            $url = 'index.php?r=akt-penerimaan-pembayaran/delete-penerimaan-pembayaran&id=' . $model->id_penjualan;
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
                                            // 'panel' => [
                                            //     'type' => GridView::TYPE_PRIMARY,
                                            //     'heading' => '<span class="fa fa-money-check-alt"></span> ' . $this->title,
                                            // ],
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
                                </div>
                            </div>
                            <div id="data-penjualan-harta-tetap" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12" style="overflow: auto;">
                                        <?= GridView::widget([
                                            'dataProvider' => $dataProvider2,
                                            'filterModel' => $searchModel2,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],

                                                // 'id_penjualan_harta_tetap',
                                                'no_penjualan_harta_tetap',
                                                [
                                                    'attribute' => 'tanggal_penjualan_harta_tetap',
                                                    'value' => function ($model) {
                                                        return tanggal_indo($model->tanggal_penjualan_harta_tetap, true);
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'id_customer',
                                                    'value' => function ($model) {
                                                        if (!empty($model->customer->nama_mitra_bisnis)) {
                                                            # code...
                                                            return $model->customer->nama_mitra_bisnis;
                                                        }
                                                    }
                                                ],
                                                // 'id_sales',
                                                //'id_mata_uang',
                                                //'the_approver',
                                                //'the_approver_date',
                                                //'no_faktur_penjualan_harta_tetap',
                                                //'tanggal_faktur_penjualan_harta_tetap',
                                                //'ongkir',
                                                //'pajak',
                                                //'uang_muka',
                                                //'id_kas_bank',
                                                //'total',
                                                //'diskon',
                                                //'jenis_bayar',
                                                //'jumlah_tempo',
                                                //'tanggal_tempo',
                                                //'materai',
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => array(
                                                        1 => 'Belum Disetujui',
                                                        2 => 'Sudah Disetujui',
                                                        3 => 'Ditolak',
                                                    ),
                                                    'value' => function ($model) {
                                                        $the_approver_name = "";
                                                        if (!empty($model->approver->nama)) {
                                                            # code...
                                                            $the_approver_name = $model->approver->nama;
                                                        }

                                                        $the_approver_date = "";
                                                        if (!empty($model->the_approver_date)) {
                                                            # code...
                                                            $the_approver_date = tanggal_indo2(date('D, d F Y H:i', strtotime($model->the_approver_date)));
                                                        }

                                                        if ($model->status == 1) {
                                                            # code...
                                                            return "<span class='label label-default' style='font-size: 12px;'>Belum Disetujui</span>";
                                                        } elseif ($model->status == 2) {
                                                            # code...
                                                            return "<span class='label label-success' style='font-size: 12px;'>Disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                                        } elseif ($model->status == 3) {
                                                            # code...
                                                            return "<span class='label label-danger' style='font-size: 12px;'>Ditolak pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                                                        }
                                                    }
                                                ],

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
                                                            $url = 'index.php?r=akt-penjualan-harta-tetap/view&id=' . $model->id_penjualan_harta_tetap;
                                                            return $url;
                                                        }

                                                        if ($action === 'update') {
                                                            $url = 'index.php?r=akt-penjualan-harta-tetap/update&id=' . $model->id_penjualan_harta_tetap;
                                                            return $url;
                                                        }

                                                        if ($action === 'delete') {
                                                            $url = 'index.php?r=akt-penjualan-harta-tetap/delete&id=' . $model->id_penjualan_harta_tetap;
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
                                            // 'panel' => [
                                            //     'type' => GridView::TYPE_PRIMARY,
                                            //     'heading' => '<span class="glyphicon glyphicon-shopping-cart"></span> ' . $this->title,
                                            // ],
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>