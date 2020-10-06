<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Foto;
use backend\models\AktCabang;
use backend\models\AktPegawai;
use backend\models\AktProyek;
use backend\models\Login;
use backend\models\AktDepartement;
use backend\models\AktSatuan;
use backend\models\AktApprover;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPermintaanPembelian */

$this->title = 'Detail Permintaan Pembelian : ' . $model->no_permintaan;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-permintaan-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Permintaan Pembelian', ['index']) ?></li>
        <li class="active"><?= $model->no_permintaan ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>

        <?php
        $approve = AktApprover::find()
            ->leftJoin('akt_jenis_approver', 'akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver')
            ->where(['=', 'nama_jenis_approver', 'Permintaan Pembelian'])
            ->asArray()
            ->all();
        $id_login =  Yii::$app->user->identity->id_login;
        $nama_approver = Login::find()->where(['id_login' => $id_login])->one();
        if ($model->status === 2) { ?>

            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_permintaan_pembelian], ['class' => 'btn btn-primary']) ?>

            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_permintaan_pembelian], [
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
                    <?= Html::a('<span class="glyphicon glyphicon-check"></span> Approve', ['approve', 'id' => $model->id_permintaan_pembelian], [
                        'class' => 'btn btn-success',
                        // $a => true,
                        'data' => [
                            'confirm' => 'Apakah anda yakin untuk mensetujui data ini ?',
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a('<span class="glyphicon glyphicon-share"></span> Reject', ['reject', 'id' => $model->id_permintaan_pembelian], [
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
        <?php if ($model->status != 2) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-pause"></span> Pending', ['pending', 'id' => $model->id_permintaan_pembelian], [
                'class' => 'btn btn-info',
                // $a => true,
                'data' => [
                    'confirm' => 'Apakah anda yakin untuk mempending data ini ?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>

        <?= Html::a('<span class="glyphicon glyphicon-print"></span> Cetak', ['print-view', 'id' => $model->id_permintaan_pembelian], ['class' => 'btn btn-default', 'target' => '_BLANK']) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file"></span> Permintaan Pembelian</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                'no_permintaan',
                                // 'tanggal',
                                [
                                    'attribute' => 'tanggal',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal);
                                    }
                                ],
                                [
                                    'attribute' => 'id_pegawai',
                                    'label' => 'Pegawai',
                                    'value' => function ($model) {

                                        $pegawai = AktPegawai::find()->where(['id_pegawai' => $model->id_pegawai])->one();

                                        return $pegawai->nama_pegawai;
                                    }
                                ],
                                'keterangan:ntext',
                                [
                                    'attribute' => 'status',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status == '2') {
                                            return '<p class="label label-default" style="font-weight:bold;"> Belum Disetujui </p> ';
                                        } else if ($model->status == '1') {
                                            $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                            return "<span class='label label-success'>Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                        } else if ($model->status == '3') {
                                            $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                                            return "<span class='label label-danger'>Ditolak pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                                        }
                                    }
                                ],
                            ],
                        ]) ?>

                        <div class="" style="margin-top:20px;">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#pendaftaran-item"><span class="fa fa-box"></span> Data Barang</a></li>
                                <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="pendaftaran-item" class="tab-pane fade in active" style="margin-top:20px;">
                                    <?php
                                    if ($model->status != 2) {
                                        $c = 'hidden';
                                    } else {
                                        $c = '';
                                    }

                                    ?>
                                    <div class="row" style="margin-top:30px;">
                                        <div class="col-md-12">
                                            <div class="box box-success">

                                                <div class="box-body">

                                                    <div class=" <?= $c; ?>">
                                                        <?php if ($model->status != 0) {  ?>
                                                            <div class="row">
                                                                <?= Html::beginForm(['akt-permintaan-pembelian/view', 'aksi' => 'save', 'id' => Yii::$app->request->get('id')], 'post') ?>
                                                                <div class="col-md-9">
                                                                    <label>Nama Barang</label>
                                                                    <?php
                                                                    echo Select2::widget([
                                                                        'name' => 'id_item_stok',
                                                                        'data' => $array_item,
                                                                        'language' => 'en',
                                                                        'options' => ['placeholder' => 'Pilih Barang', "required" => true],
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true
                                                                        ]
                                                                    ]);

                                                                    ?>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>Quantity</label>
                                                                    <?= Html::input("number", "quantity", "", ["class" => "form-control", "placeholder" => "Qty", "id" => "qty", "required" => true]) ?>
                                                                </div>
                                                                <div class="col-md-2" hidden>
                                                                    <?php echo Select2::widget([
                                                                        // 'model' => $model,
                                                                        'name' => 'proyek',
                                                                        'data' => ArrayHelper::map(AktProyek::find()->all(), 'id_proyek', 'nama_proyek'),
                                                                        'options' => ['placeholder' => 'Pilih Proyek'],
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true
                                                                        ],
                                                                    ]); ?>
                                                                </div>
                                                                <div class="col-md-2" hidden>
                                                                    <?php echo Select2::widget([
                                                                        // 'model' => $model,
                                                                        'name' => 'departement',
                                                                        'data' => ArrayHelper::map(AktDepartement::find()->all(), 'id_departement', 'nama_departement'),
                                                                        'options' => ['placeholder' => 'Pilih Departement'],
                                                                        'pluginOptions' => [
                                                                            'allowClear' => true
                                                                        ],
                                                                    ]); ?>
                                                                </div>
                                                            </div><br>
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <!-- <label>Keterangan</label> -->
                                                                    <?= Html::input("text", "keterangan", "", ["class" => "form-control", "placeholder" => "Keterangan", "id" => "keterangan"]) ?>
                                                                </div>

                                                                <div class="col-md-3" hidden>
                                                                    <?php echo DatePicker::widget([
                                                                        'name' => 'req_date',
                                                                        'options' => ['placeholder' => 'Req. Date'],
                                                                        'pluginOptions' => [
                                                                            'todayHighlight' => true,
                                                                            'todayBtn' => true,
                                                                            'format' => 'yyyy-mm-dd',
                                                                            'autoclose' => true,
                                                                        ]
                                                                    ]);
                                                                    ?>

                                                                </div>



                                                                <div class="col-md-3">
                                                                    <button class="btn btn-success" style="width: 100%;"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                                </div>

                                                                <?= Html::endForm() ?>
                                                            </div>

                                                        <?php } ?>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <br>
                                                            <table class="table">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Nama Barang</th>
                                                                    <th>Quantity</th>
                                                                    <!-- <th>Proyek</th> -->
                                                                    <!-- <th>Departement</th> -->
                                                                    <th>Keterangan</th>
                                                                    <!-- <th align="right">Req. Date</th> -->
                                                                    <th class="<?= $c ?>">Action</th>
                                                                </tr>
                                                                <?php
                                                                $i = 0;
                                                                // $subtotal = 0;
                                                                foreach ($daftar_item as $data) {

                                                                    $i++;
                                                                    echo "<tr>";
                                                                    echo "<td align='center'>$i.</td>";
                                                                    echo "<td>" . $data->item_stok->item["nama_item"] . "</td>";
                                                                    echo "<td>" . $data->quantity . "</td>";
                                                                    // echo "<td align='right'>" . $data->proyek["nama_proyek"]  . "</td>";
                                                                    // echo "<td align='right'>" . $data->departement["nama_departement"]  . "</td>";
                                                                    echo "<td>" . $data->keterangan . "</td>";
                                                                    // echo "<td align='right'>" . tanggal_indo($data->req_date, true)  . "</td>";


                                                                    echo "<td class=\" $c \"><a href=\"index.php?r=item-permintaan-pembelian/update&id=" . Yii::$app->request->get('id') . "&id_item_permintaan_pembelian=$data->id_item_permintaan_pembelian\"> <button type='submit' class='btn btn-primary'><span class='glyphicon glyphicon-edit'></span></button>  </a> &nbsp; 


                                                                    <a href=\"index.php?r=akt-permintaan-pembelian/view&id=" . Yii::$app->request->get('id') . "&action=delete_item&id_item_permintaan_pembelian=$data->id_item_permintaan_pembelian\"><button type='reset' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></button>   </a> </td>";

                                                                    echo "</tr>";
                                                                }



                                                                ?>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                    <?= Html::beginForm(['akt-permintaan-pembelian/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                    <?= Html::hiddenInput("id_tabel", $model->id_permintaan_pembelian) ?>
                                    <?= Html::hiddenInput("nama_tabel", "permintaan-pembelian") ?>
                                    <div class="box <?= $c ?>">
                                        <div class="box-header">
                                            <div class="col-md-12" style="padding: 0;">
                                                <div class="box-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>UPLOAD FOTO ATAU DOKUMEN</th>
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?= Html::endForm() ?>

                                    <div class="box">
                                        <div class="box-header">
                                            <div class="col-md-12" style="padding: 0;">
                                                <div class="box-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>DOKUMEN :</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <?php foreach ($foto as $data) { ?>
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th width="80%">
                                                                        <a target="_BLANK" href="/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                                    </th>
                                                                    <th width="20%">
                                                                        <a href="index.php?r=akt-permintaan-pembelian/view&id=<?php echo $model->id_permintaan_pembelian; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')"><img src='images/hapus.png' width='20'></a>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    <?php } ?>
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
</div>