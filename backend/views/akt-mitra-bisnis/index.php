<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktMitraBisnisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Mitra Bisnis';
?>
<div class="akt-mitra-bisnis-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Mitra Bisnis</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'kode_mitra_bisnis',
                'label' => 'Kode',
            ],
            [
                'attribute' => 'pemilik_bisnis',
            ],
            [
                'attribute' => 'nama_mitra_bisnis',
                'label' => 'Nama',
            ],
            [
                'attribute' => 'tipe_mitra_bisnis',
                'label' => 'Tipe Mitra Bisnis',
                'filter' => array(
                    1 => "Customer",
                    2 => "Supplier",
                    3 => "Customer & Supplier"
                ),
                'value' => function ($model) {
                    if ($model->tipe_mitra_bisnis == 1) {
                        # code...
                        return 'Customer';
                    } elseif ($model->tipe_mitra_bisnis == 2) {
                        # code...
                        return 'Supplier';
                    } elseif ($model->tipe_mitra_bisnis == 3) {
                        # code...
                        return 'Customer & Supplier';
                    }
                }
            ],
            [
                'attribute' => 'status_mitra_bisnis',
                'label' => 'Status',
                'filter' => array(1 => 'Aktif', 2 => 'Tidak Aktif'),
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status_mitra_bisnis == 2) {
                        return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                    } else if ($model->status_mitra_bisnis == 1) {
                        return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                    }
                }
            ],

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
                        $url = 'index.php?r=akt-mitra-bisnis/view&id=' . $model->id_mitra_bisnis;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-mitra-bisnis/update&id=' . $model->id_mitra_bisnis;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-mitra-bisnis/delete&id=' . $model->id_mitra_bisnis;
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
            'heading' => '<span class="fa fa-users"></span> Mitra Bisnis',
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
                'filename' => 'Mitra Bisnis',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>