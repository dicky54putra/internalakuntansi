<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktSaldoAwalStokDetail;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktGudang;
/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalStok */

$this->title = 'Detail Daftar Saldo Awal Stok : ' .$model->no_transaksi;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-saldo-awal-stok-view">

<h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Saldo Awal Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_saldo_awal_stok], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_saldo_awal_stok], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-cube"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'no_transaksi',
                                [
                                    'attribute' => 'tanggal',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal);
                                    }
                                ],
                                [
                                    'attribute' => 'tipe',
                                    'value' => function ($model) {
                                        if($model->tipe == 0 ) {
                                            return 'Saldo Awal Stok';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>


                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#pendaftaran-item"><span class="fa fa-box"></span> Data Barang</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="pendaftaran-item" class="tab-pane fade in active" style=";">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="box-body">
                                                <?php $form = ActiveForm::begin([
                                                    'method' => 'post',
                                                    'action' => ['akt-saldo-awal-stok-detail/create'],
                                                ]); ?>

                                                 <?= $form->field($model_detail, 'id_saldo_awal_stok')->textInput(['value' => $model->id_saldo_awal_stok,'readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <?= $form->field($model_detail, 'id_item')->widget(Select2::classname(), [
                                                            'data' => $data_item,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_detail'],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ],
                                                        ])->label('Pilih Barang')
                                                        ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?= $form->field($model_detail, 'id_item_stok')->widget(DepDrop::classname(), [
                                                                'type' => DepDrop::TYPE_SELECT2,
                                                                'options' => ['id'=>'id-item-stok', 'placeholder' => 'Pilih Gudang'],
                                                                'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                                'pluginOptions' => [
                                                                    'depends' => ['id_item_detail'],
                                                                    'url'=>Url::to(['/akt-saldo-awal-stok/level-harga'])
                                                                ]
                                                            ])->label('Pilih Gudang');
                                                        ?>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <?= $form->field($model_detail, 'qty')->textInput(['autocomplete' => 'off']) ?>
                                                    </div>
                                                    <div class="col-md-2" style="margin-top:22px;">
                                                        <button type="submit" class="btn btn-success col-md-12"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                    </div>
                                                </div>

                                                <?php ActiveForm::end(); ?>

                                                <table class="table table-hover table-condensed table-responsive" style="margin-top:30px;">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%;">No.</th>
                                                            <th style="width: 50%;">Nama Barang</th>
                                                            <th style="width: 20%;">Gudang</th>
                                                            <th style="width: 15%;">Qty</th>
                                                            <th style="width: 15%;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        $query_detail = AktSaldoAwalStokDetail::find()->where(['id_saldo_awal_stok' => $model->id_saldo_awal_stok])->all();
                                                        foreach ($query_detail as $key => $data) {
                                                            $nama_brg = AktItem::findOne($data->id_item);
                                                            $item = AktItemStok::findOne($data->id_item_stok);
                                                            $gdg = AktGudang::findOne($item['id_gudang']);
                                                        ?>
                                                            <tr>
                                                                <td><?= $no++ . '.' ?></td>
                                                                <td><?= $nama_brg['nama_item'] ?> </td>
                                                                <td><?= $gdg['nama_gudang']?> </td>
                                                                <td><?= $data->qty ?> </td>
                                                                <td> <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-saldo-awal-stok-detail/update', 'id' => $data['id_saldo_awal_stok_detail']], ['class' => 'btn btn-primary']) ?> 
                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-saldo-awal-stok-detail/delete', 'id' => $data['id_saldo_awal_stok_detail']], [
                                                                        'class' => 'btn btn-danger',
                                                                        'data' => [
                                                                            'confirm' => 'Apakah Anda yakin akan menghapus data ini?',
                                                                            'method' => 'post',
                                                                        ],
                                                                    ]) ?>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
