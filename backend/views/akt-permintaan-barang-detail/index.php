<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPermintaanBarangDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Permintaan Barang Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-permintaan-barang-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Permintaan Barang Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_permintaan_barang_detail',
            'id_permintaan_barang',
            'id_item',
            'qty',
            'qty_ordered',
            //'qty_rejected',
            //'keterangan:ntext',
            //'request_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
