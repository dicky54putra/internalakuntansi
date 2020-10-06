<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktKelompokHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Kelompok Harta Tetap';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-kelompok-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Kelompok Harta Tetap</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_kelompok_harta_tetap',
            'kode',
            'nama',
            'umur_ekonomis',
            // 'metode_depresiasi',
            [
                'attribute' => 'metode_depresiasi',
                'format' => 'html',
                'filter' => array(1 => 'Metode Saldo Menurun', 2 => 'Metode Garis Lurus'),
                'value' => function ($model) {
                    if ($model->metode_depresiasi == 1) {
                        # code...
                        return 'Metode Saldo Menurun';
                    } else {
                        return 'Metode Garis Lurus';
                        # code...
                    }
                }
            ],
            // 'id_akun_harta',
            // 'id_akun_akumulasi',
            // 'id_akun_depresiasi',
            [
                'attribute' => 'id_akun_harta',
                'label' => 'Akun Harta',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->akun_harta->nama_akun;
                }
            ],
            [
                'attribute' => 'id_akun_akumulasi',
                'label' => 'Akun Akumulasi',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->akun_akumulasi->nama_akun;
                }
            ],
            [
                'attribute' => 'id_akun_depresiasi',
                'label' => 'Akun Depresiasi',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->akun_depresiasi->nama_akun;
                }
            ],
            'keterangan:ntext',

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
                        $url = 'index.php?r=akt-kelompok-harta-tetap/view&id=' . $model->id_kelompok_harta_tetap;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-kelompok-harta-tetap/update&id=' . $model->id_kelompok_harta_tetap;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-kelompok-harta-tetap/delete&id=' . $model->id_kelompok_harta_tetap;
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
            'heading' => '<span class="fa fa-car"></span> Daftar Harta Tetap',
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
                'filename' => 'Gudang',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>