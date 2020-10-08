<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanPengirimanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Penjualan Pengirimen';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-pengiriman-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Penjualan Pengiriman', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penjualan_pengiriman',
            'no_pengiriman',
            'tanggal_pengiriman',
            'pengantar',
            'keterangan_pengantar:ntext',
            //'foto_resi',
            //'id_penjualan',
            //'id_mitra_bisnis_alamat',
            //'penerima',
            //'keterangan_penerima:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
