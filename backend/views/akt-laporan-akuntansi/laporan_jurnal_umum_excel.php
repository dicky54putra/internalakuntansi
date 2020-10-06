<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
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
$query_jurnal_umum = AktJurnalUmum::find()->where(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal ASC")->all();
foreach ($query_jurnal_umum as $key => $data) {
    # code...
?>
    <table class="tabel">
        <thead>
            <tr>
                <th style="width: 10%;">Tanggal Jurnal</th>
                <th style="width: 10%;">No. Jurnal Umum</th>
                <th style="width: 10%;">Tipe</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= date('d/m/Y', strtotime($data['tanggal'])) ?></td>
                <td><?= $data['no_jurnal_umum'] ?></td>
                <td><?= ($data['tipe'] == 1) ? 'Jurnal Umum' : '-' ?></td>
            </tr>
        </tbody>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 1%;">#</th>
                <th style="width: 10%;">No. Akun</th>
                <th style="width: 25%;">Nama Akun</th>
                <th>Keterangan</th>
                <th style="width: 10%; text-align: center;">Debet</th>
                <th style="width: 10%; text-align: center;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $totalan_debit = 0;
            $totalan_kredit = 0;
            $query_jurnal_umum_detail = AktJurnalUmumDetail::findAll(['id_jurnal_umum' => $data['id_jurnal_umum']]);
            foreach ($query_jurnal_umum_detail as $key => $dataa) {
                # code...
                $no++;
                $akt_akun = AktAkun::findOne($dataa['id_akun']);

                $totalan_debit += $dataa['debit'];
                $totalan_kredit += $dataa['kredit'];
            ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $akt_akun->kode_akun ?></td>
                    <td><?= $akt_akun->nama_akun ?></td>
                    <td><?= $dataa['keterangan'] ?></td>
                    <td style="text-align: right;"><?= ($dataa['debit'] != 0) ? ribuan($dataa['debit']) : '' ?></td>
                    <td style="text-align: right;"><?= ($dataa['kredit'] != 0) ? ribuan($dataa['kredit']) : '' ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align: left;">Total</th>
                <th style="text-align: right;"><?= ribuan($totalan_debit) ?></th>
                <th style="text-align: right;"><?= ribuan($totalan_kredit) ?></th>
            </tr>
        </tfoot>
    </table>
    <br>
<?php } ?>
<?php
$fileName = "Laporan Jurnal Umum.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>