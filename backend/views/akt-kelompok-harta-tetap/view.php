<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktKelompokHartaTetap */

$this->title = $model->kode;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Kelompok Harta Tetaps', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-kelompok-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Kelompok Harta Tetap', ['index']) ?></li>
        <li class="active"><?= $model->kode ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_kelompok_harta_tetap], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_kelompok_harta_tetap], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-list-alt"></span> Kelompok Harga Tetap</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_kelompok_harta_tetap',
                                'kode',
                                'nama',
                                // 'umur_ekonomis',
                                [
                                    'attribute' => 'umur_ekonomis',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->umur_ekonomis . ' Tahun';
                                    }
                                ],
                                // 'metode_depresiasi',
                                // 'id_akun_harta',
                                [
                                    'attribute' => 'metode_depresiasi',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->metode_depresiasi == 1) {
                                            # code...
                                            return 'Metode Saldo Menurun';
                                        } else {
                                            return 'Metode Garis Lurus';
                                            # code...
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'id_akun_harta',
                                    'label' => 'Akun Harta',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->akun_harta->nama_akun;
                                    }
                                ],
                                [
                                    'attribute' => 'id_akun_akumulasi',
                                    'label' => 'Akun Akumulasi',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->akun_akumulasi->nama_akun;
                                    }
                                ],
                                [
                                    'attribute' => 'id_akun_depresiasi',
                                    'label' => 'Akun Depresiasi',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return $model->akun_depresiasi->nama_akun;
                                    }
                                ],
                                // 'id_akun_akumulasi',
                                // 'id_akun_depresiasi',
                                'keterangan:ntext',
                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>