<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\AktApprover;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktReturPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Retur Pembelian';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php
    $id_login =  Yii::$app->user->identity->id_login;
    $query_approve = AktApprover::find()
        ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
        ->where(['=', 'nama_jenis_approver', 'Retur Pembelian'])
        ->andWhere(['id_login' => $id_login])
        ->asArray();
    $isApprove = $query_approve->one();

    if (!$isApprove) {
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

            'no_retur_pembelian',
            [
                'attribute' => 'tanggal_retur_pembelian',
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
                    return tanggal_indo($model->tanggal_retur_pembelian, true);
                }
            ],
            [
                'attribute' => 'id_pembelian',
                'label' => 'No. Pembelian',
                'value' => function ($model) {
                    if (!empty($model->pembelian->no_pembelian)) {
                        # code...
                        return $model->pembelian->no_pembelian;
                    } else {
                        # code...
                    }
                }
            ],
            [
                'attribute' => 'status_retur',
                'format' => 'raw',
                'filter' => array(
                    1 => "Pengajuan",
                    2 => "Di Terima",
                ),
                'value' => function ($model) {
                    if ($model->status_retur == 1) {
                        # code...
                        return "<span class='label label-default'>Pengajuan</span>";
                    } elseif ($model->status_retur == 2) {
                        # code...
                        return "<span class='label label-success'>Disetujui</span>";
                    }
                }
            ],

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update} {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', ['view', 'id' => $model->id_retur_pembelian], [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        if ($model->status_retur == 1) {

                            return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', ['update', 'id' => $model->id_retur_pembelian], [
                                'title' => Yii::t('app', 'lead-update'),
                            ]);
                        }
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', ['delete', 'id' => $model->id_retur_pembelian], [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                                'method' => 'post'
                            ],
                        ]);
                    },

                ],
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
            'heading' => '<span class="glyphicon glyphicon-repeat"></span> ' . $this->title,
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