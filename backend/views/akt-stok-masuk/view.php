<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktStokMasukDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktStokMasuk */

$this->title = 'Detail Data Stok Masuk : ' . $model->nomor_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Masuks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-stok-masuk-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Masuk', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_stok_masuk], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_stok_masuk], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-cart-plus"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_stok_masuk',
                            'nomor_transaksi',
                            [
                                'attribute' => 'tanggal_masuk',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal_masuk, true);
                                }
                            ],
                            [
                                'attribute' => 'tipe',
                                'value' => function ($model) {
                                    if ($model->tipe == 1) {
                                        # code...
                                        return 'Barang Masuk';
                                    }
                                }
                            ],
                            'keterangan:ntext',
                        ],
                    ]) ?>

                    <div class="box-success box" style="margin-top:20px;"></div>
                    <div class="panel-heading" style="margin-top:20px;"><span class="fa fa-box"></span> Data Barang</div>
                    <div class="row">
                        <div class="box-body">
                            <?php $form = ActiveForm::begin([
                                'method' => 'post',
                                'action' => ['akt-stok-masuk-detail/create', 'id' => $model->id_stok_masuk],
                            ]); ?>

                            <div class="col-md-5">

                                <?= $form->field($model_stok_detail, 'id_item_stok')->widget(Select2::classname(), [
                                    'data' => $data_item_stok,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                                ?>

                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model_stok_detail, 'qty')->textInput() ?>
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
                                <th>Gudang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query_detail = AktStokMasukDetail::find()->where(['id_stok_masuk' => $model->id_stok_masuk])->all();
                            foreach ($query_detail as $key => $data) {
                                # code...
                                $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                $item = AktItem::findOne($item_stok->id_item);
                                $gudang = AktGudang::findOne($item_stok->id_gudang);
                            ?>
                                <tr>
                                    <td><?= $no++ . '.' ?></td>
                                    <td><?= $item->nama_item ?></td>
                                    <td><?= $data['qty'] ?></td>
                                    <td><?= (!empty($item->satuan->nama_satuan)) ? $item->satuan->nama_satuan : '' ?></td>
                                    <td><?= $gudang->nama_gudang ?></td>
                                    <td>
                                        <?php // Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-stok-masuk-detail/update', 'id' => $data['id_stok_masuk_detail']], ['class' => 'btn btn-primary']) 
                                        ?>
                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-stok-masuk-detail/delete', 'id' => $data['id_stok_masuk_detail']], [
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