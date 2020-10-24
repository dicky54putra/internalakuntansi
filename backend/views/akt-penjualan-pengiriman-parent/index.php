<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pengiriman Penjualan';
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
            // 'no_faktur_penjualan',
            // [
            //     'attribute' => 'tanggal_faktur_penjualan',
            //     'value' => function ($model) {
            //         if (!empty($model->tanggal_faktur_penjualan)) {
            //             # code...
            //             return tanggal_indo($model->tanggal_faktur_penjualan, true);
            //         } else {
            //             # code...
            //         }
            //     }
            // ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    2 => 'Penjualan',
                    3 => 'Pengiriman',
                    4 => 'Selesai',
                ),
                'value' => function ($model) {
                    if ($model->status == 1) {
                        # code...
                        return "<span class='label label-default'>Order Penjualan</span>";
                    } elseif ($model->status == 2) {
                        # code...
                        return "<span class='label label-warning'>Penjualan</span>";
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-primary'>Pengiriman</span>";
                    } elseif ($model->status == 4) {
                        # code...
                        return "<span class='label label-success'>Selesai</span>";
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
                        $url = 'index.php?r=akt-penjualan-pengiriman-parent/view&id=' . $model->id_penjualan;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-penjualan-pengiriman-parent/update&id=' . $model->id_penjualan;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-penjualan-pengiriman-parent/delete&id=' . $model->id_penjualan;
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
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-copy"></span> ' . $this->title,
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