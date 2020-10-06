<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Produksi Detail</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .title-lap {
            text-align: center;
        }

        .header tr td {
            font-weight: bold;
        }

        .table-bahan {
            margin: 20px 0;
            border-collapse: collapse;
        }

        .header-bahan td,
        .body-bahan td {
            border: 1px solid black;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 class="title-lap"> Rekap Produksi </h2>

    <p style="text-align:right; font-size:8px; "> Data Dari <?= $tanggal_awal  . ' s/d ' . $tanggal_akhir ?> </p>

    <div class="bom">
        <?php
        $produksi_bom = Yii::$app->db->createCommand("
            SELECT id_produksi_bom,no_produksi_bom,id_bom, akt_mitra_bisnis.nama_mitra_bisnis, tanggal FROM akt_produksi_bom
            LEFT JOIN akt_mitra_bisnis ON akt_mitra_bisnis.id_mitra_bisnis = akt_produksi_bom.id_customer
            WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'")->query();
        foreach ($produksi_bom as $p) {
            $id_item_stok = Yii::$app->db->createCommand("SELECT id_item_stok FROM akt_bom WHERE id_bom = '$p[id_bom]'")->queryScalar();
            $nama_bom = Yii::$app->db->createCommand("SELECT akt_item.nama_item FROM akt_produksi_bom_detail_hp LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_produksi_bom_detail_hp.id_item_stok LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item WHERE akt_item_stok.id_item_stok = '$id_item_stok'")->queryScalar();
        ?>
            <hr>
            <div class="header"> </div>
            <table width="40%" class="table-header">
                <tr>
                    <td> <b> No Produksi </b></td>
                    <td> <b>:</b> </td>
                    <td><?= $p['no_produksi_bom'] ?> </td>
                </tr>
                <tr>
                    <td> <b> Nama B.o.M </b></td>
                    <td> <b>:</b> </td>
                    <td><?= $nama_bom ?> </td>
                </tr>
            </table>
            <table width="100%" class="table-bahan">
                <tr>
                    <td style="border:none; width:100%;">BAHAN</td>
                </tr>
                <tr class="header-bahan">
                    <td width="5%"> No </td>
                    <td> Nama Item </td>
                    <td> Unit </td>
                    <td> Qty </td>
                    <td> Cost </td>
                </tr>

                <?php
                $bb_bom = Yii::$app->db->createCommand("
                SELECT akt_produksi_bom_detail_bb.qty, akt_produksi_bom_detail_bb.keterangan, akt_item.nama_item, akt_satuan.nama_satuan, akt_item_harga_jual.harga_satuan
                FROM akt_produksi_bom_detail_bb 
                LEFT JOIN akt_produksi_bom ON akt_produksi_bom.id_produksi_bom = akt_produksi_bom_detail_bb.id_produksi_bom
                LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_produksi_bom_detail_bb.id_item_stok
                LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item
                LEFT JOIN akt_satuan ON akt_item.id_satuan = akt_item.id_satuan
                LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item
                WHERE akt_produksi_bom_detail_bb.id_produksi_bom = '$p[id_produksi_bom]'
                ")->query();
                $no = 1;
                foreach ($bb_bom as $bb) {
                ?>
                    <tr class="body-bahan">
                        <td><?= $no++ ?></td>
                        <td><?= $bb['nama_item'] ?> </td>
                        <td><?= $bb['nama_satuan'] ?> </td>
                        <td><?= $bb['qty'] ?> </td>
                        <td><?= $bb['qty'] * $bb['harga_satuan'] ?> </td>
                    </tr>

                <?php } ?>
            </table>
            <table width="100%" class="table-bahan">
                <tr>
                    <td colspan="4"> PRODUK </td>
                </tr>
                <tr class="header-bahan">
                    <td style="width:5%;"> No </td>
                    <td> Nama Item </td>
                    <td> Unit </td>
                    <td> Qty </td>
                    <td> Cost </td>
                </tr>

                <?php
                $hp_bom = Yii::$app->db->createCommand("
                SELECT akt_produksi_bom_detail_hp.qty, akt_produksi_bom_detail_hp.keterangan, akt_item.nama_item, akt_satuan.nama_satuan, akt_item_harga_jual.harga_satuan
                FROM akt_produksi_bom_detail_hp 
                LEFT JOIN akt_produksi_bom ON akt_produksi_bom.id_produksi_bom = akt_produksi_bom_detail_hp.id_produksi_bom
                LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_produksi_bom_detail_hp.id_item_stok
                LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item
                LEFT JOIN akt_satuan ON akt_item.id_satuan = akt_item.id_satuan
                LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item
                WHERE akt_produksi_bom_detail_hp.id_produksi_bom = '$p[id_produksi_bom]'
                ")->query();
                $no = 1;
                foreach ($hp_bom as $hp) {
                ?>
                    <tr class="body-bahan">
                        <td><?= $no++ ?></td>
                        <td><?= $hp['nama_item'] ?> </td>
                        <td><?= $hp['nama_satuan'] ?> </td>
                        <td><?= $hp['qty'] ?> </td>
                        <td><?= $hp['qty'] * $hp['harga_satuan'] ?> </td>
                    </tr>

                <?php } ?>
            </table>

    </div>

<?php } ?>
</div>
</body>

</html>