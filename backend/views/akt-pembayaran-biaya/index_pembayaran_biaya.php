<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use backend\models\Login;
use backend\models\AktPembelianHartaTetapDetail;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pembayaran';
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

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-truck"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs" id="tabForRefreshPage">
                            <li class="active"><a data-toggle="tab" href="#data-pembelian"><span class="fa fa-box"></span> Data Pembelian Barang Dagang</a></li>
                            <li><a data-toggle="tab" href="#data-pembelian-harta-tetap"><span class="fa fa-box"></span> Data Pembelian Harta Tetap</a></li>
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

                                                'no_pembelian',
                                                [
                                                    'attribute' => 'tanggal_pembelian',
                                                    // 'label' => 'Tanggal Faktur',
                                                    'value' => function ($model) {
                                                        if (!empty($model->tanggal_pembelian)) {
                                                            # code...
                                                            return tanggal_indo($model->tanggal_pembelian, true);
                                                        }
                                                    }
                                                ],
                                                'no_faktur_pembelian',
                                                [
                                                    'attribute' => 'tanggal_faktur_pembelian',
                                                    // 'label' => 'Tanggal Faktur',
                                                    'value' => function ($model) {
                                                        if (!empty($model->tanggal_faktur_pembelian)) {
                                                            # code...
                                                            return tanggal_indo($model->tanggal_faktur_pembelian, true);
                                                        }
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => array(
                                                        1 => 'Lunas',
                                                        2 => 'Belum Lunas',
                                                    ),
                                                    'value' => function ($model) {
                                                        $query = (new \yii\db\Query())->from('akt_pembayaran_biaya')->where(['id_pembelian' => $model->id_pembelian]);
                                                        $sum_nominal = $query->sum('nominal');
                                                        // return $sum_nominal;
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
                                                            $url = 'index.php?r=akt-pembayaran-biaya/view-pembayaran-biaya&id=' . $model->id_pembelian;
                                                            return $url;
                                                        }

                                                        if ($action === 'update') {
                                                            $url = 'index.php?r=akt-pembayaran-biaya/update&id=' . $model->id_pembelian;
                                                            return $url;
                                                        }

                                                        if ($action === 'delete') {
                                                            $url = 'index.php?r=akt-pembayaran-biaya/delete&id=' . $model->id_pembelian;
                                                            return $url;
                                                        }
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
                                            // 'panel' => [
                                            //     'type' => GridView::TYPE_PRIMARY,
                                            //     'heading' => '<i class="fa fa-list-alt"></i> ' . $this->title,
                                            // ],
                                            'persistResize' => false,
                                            'responsiveWrap' => false,
                                            'toggleDataOptions' => ['minCount' => 100],
                                            'exportConfig' => [
                                                GridView::EXCEL =>  [
                                                    'filename' => 'Data Pembelian',
                                                    'showPageSummary' => true,
                                                ]

                                            ],

                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                            <div id="data-pembelian-harta-tetap" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12" style="overflow: auto;">
                                        <?= GridView::widget([
                                            'dataProvider' => $dataProvider2,
                                            'filterModel' => $searchModel2,
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn'],

                                                // 'id_pembelian_harta_tetap',
                                                'no_pembelian_harta_tetap',
                                                // 'tanggal',
                                                [
                                                    'attribute' => 'tanggal',
                                                    'format' => 'raw',
                                                    'value' => function ($model) {
                                                        return tanggal_indo($model->tanggal);
                                                    }
                                                ],
                                                // 'termin',
                                                // [
                                                //     'attribute' => 'termin',
                                                //     'format' => 'raw',
                                                //     'filter' => array(0 => "CASH", 1 => "Credit"),
                                                //     'value' => function ($model) {
                                                //         if ($model->termin == 0) {
                                                //             return 'CASH';
                                                //         } else {
                                                //             return 'Credit';
                                                //         }
                                                //     }
                                                // ],
                                                // 'id_kas_bank',
                                                //'jumlah_hari',
                                                //'tanggal_selesai',
                                                // 'id_supplier',
                                                [
                                                    'attribute' => 'id_supplier',
                                                    'format' => 'raw',
                                                    'label' => 'Supplier',
                                                    'value' => function ($model) {
                                                        return $model->akt_mitra_bisnis->nama_mitra_bisnis;
                                                    }
                                                ],
                                                [
                                                    'attribute' => 'status',
                                                    'format' => 'raw',
                                                    'filter' => array(
                                                        1 => 'Lunas',
                                                        2 => 'Belum Lunas',
                                                    ),
                                                    'value' => function ($model) {
                                                        $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap]);
                                                        $sum_nominal = $query->sum('nominal');
                                                        $total = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->sum('harga');
                                                        // return $sum_nominal;
                                                        if ($total == $sum_nominal) {
                                                            return "<span class='label label-success'>Lunas</span>";
                                                        } else if ($total > $sum_nominal) {
                                                            return "<span class='label label-warning'>Belum Lunas</span>";
                                                        } else if ($total < $sum_nominal) {
                                                            return "<span class='label label-info'>Kelebihan</span>";
                                                        }
                                                    }
                                                ],
                                                // 'id_mata_uang',
                                                // [
                                                //     'attribute' => 'pajak',
                                                //     'format' => 'raw',
                                                //     'value' => function ($model) {
                                                //         if ($model->pajak == 10) {
                                                //             return '<input type="checkbox" checked disabled class="checkbox">';
                                                //         } else {
                                                //             return '<input type="checkbox" disabled class="checkbox">';
                                                //         }
                                                //     }
                                                // ],
                                                // [
                                                //     'attribute' => 'id_mata_uang',
                                                //     'format' => 'raw',
                                                //     'label' => 'Mata Uang',
                                                //     'value' => function ($model) {
                                                //         return $model->akt_mata_uang->mata_uang;
                                                //     }
                                                // ],
                                                //'status_pajak',
                                                //'keterangan:ntext',
                                                //'id_cabang',
                                                //'draft',

                                                [
                                                    'class' => 'yii\grid\ActionColumn',
                                                    'header' => 'Aksi',
                                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                                    'template' => "{view}",
                                                    'buttons' => [
                                                        'view' => function ($url, $model) {
                                                            return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', $url, [
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
                                                                    'method' => 'post'
                                                                ],
                                                            ]);
                                                        },

                                                    ],
                                                    'urlCreator' => function ($action, $model, $key, $index) {
                                                        if ($action === 'view') {
                                                            $url = 'index.php?r=akt-pembayaran-biaya/view-pembayaran-biaya-harta-tetap&id=' . $model->id_pembelian_harta_tetap;
                                                            return $url;
                                                        }

                                                        if ($action === 'update') {
                                                            $url = 'index.php?r=akt-pembelian-harta-tetap/update&id=' . $model->id_pembelian_harta_tetap;
                                                            return $url;
                                                        }

                                                        if ($action === 'delete') {
                                                            $url = 'index.php?r=akt-pembelian-harta-tetap/delete&id=' . $model->id_pembelian_harta_tetap;
                                                            return $url;
                                                        }
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
                                            // 'panel' => [
                                            //     'type' => GridView::TYPE_PRIMARY,
                                            //     'heading' => '<i class="fa fa-list-alt"></i> Daftar Pembelian Harta Tetap',
                                            // ],
                                            'persistResize' => false,
                                            'responsiveWrap' => false,
                                            'toggleDataOptions' => ['minCount' => 100],
                                            'exportConfig' => [
                                                GridView::EXCEL =>  [
                                                    'filename' => 'Data Kartu Kredit',
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