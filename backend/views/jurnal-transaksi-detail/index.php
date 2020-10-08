<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\JurnalTransaksiDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jurnal Transaksi Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurnal-transaksi-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Jurnal Transaksi Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_jurnal_transaksi_detail',
            'id_jurnal_transaksi',
            'tipe',
            'id_akun',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
