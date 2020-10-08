<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktReturPenjualanDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\AktPenjualanDetail;
use backend\models\AktApprover;
use backend\models\AktPenjualanPengirimanDetail;
use backend\models\Login;
/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPenjualan */

$this->title = 'Detail Data Retur Penjualan : ' . $model->no_retur_penjualan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur Penjualans', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-retur-penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Penjualan', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>


    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        // $approve = AktApprover::find()->where(['id_jenis_approver' => 17])->all();
        $approve = AktApprover::find()->leftJoin("akt_jenis_approver", "akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver")->where(['=', 'nama_jenis_approver', 'Retur Penjualan'])->all();
        $id_login =  Yii::$app->user->identity->id_login;
        $nama_approver = Login::find()->where(['id_login' => $id_login])->one();

        # untuk menentukan yang login apakah approver, jika approver maka form tidak muncul
        $string_approve = array();
        foreach ($approve as $key => $value) {
            # code...
            $string_approve[] = $value['id_login'];
        }
        $hasil_string_approve = implode(", ", $string_approve);
        $hasil_array_approve = explode(", ", $hasil_string_approve);
        $angka_array_approve = 0;
        if (in_array(Yii::$app->user->identity->id_login, $hasil_array_approve)) {
            # code...
            $angka_array_approve = 1;
        }

        if ($model->status_retur == 0) { ?>

            <?php
            if ($angka_array_approve == 0) {
                # code...
            ?>
                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_retur_penjualan], ['class' => 'btn btn-primary']) ?>

                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_retur_penjualan], [
                    'class' => 'btn btn-danger',
                    // $a => true,
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menghapus data ini ?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php } ?>

            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approve', ['approve', 'id' => $model->id_retur_penjualan], [
                        'class' => 'btn btn-success',
                        // $a => true,
                        'data' => [
                            'confirm' => 'Apakah anda yakin untuk mensetujui data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_retur_penjualan], [
                        'class' => 'btn btn-danger',
                        // $a => true,
                        'data' => [
                            'confirm' => 'Apakah anda yakin untuk menolak data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php
                }
            }
        } ?>
        <?php if ($model->status_retur != 0) { ?>
            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_retur_penjualan], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Apakah anda yakin untuk mempending data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php }
            }
        } ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print-view', 'id' => $model->id_retur_penjualan], ['class' => 'btn btn-default', 'target' => '_BLANK']) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="glyphicon glyphicon-repeat"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_retur_penjualan',
                                    'no_retur_penjualan',
                                    [
                                        'attribute' => 'tanggal_retur_penjualan',
                                        'value' => function ($model) {
                                            return tanggal_indo($model->tanggal_retur_penjualan, true);
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:40%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_retur_penjualan',
                                    [
                                        'attribute' => 'id_penjualan_pengiriman',
                                        'value' => function ($model) {
                                            if (!empty($model->penjualan_pengiriman->no_pengiriman)) {
                                                # code...
                                                return $model->penjualan_pengiriman->no_pengiriman;
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'status_retur',
                                        'format' => 'html',
                                        'label' => 'Status',
                                        'filter' => array(
                                            0 => 'Pengajuan',
                                            1 => 'Disetujui',
                                            2 => 'Ditolak'
                                        ),
                                        'value' => function ($model) {
                                            if ($model->status_retur == 0) {
                                                # code...
                                                return "<span class='label label-warning'>Pengajuan</span>";
                                            } elseif ($model->status_retur == 1) {
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-success'>Disetujui pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                            } elseif ($model->status_retur == 2) {
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-danger'>Ditolak pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang-penjualan"><span class="fa fa-box"></span> Data Retur Barang Penjualan</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang-penjualan" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="row">
                                            <?php
                                            if ($model->status_retur == 0 && $angka_array_approve == 0) {
                                                # code...
                                            ?>
                                                <?php $form = ActiveForm::begin([
                                                    'method' => 'post',
                                                    'action' => ['akt-retur-penjualan-detail/create'],
                                                ]); ?>

                                                <?= $form->field($model_retur_penjualan_detail, 'id_retur_penjualan')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>

                                                <div class="col-md-9">
                                                    <?= $form->field($model_retur_penjualan_detail, 'id_penjualan_pengiriman_detail')->widget(Select2::classname(), [
                                                        'data' => $data_penjualan_pengiriman_detail,
                                                        'language' => 'en',
                                                        'options' => ['placeholder' => 'Pilih Barang'],
                                                        'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ])
                                                    ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <?= $form->field($model_retur_penjualan_detail, 'retur')->textInput(['maxlength' => true, 'readonly' => false, 'autocomplete' => 'off', 'placeholder' => 'Jumlah Retur']) ?>
                                                </div>

                                                <div class="col-md-10">
                                                    <?= $form->field($model_retur_penjualan_detail, 'keterangan')->textarea(['rows' => 1, 'placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success col-md-12"><span class="glyphicon glyphicon-floppy-saved"></span> Tambahkan</button>
                                                </div>

                                                <?php ActiveForm::end(); ?>
                                            <?php } ?>
                                        </div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 45%;">Nama Barang</th>
                                                    <th style="width: 5%;white-space: nowrap;">Qty Dikirim</th>
                                                    <th style="width: 5%;">Retur</th>
                                                    <th style="width: 45%;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_retur_penjualan_detail = AktReturPenjualanDetail::find()->where(['id_retur_penjualan' => $model->id_retur_penjualan])->all();
                                                foreach ($query_retur_penjualan_detail as $key => $data) {
                                                    # code...
                                                    $penjualan_pengiriman_detail = AktPenjualanPengirimanDetail::findOne($data->id_penjualan_pengiriman_detail);
                                                    $penjualan_detail = AktPenjualanDetail::findOne($penjualan_pengiriman_detail->id_penjualan_detail);
                                                    $item_stok = AktItemStok::findOne($penjualan_detail->id_item_stok);
                                                    $item = AktItem::findOne($item_stok->id_item);
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                                                        <td><?= $data['qty'] ?></td>
                                                        <td><?= $data['retur'] ?></td>
                                                        <td><?= $data['keterangan'] ?></td>
                                                        <td style="white-space: nowrap;">
                                                            <?php
                                                            if ($model->status_retur == 0 && $angka_array_approve == 0) {
                                                                # code...
                                                            ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-retur-penjualan-detail/update', 'id' => $data['id_retur_penjualan_detail']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-retur-penjualan-detail/delete', 'id' => $data['id_retur_penjualan_detail']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Apakah Anda yakin akan menghapus ' . $item->nama_item . ' dari Data Retur Barang Penjualan?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <?= Html::beginForm(['akt-retur-penjualan/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_retur_penjualan) ?>
                                        <?= Html::hiddenInput("nama_tabel", "akt_retur_penjualan") ?>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">UPLOAD FOTO ATAU DOKUMEN</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input class='btn btn-warning' type="file" name="foto" id="exampleInputFile" required><br>
                                                        <b style="color: red;">Catatan:<br>- File harus bertype jpg, png, jpeg, excel, work, pdf<br>- Ukuran maksimal 2 MB.</b>
                                                    </td>
                                                    <td>
                                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?= Html::endForm() ?>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">DOKUMEN :</th>
                                                </tr>
                                                <?php
                                                $no = 1;
                                                foreach ($foto as $key => $data) {
                                                    # code...
                                                ?>
                                                    <tr>
                                                        <th style="width: 1%;"><?= $no++ . '.' ?></th>
                                                        <th style="width: 80%;">
                                                            <a target="_BLANK" href="/accounting/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                        </th>
                                                        <th style="width: 20%;">
                                                            <a href="index.php?r=akt-retur-penjualan/view&id=<?php echo $model->id_retur_penjualan; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')">
                                                                <img src='images/hapus.png' width='20'>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </thead>
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

<?php
$script = <<< JS

    $('#aktreturpenjualandetail-id_penjualan_pengiriman_detail').change(function(){
	var id = $(this).val();

	$.get('index.php?r=akt-retur-penjualan-detail/get-qty-penjualan-pengiriman-detail',{ id : id },function(data){
		var data = $.parseJSON(data);
		$('#aktreturpenjualandetail-qty').attr('value',data.qty_dikirim);
	});
    });

JS;
$this->registerJs($script);
?>