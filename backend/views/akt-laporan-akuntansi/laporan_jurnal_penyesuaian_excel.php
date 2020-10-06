<?php

use backend\models\AktAkun;
use backend\models\AktJurnalPenyesuaian;
use backend\models\AktJurnalPenyesuaianDetail;
?>
<style>
    .table,
    .table td {
        border: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    .table,
    .table th {
        border: 1px solid #000000;
        padding: 5px;
        text-align: center;
    }

    .table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        padding: 10px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .table th,
    .table td {
        padding: 5px;
    }
</style>
<?php
$query_jurnal_penyesuaian = AktJurnalPenyesuaian::find()->where(['BETWEEN', 'tanggal_jurnal_penyesuaian', $tanggal_awal, $tanggal_akhir])->orderBy("tanggal_jurnal_penyesuaian ASC")->all();
foreach ($query_jurnal_penyesuaian as $key => $data) {
    # code...
?>
    <style>
        .tabel {
            width: 100%;
        }

        .tabel th,
        .tabel td {
            padding: 2px;
            text-align: left;
        }

        .tabel th {
            width: 20%;
        }
    </style>
    <table class="tabel">
        <thead>
            <tr>
                <th style="text-align: left;">No. Jurnal</th>
                <td>: <?= $data['no_jurnal_penyesuaian'] ?></td>
            </tr>
            <tr>
                <th style="text-align: left;">Tanggal Jurnal</th>
                <td>: <?= date('d/m/Y', strtotime($data['tanggal_jurnal_penyesuaian'])) ?></td>
            </tr>
        </thead>
    </table>

    <table class="table" border="1">
        <thead>
            <tr>
                <th style="width: 1%;">#</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 10%;white-space: nowrap;">Kode Akun</th>
                <th>Uraian</th>
                <th style="width: 10%;text-align: center;">Debit</th>
                <th style="width: 10%;text-align: center;">Kredit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $query_jurnal_penyesuaian_detail = AktJurnalPenyesuaianDetail::find()->where(['id_jurnal_penyesuaian' => $data['id_jurnal_penyesuaian']])->all();
            foreach ($query_jurnal_penyesuaian_detail as $key => $dataa) {
                # code...
                $no++;
                $akt_akun = AktAkun::findOne($dataa['id_akun']);
            ?>
                <tr>
                    <td style="text-align: center;"><?= $no ?></td>
                    <td style="text-align: left;"><?= date('d/m/Y', strtotime($data['tanggal_jurnal_penyesuaian'])) ?></td>
                    <td style="text-align: center;"><?= $akt_akun->kode_akun ?></td>
                    <td style="text-align: left;"><?= $akt_akun->nama_akun ?></td>
                    <td style="text-align: right;"><?= ($dataa['debit'] != 0) ? ribuan($dataa['debit']) : '' ?></td>
                    <td style="text-align: right;"><?= ($dataa['kredit'] != 0) ? ribuan($dataa['kredit']) : '' ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

<?php } ?>
<?php
$fileName = "Laporan Jurnal Penyesuaian.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>