<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktLevelHarga */

$this->title = 'Detail Level Harga : '.$model->keterangan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Level Hargas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-level-harga-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Level Harga', ['akt-level-harga/index']) ?></li>
        <li class="active"><?= $model->keterangan ?></li>
    </ul>


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-level-harga/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_level_harga], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_level_harga], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="box">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-level-up-alt"></span> Level Harga</div>
    <div class="panel-body">
    <div class="col-md-12" style="padding: 0;">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_level_harga',
            'kode_level_harga',
            'keterangan:ntext',
        ],
    ]) ?>
</div>

</div>
