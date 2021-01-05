<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktProduksiBomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Produksi B.o.M';
?>
<div class="akt-produksi-bom-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Produksi B.o.M</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_produksi_bom',
            'no_produksi_bom',
            [
                'attribute' => 'tanggal',
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
                    return tanggal_indo($model->tanggal, true);
                }
            ],
            [
                'attribute' => 'id_pegawai',
                'label' => 'Pegawai',
                'value' => function ($model) {
                    if ($model->id_pegawai == NULL) {
                        return 'Semua';
                    } else {
                        return $model->pegawai->nama_pegawai;
                    }
                }
            ],
            [
                'attribute' => 'id_customer',
                'value' => 'mitra_bisnis.nama_mitra_bisnis'
            ],
            [
                'attribute' => 'status_produksi',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status_produksi == 0) {
                        return '<span class="label label-default">Persiapan Produksi</span>';
                    } else if ($model->status_produksi == 1) {
                        return '<span class="label label-success">Proses Produksi</span>';
                    } else if ($model->status_produksi == 2) {
                        return '<span class="label label-warning">Selesai Produksi</span>';
                    } else if ($model->status_produksi == 3) {
                        return '<span class="label label-danger">Ditolak</span>';
                    }
                }
            ],
            //'id_bom',
            //'tipe',
            //'id_akun',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update} {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        if ($model->status_produksi != 0) {
                            $hide = 'hidden';
                        } else {
                            $hide = '';
                        }
                        return Html::a('<button class = "btn btn-primary ' . $hide . ' "><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if ($model->status_produksi != 0) {
                            $hide = 'hidden';
                        } else {
                            $hide = '';
                        }
                        return Html::a('<button class = "btn btn-danger ' . $hide . ' "><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
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
                        $url = 'index.php?r=akt-produksi-bom/view&id=' . $model->id_produksi_bom;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-produksi-bom/update&id=' . $model->id_produksi_bom;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-produksi-bom/delete&id=' . $model->id_produksi_bom;
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
            'heading' => '<span class="fa fa-area-chart"></span> Produksi B.o.M',
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
                'filename' => 'Produksi B.o.M',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>