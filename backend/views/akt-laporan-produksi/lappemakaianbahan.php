<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Pemakaian Bahan</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .title-lap {
            text-align: center;
        }

        table {
            margin: 20px 0;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th {
            border: 1px solid black;
        }

        table tr td {
            padding: 5px 0;
            border: 1px solid black;
        }

        .total {
            padding-top: 20px;
            border: 1px solid black;
        }
    </style>
</head>

<body>

    <h2 class="title-lap"> Rekap Pemakaian Bahan </h2>

    <p style="text-align:right; font-size:8px; "> Data Dari <?= $tanggal_awal . ' s/d ' . $tanggal_akhir ?> </p>

    <hr>

    <table width="100%">
        <tr>
            <th width="5%">No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Qty</th>
        </tr>
        <?php
        $bahan = Yii::$app->db->createCommand("SELECT SUM(qty) AS qty , id_item_stok, tanggal FROM ( SELECT akt_produksi_bom_detail_bb.*, akt_produksi_bom.tanggal FROM akt_produksi_bom LEFT JOIN akt_produksi_bom_detail_bb ON akt_produksi_bom_detail_bb.id_produksi_bom = akt_produksi_bom.id_produksi_bom UNION SELECT akt_produksi_manual_detail_bb.*,akt_produksi_manual.tanggal FROM akt_produksi_manual LEFT JOIN akt_produksi_manual_detail_bb ON akt_produksi_manual_detail_bb.id_produksi_manual = akt_produksi_manual.id_produksi_manual ) AS Hasil WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' GROUP BY id_item_stok")->query();
        $no = 1;
        $total = 0;
        foreach ($bahan as $b) {
            $total += $b['qty'];
            $id_item = Yii::$app->db->createCommand("SELECT id_item FROM akt_item_stok WHERE id_item_stok = '$b[id_item_stok]'")->queryScalar();
            $kode_item =  Yii::$app->db->createCommand("SELECT kode_item FROM akt_item WHERE id_item = '$id_item'")->queryScalar();
            $nama = Yii::$app->db->createCommand("SELECT nama_item FROM akt_item WHERE id_item = '$id_item'")->queryScalar();
            $id_satuan = Yii::$app->db->createCommand("SELECT id_satuan FROM akt_item WHERE id_item = '$id_item'")->queryScalar();
            $satuan = Yii::$app->db->createCommand("SELECT nama_satuan FROM akt_satuan WHERE id_satuan = '$id_satuan'")->queryScalar();
        ?>
            <tr>
                <td> <?= $no++ ?></td>
                <td> <?= $kode_item ?></td>
                <td> <?= $nama ?></td>
                <td> <?= $b['qty'] ?> <?= $satuan ?></td>
            </tr>
        <?php } ?>
        <tr class="total">
            <td colspan="2" style="border:none; "></td>
            <td style="border:none;">Total</td>
            <td style="border:none;"><?= $total ?> Satuan</td>
        </tr>
    </table>
</body>

</html>