<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPermintaanBarangPegawaiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Permintaan Barang Pegawais';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-permintaan-barang-pegawai-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Permintaan Barang Pegawai', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_permintaan_barang_pegawai',
            'id_permintaan_barang',
            'id_pegawai',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
