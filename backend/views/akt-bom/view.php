<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktBomDetailBb;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktApprover;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktBom */

$this->title = 'Detail Bill of Material : ' . $model->no_bom;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-bom-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Bill of Material', ['index']) ?></li>
        <li class="active">Detail Bill of Material : <?= $model->no_bom ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        // $approve = AktApprover::find()->where(['id_jenis_approver' => 9])->all();
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Bill Of Material'])
            ->asArray()
            ->all();
        // echo $approve->id_login;
        $id_login =  Yii::$app->user->identity->id_login;
        if ($model->status_bom == 2) {
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_bom], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_bom], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approved', ['approved', 'id' => $model->id_bom], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => 'Are you sure you want to approve this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_bom], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to reject this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php
                }
            }
        }
        ?>
        <?php if ($model->status_bom != 2) { ?>
            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_bom], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Are you sure you want to pending this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php }
            }
        } ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-credit-card"></span> Bill of Material</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_bom',
                                'no_bom',
                                'keterangan:ntext',
                                [
                                    'attribute' => 'tipe',
                                    'value' => function ($model) {
                                        if ($model->tipe == 1) {
                                            return "De-Produksi";
                                        } else {
                                            return "Produksi";
                                        }
                                    }
                                ],
                                // 'id_item_stok',
                                [
                                    'attribute' => 'id_item_stok',
                                    'label' => 'Barang Hasil Produksi',
                                    'value' => function ($model) {
                                        // if (!empty($model->nama_item)) {
                                        $item = AktItem::find()->where(['id_item' => $model->item_stok->id_item])->one();
                                        return $item->nama_item;
                                        // }
                                    }
                                ],
                                'qty',
                                'total',
                                [
                                    'attribute' => 'status_bom',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_bom == 2) {
                                            return '<p class="label label-default" style="font-weight:bold;"> Belum Disetujui </p> ';
                                        } else if ($model->status_bom == 1) {
                                            // return 'ok';
                                            return '<p class="label label-success" style="font-weight:bold;"> Disetujui pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $model->login->nama . '</p> ';;
                                        } else if ($model->status_bom == 3) {
                                            // return '<p class="label label-danger" style="font-weight:bold;"> Ditolak </p> | ' . tanggal_indo($model->tanggal_approve) . ' | ' . $model->login->nama;
                                            return '<p class="label label-danger" style="font-weight:bold;"> Ditolak pada tanggal ' . tanggal_indo($model->tanggal_approve) . ' oleh ' . $model->login->nama . '</p> ';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                        <div class="" style="margin-top:20px;">
                            <div class="tab-content">
                                <div id="stok" class="tab-pane fade in active" style="margin-top:20px;">
                                    <?php
                                    if ($model->status_bom != 2) {
                                        $c = 'hidden';
                                    } else {
                                        $c = '';
                                    }

                                    ?>
                                    <div class="box box-success">
                                    </div>
                                    <div class="box-header with-border">
                                        <div class="box-title"> Daftar Bahan Baku</div>
                                    </div>
                                    <div class="test">
                                        <?= Html::beginForm(['akt-bom/view', 'aksi' => 'save', 'id' => Yii::$app->request->get('id')], 'post') ?>
                                        <div class="row <?= $c ?>" style="margin-left:-20px;">
                                            <div class="col-md-12">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Pilih Barang</label>
                                                        <?= Select2::widget([
                                                            // 'model' => $model,
                                                            'name' => 'id_item_stok',
                                                            'data' => ArrayHelper::map(AktItemStok::find()->all(), 'id_item_stok', function ($model_item) {
                                                                $nama_item = Yii::$app->db->createCommand("SELECT nama_item FROM akt_item WHERE id_item = '$model_item->id_item'")->queryScalar();
                                                                $gudang = Yii::$app->db->createCommand("SELECT nama_gudang FROM akt_gudang WHERE id_gudang = '$model_item->id_gudang'")->queryScalar();
                                                                return 'Nama Barang: ' . $nama_item . ' Gudang: ' . $gudang . ' Stok: ' . $model_item->qty;
                                                            }),
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok', 'required' => true],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ]
                                                        ]);
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Qty</label>
                                                        <?= Html::input("number", "qty", "", ["class" => "form-control", "placeholder" => "Qty", "id" => "qty", 'required' => true]) ?>
                                                        <input type="text" name="id_bom" value="<?= $model->id_bom ?>" id="id_bom" class="hidden">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Harga</label>
                                                        <?= Html::input("text", "harga", "", ["class" => "form-control", "readonly" => true, "placeholder" => "Harga", "id" => "harga", 'required' => true]) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row <?= $c ?>" style="margin-left:-5px;">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <?= Html::input("text", "keterangan", "", ["class" => "form-control", "placeholder" => "Keterangan", "id" => "keterangan",]) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                            </div>
                                        </div>
                                        <?= Html::endForm() ?>
                                    </div>
                                    <table class="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Barang</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Keterangan</th>
                                                <th class="<?= $c ?>">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->asArray()->all();
                                            foreach ($query as $key => $data) {
                                                # code...
                                                // $item = AktItemStok::find()->where(['id_item_stok' => $data['id_item_stok']])->one();
                                                // var_dump($item);
                                                // die;
                                                // $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item = '" . $data['id_item'] . "'")->queryScalar();
                                                $stok = AktItemStok::find()->where(['id_item_stok' => $data['id_item_stok']])->one();
                                            ?>
                                                <tr>
                                                    <td><?= $no++ . '.' ?></td>
                                                    <td>
                                                        <?php
                                                        if (!empty($stok->id_item)) {
                                                            echo $stok->item->nama_item;
                                                        }
                                                        echo '<br>';
                                                        if ($stok->qty >= $data['qty']) {
                                                        ?>
                                                            <p class="label label-primary">Stok Tersedia</p>
                                                        <?php } else {
                                                        ?>
                                                            <p class="label label-danger">Stok Tidak Tersedia</p>
                                                        <?php }
                                                        ?>
                                                    </td>
                                                    <td><?= $data['qty'] ?></td>
                                                    <td><?= $data['harga'] ?></td>
                                                    <td><?= $data['keterangan'] ?></td>
                                                    <td class="<?= $c ?>">
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-bom-detail-bb/update', 'id' => $data['id_bom_detail_bb']], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-bom-detail-bb/delete', 'id' => $data['id_bom_detail_bb']], [
                                                            'class' => 'btn btn-danger',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
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

<?php
$script = <<< JS
$(document).ready(function(){
    $('#id_item_stok').change(function(){
    var id = $(this).val();
    $.ajax({
            url:'index.php?r=akt-bom/get-harga',
            data: {id : id},
            dataType:'json',
            success:function(data){
                $('#harga').val(data.hpp);
            }
        })
    })
});    
JS;
$this->registerJs($script);
?>