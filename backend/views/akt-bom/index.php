<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\AktItem;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktBomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bill of Material';
?>
<div class="akt-bom-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Bill of Material</li>
    </ul>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_bom',
            'no_bom',
            // 'keterangan:ntext',
            [
                'attribute' => 'tipe',
                'filter' => array(
                    1 => 'De-produksi',
                    2 => 'Produksi'
                ),
                'value' => function ($model) {
                    if ($model->tipe == 1) {
                        return "De-Produksi";
                    } else {
                        return "Produksi";
                    }
                }
            ],
            [
                'attribute' => 'id_item_stok',
                'label' => 'Barang',
                'value' => function ($model) {
                    // if (!empty($model->nama_item)) {
                    # code...
                    // return $model->item_stok->item->nama_item;
                    // return $model->nama_item;
                    $item = AktItem::find()->where(['id_item' => $model->item_stok->id_item])->one();
                    return $item->nama_item;
                    // }
                }
            ],
            //'qty',
            //'total',
            [
                'attribute' => 'status_bom',
                'format' => 'html',
                'label' => 'Status',
                'filter' => array(1 => 'Disetujui', 2 => 'Belum Disetujui', 3 => 'Ditolak'),
                'value' => function ($model) {
                    if ($model->status_bom == 2) {
                        return '<p class="label label-default" style="font-weight:bold;"> Belum Disetujui </p> ';
                    } else if ($model->status_bom == 1) {
                        // return 'ok';
                        return '<p class="label label-success" style="font-weight:bold;"> Disetujui pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $model->login->nama . '</p> ';
                    } else if ($model->status_bom == 3) {
                        return '<p class="label label-danger" style="font-weight:bold;"> Ditolak pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $model->login->nama . '</p> ';
                    }
                }
            ],

            //'status_bom',

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
                        $url = 'index.php?r=akt-bom/view&id=' . $model->id_bom;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-bom/update&id=' . $model->id_bom;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-bom/delete&id=' . $model->id_bom;
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
            'heading' => '<span class="fa fa-credit-card"></span> Bill of Material',
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
                'filename' => 'Bill of Material',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>