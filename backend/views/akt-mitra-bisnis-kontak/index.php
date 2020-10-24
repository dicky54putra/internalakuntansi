<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktMitraBisnisKontakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Akt Mitra Bisnis Kontaks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-mitra-bisnis-kontak-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Akt Mitra Bisnis Kontak', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_mitra_bisnis_kontak',
            'id_mitra_bisnis',
            'nama_kontak',
            'jabatan',
            'handphone',
            //'email:email',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
