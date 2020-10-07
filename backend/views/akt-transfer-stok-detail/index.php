<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktTransferStokDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Transfer Stok Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-transfer-stok-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Transfer Stok Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_transfer_stok_detail',
            'id_transfer_stok',
            'id_item',
            'qty',
            'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
