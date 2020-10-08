<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenawaranPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Penawaran Penjualan';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penawaran-penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title; ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_penawaran_penjualan',
            'no_penawaran_penjualan',
            [
                'attribute' => 'tanggal',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal);
                }
            ],
            [
                'attribute' => 'id_customer',
                'value' => function ($model) {
                    return $model->customer->nama_mitra_bisnis;
                }
            ],
            // [
            //     'attribute' => 'id_sales',
            //     'value' => function ($model) {
            //         return $model->sales->nama_sales;
            //     }
            // ],
            // [
            //     'attribute' => 'id_mata_uang',
            //     'value' => function ($model) {
            //         return $model->mata_uang->mata_uang;
            //     }
            // ],
            // // 'pajak',
            // [
            //     'attribute' => 'pajak',
            //     'format' => 'raw',
            //     'filter' => array(1 => 'Iya', 0 => 'Tidak'),
            //     'value' => function ($model) {
            //         if ($model->pajak == 1) {
            //             # code...
            //             return '<input type="checkbox" name="" id="" checked disabled>';
            //         } else {
            //             return '<input type="checkbox" name="" id="" disabled>';
            //             # code...
            //         }
            //     }
            // ],
            // [
            //     'attribute' => 'id_penagih',
            //     'value' => function ($model) {
            //         return $model->penagih->nama_mitra_bisnis;
            //     }
            // ],
            // [
            //     'attribute' => 'id_pengirim',
            //     'value' => function ($model) {
            //         return $model->pengirim->nama_mitra_bisnis;
            //     }
            // ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    1 => 'Belum Disetujui',
                    2 => 'Disetujui',
                    3 => 'Ditolak',
                ),
                'value' => function ($model) {
                    $retValStatus = ($model->status == 2) ? 'Disetujui pada ' : 'Ditolak pada ';
                    $retValColor = ($model->status == 2) ? 'success pada ' : 'danger pada ';
                    if ($model->status == 1) {
                        # code...
                        return "<span class='label label-warning'>Belum Disetujui</span>";
                    } elseif ($model->status == 2) {
                        # code...
                        return "<span class='label label-$retValColor'>" . $retValStatus . "" . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $model->login->nama . "</span>";
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-$retValColor'>" . $retValStatus . "" . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $model->login->nama . "</span>";
                    }
                }
            ],

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
                        $url = 'index.php?r=akt-penawaran-penjualan/view&id=' . $model->id_penawaran_penjualan;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-penawaran-penjualan/update&id=' . $model->id_penawaran_penjualan;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-penawaran-penjualan/delete&id=' . $model->id_penawaran_penjualan;
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
                'filename' => 'Penagih',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>