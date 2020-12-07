<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\Login;
use backend\models\AktPembelian;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktpembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data pembelian';
// $this->params['breadcrumbs'][] = $this->title;


?>
<div class="akt-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <?php if ($is_pembelian->status == 1) { ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'no_pembelian',
            [
                'attribute' => 'tanggal_pembelian',
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
                    if ($model->tanggal_pembelian != null) {
                        # code...
                        return tanggal_indo($model->tanggal_pembelian, true);
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'tanggal_estimasi',
                'label' => 'Tanggal Estimasi Barang Diterima',
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
                    if ($model->tanggal_estimasi != null) {
                        return tanggal_indo($model->tanggal_estimasi, true);
                    } else {
                        return null;
                    }
                }
            ],
            [
                'attribute' => 'id_customer',
                'label' => 'Supplier',
                'format' => 'raw',
                'value' => 'customer.nama_mitra_bisnis',
            ],


            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    // 1 => 'Order pembelian',
                    2 => 'Pembelian',
                    // 3 => 'Pengiriman',
                    4 => 'Selesai',
                    5 => 'Proses Penerimaan',
                ),
                'value' => function ($model) {
                    if ($model->status == 1) {
                        # code...
                        return "<span class='label label-default'>Order pembelian</span>";
                    } elseif ($model->status == 2) {
                        # code...
                        if (AktPembelian::cekButtonPembelian()->status == 0 && $model->no_order_pembelian != null) {
                            $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                            return "<span class='label label-warning'>Pembelian PO, Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                        } else if (AktPembelian::cekButtonPembelian()->status == 1 || $model->no_order_pembelian == null) {
                            return "<span class='label label-warning'>Pembelian </span>";
                        }
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-primary'>Penerimaan</span>";
                    } elseif ($model->status == 4) {
                        # code...
                        return "<span class='label label-success'>Selesai</span>";
                    } elseif ($model->status == 5) {
                        # code...
                        return "<span class='label label-info'>Proses Penerimaan</span>";
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
                        $url = 'index.php?r=akt-pembelian-pembelian/view&id=' . $model->id_pembelian;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-pembelian-pembelian/update&id=' . $model->id_pembelian;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-pembelian-pembelian/delete&id=' . $model->id_pembelian;
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