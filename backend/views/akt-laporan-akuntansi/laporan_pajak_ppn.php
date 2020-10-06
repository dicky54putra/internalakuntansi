<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;

$this->title = 'Laporan Pajak PPN';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Akuntansi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= Html::beginForm(['', array('class' => 'form-inline')]) ?>

                        <table border="0" width="100%">
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Dari Tanggal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        if (!empty($tanggal_awal)) {
                                            $val = $tanggal_awal;
                                        } else {
                                            $val = '';
                                        }
                                        ?>
                                        <input type="date" name="tanggal_awal" class="form-control" value="<?= $val ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Sampai Tanggal</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        if (!empty($tanggal_akhir)) {
                                            $val_ = $tanggal_akhir;
                                        } else {
                                            $val_ = '';
                                        }
                                        ?>
                                        <input type="date" name="tanggal_akhir" class="form-control" value="<?= $val_ ?>" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Tipe</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <?php
                                        if (!empty($tipe)) {
                                            if ($tipe == 'PPN Masukan') {
                                                $masuk = 'selected';
                                                $keluar = '';
                                            } else {
                                                $masuk = '';
                                                $keluar = 'selected';
                                            }
                                        } else {
                                            $masuk = '';
                                            $keluar = '';
                                        }
                                        ?>
                                        <select name="tipe" id="tipe" class="form-control">
                                            <option value="PPN Masukan" <?= $masuk ?>>PPN Masukan</option>
                                            <option value="PPN Keluaran" <?= $keluar ?>>PPN Keluaran</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <?= Html::endForm() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-ppn-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tipe' => $tipe], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-ppn-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir, 'tipe' => $tipe], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title . substr($tipe, 3) ?></div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;">#</th>
                                        <th style="width: 5%;">Tanggal</th>
                                        <!-- <th style="width: 10%;">Tipe Transaksi</th> -->
                                        <th style="width: 15%;">No. Referensi</th>
                                        <th>Keterangan</th>
                                        <!-- <th style="width: 1%;">Kurs</th> -->
                                        <th style="width: 15%;">
                                            <p style=" float: right;">Jumlah</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td colspan="4">Saldo Awal</td>
                                        <?php
                                        $sa = AktAkun::find()->where(['nama_akun' => $tipe])->one();
                                        ?>
                                        <td style="text-align: right;"><?= $sa->saldo_akun ?></td>
                                    </tr> -->
                                    <?php
                                    $gt = 0;

                                    $ju = Yii::$app->db->createCommand("SELECT * FROM `akt_jurnal_umum_detail` INNER JOIN `akt_jurnal_umum` ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum INNER JOIN `akt_akun` ON akt_akun.id_akun = akt_jurnal_umum_detail.id_akun WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND ' $tanggal_akhir' AND akt_akun.nama_akun = '" . $tipe . "'")->queryAll();

                                    $no = 1;
                                    foreach ($ju as $k) {
                                        $gt += $k['debit'] += $k['kredit'];
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= date('d/m/Y', strtotime($k['tanggal'])) ?></td>
                                            <!-- <td><?php // $k['nama_akun'] 
                                                        ?></td> -->
                                            <td><?= $k['no_jurnal_umum'] ?></td>
                                            <td><?= $k['keterangan'] ?></td>
                                            <!-- <td>1.00</td> -->
                                            <td style="text-align: right;">
                                                <?php
                                                if ($k['kredit'] == 0) {
                                                    echo ribuan($k['debit']);
                                                } else {
                                                    echo ribuan($k['kredit']);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align: right;">Grand Total</th>
                                        <th style="text-align: right;"><?= ribuan($gt) ?></th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>