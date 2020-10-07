<?php

use backend\models\AktPengajuanBiaya;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Login;
use backend\models\AktPengajuanBiayaDetail;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktApprover;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiaya */

$this->title = 'Detail Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya;
// $this->params['breadcrumbs'][] = ['label' => 'Akt Pengajuan Biayas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-pengajuan-biaya-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Pengajuan Biaya', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?php
        $approve = AktApprover::find()->leftJoin("akt_jenis_approver", "akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver")->where(['=', 'nama_jenis_approver', 'Pengajuan Biaya'])->all();

        $id_login =  Yii::$app->user->identity->id_login;
        $nama_approver = Login::find()->where(['id_login' => $id_login])->one();
       
        foreach ($approve as $key => $value) {
            if ($id_login == $value['id_login']) {
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Approve', ['approve', 'id' => $model->id_pengajuan_biaya], [
                'class' => 'btn btn-success data-approver-1',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan approving Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya . ' ?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Reject', ['reject', 'id' => $model->id_pengajuan_biaya], [
                'class' => 'btn btn-danger data-approver-2',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan rejecting Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya . ' ?',
                    'method' => 'post',
                ],
            ]) ?>
            <?php } ?>
        <?php } ?>

        <?php if ($model->status < 4) {
            $retVal = ($model->status == 4) ? 'disabled' : '';
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_pengajuan_biaya], ['class' => 'btn btn-primary btn-ubah ' . $retVal . '']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_pengajuan_biaya], [
                'class' => 'btn btn-danger btn-hapus ' . $retVal . '',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya . ' ?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>

        <?php
        if ($model->status_pembayaran == 1) {
        ?>
            <?php
            $retVal = ($model->status == 4) ? '' : 'disabled';
            ?>
            <?= Html::a('<span class="glyphicon glyphicon-ok"></span> Sudah Di Bayar', ['sudah-dibayar', 'id' => $model->id_pengajuan_biaya], [
                'class' => 'btn btn-success btn-sudah-bayar ' . $retVal . '',
                'data' => [
                    'confirm' => 'Apakah anda yakin Data Pengajuan Biaya : ' . $model->nomor_pengajuan_biaya . ' sudah dibayar ?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php } ?>
            
    </p>

    <div class="panel panel-primary">
        <div class="panel-heading"><span class="fa fa-book"></span> <?= $this->title ?></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:35%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pengajuan_biaya',
                                    'nomor_pengajuan_biaya',
                                    [
                                        'attribute' => 'tanggal_pengajuan',
                                        'value' => function ($model) {
                                            return tanggal_indo($model->tanggal_pengajuan, true);
                                        }
                                    ],
                                    'nomor_purchasing_order',
                                    'nomor_kendaraan',
                                    'volume',
                                    'keterangan_pengajuan:ntext',
                                    [
                                        'attribute' => 'dibuat_oleh',
                                        'value' => function ($model) {
                                            if (!empty($model->login->nama)) {
                                                # code...
                                                return $model->login->nama;
                                            }
                                        }
                                    ],
                                    'jenis_bayar',
                                    'dibayar_oleh',
                                    'dibayar_kepada',
                                    'alamat_dibayar_kepada:ntext',
                                ],
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'template' => '<tr><th style="width:35%;">{label}</th><td>{value}</td></tr>',
                                'attributes' => [
                                    // 'id_pengajuan_biaya',
                                    [
                                        'attribute' => 'approver1',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $login_approver1 = Login::findOne($model->approver1);
                                            $approver1 = '';
                                            if (!empty($login_approver1->nama)) {
                                                # code...
                                                $approver1 = $login_approver1->nama;
                                            }
                                            $approver1_date = '';
                                            if ($model->approver1_date == '0000-00-00 00:00:00') {
                                                # code...
                                                $approver1_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                                            } else {
                                                # code...
                                                $approver1_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver1_date))) . "</span>";
                                            }
                                            if ($model->status == 1) {
                                                # code...
                                                $approver1_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                                            }
                                            return $approver1 . '<br>' . $approver1_date;
                                        }
                                    ],
                                    [
                                        'attribute' => 'approver2',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $login_approver2 = Login::findOne($model->approver2);
                                            $approver2 = '';
                                            if (!empty($login_approver2->nama)) {
                                                # code...
                                                $approver2 = $login_approver2->nama;
                                            }
                                            $approver2_date = '';
                                            if ($model->approver2_date == '0000-00-00 00:00:00') {
                                                # code...
                                                $approver2_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                                            } else {
                                                # code...
                                                $approver2_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver2_date))) . "</span>";
                                            }
                                            if ($model->status == 2) {
                                                # code...
                                                $approver2_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                                            }
                                            return $approver2 . '<br>' . $approver2_date;
                                        }
                                    ],
                                    [
                                        'attribute' => 'approver3',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            $login_approver3 = Login::findOne($model->approver3);
                                            $approver3 = '';
                                            if (!empty($login_approver3->nama)) {
                                                # code...
                                                $approver3 = $login_approver3->nama;
                                            } 
                                            $approver3_date = '';
                                            if ($model->approver3_date == '0000-00-00 00:00:00') {
                                                # code...
                                                $approver3_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                                            } else {
                                                # code...
                                                $approver3_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver3_date))) . "</span>";
                                            }
                                            if ($model->status == 3) {
                                                # code...
                                                $approver3_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                                            }
                                            return $approver3 . '<br>' . $approver3_date;
                                        }
                                    ],
                                    [
                                        'attribute' => 'status',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($model->status == 0) {
                                                # code...
                                                return "<span class='label label-default' style='font-size: 85%;'>Belum Di Setujui</span>";
                                            } elseif ($model->status == 1) {
                                                # code...
                                                return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 1</span>";
                                            } elseif ($model->status == 2) {
                                                # code...
                                                return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 2</span>";
                                            } elseif ($model->status == 3) {
                                                # code...
                                                return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 3</span>";
                                            } elseif ($model->status == 4) {
                                                # code...
                                                return "<span class='label label-success' style='font-size: 85%;'>Sudah Di Setujui</span>";
                                            }
                                        }
                                    ],
                                    'alasan_reject:ntext',
                                    [
                                        'attribute' => 'tanggal_jatuh_tempo',
                                        'value' => function ($model) {
                                            if (!empty($model->tanggal_jatuh_tempo)) {
                                                # code...
                                                return tanggal_indo($model->tanggal_jatuh_tempo, true);
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'sumber_dana',
                                        'value' => function ($model) {
                                            if ($model->sumber_dana == 1) {
                                                # code...
                                                return "Kas Kecil Tanjung";
                                            } elseif ($model->sumber_dana == 2) {
                                                # code...
                                                return "Bank";
                                            }
                                        }
                                    ],
                                    [
                                        'attribute' => 'status_pembayaran',
                                        'format' => 'raw',
                                        'value' => function ($model) {
                                            if ($model->status_pembayaran == 1) {
                                                # code...
                                                return "<span class='label label-default' style='font-size: 85%;'>Belum Di Bayar</span>";
                                            } elseif ($model->status_pembayaran == 2) {
                                                # code...
                                                return "<span class='label label-success' style='font-size: 85%;'>Sudah Di Bayar</span>";
                                            }
                                        }
                                    ],
                                ],
                            ]) ?>
                        </div>
                    </div>
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#data-barang-penjualan"><span class="fa fa-box"></span> Data List Pengajuan</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen"><span class="fa fa-file-text"></span> Unggah Dokumen</a></li>
                        </ul>
                        <div class="tab-content">

                            <div id="data-barang-penjualan" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <?php
                                        if (in_array("APPROVER", Yii::$app->session->get('user_role'))) {
                                        } else {
                                            # code...
                                        ?>
                                            <div class="row">
                                                <?php
                                                if ($model->status < 4) {
                                                    # code...
                                                ?>
                                                    <?php $form = ActiveForm::begin([
                                                        'method' => 'post',
                                                        'action' => ['akt-pengajuan-biaya-detail/create-from-pengajuan-biaya'],
                                                    ]); ?>

                                                    <?= $form->field($model_pengajuan_biaya_detail, 'id_pengajuan_biaya')->textInput(['readonly' => true, 'type' => 'hidden'])->label(FALSE) ?>


                                                    <div class="add-class">
                                                        <?= $form->field($model_pengajuan_biaya_detail, 'id_akun')->widget(Select2::classname(), [
                                                            'data' => $data_akun,
                                                            'language' => 'en',
                                                            'options' => ['placeholder' => 'Pilih Akun', 'id' => 'id_akun'],
                                                            'pluginOptions' => [
                                                                'allowClear' => true,
                                                                'tags' => true,
                                                                'tokenSeparators' => [',', ' '],
                                                            ],
                                                        ]) ?>
                                                    </div>

                                                    <div class="col-md-2 detail-kas">
                                                        <label for="">Pilih Kas</label>
                                                        <?= DepDrop::widget([
                                                            'name' => 'detail-kas',
                                                            'type' => DepDrop::TYPE_SELECT2,
                                                            'options' => ['id' => 'id-detail-kas', 'placeholder' => 'Pilih Jenis...'],
                                                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                                                            'pluginOptions' => [
                                                                'depends' => ['id_akun'],
                                                                'url' => Url::to(['/akt-jurnal-umum/level-harga'])
                                                            ]
                                                        ]);
                                                        ?>
                                                </div>

                                                    <div class="col-md-2">
                                                        <?= $form->field($model_pengajuan_biaya_detail, 'kode_rekening')->textInput() ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <?= $form->field($model_pengajuan_biaya_detail, 'debit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <?= $form->field($model_pengajuan_biaya_detail, 'kredit')->widget(\yii\widgets\MaskedInput::className(), ['clientOptions' => ['alias' => 'decimal', 'groupSeparator' => '.', 'autoGroup' => true, 'removeMaskOnSubmit' => true, 'rightAlign' => false, 'min' => 0]]); ?>
                                                    </div>

                                                    <div class="col-md-10">
                                                        <?= $form->field($model_pengajuan_biaya_detail, 'nama_pengajuan')->textInput(['placeholder' => 'Keterangan'])->label(FALSE) ?>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button type="submit" style="width: 100%;" class=" btn btn-success"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                    </div>

                                                    <?php ActiveForm::end(); ?>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 1%;">#</th>
                                                    <th style="width: 10%;">Akun</th>
                                                    <th style="width: 10%;">Divisi</th>
                                                    <th style="width: 50%;">Pengajuan</th>
                                                    <th style="width: 10%;">Debit</th>
                                                    <th style="width: 10%;">Kredit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $totalan_debit = 0;
                                                $totalan_kredit = 0;
                                                $query_detail = AktPengajuanBiayaDetail::findAll(['id_pengajuan_biaya' => $model->id_pengajuan_biaya]);
                                                foreach ($query_detail as $key => $data) {
                                                    # code...
                                                    $akun = AktAkun::findOne($data['id_akun']);
                                                    $totalan_debit += $data['debit'];
                                                    $totalan_kredit += $data['kredit'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= (!empty($akun->nama_akun)) ? $akun->nama_akun : '' ?></td>
                                                        <td><?= $data['kode_rekening'] ?></td>
                                                        <td><?= $data['nama_pengajuan'] ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['debit']) ?></td>
                                                        <td style="text-align: right;"><?= ribuan($data['kredit']) ?></td>
                                                        <?php
                                                        if (in_array("APPROVER", Yii::$app->session->get('user_role'))) {
                                                        } else {
                                                            # code...
                                                        ?>
                                                            <?php
                                                            if ($model->status < 1) {
                                                                # code...
                                                            ?>
                                                                <td>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-edit"></span>', ['akt-pengajuan-biaya-detail/update-from-pengajuan-biaya', 'id' => $data['id_pengajuan_biaya_detail']], ['class' => 'btn btn-primary']) ?>
                                                                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['akt-pengajuan-biaya-detail/delete-from-pengajuan-biaya', 'id' => $data['id_pengajuan_biaya_detail']], [
                                                                        'class' => 'btn btn-danger',
                                                                        'data' => [
                                                                            'confirm' => 'Apakah Anda yakin akan menghapus ' . $data['nama_pengajuan'] . ' dari Data List Pengajuan?',
                                                                            'method' => 'post',
                                                                        ],
                                                                    ]) ?>
                                                                </td>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4" style="text-align: right;">Total</th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_debit) ?></th>
                                                    <th style="text-align: right;"><?= ribuan($totalan_kredit) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                <div class="row">
                                    <div class="col-md-12">

                                        <?= Html::beginForm(['akt-pengajuan-biaya/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                        <?= Html::hiddenInput("id_tabel", $model->id_pengajuan_biaya) ?>
                                        <?= Html::hiddenInput("nama_tabel", "akt_pengajuan_biaya") ?>
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
                                                            <a href="index.php?r=akt-pengajuan-biaya/view&id=<?php echo $model->id_pengajuan_biaya; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')"><img src='images/hapus.png' width='20'></a>
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

<script>
    const approver1 = document.querySelector('.data-approver-1');
    const approver2 = document.querySelector('.data-approver-2');
    const btnUbah = document.querySelector('.btn-ubah');
    const btnHapus = document.querySelector('.btn-hapus');
    const btnSudahBayar = document.querySelector('.btn-sudah-bayar');
    if (approver1 != null || approver2 != null ) {
        btnUbah.style.display = "none";
        btnHapus.style.display = "none";
        btnSudahBayar.style.display = "none";
    }
</script>


<?php

$script = <<< JS
    const detailKas = document.querySelector('.detail-kas');
    const classAkun = document.querySelector('.add-class');
    classAkun.className = 'col-md-6 add-class'
    detailKas.style.display = "none";
    $('#id_akun').on("select2:select", function (e) {
        let id = e.params.data.id;
        // console.log(id);
        if(id == 1) {
            detailKas.style.display = "block";
            classAkun.className = 'col-md-4 add-class'
        } else {
            detailKas.style.display = "none";
            classAkun.className = 'col-md-6 add-class'
        }
    })
JS;

$this->registerJs($script);

?>