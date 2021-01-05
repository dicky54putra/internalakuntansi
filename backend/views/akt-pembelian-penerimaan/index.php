<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPembelianPenerimaanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Pembelian Penerimaans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-penerimaan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Pembelian Penerimaan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pembelian_penerimaan',
            'no_penerimaan',
            'tanggal_penerimaan',
            'penerima',
            'foto_resi',
            //'id_pembelian',
            //'pengantar',
            //'keterangan_pengantar:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
