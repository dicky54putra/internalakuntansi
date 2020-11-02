<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;
use backend\models\Setting;

$this->title = 'Laporan Laba Rugi';
?>
<style>
    .tabel {
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .tabel th,
    .tabel td {
        padding: 2px;
        text-align: left;
        font-size: 12px;
    }

    .table td {
        border-bottom: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    .table th {
        text-align: left;
        padding: 5px;
    }

    .table thead {
        border-bottom: 1px solid #000000;
        padding: 5px;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
        font-size: 12px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 5px;
    }
</style>
<?php
if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    # code...
?>
    <center>
        <table style="width: 70%;">
            <tr>
                <td colspan="4" align="center">
                    <p class="table" style="font-size: 20px; font-weight: bold;">
                        LAPORAN LABA RUGI
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="table" style="font-size: 20px;">
                        <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
                    </p>
                </td>
                <td colspan="2" align="right">
                    <p class="table" style="font-size: 20px;">
                        <?php
                        $nama = Setting::find()->one();
                        echo $nama->nama;
                        ?>
                    </p>
                </td>
            </tr>
        </table>

        <table style="width: 70%; background: rgba(0, 0, 0, 0.05);">
            <tr>
                <th colspan="2">
                    <p style="font-weight: bold; font-size: 25px; text-align: left;">Pendapatan</p>
                </th>
            </tr>
            <tr>
                <td colspan="2">
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
                    <?php } ?></td>
            </tr>
            <tr style="background: rgba(0, 0, 0, 0.2);">
                <th style="text-align: left;">Grandtotal Pendapatan</th>
                <th style="text-align: right;"><?= number_format($grandtotal_pendapatan) ?></th>
            </tr>
        </table>
        <br>
        <table style="width: 70%; background: rgba(0, 0, 0, 0.05);">
            <tr>
                <th colspan="2">
                    <p style="font-weight: bold; font-size: 25px; text-align: left;">Liabilitas Jangka Pendek</p>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    $liabilitas_pendek_ = Yii::$app->db->createCommand("SELECT akt_klasifikasi.id_klasifikasi, akt_klasifikasi.klasifikasi FROM akt_klasifikasi LEFT JOIN akt_akun ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 5 GROUP BY akt_klasifikasi.klasifikasi")->query();
                    $grandtotal_liabilitas_pendek = 0;
                    foreach ($liabilitas_pendek_ as $key => $val) {
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
                                $total_liabilitas_pendek = 0;
                                $liabilitas_pendek = Yii::$app->db->createCommand("SELECT * FROM akt_akun LEFT JOIN akt_klasifikasi ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 5 AND akt_klasifikasi.klasifikasi = '" . $val['klasifikasi'] . "'")->query();
                                foreach ($liabilitas_pendek as $key => $value) {
                                    $no++;

                                    $j_umum = AktJurnalUmumDetail::find()->select('*')->leftJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')->where(['id_akun' => $value['id_akun']])->andWhere(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->one();
                                    if ($j_umum['kredit'] > 0) {
                                        (!empty($j_umum['kredit'])) ? $nominal = $j_umum['kredit'] : $nominal = 0;
                                    } else {
                                        (!empty($j_umum['debit'])) ? $nominal = $j_umum['debit'] : $nominal = 0;
                                    }
                                    $total_liabilitas_pendek += $nominal;
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
                                    <th style="text-align: right;"><?= number_format($total_liabilitas_pendek) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                        <?php $grandtotal_liabilitas_pendek += $total_liabilitas_pendek; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr style="background: rgba(0, 0, 0, 0.2);">
                <th style="text-align: left;">Grandtotal Pendapatan</th>
                <th style="text-align: right;"><?= number_format($grandtotal_pendapatan) ?></th>
            </tr>
        </table>
        <br>
        <table style="width: 70%; background: rgba(0, 0, 0, 0.05);">
            <tr>
                <th colspan="2">
                    <p style="font-weight: bold; font-size: 25px; text-align: left;">Liabilitas Jangka Panjang</p>
                </th>
            </tr>
            <tr>
                <td colspan="2">
                    <?php
                    $liabilitas_panjang_ = Yii::$app->db->createCommand("SELECT akt_klasifikasi.id_klasifikasi, akt_klasifikasi.klasifikasi FROM akt_klasifikasi LEFT JOIN akt_akun ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 6 GROUP BY akt_klasifikasi.klasifikasi")->query();
                    $grandtotal_liabilitas_panjang = 0;
                    foreach ($liabilitas_panjang_ as $key => $val) {
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
                                $total_liabilitas_panjang = 0;
                                $liabilitas_panjang = Yii::$app->db->createCommand("SELECT * FROM akt_akun LEFT JOIN akt_klasifikasi ON akt_klasifikasi.id_klasifikasi = akt_akun.klasifikasi WHERE akt_akun.jenis = 6 AND akt_klasifikasi.klasifikasi = '" . $val['klasifikasi'] . "'")->query();
                                foreach ($liabilitas_panjang as $key => $value) {
                                    $no++;

                                    $j_umum = AktJurnalUmumDetail::find()->select('*')->leftJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')->where(['id_akun' => $value['id_akun']])->andWhere(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->one();
                                    if ($j_umum['kredit'] > 0) {
                                        (!empty($j_umum['kredit'])) ? $nominal = $j_umum['kredit'] : $nominal = 0;
                                    } else {
                                        (!empty($j_umum['debit'])) ? $nominal = $j_umum['debit'] : $nominal = 0;
                                    }
                                    $total_liabilitas_panjang += $nominal;
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
                                    <th style="text-align: right;"><?= number_format($total_liabilitas_panjang) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                        <?php $grandtotal_liabilitas_panjang += $total_liabilitas_panjang; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr style="background: rgba(0, 0, 0, 0.2);">
                <th style="text-align: left;">Grandtotal Pendapatan</th>
                <th style="text-align: right;"><?= number_format($grandtotal_pendapatan) ?></th>
            </tr>
        </table>
        <br>
        <table style="width: 70%; background: rgba(0, 0, 0, 0.05);">
            <tr>
                <th colspan="2">
                    <p style="font-weight: bold; font-size: 25px; text-align: left;">Ekuitas</p>
                </th>
            </tr>
            <tr>
                <td colspan="2">
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
                </td>
            </tr>
            <tr style="background: rgba(0, 0, 0, 0.2);">
                <th style="text-align: left;">Grandtotal Pendapatan</th>
                <th style="text-align: right;"><?= number_format($grandtotal_pendapatan) ?></th>
            </tr>
        </table>
        <br>
        <table style="width: 70%; background: rgba(0, 0, 0, 0.05);">
            <tr>
                <th colspan="2">
                    <p style="font-weight: bold; font-size: 25px; text-align: left;">Beban</p>
                </th>
            </tr>
            <tr>
                <td colspan="2">
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
                </td>
            </tr>
            <tr style="background: rgba(0, 0, 0, 0.2);">
                <th style="text-align: left;">Grandtotal Pendapatan</th>
                <th style="text-align: right;"><?= number_format($grandtotal_pendapatan) ?></th>
            </tr>
        </table>
        <br>
        <table class="width: 70%; background: rgba(0, 0, 0, 0.05);"">
            <tr>
                <th>
                    <h3>Laba Bersih</h3>
                </th>
                <th style=" text-align: right;">
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
    </center>
<?php } ?>

<?php
$fileName = "Laporan Jurnal Umum.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>