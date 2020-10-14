<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\AktPembelianHartaTetapDetail;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktDepartementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Depresiasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-departement-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Depresiasi</li>
    </ul>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'kode_depresiasi',
            [
                'attribute' => "tanggal",
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal);
                }
            ],
            [
                'attribute' => "id_pembelian_harta_tetap_detail",
                'label' => 'Aset Tetap',
                'value' => function ($model) {

                    $akt_pembelian_harta_tetap = AktPembelianHartaTetapDetail::findOne($model->id_pembelian_harta_tetap_detail);
                    return $akt_pembelian_harta_tetap->kode_pembelian . '  - ' . $akt_pembelian_harta_tetap->nama_barang;
                }
            ],
            [
                'attribute' => "nilai",
                'value' => function ($model) {
                    return ribuan($model->nilai);
                }
            ],

            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     'header' => 'Aksi',
            //     'headerOptions' => ['style' => 'color:#337ab7'],
            //     'template' => " ",
            //     'buttons' => [
            //         'view' => function ($url, $model) {
            //             return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', $url, [
            //                 'title' => Yii::t('app', 'lead-view'),
            //             ]);
            //         },

            //     ],
            //     'urlCreator' => function ($action, $model, $key, $index) {
            //         if ($action === 'view') {
            //             $url = 'index.php?r=akt-depresiasi-harta-tetap/view&id=' . $model->id_depresiasi_harta_tetap;
            //             return $url;
            //         }
            //     }
            // ],
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
            'heading' => '<span class="fa fa-clipboard-list"> </span> Depresiasi',
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
                'filename' => 'Data Depresiasi',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>