<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktItemHargaJualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Item Harga Juals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-item-harga-jual-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Item Harga Jual', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_item_harga_jual',
            'id_item',
            'id_mata_uang',
            'id_level_harga',
            'harga_satuan',
            //'diskon_satuan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
