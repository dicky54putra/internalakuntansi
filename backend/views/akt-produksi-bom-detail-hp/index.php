<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktProduksiBomDetailHpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Produksi Bom Detail Hps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-produksi-bom-detail-hp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Produksi Bom Detail Hp', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_produksi_bom_detail_hp',
            'id_produksi_bom',
            'id_item',
            'qty',
            'keterangan:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
