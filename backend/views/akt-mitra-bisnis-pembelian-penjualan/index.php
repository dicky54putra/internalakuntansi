<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktMitraBisnisPembelianPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Mitra Bisnis Pembelian Penjualans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-mitra-bisnis-pembelian-penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Mitra Bisnis Pembelian Penjualan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_mitra_bisnis_pembelian_penjualan',
            'id_mitra_bisnis',
            'id_mata_uang',
            'termin_pembelian',
            'tempo_pembelian',
            //'termin_penjualan',
            //'tempo_penjualan',
            //'batas_hutang',
            //'batas_frekuensi_hutang',
            //'id_akun_hutang',
            //'batas_piutang',
            //'batas_frekuensi_piutang',
            //'id_akun_piutang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
