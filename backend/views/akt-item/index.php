<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\AktItemStok;
use backend\models\AktGudang;
use backend\models\AktItemPajakPembelian;
use backend\models\AktItemPajakPenjualan;
use backend\models\AktPajak;
use backend\models\AktItemHargaJual;
use backend\models\AktLevelHarga;
use backend\models\AktMataUang;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Barang';
?>
<div class="akt-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Barang</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_item',
            [
                'attribute' => 'kode_item',
                'label' => 'Kode',

            ],
            [
                'attribute' => 'barcode_item',
                'label' => 'Barcode',
            ],
            [
                'attribute' => 'nama_item',
                'label' => 'Nama',
            ],
            [
                'attribute' => 'id_tipe_item',
                'value' => function ($model) {
                    return $model->tipe_item->nama_tipe_item;
                }
            ],
            [
                'attribute' => 'id_merk',
                'value' => 'merk.nama_merk'
            ],
            [
                'attribute' => 'status_aktif_item',
                'label' => 'Status',
                'filter' => array(1 => 'Aktif', 2 => 'Tidak Aktif'),
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status_aktif_item == 2) {
                        return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                    } else if ($model->status_aktif_item == 1) {
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
                        $url = 'index.php?r=akt-item/view&id=' . $model->id_item;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-item/update&id=' . $model->id_item;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-item/delete&id=' . $model->id_item;
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
            'heading' => '<span class="fa fa-box"></span> Daftar Barang',
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
                'filename' => 'Barang',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>