<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktProduksiBomDetailBbSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Produksi Bom Detail Bbs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-produksi-bom-detail-bb-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Produksi Bom Detail Bb', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_produksi_bom_detail_bb',
            'id_produksi_bom',
            'id_item',
            'qty',
            'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
