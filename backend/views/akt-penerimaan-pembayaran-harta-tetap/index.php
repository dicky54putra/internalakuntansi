<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenerimaanPembayaranHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Penerimaan Pembayaran Harta Tetaps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penerimaan-pembayaran-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Penerimaan Pembayaran Harta Tetap', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_penerimaan_pembayaran_harta_tetap',
            'tanggal_penerimaan_pembayaran',
            'id_penjualan_harta_tetap',
            'cara_bayar',
            'id_kas_bank',
            //'nominal',
            //'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
