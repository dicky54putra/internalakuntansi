<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktAkunSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Akun';
?>
<div class="akt-akun-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Akun</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_akun',
            'kode_akun',
            'nama_akun',
            [
                'attribute' => 'saldo_akun',
                'hAlign' => 'right',
                'value' => function ($model) {
                    return ribuan($model->saldo_akun);
                }
            ],
            // 'header',
            // 'parent',
            [
                'attribute' => 'jenis',
                'format' => 'raw',
                'filter' => array(
                    // 1 => 'Harta',
                    1 => 'Aset Lancar',
                    2 => 'Aset Tetap',
                    3 => 'Aset Tetap Tidak Berwujud',
                    4 => 'Pendapatan',
                    // 2 => 'Kewajiban',
                    5 => 'Liabilitas Jangka Pendek',
                    6 => 'Liabilitas Jangka Panjang',
                    // 3 => 'Modal',
                    7 => 'Ekuitas',
                    // 5 => 'Pendapatan Lain',
                    8 => 'Beban',
                ),
                'value' => function ($model) {
                    $j = $model->jenis;
                    if ($j == 1) {
                        return 'Aset Lancar';
                    } elseif ($j == 2) {
                        return 'Aset Tetap';
                    } elseif ($j == 3) {
                        return 'Aset Tetap Tidak Berwujud';
                    } elseif ($j == 4) {
                        return 'Pendapatan';
                    } elseif ($j == 5) {
                        return 'Liabilitas Jangka Pendek';
                    } elseif ($j == 6) {
                        return 'Liabilitas Jangka Panjang';
                    } elseif ($j == 7) {
                        return 'Ekuitas';
                    } elseif ($j == 8) {
                        return 'Beban';
                    }
                }
            ],
            [
                'attribute' => 'klasifikasi',
                'value' => function ($model) {
                    return $model->akt_klasifikasi->klasifikasi;
                }
            ],
            // 'jenis',
            // 'klasifikasi',
            // 'status_aktif',
            [
                'attribute' => 'saldo_normal',
                'format' => 'raw',
                'filter' => array(
                    1 => 'Debet',
                    2 => 'Kredit',
                ),
                'value' => function ($model) {
                    if ($model->saldo_normal == 1) {
                        return 'Debet';
                    } else if ($model->saldo_normal == 2) {
                        return 'Kredit';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => $permission_button,
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
                        $url = 'index.php?r=akt-akun/view&id=' . $model->id_akun;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-akun/update&id=' . $model->id_akun;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-akun/delete&id=' . $model->id_akun;
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
            'heading' => '<span class="fa fa-check"></span> Akun',
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
                'filename' => 'Akun',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>