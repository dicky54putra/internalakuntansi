<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktHartaTetap */

$this->title = $model->kode;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $model->kode ?></li>
    </ul>


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_harta_tetap], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_harta_tetap], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-car"></span> Harga Tetap</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_harta_tetap',
                                'kode',
                                'nama',
                                // 'id_kelompok_harta_tetap',
                                [
                                    'attribute' => 'id_kelompok_harta_tetap',
                                    'label' => 'Kelompok Harta Tetap',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->kelompok_harta_tetap->nama;
                                    }
                                ],
                                // 'tipe',
                                [
                                    'attribute' => 'tipe',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->tipe == 1) {
                                            return 'Berwujud';
                                        } else {
                                            return 'Tidak Berwujud';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status == 1) {
                                            # code...
                                            return 'Aktif';
                                        } else {
                                            return 'Tidak Aktif';
                                            # code...
                                        }
                                    }
                                ],
                                // 'status',
                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>