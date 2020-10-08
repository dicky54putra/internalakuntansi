<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktTransferStokDetail;
use backend\models\AktItem;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktTransferStok */

$this->title = 'Detail Data Transfer Stok : ' . $model->no_transfer;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Transfer Stoks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-transfer-stok-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Transfer Stok', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_transfer_stok], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_transfer_stok], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-truck"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_transfer_stok',
                            'no_transfer',
                            [
                                'attribute' => 'tanggal_transfer',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal_transfer, true);
                                }
                            ],
                            [
                                'attribute' => 'id_gudang_asal',
                                'value' => function ($model) {
                                    return $model->gudang_asal->nama_gudang;
                                }
                            ],
                            [
                                'attribute' => 'id_gudang_tujuan',
                                'value' => function ($model) {
                                    return $model->gudang_tujuan->nama_gudang;
                                }
                            ],
                            'keterangan:ntext',
                        ],
                    ]) ?>

                    <div class="box box-success" style="margin-top:20px;"></div>
                    <div class="panel-heading" style="margin-top:20px;"><span class="fa fa-box"></span> Data Barang</div>
                    <div class="row">
                        <div class="box-body">
                            <?php $form = ActiveForm::begin([
                                'method' => 'post',
                                'action' => ['akt-transfer-stok-detail/create','id' => $model->id_transfer_stok],
                            ]); ?>

                            <div class="col-md-3">
                                <?= $form->field($model_transfer_detail, 'id_item')->widget(Select2::classname(), [
                                    'data' => $data_item,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang', 'required' => 'required'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model_transfer_detail, 'qty')->textInput() ?>
                            </div>
                            <div class="col-md-4"> 
                            <?= $form->field($model_transfer_detail, 'keterangan')->textarea(['rows' => 1]) ?>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-success" style="width: 100%; margin-top:25px;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <table class="table" style="margin-left:7px;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query_detail = AktTransferStokDetail::find()->where(['id_transfer_stok' => $model->id_transfer_stok])->all();
                            foreach ($query_detail as $key => $data) {
                                # code...
                                $item = AktItem::findOne($data['id_item']);
                            ?>
                                <tr>
                                    <td><?= $no++ . '.' ?></td>
                                    <td><?= $item->nama_item ?></td>
                                    <td><?= $data['qty'] ?></td>
                                    <td><?= $item->satuan->nama_satuan ?></td>
                                    <td><?= $data['keterangan'] ?></td>
                                    <td>
                                        <?php
                                        //  Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-transfer-stok-detail/update', 'id' => $data['id_transfer_stok_detail']], ['class' => 'btn btn-primary']) 
                                        ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-transfer-stok-detail/delete', 'id' => $data['id_transfer_stok_detail']], [
                                            'class' => 'btn btn-danger',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
