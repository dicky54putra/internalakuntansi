<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktMitraBisnisBankPajakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Mitra Bisnis Bank Pajaks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-mitra-bisnis-bank-pajak-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Mitra Bisnis Bank Pajak', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_mitra_bisnis_bank_pajak',
            'id_mitra_bisnis',
            'nama_bank',
            'no_rekening',
            'atas_nama',
            //'npwp',
            //'pkp',
            //'tanggal_pkp',
            //'no_nik',
            //'atas_nama_nik',
            //'pembelian_pajak',
            //'penjualan_pajak',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
