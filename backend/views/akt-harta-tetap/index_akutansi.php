<?php

use backend\models\AktPembelianHartaTetap;
use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Harta Tetap';
?>
<div class="akt-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Harta Tetap</li>
    </ul>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Kode Pembelian',
                'value' => function ($model) {
                    return $model->akt_pembelian_harta_tetap->no_pembelian_harta_tetap;
                }
            ],
            [
                // 'attribute' => 'kode_pembelian',
                'label' => 'Kode Harta',
                'value' => function ($model) {
                    return $model->kode_pembelian;
                }
            ],
            [
                // 'attribute' => 'kode_pembelian',
                'label' => 'Nama Barang',
                'value' => function ($model) {
                    return $model->nama_barang;
                }
            ],
            [
                'label' => 'Tanggal',
                'value' => function ($model) {
                    return tanggal_indo($model->akt_pembelian_harta_tetap->tanggal);
                }
            ],
            [
                'label' => 'Harga Perolehan',
                'value' => function ($model) {
                    $total = $model->qty * $model->harga;
                    $diskon = $total * $model->diskon / 100;
                    $sub_total = $total - $diskon;

                    $akt_harta_tetap = AktPembelianHartaTetap::find()->where(['id_pembelian_harta_tetap' => $model->id_pembelian_harta_tetap])->one();
                    $diskon_harta_tetap = $sub_total * $akt_harta_tetap->diskon / 100;

                    $akt_harta_tetap->pajak == 0 ? $pajak = 0 : $pajak = ($sub_total - $diskon_harta_tetap) * 0.1;
                    $harga_perolehan = $sub_total + $akt_harta_tetap->ongkir + $akt_harta_tetap->materai + $pajak - $diskon_harta_tetap;

                    return ribuan($harga_perolehan);
                }
            ],
            [
                'label' => 'Status',
                'value' => function ($model) {

                    if ($model->status == 1) {
                        # code...
                        return 'Ada';
                    } else {
                        return 'Terjual';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=akt-harta-tetap/view-akutansi&id=' . $model->id_pembelian_harta_tetap_detail;
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