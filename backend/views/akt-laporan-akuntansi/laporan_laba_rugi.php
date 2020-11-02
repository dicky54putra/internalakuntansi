<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;

$this->title = 'Laporan Laba Rugi';
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
                                        <input type="date" name="tanggal_awal" value="<?= (!empty($tanggal_awal)) ? $tanggal_awal : ''; ?>" class="form-control" required>
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
                                        <input type="date" name="tanggal_akhir" value="<?= (!empty($tanggal_akhir)) ? $tanggal_akhir : ''; ?>" class="form-control" required>
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
            <?= Html::a('Cetak', ['laporan-laba-rugi-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-laba-rugi-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading">Pendapatan</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <?php
                            $pendapatan_ = Yii::$app->db->createCommand("SELECT akt_klasifikasi.id_klasifikasi, akt_klasifikasi.klasifikasi FROM akt_klasifikasi LEFT JOIN akt_akun ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 4 GROUP BY akt_klasifikasi.klasifikasi")->query();
                            $grandtotal_pendapatan = 0;
                            foreach ($pendapatan_ as $key => $val) {
                            ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="4" bgcolor="grey" style="color: white;"><?= $val['klasifikasi'] ?></th>
                                        </tr>
                                        <tr>
                                            <th style="width: 1%;">#</th>
                                            <th style="width: 15%;">Kode</th>
                                            <th>Nama Akun</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $total_pendapatan = 0;
                                        $pendapatan = Yii::$app->db->createCommand("SELECT * FROM akt_akun LEFT JOIN akt_klasifikasi ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 4 AND akt_klasifikasi.klasifikasi = '" . $val['klasifikasi'] . "'")->query();
                                        foreach ($pendapatan as $key => $value) {
                                            $no++;

                                            $j_umum = AktJurnalUmumDetail::find()->select('*')->leftJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')->where(['id_akun' => $value['id_akun']])->andWhere(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->one();
                                            if ($j_umum['kredit'] > 0) {
                                                (!empty($j_umum['kredit'])) ? $nominal = $j_umum['kredit'] : $nominal = 0;
                                            } else {
                                                (!empty($j_umum['debit'])) ? $nominal = $j_umum['debit'] : $nominal = 0;
                                            }
                                            $total_pendapatan += $nominal;
                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $value['kode_akun']
                                                    ?></td>
                                                <td><?= $value['nama_akun'] ?></td>
                                                <td style="text-align: right;"><?= number_format($nominal) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="text-align: right;">Total</th>
                                            <th style="text-align: right;"><?= number_format($total_pendapatan) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php $grandtotal_pendapatan += $total_pendapatan; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <center>
                        <table style="width: 97%;">
                            <tr>
                                <td><b>Grandtotal Pendapatan</b></td>
                                <td><b style="float: right;"><?= number_format($grandtotal_pendapatan) ?></b></td>
                            </tr>
                        </table>
                    </center>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading">Ekuitas</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <?php
                            $ekuitas_ = Yii::$app->db->createCommand("SELECT akt_klasifikasi.id_klasifikasi, akt_klasifikasi.klasifikasi FROM akt_klasifikasi LEFT JOIN akt_akun ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 7 GROUP BY akt_klasifikasi.klasifikasi")->query();
                            $grandtotal_ekuitas = 0;
                            foreach ($ekuitas_ as $key => $val) {
                            ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="4" bgcolor="grey" style="color: white;"><?= $val['klasifikasi'] ?></th>
                                        </tr>
                                        <tr>
                                            <th style="width: 1%;">#</th>
                                            <th style="width: 15%;">Kode</th>
                                            <th>Nama Akun</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $total_ekuitas = 0;
                                        $ekuitas = Yii::$app->db->createCommand("SELECT * FROM akt_akun LEFT JOIN akt_klasifikasi ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 7 AND akt_klasifikasi.klasifikasi = '" . $val['klasifikasi'] . "'")->query();
                                        foreach ($ekuitas as $key => $value) {
                                            $no++;

                                            $j_umum = AktJurnalUmumDetail::find()->select('*')->leftJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')->where(['id_akun' => $value['id_akun']])->andWhere(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->one();
                                            if ($j_umum['kredit'] > 0) {
                                                (!empty($j_umum['kredit'])) ? $nominal = $j_umum['kredit'] : $nominal = 0;
                                            } else {
                                                (!empty($j_umum['debit'])) ? $nominal = $j_umum['debit'] : $nominal = 0;
                                            }
                                            $total_ekuitas += $nominal;
                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $value['kode_akun']
                                                    ?></td>
                                                <td><?= $value['nama_akun'] ?></td>
                                                <td style="text-align: right;"><?= number_format($nominal) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="text-align: right;">Total</th>
                                            <th style="text-align: right;"><?= number_format($total_ekuitas) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php $grandtotal_ekuitas += $total_ekuitas; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <center>
                        <table style="width: 97%;">
                            <tr>
                                <td><b>Grandtotal Ekuitas</b></td>
                                <td><b style="float: right;"><?= number_format($grandtotal_ekuitas) ?></b></td>
                            </tr>
                        </table>
                    </center>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading">Beban</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <?php
                            $beban_ = Yii::$app->db->createCommand("SELECT akt_klasifikasi.id_klasifikasi, akt_klasifikasi.klasifikasi FROM akt_klasifikasi LEFT JOIN akt_akun ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 8 GROUP BY akt_klasifikasi.klasifikasi")->query();
                            $grandtotal_beban = 0;
                            foreach ($beban_ as $key => $val) {
                            ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="4" bgcolor="grey" style="color: white;"><?= $val['klasifikasi'] ?></th>
                                        </tr>
                                        <tr>
                                            <th style="width: 1%;">#</th>
                                            <th style="width: 15%;">Kode</th>
                                            <th>Nama Akun</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
                                        $total_beban = 0;
                                        $beban = Yii::$app->db->createCommand("SELECT * FROM akt_akun LEFT JOIN akt_klasifikasi ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 8 AND akt_klasifikasi.klasifikasi = '" . $val['klasifikasi'] . "'")->query();
                                        foreach ($beban as $key => $value) {
                                            $no++;

                                            $j_umum = AktJurnalUmumDetail::find()->select('*')->leftJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')->where(['id_akun' => $value['id_akun']])->andWhere(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->one();
                                            if ($j_umum['kredit'] > 0) {
                                                (!empty($j_umum['kredit'])) ? $nominal = $j_umum['kredit'] : $nominal = 0;
                                            } else {
                                                (!empty($j_umum['debit'])) ? $nominal = $j_umum['debit'] : $nominal = 0;
                                            }
                                            $total_beban += $nominal;
                                        ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $value['kode_akun']
                                                    ?></td>
                                                <td><?= $value['nama_akun'] ?></td>
                                                <td style="text-align: right;"><?= number_format($nominal) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="text-align: right;">Total</th>
                                            <th style="text-align: right;"><?= number_format($total_beban) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php $grandtotal_beban += $total_beban; ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <center>
                        <table style="width: 97%;">
                            <tr>
                                <td><b>Grandtotal Beban</b></td>
                                <td><b style="float: right;"><?= number_format($grandtotal_beban) ?></b></td>
                            </tr>
                        </table>
                    </center>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <table class="table">
                    <tr>
                        <th>
                            <h3>Laba Bersih</h3>
                        </th>
                        <th style="text-align: right;">
                            <?php
                            $laba_bersih = $grandtotal_pendapatan - $grandtotal_ekuitas - $grandtotal_beban;
                            if ($laba_bersih < 0) {
                                echo '<h3>(' . number_format(substr($laba_bersih, 1)) . ')</h3>';
                            } else {
                                echo '<h3>' . number_format($laba_bersih, 1) . '</h3>';
                            }
                            ?>
                        </th>
                    </tr>
                </table>
            </div>
        </div>

    <?php } ?>

</div>