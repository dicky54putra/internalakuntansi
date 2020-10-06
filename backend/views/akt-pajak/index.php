<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPajakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pajak';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pajak-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li class="active">Daftar Pajak</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_pajak',
            'kode_pajak',
            'nama_pajak',
            [
                'attribute' => 'id_akun_pembelian',
                'value' => function ($model) {
                    $nama_akun = Yii::$app->db->createCommand("SELECT nama_akun FROM akt_akun WHERE id_akun = '$model->id_akun_pembelian'")->queryScalar();
                    return $nama_akun;
                }
            ],
            [
                'attribute' => 'id_akun_penjualan',
                'value' => function ($model) {
                    $nama_akun = Yii::$app->db->createCommand("SELECT nama_akun FROM akt_akun WHERE id_akun = '$model->id_akun_penjualan'")->queryScalar();
                    return $nama_akun;
                }
            ],
            'presentasi_npwp',
            'presentasi_non_npwp',

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
                        $url = 'index.php?r=akt-pajak/view&id=' . $model->id_pajak;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-pajak/update&id=' . $model->id_pajak;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-pajak/delete&id=' . $model->id_pajak;
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
            'heading' => '<span class="fa fa-hand-holding-usd"></span> Daftar Pajak',
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
                'filename' => 'Daftar Pajak',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>
