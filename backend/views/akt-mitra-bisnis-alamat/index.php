<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktMitraBisnisAlamatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Mitra Bisnis Alamats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-mitra-bisnis-alamat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Mitra Bisnis Alamat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_mitra_bisnis_alamat',
            'id_mitra_bisnis',
            'keterangan_alamat:ntext',
            'alamat_lengkap:ntext',
            'id_kota',
            //'telephone',
            //'fax',
            //'kode_pos',
            //'alamat_pengiriman_penagihan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
