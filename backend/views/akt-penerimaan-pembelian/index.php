<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenerimaanPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penerimaan Pembelian';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penerimaan-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Daftar Penerimaan Pembelian</li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Data Penerimaan Pembelian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_penerimaan_pembelian',
            'no_penerimaan',
            // 'no_ref',
            'tanggal',
            'id_supplier',
            //'id_penerima',
            //'keterangan:ntext',
            'id_cabang',
            //'draft',

            'status_invoiced',


            ['class' => 'yii\grid\ActionColumn'],
        ],
        
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
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
            'heading' => 'Data Penerimaan Pembelian',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data Kartu Kredit',
                'showPageSummary' => true,
            ]

        ],

    ]); ?>
</div>
