<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPembayaranBiayaHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Pembayaran Biaya Harta Tetaps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembayaran-biaya-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Pembayaran Biaya Harta Tetap', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pembayaran_biaya_harta_tetap',
            'tanggal_pembayaran_biaya',
            'id_pembelian_harta_tetap',
            'cara_bayar',
            'id_kas_bank',
            //'nominal',
            //'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
