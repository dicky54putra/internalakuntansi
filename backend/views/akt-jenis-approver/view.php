<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJenisApprover */

$this->title = "Detail Jenis Approver";
\yii\web\YiiAsset::register($this);
?>
<div class="akt-jenis-approver-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Jenis Approver', ['index']) ?></li>
        <li class="active">Detail <?= $this->title; ?> </li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_jenis_approver], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_jenis_approver], [
            'class' => 'btn btn-danger hidden',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-users"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?= DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        // 'id_jenis_approver',
                                        'nama_jenis_approver',
                                    ],
                                ]) ?>

                            </div>