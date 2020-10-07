<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktPermintaanBarangPegawai;
use backend\models\AktPegawai;
use backend\models\AktPermintaanBarangDetail;
use backend\models\AktItem;
use backend\models\AktApprover;
use backend\models\Login;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanBarang */

$this->title = 'Detail Permintaan Barang : ' . $model->nomor_permintaan;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Permintaan Barangs', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-permintaan-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Permintaan Barang :', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        // $approve = AktApprover::find()->where(['id_jenis_approver' => 8])->all();
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Permintaan Barang'])
            ->asArray()
            ->all();
        $id_login =  Yii::$app->user->identity->id_login;
        $nama_approver = Login::find()->where(['id_login' => $id_login])->one();
        if ($model->status_aktif == 0) { ?>

            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_permintaan_barang], ['class' => 'btn btn-primary']) ?>

            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_permintaan_barang], [
                'class' => 'btn btn-danger',
                // $a => true,
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus data ini ?',
                    'method' => 'post',
                ],
            ]) ?>

            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approve', ['approve', 'id' => $model->id_permintaan_barang], [
                        'class' => 'btn btn-success',
                        // $a => true,
                        'data' => [
                            'confirm' => 'Apakah anda yakin untuk mensetujui data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_permintaan_barang], [
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
        <?php if ($model->status_aktif != 0) { ?>
            <?php
            foreach ($approve as $key => $value) {
                if ($id_login == $value['id_login']) {
            ?>
                    <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_permintaan_barang], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => 'Apakah anda yakin untuk mempending data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
        <?php }
            }
        } ?>
        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print-view', 'id' => $model->id_permintaan_barang], ['class' => 'btn btn-default', 'target' => '_BLANK']) ?>
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            // 'id_permintaan_barang',
                            'nomor_permintaan',
                            [
                                'attribute' => 'tanggal_permintaan',
                                'value' => function ($model) {
                                    return tanggal_indo($model->tanggal_permintaan, TRUE);
                                }
                            ],
                            [
                                'attribute' => 'id_pegawai',
                                'value' => function ($model) {
                                    return $model->pegawai->nama_pegawai;
                                }
                            ],
                            [
                                'attribute' => 'status_aktif',
                                'format' => 'html',
                                'label' => 'Status',
                                'filter' => array(
                                    0 => 'Belum Disetujui',
                                    1 => 'Disetujui',
                                ),
                                'value' => function ($model) {
                                    if ($model->status_aktif == 0) {
                                        # code...
                                        return "<span class='label label-warning'>Belum Disetujui</span>";
                                    } elseif ($model->status_aktif == 1) {
                                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                        return "<span class='label label-success'>Disetujui pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                    } elseif ($model->status_aktif == 2) {
                                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                        return "<span class='label label-danger'>Ditolak pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                    }
                                }
                            ],
                        ],
                    ]) ?>
                    <div class="box box-success" style="margin:20px 0;"> </div>

                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#pegawai"> <span class="fa fa-box"></span> Barang</a></li>
                            <!-- <li><a data-toggle="tab" href="#item">Barang</a></li> -->
                        </ul>

                        <div class="tab-content">
                            <?php if ($model->status_aktif != 1) { ?>
                                <div class="row">
                                    <div class="box-body">
                                        <?php $form = ActiveForm::begin([
                                            'method' => 'post',
                                            'action' => ['akt-permintaan-barang-detail/create'],
                                        ]); ?>
                                        <?= $form->field($model2, 'id_permintaan_barang')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <?= $form->field($model2, 'id_item')->widget(Select2::classname(), [
                                                    'data' => $data_item,
                                                    'language' => 'en',
                                                    'options' => ['placeholder' => 'Pilih Barang'],
                                                    'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ])->label('Pilih Barang');
                                                ?>
                                            </div>
                                            <div class="col-md-2">
                                                <?= $form->field($model2, 'qty')->textInput() ?>
                                            </div>
                                            <div class="col-md-5">
                                                <?= $form->field($model2, 'keterangan')->textarea(['rows' => 1]) ?>
                                            </div>
                                            <div class="col-md-2">
                                                <button class="btn btn-success" style="width: 100%; margin-top:25px;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                            </div>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div id="pegawai" class="tab-pane fade in active">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Barang</th>
                                            <th>Qty</th>
                                            <th>Satuan</th>
                                            <th>Qty Ordered</th>
                                            <th>Qty Rejected</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $query_permintaan_barang_detail = AktPermintaanBarangDetail::find()->where(['id_permintaan_barang' => $model->id_permintaan_barang])->all();
                                        foreach ($query_permintaan_barang_detail as $key => $data) {
                                            # code...
                                            $item = AktItem::findOne($data['id_item']);
                                        ?>
                                            <tr>
                                                <td><?= $no++ . '.' ?></td>
                                                <td><?= (!empty($item->nama_item)) ? $item->nama_item : '' ?></td>
                                                <td><?= $data['qty'] ?></td>
                                                <td><?= (!empty($item->satuan->nama_satuan)) ? $item->satuan->nama_satuan : '' ?></td>
                                                <td><?= $data['qty_ordered'] ?></td>
                                                <td><?= $data['qty_rejected'] ?></td>
                                                <td><?= $data['keterangan'] ?></td>
                                                <?php if ($model->status_aktif == 0) { ?>
                                                    <td>
                                                        <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-permintaan-barang-detail/update', 'id' => $data['id_permintaan_barang_detail']], ['class' => 'btn btn-primary']) ?>
                                                        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-permintaan-barang-detail/delete', 'id' => $data['id_permintaan_barang_detail']], [
                                                            'class' => 'btn btn-danger',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                'method' => 'post',
                                                            ],
                                                        ]) ?>
                                                    </td>
                                                    <?php } else {
                                                    foreach ($approve as $key => $value) {
                                                        if ($id_login == $value['id_login']) {
                                                    ?>
                                                            <td>
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-permintaan-barang-detail/update', 'id' => $data['id_permintaan_barang_detail']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-permintaan-barang-detail/delete', 'id' => $data['id_permintaan_barang_detail']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            </td>
                                                <?php }
                                                    }
                                                } ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- </div> 
                                    <p>
                                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Pegawai', ['akt-permintaan-barang-pegawai/create', 'id' => $model->id_permintaan_barang], ['class' => 'btn btn-success']) ?>
                                    </p>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Pegawai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query_permintaan_baran_pegawai = AktPermintaanBarangPegawai::find()->where(['id_permintaan_barang' => $model->id_permintaan_barang])->all();
                                            foreach ($query_permintaan_baran_pegawai as $key => $data) {
                                                # code...
                                                $pegawai = AktPegawai::findOne($data['id_pegawai']);
                                            ?>
                                            <tr>
                                                <td><?= $no++ . '.' ?></td>
                                                <td><?= (!empty($pegawai->nama_pegawai)) ? $pegawai->nama_pegawai : '' ?></td>
                                                <td>
                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-permintaan-barang-pegawai/update', 'id' => $data['id_permintaan_barang_pegawai']], ['class' => 'btn btn-primary']) ?>
                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-permintaan-barang-pegawai/delete', 'id' => $data['id_permintaan_barang_pegawai']], [
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
                                    </table> -->

                            </div>
                            <div id="item" class="tab-pane fade" style="margin-top:20px;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>