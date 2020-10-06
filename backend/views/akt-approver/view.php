<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktApprover */

$this->title = 'Detail Data Approver : ' . $retVal = (!empty($model->login->nama)) ? $model->login->nama : '';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Approvers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-approver-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Approver', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_approver], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_approver], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah anda yakin akan menghapus Data Approver : ' . $retVal = (!empty($model->login->nama)) ? $model->login->nama : '' . ' ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-users"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_approver',
                            [
                                'attribute' => 'id_login',
                                'value' => function ($model) {
                                    if (!empty($model->login->nama)) {
                                        # code...
                                        return $model->login->nama;
                                    }
                                }
                            ],
                            [
                                'attribute' => 'jenis_approver',
                                'value' => function ($model) {
                                    if (!empty($model->jenis_approver->nama_jenis_approver)) {
                                        # code...
                                        return $model->jenis_approver->nama_jenis_approver;
                                    }
                                }
                            ],
                            [
                                'attribute' => 'tingkat_approver',
                                'value' => function ($model) {
                                    if ($model->tingkat_approver == 1) {
                                        # code...
                                        return 'Approver 1';
                                    } elseif ($model->tingkat_approver == 2) {
                                        # code...
                                        return 'Approver 2';
                                    } elseif ($model->tingkat_approver == 3) {
                                        # code...
                                        return 'Approver 3';
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