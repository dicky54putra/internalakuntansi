<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktReturPembelianDetail;
use backend\models\AktItemStok;
use backend\models\AktItem;
use backend\models\Login;
use backend\models\AktApprover;
use backend\models\AktPembelianDetail;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturpembelian */

$this->title = 'Detail Data Retur Pembelian : ' . $model->no_retur_pembelian;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Retur pembelians', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-retur-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Retur Pembelian', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        $id_login =  Yii::$app->user->identity->id_login;
        $query_approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Retur Pembelian'])
            ->andWhere(["id_login" => $id_login])
            ->asArray();
        $approve = $query_approve->all();

        $isApprove = $query_approve->one();


        if ($model->status_retur == 1 && $isApprove) {
            # code...
        ?>

            <?php
            foreach ($approve as $key => $value) {
            ?>
                <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approved', ['approved', 'id' => $model->id_retur_pembelian], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menerima retur ' . $model->no_retur_pembelian . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_retur_pembelian], [
                    'class' => 'btn btn-danger',
                    // $a => true,
                    'data' => [
                        'confirm' => 'Apakah anda yakin untuk menolak data ini ' . $model->no_retur_pembelian . ' ?',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php }
        } ?>

        <?php if ($model->status_retur == 1 && !$isApprove) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_retur_pembelian], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_retur_pembelian], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus ' . $model->no_retur_pembelian . ' dari Data Retur Pembelian ?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>

        <?php if ($model->status_retur != 1) { ?>
            <?php
            foreach ($approve as $key => $value) {
            ?>
                <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_retur_pembelian], [
                    'class' => 'btn btn-info',
                    'data' => [
                        'confirm' => 'Apakah anda yakin untuk mempending data ini ?',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php }
        } ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print-view', 'id' => $model->id_retur_pembelian], ['class' => 'btn btn-default', 'target' => '_BLANK']) ?>
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
                                    // 'id_retur_pembelian',
                                    'no_retur_pembelian',
                                    [
                                        'attribute' => 'id_kas_bank',
                                        'value' => function ($model) {
                                            if (!empty($model->id_kas_bank)) {
                                                # code...
                                                return $model->kas->keterangan;
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'status_retur',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($model->status_retur == 1) {
                                                # code...
                                                return "<span class='label label-default'>Pengajuan</span>";
                                            } else if ($model->status_retur == 2) {
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-success'>Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                            } else if ($model->status_retur == 3) {
                                                $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                                return "<span class='label label-danger'>Ditolak pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                            }
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
                                    // 'id_retur_pembelian',

                                    [
                                        'attribute' => 'tanggal_retur_pembelian',
                                        'label' => 'Tanggal Retur',
                                        'value' => function ($model) {
                                            return tanggal_indo($model->tanggal_retur_pembelian, true);
                                        }
                                    ],
                                    [
                                        'attribute' => 'id_pembelian',
                                        'label' => 'No. Pembelian',
                                        'value' => function ($model) {
                                            if (!empty($model->pembelian->no_pembelian)) {
                                                # code...
                                                return $model->pembelian->no_pembelian;
                                            } else {
                                                # code...
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang-pembelian"><span class="fa fa-box"></span> Data Retur Barang Pembelian</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang-pembelian" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if (!$isApprove) { ?>
                                            <div class="row">
                                                <?php
                                                if ($model->status_retur == 1) {
                                                    # code...
                                                ?>
                                                    <?php $form = ActiveForm::begin([
                                                        'method' => 'post',
                                                        'action' => ['akt-retur-pembelian-detail/create-from-retur-pembelian'],
                                                    ]); ?>

                                                    <?= $form->field($model_retur_pembelian_detail, 'id_retur_pembelian')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
                                                    <div class="col-md-7">
                                                        <?= $form->field($model_retur_pembelian_detail, 'id_pembelian_detail')->widget(Select2::classname(), [
                                                            'data' => $data_pembelian_detail,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Barang'],
                                                            'pluginOptions' => [
                                                                'allowClear' => true
                                                            ],
                                                        ])->label('Nama Barang')
                                                        ?>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <?= $form->field($model_retur_pembelian_detail, 'qty')->textInput(['autocomplete' => 'off', 'readonly' => true]) ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <?= $form->field($model_retur_pembelian_detail, 'retur')->textInput(['maxlength' => true, 'readonly' => false, 'autocomplete' => 'off', 'placeholder' => 'Jumlah Retur']) ?>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <?= $form->field($model_retur_pembelian_detail, 'keterangan')->textarea(['rows' => 1, 'placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button class="btn btn-success" style="padding:6px 33px;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 50%;">Nama Barang</th>
                                                    <th>Qty</th>
                                                    <th>Retur</th>
                                                    <th style="width: 30%;">Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_retur_pembelian_detail = AktReturPembelianDetail::find()->where(['id_retur_pembelian' => $model->id_retur_pembelian])->all();
                                                foreach ($query_retur_pembelian_detail as $key => $data) {
                                                    # code...
                                                    $pembelian_detail = AktPembelianDetail::findOne($data['id_pembelian_detail']);
                                                    if (!empty($pembelian_detail->id_item_stok)) {
                                                        $item_stok = AktItemStok::findOne($pembelian_detail->id_item_stok);
                                                        $item = AktItem::findOne($item_stok->id_item);
                                                ?>
                                                        <tr>
                                                            <td><?= $no++ . '.' ?></td>
                                                            <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                                                            <td><?= $data['qty'] ?></td>
                                                            <td><?= $data['retur'] ?></td>
                                                            <td><?= $data['keterangan'] ?></td>
                                                            <td>
                                                                <?php
                                                                if ($model->status_retur == 1) {
                                                                    # code...
                                                                ?>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-retur-pembelian-detail/update', 'id' => $data['id_retur_pembelian_detail']], ['class' => 'btn btn-primary']) ?>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-retur-pembelian-detail/delete', 'id' => $data['id_retur_pembelian_detail']], [
                                                                        'class' => 'btn btn-danger',
                                                                        'data' => [
                                                                            'confirm' => 'Apakah Anda yakin akan menghapus ' . $item->nama_item . ' dari Data Retur Barang pembelian?',
                                                                            'method' => 'post',
                                                                        ],
                                                                    ]) ?>
                                                            <?php }
                                                            } ?>
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

                                        <?= Html::beginForm(['akt-retur-pembelian/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_retur_pembelian) ?>
                                        <?= Html::hiddenInput("nama_tabel", "akt_retur_pembelian") ?>
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
                                                            <a href="index.php?r=akt-retur-pembelian/view&id=<?php echo $model->id_retur_pembelian; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')">
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

    $('#aktreturpembeliandetail-id_pembelian_detail').change(function(){
    var id = $(this).val();

    $.get('index.php?r=akt-retur-pembelian-detail/get-qty-pembelian-detail',{ id : id },function(data){
        var data = $.parseJSON(data);
        // console.log(data);
        if(data.qty_retur === null ) {
             $('#aktreturpembeliandetail-qty').attr('value',data.qty_pembelian.qty);
        } else {
             $('#aktreturpembeliandetail-qty').attr('value',data.qty_retur);
        }
       
    });
    });

JS;
$this->registerJs($script);
?>