<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ItemPermintaanPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Permintaan Pembelians';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-permintaan-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item Permintaan Pembelian', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_permintaan_pembelian',
            'id_permintaan_pembelian',
            'id_item',
            'quantity',
            'satuan',
            //'id_departement',
            //'id_proyek',
            //'keterangan',
            //'req_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
