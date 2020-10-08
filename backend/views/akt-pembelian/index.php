<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;
use backend\models\Login;
use backend\models\AktApprover;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Order Pembelian';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Order Pembelian</li>
    </ul>
    <?php
    $id_login =  Yii::$app->user->identity->id_login;
    $isApprover =  AktApprover::find()
        ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
        ->where(['=', 'nama_jenis_approver', 'Order Pembelian'])
        ->andWhere(['id_login' => $id_login])
        ->asArray()
        ->one();

    if (!$isApprover) {
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

            'no_order_pembelian',
            [
                'attribute' => 'tanggal_order_pembelian',
                'headerOptions' => ['style' => 'color:#337ab7'],
                // 'format'    => 'date', 
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'tanggal_order_pembelian',
                    'convertFormat' => true,
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd-m-Y'
                        ],
                        'todayHighlight' => true
                    ],
                ]),
                'value'     => function ($model) {
                    // return Yii::$app->formatter->asDate($model->tanggal_order_pembelian, 'php:d-m-Y');
                    return tanggal_indo($model->tanggal_order_pembelian);
                }
            ],
            [
                'attribute' => 'id_customer',
                'label' => 'Supplier',
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
                    1 => 'Order pembelian',
                    // 2 => 'Pembelian',
                    // 3 => 'Pengiriman',
                    4 => 'Selesai',
                    5 => 'Proses Penerimaan',
                    6 => 'Ditolak',
                ),
                'value' => function ($model) {
                    if ($model->status == 1) {
                        # code...
                        return "<span class='label label-default'>Order Pembelian</span>";
                    } elseif ($model->status == 2) {
                        # code...
                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                        return "<span class='label label-warning'>Pembelian, Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-primary'>Penerimaan</span>";
                    } elseif ($model->status == 4) {
                        # code...
                        return "<span class='label label-success'>Selesai</span>";
                    } elseif ($model->status == 5) {
                        # code...
                        return "<span class='label label-info'>Proses Penerimaan</span>";
                    } elseif ($model->status == 6) {
                        # code...
                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                        return "<span class='label label-danger'>Ditolak pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
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
                        $url = 'index.php?r=akt-pembelian/view&id=' . $model->id_pembelian;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-pembelian/update&id=' . $model->id_pembelian;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-pembelian/delete&id=' . $model->id_pembelian;
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
        'responsiveWrap' => false,
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
            'heading' => '<i class="fa fa-list-alt"></i> Daftar Order Pembelian',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data Pembelian',
                'showPageSummary' => true,
            ]

        ],

    ]); ?>
</div>