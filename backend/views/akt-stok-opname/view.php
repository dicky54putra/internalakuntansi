<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktStokOpnameDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktGudang;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\AktStokOpname */

$this->title = 'Detail Data Stok Opname : ' . $model->no_transaksi;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Stok Opnames', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-stok-opname-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Stok Opname', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_stok_opname], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_stok_opname], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-cubes"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_stok_opname',
                            'no_transaksi',
                            [
                                'attribute' => 'tanggal_opname',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal_opname, true);
                                }
                            ],
                            [
                                'attribute' => 'id_pegawai',
                                'value' => function ($model) {
                                    if (!empty($model->pegawai->nama_pegawai)) {
                                        # code...
                                        return $model->pegawai->nama_pegawai;
                                    } else {
                                        # code...
                                    }
                                }
                            ],
                        ],
                    ]) ?>
                    <div class="box box-success" style="margin-top:20px;"></div>
                    <div class="panel-heading" style="margin-top:20px;"><span class="fa fa-box"></span> Data Barang</div>
                    <div class="row">
                        <div class="box-body">
                            <?php $form = ActiveForm::begin([
                                'method' => 'post',
                                'action' => ['akt-stok-opname-detail/create', 'id' => $model->id_stok_opname],
                                'options' => ['oninput' => 'qty_selisih.value=(parseInt(qty_opname.value)-parseInt(qty_program.value))'],
                            ]); ?>

                            <div class="col-md-3">

                                <?= $form->field($model_opname_detail, 'id_item_stok')->widget(Select2::classname(), [
                                    'data' => $data_item_stok,
                                    'language' => 'en',
                                    'options' => ['placeholder' => 'Pilih Barang', 'id' => 'id_item_stok_detail'],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                    ],
                                ]);
                                ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model_opname_detail, 'qty_opname')->textInput(['id' => 'qty_opname']) ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model_opname_detail, 'qty_program')->textInput(['readonly' => true, 'id' => 'qty_program']) ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model_opname_detail, 'qty_selisih')->textInput(['id' => 'qty_selisih']) ?>
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
                                <th>Qty Opname</th>
                                <th>Qty Program</th>
                                <th>Qty Selisih</th>
                                <th>Satuan</th>
                                <th>Gudang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query_detail = AktStokOpnameDetail::find()->where(['id_stok_opname' => $model->id_stok_opname])->all();
                            foreach ($query_detail as $key => $data) {
                                # code...
                                $item_stok = AktItemStok::findOne($data['id_item_stok']);
                                $item = AktItem::findOne($item_stok->id_item);
                                $gudang = AktGudang::findOne($item_stok->id_gudang);
                            ?>
                                <tr>
                                    <td><?= $no++ . '.' ?></td>
                                    <td><?= $item->nama_item ?></td>
                                    <td><?= $data['qty_opname'] ?></td>
                                    <td><?= $data['qty_program'] ?></td>
                                    <td><?= $data['qty_selisih'] ?></td>
                                    <td><?= $item->satuan->nama_satuan ?></td>
                                    <td><?= $gudang->nama_gudang ?></td>
                                    <td>

                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-stok-opname-detail/delete', 'id' => $data['id_stok_opname_detail']], [
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
<?php
$script = <<< JS
$('#id_item_stok_detail').change(function(){
	var id = $(this).val();
 
	$.get('index.php?r=akt-stok-opname-detail/get-qty-item',{ id : id },function(data){
		var data = $.parseJSON(data);
		$('#qty_program').attr('value',data.qty);
	});
});
 
JS;
$this->registerJs($script);
?>