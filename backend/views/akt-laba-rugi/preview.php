<?php

use yii\helpers\Html;
use backend\models\AktAkun;

if ($post_periode == 1) {
    $type = 'Bulanan';
} else if ($post_periode == 2) {
    $type = 'Triwulan 1';
} else if ($post_periode == 3) {
    $type = 'Triwulan 2';
} else if ($post_periode == 4) {
    $type = 'Triwulan 3';
} else if ($post_periode == 5) {
    $type = 'Triwulan 4';
} else if ($post_periode == 6) {
    $type = 'Tahunan';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
    <style>
        .table-border td,
        th {
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-border th,
        .table-border td {
            padding: 15px;
        }

        .table-ekuitas td {
            font-size: 18px;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h1 align="center" style="margin-bottom:20px;">Laporan Laba Rugi <?= $type ?></h1>
    <hr>
    <h3>Pendapatan</h3>
    <table class="table-border">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="70%">Nama Akun</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $no = 1;
            foreach ($akun_pendapatan as $data) {
                $total += $data->saldo_akun;
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data->nama_akun ?></td>
                    <td align="right"><?= ribuan($data->saldo_akun) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td align="left" colspan="2" style="font-weight: bold;">Total Pendapatan</td>
                <td align="right"><?= ribuan($total) ?></td>
            </tr>
        </tbody>
    </table>
    <h3 style="margin-top:30px;">Beban </h3>
    <table class="table-border">
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="70%">Nama Akun</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total2 = 0;
            $no2 = 1;
            foreach ($akun_beban as $data2) {
                $total2 += $data2->saldo_akun;
            ?>
                <tr>
                    <td><?= $no2++ ?></td>
                    <td><?= $data2->nama_akun ?></td>
                    <td align="right"><?= ribuan($data2->saldo_akun) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td align="left" colspan="2" style="font-weight: bold;">Total Beban</td>
                <td align="right">(<?= ribuan($total2) ?>)</td>
            </tr>
            <tr>
                <td align="left" colspan="2" style="font-weight: bold;">Laba Bersih</td>
                <td align="right">
                    <?php
                    $grandtotal = $total - $total2;
                    if ($grandtotal >= 0) {
                        echo ribuan($total - $total2);
                    } else {
                        echo '(' . ribuan($total - $total2) . ')';
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <h1 align="center" style="margin-top:50px;">Laporan Ekuitas <?= $type ?></h1>
    <hr>
    <table class="table-ekuitas">
        <tr>
            <td width="30%">Modal</td>
            <td width="5%">:</td>
            <td>
                <?php if ($modal == null) { ?>
                    Data tidak ada
                <?php } else {
                    echo ribuan($modal);
                } ?>
            </td>
        </tr>
        <tr>
            <td>Setoran modal tambahan</td>
            <td>:</td>
            <td>
                <?php if ($setor == null) { ?>
                    0
                <?php } else {
                    echo ribuan($setor);
                } ?>
            </td>
        </tr>
        <tr>
            <td>Laba Bersih</td>
            <td>:</td>
            <td>
                <?= ribuan($grandtotal) ?>
            </td>
        </tr>
        <tr>
            <td>Prive</td>
            <td>:</td>
            <td>
                <?= ribuan($jurnal) ?>
            </td>
        </tr>
        <tr>
            <td>Total</td>
            <td>:</td>
            <td>
                <?= ribuan($modal + $setor + $grandtotal - $jurnal) ?>
            </td>
        </tr>
    </table>
    <h1 align="center" style="margin-top:50px;">Laporan Posisi Keuangan <?= $type ?></h1>
    <table class="table-border">
        <?php foreach ($jenis as $j) {
            if ($j['jenis'] == 1) {
                $nama_jenis = 'Aset Lancar';
            } elseif ($j['jenis'] == 2) {
                $nama_jenis = 'Aset Tetap';
            } elseif ($j['jenis'] == 3) {
                $nama_jenis = 'Aset Tetap Tidak Berwujud';
            } elseif ($j['jenis'] == 4) {
                $nama_jenis = 'Pendapatan';
            } elseif ($j['jenis'] == 5) {
                $nama_jenis = 'Liabilitas Jangka Pendek';
            } elseif ($j['jenis'] == 6) {
                $nama_jenis = 'Liabilitas Jangka Panjang';
            } elseif ($j['jenis'] == 7) {
                $nama_jenis = 'Ekuitas';
            } elseif ($j['jenis'] == 8) {
                $nama_jenis = 'Beban';
            }

            $akun = AktAkun::find()->where(['jenis' => $j['jenis']])->all();
        ?>
            <tr>
                <td style="font-weight: bold;" colspan="2"><?= $nama_jenis ?></td>
            </tr>
            <?php
            $total_saldo = 0;
            foreach ($akun as $a) {
                if ($a->id_akun == 6 || $a->id_akun == 7 || $a->id_akun == 8) {
                    $total_saldo = $total_saldo - $a->saldo_akun;
                } else {
                    $total_saldo += $a->saldo_akun;
                }
            ?>
                <tr>
                    <td><?= $a->nama_akun ?></td>
                    <td align="right"><?= ribuan($a->saldo_akun) ?></td>
                </tr>

            <?php } ?>
            <tr>
                <td style="font-weight: bold; text-align:right;">Total</td>
                <td align="right"><?= ribuan($total_saldo) ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>