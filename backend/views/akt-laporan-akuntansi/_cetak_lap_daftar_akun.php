<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Daftar Akun</title>
    <style>
        table {
            border-collapse: collapse;
        }

        tr td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h1 align="center" style="margin-bottom:20px;">Laporan Daftar Akun</h1>

    <table>
        <tr>
            <td> No.</td>
            <td>Kode Akun</td>
            <td>Nama Akun</td>
            <td>Header</td>
            <td>Parent</td>
            <td>Jenis</td>
            <td>Klasifikasi</td>
            <td>Debet/Kredit</td>
        </tr>
        <?php

        use backend\models\AktAkun;
        use backend\models\AktKlasifikasi;

        $no = 1;
        foreach ($model as $data) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['kode_akun'] ?></td>
                <td><?= $data['nama_akun'] ?></td>
                <td>
                    <?php
                    if ($data['header']  == 1) {
                        echo "<p style='font-family:helvetica'>&#10004;</p>";
                    } else {
                        echo '<input type="checkbox" disabled class="checkbox">';;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $akun = AktAkun::findOne($data['parent']);
                    if ($data['parent'] != null) {
                        echo $akun['nama_akun'];
                    } else {
                        echo null;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $j = $data['jenis'];
                    if ($j == 1) {
                        echo 'Aset Lancar';
                    } elseif ($j == 2) {
                        echo 'Aset Tetap';
                    } elseif ($j == 3) {
                        echo 'Aset Tetap Tidak Berwujud';
                    } elseif ($j == 4) {
                        echo 'Pendapatan';
                    } elseif ($j == 5) {
                        echo 'Liabilitas Jangka Pendek';
                    } elseif ($j == 6) {
                        echo 'Liabilitas Jangka Panjang';
                    } elseif ($j == 7) {
                        echo 'Ekuitas';
                    } elseif ($j == 8) {
                        echo 'Beban';
                    } elseif ($j == 9) {
                        echo 'Pengeluaran Lain';
                    } elseif ($j == 10) {
                        echo 'Pendapatan Lain';
                    }
                    ?>
                </td>
                <td>
                    <?php

                    $akt_klasifikasi = AktKlasifikasi::findOne($data['klasifikasi']);
                    echo $akt_klasifikasi['klasifikasi'];

                    ?>
                </td>
                <td><?php
                    if ($data['saldo_normal'] == 1) {
                        echo 'Debet';
                    } else if ($data['saldo_normal'] == 2) {
                        echo 'Kredit';
                    } ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>