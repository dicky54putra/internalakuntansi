<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPengajuanBiayaDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Pengajuan Biaya Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pengajuan-biaya-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Pengajuan Biaya Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_pengajuan_biaya_detail',
            'id_pengajuan',
            'id_akun',
            'kode_rekening',
            'nama_pengajuan',
            //'debit',
            //'kredit',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
