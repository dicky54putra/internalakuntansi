<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktCreditCard */

$this->title = 'Detail Kartu Kredit : '.$model->nama_cc;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Credit Cards', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-credit-card-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kartu Kredit', ['akt-credit-card/index']) ?></li>
        <li class="active">Detail kartu Kredit</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['akt-credit-card/index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_cc], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_cc], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<div class="box">
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-credit-card"></span> Kartu Kredit</div>
    <div class="panel-body">
    <div class="col-md-12" style="padding: 0;">
    <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_cc',
            'kode_cc',
            'nama_cc',
        ],
    ]) ?>
</div>

</div>
