<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktAkun */

$this->title = 'Detail Akun : ' . $model->nama_akun;
// \yii\web\YiiAsset::register($this);
?>
<div class="akt-akun-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Akun', ['index']) ?></li>
        <li class="active"><?= $model->nama_akun ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_akun], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_akun], [
            'class' => 'btn btn-danger hidden',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-check"></span> Akun</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_akun',
                                'kode_akun',
                                'nama_akun',
                                'saldo_akun',
                                // 'header',
                                [
                                    'attribute' => 'header',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if ($model->header == 1) {
                                            return '<input type="checkbox" checked disabled class="checkbox">';
                                        } else {
                                            return '<input type="checkbox" disabled class="checkbox">';;
                                        }
                                    }
                                ],
                                // 'parent',
                                [
                                    'attribute' => 'parent',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if (!empty($model->akt_akun->nama_akun)) {
                                            # code...
                                            return $model->akt_akun->nama_akun;
                                        }
                                    }
                                ],
                                // 'jenis',
                                [
                                    'attribute' => 'jenis',
                                    'value' => function ($model) {
                                        $j = $model->jenis;
                                        if ($j == 1) {
                                            return 'Aset Lancar';
                                        } elseif ($j == 2) {
                                            return 'Aset Tetap';
                                        } elseif ($j == 3) {
                                            return 'Aset Tetap Tidak Berwujud';
                                        } elseif ($j == 4) {
                                            return 'Pendapatan';
                                        } elseif ($j == 5) {
                                            return 'Liabilitas Jangka Pendek';
                                        } elseif ($j == 6) {
                                            return 'Liabilitas Jangka Panjang';
                                        } elseif ($j == 7) {
                                            return 'Ekuitas';
                                        } elseif ($j == 8) {
                                            return 'Beban';
                                        }
                                    }
                                ],
                                'akt_klasifikasi.klasifikasi',
                                [
                                    'attribute' => 'status_aktif',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_aktif == 2) {
                                            return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                        } else if ($model->status_aktif == 1) {
                                            return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'saldo_normal',
                                    'value' => function ($model) {
                                        if ($model->saldo_normal == 1) {
                                            return 'Debet';
                                        } else {
                                            return 'Kredit';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>