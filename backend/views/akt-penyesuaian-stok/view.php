<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPenyesuaianStokDetail;
use backend\models\AktGudang;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktApprover;
use backend\models\Login;
use backend\models\AktSatuan;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktPenyesuaianStok */

$this->title = 'Detail Data Penyesuaian Stok : ' . $model->no_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Penyesuaian Stoks', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penyesuaian-stok-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Penyesuaian Stok', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>


        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_penyesuaian_stok], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_penyesuaian_stok], [
            'class' => 'btn btn-danger',
            // $a => true,
            'data' => [
                'confirm' => 'Apakah anda yakin akan menghapus data ini ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    // 'id_penyesuaian_stok',
                                    'no_transaksi',
                                    [
                                        'attribute' => 'tanggal_penyesuaian',
                                        'value' => function ($model) {
                                            return tanggal_indo($model->tanggal_penyesuaian, true);
                                        }
                                    ],
                                    [
                                        'attribute' => 'tipe_penyesuaian',
                                        'value' => function ($model) {
                                            if ($model->tipe_penyesuaian == 1) {
                                                # code...
                                                return 'Penambahan Stok';
                                            }
                                            if ($model->tipe_penyesuaian == 0) {
                                                # code...
                                                return 'Pengurangan Stok';
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'keterangan_penyesuaian:ntext',
                                ],
                            ]) ?>
                        </div>
                    </div>

                    <div class="box box-success" style="margin-top:20px;"></div>
                    <div class="panel-heading" style="margin-top:20px;"><i class="fa fa-box"></i> Daftar Barang</div>
                    <div class="col-md-12" style="padding: 0;">
                        <div class="row" style="margin-left:2px;">
                            <?php $form = ActiveForm::begin([
                                'method' => 'post',
                                'action' => ['akt-penyesuaian-stok-detail/create'],
                            ]); ?>

                            <?= $form->field($model_penyesuain_stok_detail, 'id_penyesuaian_stok')->textInput(['readonly' => true, 'type' => 'hidden', 'value' => $model->id_penyesuaian_stok])->label(FALSE) ?>
                            <div class="col-lg-6">
                                <?= $form->field($model_penyesuain_stok_detail, 'id_item_stok')->widget(Select2::classname(), [
                                    'data' => $data_item_stok,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ])->label('Barang');
                                ?>
                            </div>
                            <div class="col-lg-2">
                                <?= $form->field($model_penyesuain_stok_detail, 'qty')->textInput() ?>
                            </div>
                            <div class="col-lg-2" style="margin-top:23px;">
                                <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div class="box-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Gudang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_detail = AktPenyesuaianStokDetail::find()->where(['id_penyesuaian_stok' => $model->id_penyesuaian_stok])->all();
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
                                            <td><?= $gudang->nama_gudang ?></td>
                                            <td>

                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-penyesuaian-stok-detail/delete', 'id' => $data['id_penyesuaian_stok_detail']], [
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
    </div>

</div>

<?php
$script = <<< JS
$(document).ready(function(){
    $('#id_item_stok').change(function(){
    var id = $(this).val();
    $.ajax({
            url:'index.php?r=akt-penyesuaian-stok/get-hpp',
            data: {id : id},
            dataType:'json',
            success:function(data){
                // console.log(data);
                $('#aktpenyesuaianstokdetail-hpp').val(data.hpp);
                // $('#aktpenyesuaianstokdetail-qty').val(data.qty);
            }
        })
    })
});    
JS;
$this->registerJs($script);
?>