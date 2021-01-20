<?php

use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktSaldoAwalAkunDetail;
?>
<style>
    table,
    td {
        border: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    table,
    th {
        border: 1px solid #000000;
        padding: 5px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        padding: 10px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    th,
    td {
        padding: 5px;
    }
</style>
<div style="page-break-after: always;">
    <p style="font-weight: bold;font-size: 20px;">
        Laporan Buku Besar : <?= date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir))  ?>
    </p>
    <?php
    $jurnal_umum_detail = AktJurnalUmumDetail::find()
        ->select('*')
        ->innerJoin('akt_akun', 'akt_akun.id_akun = akt_jurnal_umum_detail.id_akun')
        ->innerJoin('akt_jurnal_umum', 'akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum')
        ->where(['=', 'akt_akun.nama_akun', 'kas'])
        ->where(['between', 'tanggal', $tanggal_awal, $tanggal_akhir])
        ->all();
    // $jurnal_umum_detail = AktJurnalUmumDetail::find()
    //     ->select('*')
    //     ->innerJoin('akt_akun', 'akt_akun.id_akun = akt_jurnal_umum_detail.id_akun')
    //     ->where(['=', 'akt_akun.nama_akun', 'kas'])
    //     ->all();
    $kredit = 0;
    $debit = 0;
    ?>
    <table class="table table-condensed">
        <tr>
            <th colspan="3">Arus kas dari aktivitas operasi</th>
        </tr>
        <tr>
            <th>#</th>
            <th>Keterangan</th>
            <th>Nominal</th>
        </tr>
        <tr>
            <?php
            $saldo_awal = AktSaldoAwalAkunDetail::find()
                ->select('*')
                ->innerJoin('akt_akun', 'akt_akun.id_akun = akt_saldo_awal_akun_detail.id_akun')
                ->where(['=', 'akt_akun.nama_akun', 'kas'])
                ->limit(1)
                ->one();
            ?>
            <td>1</td>
            <td>Saldo Awal Kas</td>
            <td style="text-align: right;width: 20%;">
                <?php
                if (!empty($saldo_awal->debet)) {
                    $saldo_awal_ = $saldo_awal->debet;
                    echo ribuan($saldo_awal->debet);
                } elseif (!empty($saldo_awal->kredit)) {
                    echo '-' . ribuan($saldo_awal->kredit);
                    $saldo_awal_ = $saldo_awal->kredit;
                }
                ?>
            </td>
        </tr>
        <?php
        $no = 2;
        foreach ($jurnal_umum_detail as $k) {
            $akun = AktAkun::find()->where(['id_akun' => $k->id_akun])->one();
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $k->keterangan ?></td>
                <td style="text-align: right;width: 20%;">
                    <?php
                    if ($k->kredit == 0) {
                        echo ribuan($k->debit);
                    } elseif ($k->debit == 0) {
                        echo '-' . ribuan($k->kredit);
                    }
                    ?>
                </td>
            </tr>
        <?php
            $debit += $k->debit;
            $kredit += $k->kredit;
        }
        // die; 
        ?>
        <tr>
            <th style="text-align: right;" colspan="2">Arus kas bersih dari aktivitas operasi</th>
            <th style="text-align: right;width: 20%;">
                <?php
                if (!empty($saldo_awal->debet)) {
                    $hasil = $saldo_awal->debet + $debit - $kredit;
                    // echo 'Rp. ' . ribuan($hasil);
                    echo ribuan($hasil);
                } elseif (!empty($saldo_awal->kredit)) {
                    $hasil = $debit - $kredit - $saldo_awal->debet;
                    // echo 'Rp. ' . ribuan($hasil);
                    echo ribuan($hasil);
                }
                ?>
            </th>
        </tr>
    </table>
</div>
<script>
    window.print();
    setTimeout(window.close, 500);
</script>