<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktTransferKasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Transfer Kas';
?>
<div class="akt-transfer-kas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Transfer Kas</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_transfer_kas',
            'no_transfer_kas',
            [
                'attribute' => 'tanggal',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'filter' => DatePicker::widget([

                    'model' => $searchModel,

                    'attribute' => 'tanggal',

                    'convertFormat' => true,

                    'pluginOptions' => [

                        'locale' => [

                            'format' => 'd-m-Y'

                        ],
                        'todayHighlight' => true

                    ],

                ]),
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal, true);
                }
            ],
            [
                'attribute' => 'id_asal_kas',
                'value' => function ($model) {
                    return $model->kas_bank->keterangan;
                }
            ],
            [
                'attribute' => 'id_tujuan_kas',
                'value' => function ($model) {
                    return $model->kas_bank2->keterangan;
                }
            ],
            //'jumlah1',
            //'jumlah2',
            //'keterangan:ntext',

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
                        $url = 'index.php?r=akt-transfer-kas/view&id=' . $model->id_transfer_kas;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-transfer-kas/update&id=' . $model->id_transfer_kas;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-transfer-kas/delete&id=' . $model->id_transfer_kas;
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
            'heading' => '<span class="fa fa-book"></span> Daftar Transfer Kas',
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
                'filename' => 'Transfer Kas',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>