<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Laporan Transfer Kas';
?>
<style>
    .table1 {
        width: 100%;
        border-collapse: collapse;
        /*font-family: Arial;*/
        font-size: 15px;
    }

    .table1 th {
        text-align: left;
        padding: 5px;
    }

    .header_kiri {
        width: 25%;
    }

    .header_kanan {
        width: 15%;
    }

    hr {
        border: 1px solid black;
    }

    .table2,
    .table2 td {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table2,
    .table2 th {
        /* border: 1px solid #000000; */
        text-align: left;
    }

    .table2 {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        font-family: Arial;
    }

    .table2 th {
        padding: 5px;
        border-bottom: 1px solid #000000;
    }

    .table2 td {
        padding: 5px;
    }

    .table3 {
        border-collapse: collapse;
        width: 100%;
        font-size: 15px;
    }

    .table3,
    .table3 th {
        border: 0px solid #000000;
    }

    .table3 th {
        padding: 5px;
    }

    .header_kiri {
        text-align: left;
    }

    .table4 {
        width: 100%;
    }

    .table_order {
        width: 100%;
    }

    @media print {
        @page {
            size: auto;
            margin: 1mm;
        }
    }
</style>

<div class="absensi-index">
    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        if ($kasbank_asal == null && $kasbank_tujuan == null) {
            $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
        } elseif ($kasbank_asal == null) {
            $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE id_tujuan_kas = '$kasbank_tujuan' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
        } elseif ($kasbank_tujuan == null) {
            $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE id_asal_kas = '$kasbank_asal' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
        } else {
            $query_transfer_kasbank = Yii::$app->db->createCommand("SELECT * FROM akt_transfer_kas WHERE id_asal_kas = '$kasbank_asal' AND id_tujuan_kas = '$kasbank_tujuan' AND tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
        }
    ?>
        <table class="table1">
            <tr>
                <?php
                $setting = Setting::find()->one();
                if (!empty($setting->foto)) {
                ?>
                    <th rowspan="3" style="width: 150px;"><img style="float: right;" width="150px" src="upload/<?= $setting->foto ?>" alt=""></th>
                <?php } ?>
                <th style="text-align: center;">
                    <h3 style="margin-top: -5px;margin-bottom: -5px;"><?= $setting->nama ?></h3>
                </th>
            </tr>
            <tr>
                <th style="text-align: center;">
                    <h3 style="margin-top: -5px;margin-bottom: -5px;">Mutasi Kas</h3>
                </th>
            </tr>
            <tr>
                <th style="text-align: right;"><?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?></th>
            </tr>
        </table>
        <table class="table2">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>No Transaksi</th>
                    <th>Kas Asal</th>
                    <th>Kas Tujuan</th>
                    <th style="text-align: right;">Jumlah Kas Asal</th>
                    <th style="text-align: right;">Jumlah Kas Tujuan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 0;
                $sum_asal = 0;
                $sum_tujuan = 0;
                foreach ($query_transfer_kasbank as $key => $value) {
                    $no++;
                    $sum_asal += $value->jumlah1;
                    $sum_tujuan += $value->jumlah2;
                    $kas_asal = AktKasBank::find()->where(['id_kas_bank' => 'id_asal_kas'])->one();
                    $kas_tujuan = AktKasBank::find()->where(['id_kas_bank' => 'id_tujuan_kas'])->one();
                ?>
                    <tr>
                        <td><?= $no ?></td>
                        <td><?= $value->tanggal ?></td>
                        <td><?= $value->no_transfer_kas ?></td>
                        <td><?= $kas_asal->keterangan ?></td>
                        <td><?= $kas_tujuan->keterangan ?></td>
                        <td>Rp. <?= ribuan($value->jumlah1) ?></td>
                        <td>Rp. <?= ribuan($value->jumlah2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align: left;">Total</th>
                    <th style="text-align: right;">Rp. <?= ribuan($sum_asal) ?></th>
                    <th style="text-align: right;">Rp. <?= ribuan($sum_tujuan) ?></th>
                </tr>
            </tfoot>
        </table>
    <?php } ?>

</div>
<?php
$fileName = "Laporan Transfer Kas.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>