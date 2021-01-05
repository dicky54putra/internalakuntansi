<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\AktPenjualan;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penjualan';
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
    <?php if ($is_penjualan->status == 1) { ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_penjualan',
            [
                'attribute' => 'tanggal_penjualan',
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
                    if (!empty($model->tanggal_penjualan)) {
                        # code...
                        return tanggal_indo($model->tanggal_penjualan, true);
                    } else {
                        # code...
                    }
                }
            ],

            [
                'attribute' => 'id_customer',
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
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    // 1 => 'Order Penjualan',
                    2 => 'Penjualan',
                    3 => 'Pengiriman',
                    4 => 'Selesai',
                    // 5 => 'Rejected',
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
                        return "<span class='label label-default'>Order Penjualan</span>";
                    } elseif ($model->status == 2) {
                        if (AktPenjualan::cekButtonPenjualan()->status == 0 && $model->no_order_penjualan != null) {
                            return "<span class='label label-warning'>Penjualan disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                        } else if (AktPenjualan::cekButtonPenjualan()->status == 1 || $model->no_order_penjualan == null) {
                            return "<span class='label label-warning'>Penjualan </span>";
                        }
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-primary'>Pengiriman</span>";
                    } elseif ($model->status == 4) {
                        # code...
                        return "<span class='label label-success'>Selesai</span>";
                    } elseif ($model->status == 5) {
                        # code...
                        return "<span class='label label-danger'>Ditolak pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
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
                        $url = 'index.php?r=akt-penjualan-penjualan/view&id=' . $model->id_penjualan;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-penjualan-penjualan/update&id=' . $model->id_penjualan;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-penjualan-penjualan/delete&id=' . $model->id_penjualan;
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