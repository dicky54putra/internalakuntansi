<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\Login;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPembelianHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pembelian Harta Tetap';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Pembelian Harta Tetap</li>
    </ul>
    <?php
    if ($approve == 0) {
    ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'no_pembelian_harta_tetap',
            [
                'attribute' => 'tanggal',
                'format' => 'raw',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal);
                }
            ],
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
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->id_login != null) {
                        $login = Login::find()->where(['id_login' => $model->id_login])->one();
                    }
                    if ($model->status == 2) {
                        return '<p class="label label-success" style="font-weight:bold;"> Disetujui pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $login->nama . '</p> ';
                    } else if ($model->status == 1) {
                        return '<p class="label label-warning" style="font-weight:bold;"> Belum Disetujui </p> ';
                    } else if ($model->status == 3) {
                        return '<p class="label label-danger" style="font-weight:bold;"> Ditolak pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $login->nama . '</p> ';
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
                        $url = 'index.php?r=akt-pembelian-harta-tetap/view&id=' . $model->id_pembelian_harta_tetap;
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
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="fa fa-list-alt"></i> Daftar Pembelian Harta Tetap',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data Kartu Kredit',
                'showPageSummary' => true,
            ]

        ],

    ]); ?>
</div>