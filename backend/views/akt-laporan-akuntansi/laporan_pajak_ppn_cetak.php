<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktSaldoAwalAkunDetail;
use backend\models\Setting;
?>
<style type="text/css">
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

    @media print {
        @page {
            size: auto;
            /* auto is the initial value */
            margin: 0mm;
            /* this affects the margin in the printer settings */
        }
    }
</style>
<?php
$data_setting = Setting::find()->one();
?>
<div style="margin: 30px;">
    <table class="table3">
        <thead>
            <tr>
                <th class="header_kiri" style="font-size: 15px; font-weight: bold;"><?= $data_setting->nama ?></th>
            </tr>
            <tr>
                <th class="header_kiri"><?= $data_setting->nama_usaha ?></th>
            </tr>
            <tr>
                <th class="header_kiri"><?= $data_setting->alamat ?></th>
            </tr>
            <tr>
                <th class="header_kiri">Telp : <?= $data_setting->telepon ?>, Fax : <?= $data_setting->fax ?></th>
            </tr>
            <tr>
                <th class="header_kiri">NPWP : <?= $data_setting->npwp ?></th>
            </tr>
        </thead>
    </table>
    <div style="page-break-after: always;">
        <p style="font-weight: bold;font-size: 20px; text-align:center;">
            Laporan <?= $tipe ?>
        </p>
        <p style="float: right;">
            Periode : <?= date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir))  ?>
        </p>
<<<<<<< HEAD
        <table class="table2">
            <tr>
                <th style="width: 1%;">#</th>
                <th style="width: 5%;">Tanggal</th>
                <!-- <th style="width: 10%;">Tipe Transaksi</th> -->
                <th style="width: 15%;">No. Referensi</th>
                <th>Keterangan</th>
                <!-- <th style="width: 1%;">Kurs</th> -->
                <th style="width: 15%;" align="right">Jumlah</th>
            </tr>
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
            <tr>
                <th colspan="4" style="text-align: right;">Grand Total</th>
                <th style="text-align: right;"><?= ribuan($gt) ?></th>
            </tr>
=======
        <table class="table1">
            <?php
            if ($tipe == 'PPN Semua') {
                $tipe_ = 'PPN Masukan';
                $tipe__ = 'PPN Keluaran';
            } else {
                $tipe_ = $tipe;
                $tipe__ = $tipe;
            } ?>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $gt = 0;
                $ju = Yii::$app->db->createCommand("SELECT * FROM `akt_jurnal_umum_detail` INNER JOIN `akt_jurnal_umum` ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum INNER JOIN `akt_akun` ON akt_akun.id_akun = akt_jurnal_umum_detail.id_akun WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND ' $tanggal_akhir' AND akt_akun.nama_akun = '" . $tipe_ . "'")->queryAll();

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
                        <td></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="5" style="text-align: left;">Total</th>
                    <th style="text-align: right; border-top: 1px solid #000000;"><?= ribuan($gt) ?></th>
                </tr>
                <?php
                if ($tipe == 'PPN Semua') {
                    $gt_ = 0;
                    $ju = Yii::$app->db->createCommand("SELECT * FROM `akt_jurnal_umum_detail` INNER JOIN `akt_jurnal_umum` ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum INNER JOIN `akt_akun` ON akt_akun.id_akun = akt_jurnal_umum_detail.id_akun WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND ' $tanggal_akhir' AND akt_akun.nama_akun = '" . $tipe__ . "'")->queryAll();

                    $no = 1;
                    foreach ($ju as $k) {
                        $gt_ += $k['debit'] += $k['kredit'];
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
                            <td></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th colspan="5" style="text-align: left;">Total</th>
                        <th style="text-align: right; border-top: 1px solid #000000;"><?= ribuan($gt_) ?></th>
                    </tr>
                    <tr>
                        <th colspan="5" style="text-align: left;border-top: 1px solid #000000;"">Grand Total</th>
                                            <th style=" text-align: right; border-top: 1px solid #000000;"><?= ribuan($gt_ - $gt) ?></th>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <!-- <tr>
                                        <th colspan="4" style="text-align: right;">Grand Total</th>
                                        <th style="text-align: right;"><?= ribuan($gt) ?></th>
                                    </tr> -->
            </tfoot>
>>>>>>> 731cfed3fece0ab1886e838f6a727eb1810d8018
        </table>
        <br>
    </div>
</div>
<script>
    window.print();
    setTimeout(window.close, 500);
</script>