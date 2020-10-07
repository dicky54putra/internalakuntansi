<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Setting */

$this->title = $model->nama;
// $this->params['breadcrumbs'][] = ['label' => 'Settings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="setting-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Setting', ['index']) ?></li>
        <li class="active"><?= $model->nama ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_setting], ['class' => 'btn btn-primary']) ?>
        <?php
        // Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_setting], [
        //     'class' => 'btn btn-danger',
        //     'data' => [
        //         'confirm' => 'Are you sure you want to delete this item?',
        //         'method' => 'post',
        //     ],
        // ])
        ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-hospital-o"></span> Sales</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_setting',
                                'nama',
                                'nama_usaha',
                                'email:email',
                                'alamat:ntext',
                                [
                                    'attribute' => 'id_kota',
                                    'value' => function ($model) {
                                        if (!empty($model->kota->nama_kota)) {
                                            # code...
                                            return $model->kota->nama_kota;
                                        }
                                    }
                                ],
                                'telepon',
                                'fax',
                                'npwp',
                                // 'foto',
                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>