<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktMataUangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Mata Uang';
?>
<div class="akt-mata-uang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Mata Uang</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_mata_uang',
            'kode_mata_uang',
            'mata_uang',
            'simbol',
            'kurs',
            'fiskal',
            // 'rate_type',
            [
                'attribute' => 'rate_type',
                'filter' => array(1 => 'Normal', 2 => 'Reverse'),
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->rate_type == 1) {
                        return '<p class="text-primary" style="font-weight:bold;"> Normal </p> ';
                    } else if ($model->rate_type == 1) {
                        return '<p class="text-success" style="font-weight:bold;"> Reserve </p> ';
                    }
                }
            ],
            [
                'attribute' => 'status_default',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->status_default == 2) {
                        return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                    } else if ($model->status_default == 1) {
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
                        $url = 'index.php?r=akt-mata-uang/view&id=' . $model->id_mata_uang;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-mata-uang/update&id=' . $model->id_mata_uang;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-mata-uang/delete&id=' . $model->id_mata_uang;
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
            'heading' => '<span class="fa fa-usd"></span> Daftar Mata Uang',
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
                'filename' => 'Daftar Mata Uang',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>