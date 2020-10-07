<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laba Rugi</title>
    <style>
        .table-border, .table-border td, .table-border th {  
            border: 1px solid #ddd;
            text-align: left;
        }

        .table-border {
            border-collapse: collapse;
            width: 100%;
        }

       .table-border th, .table-border td {
            padding: 15px;
        }

        .table-ekuitas td {
            font-size: 18px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1 align="center" style="margin-bottom:20px;">Laporan Laba Rugi</h1>

    <table width="50%" style="border:none;">
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td><?= tanggal_indo($model->tanggal) ?></td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <?php if($model->periode == 1 ) { ?>
            <td>Bulanan</td>
            <?php } else if($model->periode == 2 ) { ?>
            <td>Triwulan</td>
            <?php } else if($model->periode == 3 ) { ?>
            <td>Tahunan</td>
            <?php } ?>
        </tr>
    </table>

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
                foreach ( $akun_pendapatan as $data) { 
                $total += $data['saldo_akun'];    
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['nama_akun'] ?></td>
                <td align="right"><?= ribuan($data['saldo_akun'])?></td>
            </tr>
            <?php } ?>
            <tr>
                <td align="right" colspan="2" style="font-weight: bold;">Total</td>
                <td align="right"><?= ribuan($total)?></td>
            </tr>
        </tbody>
    </table>
    <h3 style="margin-top:30px;">Beban</h3>
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
                foreach ( $akun_beban as $data2) { 
                $total2 += $data['saldo_akun'];    
            ?>
            <tr>
                <td><?= $no2++ ?></td>
                <td><?= $data2['nama_akun'] ?></td>
                <td align="right"><?= ribuan($data2['saldo_akun'])?></td>
            </tr>
            <?php } ?>
            <tr>
                <td align="right" colspan="2" style="font-weight: bold;">Total</td>
                <td align="right"><?= ribuan($total2)?></td>
            </tr>
            <tr>
                <td align="right" colspan="2" style="font-weight: bold;">Laba Bersih</td>
                <td align="right"><?= ribuan($total - $total2)?></td>
            </tr>
        </tbody>
    </table>
    <h1 align="center" style="margin-top:50px;">Laporan Ekuitas</h1>
    <hr>
    <table class="table-ekuitas" width="100%">
        <?php foreach($ekuitas as $e) { ?>
        <tr>
            <td width="50%">Modal</td>
            <td width="5%">:</td>
            <td><?= ribuan($e->modal) ?></td>
        </tr>
        <tr>
            <td>Setoran modal tambahan</td>
            <td>:</td>
            <td>
                <?= ribuan($e->setor_tambahan) ?>
            </td>
        </tr>
        <tr>
            <td>Laba Bersih</td>
            <td>:</td>
            <td>
            <?= ribuan($e->laba_bersih) ?>
            </td>
        </tr>
        <tr>
            <td>Prive</td>
            <td>:</td>
            <td>
                <?= ribuan($e->prive) ?>
            </td>
        </tr>
        <tr>
            <td>Total</td>
            <td>:</td>
            <td>
                <?= ribuan($e->modal + $e->setor_tambahan + $e->laba_bersih - $e->prive) ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    <h1 align="center" style="margin-top:50px;">Laporan Posisi Keuangan</h1>
    <table class="table-border">
            <?php foreach($jenis as $p) { 
                if ($p['jenis'] == 1) {
                    $nama_jenis = 'Aset Lancar';
                } elseif ($p['jenis'] == 2) {
                    $nama_jenis = 'Aset Tetap';
                } elseif ($p['jenis'] == 3) {
                    $nama_jenis = 'Aset Tetap Tidak Berwujud';
                } elseif ($p['jenis'] == 4) {
                    $nama_jenis = 'Pendapatan';
                } elseif ($p['jenis'] == 5) {
                    $nama_jenis = 'Liabilitas Jangka Pendek';
                } elseif ($p['jenis'] == 6) {
                    $nama_jenis = 'Liabilitas Jangka Panjang';
                } elseif ($p['jenis'] == 7) {
                    $nama_jenis = 'Ekuitas';
                } elseif ($p['jenis'] == 8) {
                    $nama_jenis = 'Beban';
                }        

                $lap_posisi = Yii::$app->db->createCommand("SELECT akt_laporan_posisi_keuangan.id_akun,akt_laporan_posisi_keuangan.nominal,akt_akun.nama_akun,akt_akun.jenis FROM akt_laporan_posisi_keuangan LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laporan_posisi_keuangan.id_akun WHERE id_laba_rugi = '$model->id_laba_rugi' AND akt_akun.jenis = '$p[jenis]'")->query();                
            ?>
                <tr> 
                <td style="font-weight: bold;" colspan="2"><?= $nama_jenis ?></td>
            </tr>
            <?php
                $total_saldo = 0;
                foreach ($lap_posisi as $a) {
                    if($a['id_akun'] == 6 || $a['id_akun'] == 7 || $a['id_akun'] == 8 ) {
                        $total_saldo = $total_saldo - $a['nominal']; 
                    } else {
                        $total_saldo += $a['nominal']; 
                    }
            ?>
                <tr>
                    <td><?= $a['nama_akun'] ?></td>
                    <td align="right"><?= ribuan($a['nominal'])?></td>
                </tr>
                
                <?php } ?>
                <tr>
                    <td style="font-weight: bold; text-align:right;">Total</td>
                    <td align="right"><?= ribuan($total_saldo) ?></td>
                </tr>
            <?php }  ?>
        </table>
</body>
</html>