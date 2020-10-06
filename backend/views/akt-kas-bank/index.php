<?php

use yii\helpers\Html;
// use kartik\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktKasBankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Kas Bank';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-kas-bank-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Kas Bank</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_kas_bank',
            'kode_kas_bank',
            [
                'attribute' => 'jenis',
                'filter' => array(
                    1 => "Cash",
                    2 => "Bank",
                ),

                'value' => function ($model) {
                    if ($model->jenis == 1) {
                        return "Cash";
                    } else {
                        return "Bank";
                    }
                }

            ],
            [
                'attribute' => 'id_akun',
                'value' => 'akt_akun.nama_akun',
            ],
            'keterangan:ntext',
            [
                'attribute' => 'id_mata_uang',
                'value' => 'akt_mata_uang.mata_uang',
            ],
            [
                'attribute' => 'saldo',
                'hAlign' => 'right',
                'value' => function ($model) {
                    return number_format($model->saldo);
                },
            ],
            [
                'attribute' => 'total_giro_keluar',
                'hAlign' => 'right',
                'value' => function ($model) {
                    return ribuan($model->total_giro_keluar);
                }
            ],
            // 'status_aktif',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update}",
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
                        $url = 'index.php?r=akt-kas-bank/view&id=' . $model->id_kas_bank;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-kas-bank/update&id=' . $model->id_kas_bank;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-kas-bank/delete&id=' . $model->id_kas_bank;
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
            'heading' => '<span class="fa fa-building"></span> Kas Bank',
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
                'filename' => 'Data_SuratJalan',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>