<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktMitraBisnisKontak;
use backend\models\AktMitraBisnisBankPajak;
use backend\models\AktMitraBisnisPembelianPenjualan;
use backend\models\AktAkun;
use backend\models\AktMataUang;
use backend\models\AktKota;
/* @var $this yii\web\View */
/* @var $model backend\models\AktMitraBisnis */

$this->title = "Detail Mitra Bisnis : " . $model->kode_mitra_bisnis;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-mitra-bisnis-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Mitra Bisnis', ['index']) ?></li>
        <li class="active">Detail Mitra Bisnis : <?= $model->kode_mitra_bisnis ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_mitra_bisnis], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-users"></span> Daftar Mitra Bisnis</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_mitra_bisnis',
                                [
                                    'attribute' => 'kode_mitra_bisnis',
                                    'label' => 'Kode',
                                ],
                                [
                                    'attribute' => 'pemilik_bisnis',
                                ],
                                [
                                    'attribute' => 'nama_mitra_bisnis',
                                    'label' => 'Nama',
                                ],
                                [
                                    'attribute' => 'deskripsi_mitra_bisnis',
                                    'label' => 'Deskripsi',
                                ],
                                [
                                    'attribute' => 'tipe_mitra_bisnis',
                                    'label' => 'Tipe Mitra Bisnis',
                                    'filter' => array(
                                        1 => "Customer",
                                        2 => "Supplier",
                                        3 => "Customer & Supplier"
                                    ),
                                    'value' => function ($model) {
                                        if ($model->tipe_mitra_bisnis == 1) {
                                            # code...
                                            return 'Customer';
                                        } elseif ($model->tipe_mitra_bisnis == 2) {
                                            # code...
                                            return 'Supplier';
                                        } elseif ($model->tipe_mitra_bisnis == 3) {
                                            # code...
                                            return 'Customer & Supplier';
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'status_mitra_bisnis',
                                    'label' => 'Status',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        if ($model->status_mitra_bisnis == 2) {
                                            return '<p class="label label-danger" style="font-weight:bold;"> Tidak Aktif </p> ';
                                        } else if ($model->status_mitra_bisnis == 1) {
                                            return '<p class="label label-success" style="font-weight:bold;"> Aktif </p> ';
                                        }
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <div class="" style="margin-top:20px;">
                                <ul class="nav nav-tabs" id="tabForRefreshPage">
                                    <li class="active"><a data-toggle="tab" href="#alamat">Alamat</a></li>
                                    <li><a data-toggle="tab" href="#kontak">Kontak</a></li>
                                    <li><a data-toggle="tab" href="#bank-pajak">Bank / Pajak</a></li>
                                    <!-- <li><a data-toggle="tab" href="#hutang-piutang">Hutang / Piutang</a></li> -->
                                </ul>

                                <div class="tab-content">
                                    <div id="alamat" class="tab-pane fade in active" style="margin-top:20px;">
                                        <p>
                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span>  Tambah Alamat', ['akt-mitra-bisnis-alamat/create', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-success']) ?>
                                        </p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Keterangan Alamat</th>
                                                    <th>Alamat Lengkap</th>
                                                    <th>Kota</th>
                                                    <th>Telephone</th>
                                                    <th>Fax</th>
                                                    <th>Kode Pos</th>
                                                    <th>Alamat Pengiriman/Penagihan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_alamat = AktMitraBisnisAlamat::find()->where(['id_mitra_bisnis' => $model->id_mitra_bisnis])->asArray()->all();
                                                foreach ($query_alamat as $key => $data) {
                                                    # code...
                                                    $kota = AktKota::findOne($data['id_kota']);
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= $data['keterangan_alamat'] ?></td>
                                                        <td><?= $data['alamat_lengkap'] ?></td>
                                                        <td><?= (!empty($kota->nama_kota)) ? $kota->nama_kota : '' ?></td>
                                                        <td><?= $data['telephone'] ?></td>
                                                        <td><?= $data['fax'] ?></td>
                                                        <td><?= $data['kode_pos'] ?></td>
                                                        <td><?= ($data['alamat_pengiriman_penagihan'] == 1) ? 'Pengiriman' : $retVal = ($data['alamat_pengiriman_penagihan'] == 2) ? 'Penagihan' : 'Pengiriman & Penagihan'; ?></td>
                                                        <td>
                                                            <p>
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-mitra-bisnis-alamat/update', 'id' => $data['id_mitra_bisnis_alamat']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-mitra-bisnis-alamat/delete', 'id' => $data['id_mitra_bisnis_alamat']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            </p>

                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="kontak" class="tab-pane fade" style="margin-top:20px;">
                                        <p>
                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span>  Tambah Kontak', ['akt-mitra-bisnis-kontak/create', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-success']) ?>
                                        </p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Kontak</th>
                                                    <th>Jabatan</th>
                                                    <th>Handphone</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_kontak = AktMitraBisnisKontak::find()->where(['id_mitra_bisnis' => $model->id_mitra_bisnis])->asArray()->all();
                                                foreach ($query_kontak as $key => $data) {
                                                    # code...
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= $data['nama_kontak'] ?></td>
                                                        <td><?= $data['jabatan'] ?></td>
                                                        <td><?= $data['handphone'] ?></td>
                                                        <td><?= $data['email'] ?></td>
                                                        <td>
                                                            <p>
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-mitra-bisnis-kontak/update', 'id' => $data['id_mitra_bisnis_kontak']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-mitra-bisnis-kontak/delete', 'id' => $data['id_mitra_bisnis_kontak']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            </p>

                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="bank-pajak" class="tab-pane fade" style="margin-top:20px;">
                                        <p>
                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Bank/Pajak', ['akt-mitra-bisnis-bank-pajak/create', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-success']) ?>
                                        </p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Bank</th>
                                                    <th>No. Rekening</th>
                                                    <th>Atas Nama</th>
                                                    <th>N.P.W.P</th>
                                                    <th>P.K.P</th>
                                                    <th>Tanggak P.K.P</th>
                                                    <th>No. NIK</th>
                                                    <th>Atas Nama NIK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_bank_pajak = AktMitraBisnisBankPajak::find()->where(['id_mitra_bisnis' => $model->id_mitra_bisnis])->asArray()->all();
                                                foreach ($query_bank_pajak as $key => $data) {
                                                    # code...
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= $data['nama_bank'] ?></td>
                                                        <td><?= $data['no_rekening'] ?></td>
                                                        <td><?= $data['atas_nama'] ?></td>
                                                        <td><?= $data['npwp'] ?></td>
                                                        <td><?= $data['pkp'] ?></td>
                                                        <td><?= $data['tanggal_pkp'] ?></td>
                                                        <td><?= $data['no_nik'] ?></td>
                                                        <td><?= $data['atas_nama_nik'] ?></td>
                                                        <td>
                                                            <p>
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-mitra-bisnis-bank-pajak/update', 'id' => $data['id_mitra_bisnis_bank_pajak']], ['class' => 'btn btn-primary']) ?>
                                                            </p>
                                                            <p>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-mitra-bisnis-bank-pajak/delete', 'id' => $data['id_mitra_bisnis_bank_pajak']], [
                                                                    'class' => 'btn btn-danger m-5',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>

                                                            </p>


                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="hutang-piutang" class="tab-pane fade" style="margin-top:20px;">
                                        <p>
                                            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Hutang/Piutang', ['akt-mitra-bisnis-pembelian-penjualan/create', 'id' => $model->id_mitra_bisnis], ['class' => 'btn btn-success']) ?>
                                        </p>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th rowspan="2">Mata Uang</th>
                                                    <th colspan="2" style="text-align: center;">Pembelian</th>
                                                    <th colspan="2" style="text-align: center;">Penjualan</th>
                                                    <th colspan="3" style="text-align: center;">Hutang</th>
                                                    <th colspan="3" style="text-align: center;">Piutang</th>
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th>Termin</th>
                                                    <th>Tempo</th>
                                                    <th>Termin</th>
                                                    <th>Tempo</th>
                                                    <th>Batas Hutang</th>
                                                    <th>Batas Frekuensi</th>
                                                    <th>Akun</th>
                                                    <th>Batas Hutang</th>
                                                    <th>Batas Frekuensi</th>
                                                    <th>Akun</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                $query_hutang_piutang = AktMitraBisnisPembelianPenjualan::find()->where(['id_mitra_bisnis' => $model->id_mitra_bisnis])->asArray()->all();
                                                foreach ($query_hutang_piutang as $key => $data) {
                                                    # code...
                                                    $mata_uang = AktMataUang::find()->where(['id_mata_uang' => $data['id_mata_uang']])->one();
                                                    $akun_hutang = AktAkun::find()->where(['id_akun' => $data['id_akun_hutang']])->one();
                                                    $akun_piutang = AktAkun::find()->where(['id_akun' => $data['id_akun_piutang']])->one();
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ . '.' ?></td>
                                                        <td><?= $mata_uang->mata_uang ?></td>
                                                        <td><?= ($data['termin_pembelian'] == 1) ? 'Cash' : 'Credit' ?></td>
                                                        <td><?= $data['tempo_pembelian'] ?></td>
                                                        <td><?= ($data['termin_penjualan'] == 1) ? 'Cash' : 'Credit' ?></td>
                                                        <td><?= $data['tempo_penjualan'] ?></td>
                                                        <td><?= $data['batas_hutang'] ?></td>
                                                        <td><?= $data['batas_frekuensi_hutang'] ?></td>
                                                        <td><?= $akun_hutang->nama_akun ?></td>
                                                        <td><?= $data['batas_piutang'] ?></td>
                                                        <td><?= $data['batas_frekuensi_piutang'] ?></td>
                                                        <td><?= $akun_piutang->nama_akun ?></td>
                                                        <td>

                                                            <p>
                                                                <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['akt-mitra-bisnis-pembelian-penjualan/update', 'id' => $data['id_mitra_bisnis_pembelian_penjualan']], ['class' => 'btn btn-primary']) ?>
                                                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['akt-mitra-bisnis-pembelian-penjualan/delete', 'id' => $data['id_mitra_bisnis_pembelian_penjualan']], [
                                                                    'class' => 'btn btn-danger',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]) ?>
                                                            </p>

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
        <div>
        </div>