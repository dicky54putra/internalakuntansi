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

        table {
            border-collapse: collapse;
            text-align: center;

        }

        table th {
            border: 1px solid black;
            padding: 5px 0;
        }

        table td {
            border: 1px solid black;
            padding: 5px 0;
        }

        .table-in tr th {
            border: none;
        }

        .table-in tr td {
            border: none;
        }
    </style>
</head>

<body>
    <h2 class="title-lap"> Daftar BOM </h2>
    <hr>

    <div class="content" style="margin-top:20px;">
        <table width="100%">


            <?php
            $bom = Yii::$app->db->createCommand("SELECT akt_bom.*, akt_item.nama_item, akt_item_harga_jual.harga_satuan FROM akt_bom 
                LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_bom.id_item_stok
                LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item
                LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item")->query();
            foreach ($bom as $b) {
            ?>
                <tr>
                    <th>No B.o.M</th>
                    <th>Nama B.o.M</th>
                    <th>Qty</th>
                    <th>Harga</th>
                </tr>
                <tr>
                    <td> <?= $b['no_bom'] ?></td>
                    <td><?= $b['nama_item'] ?></td>
                    <td><?= $b['qty'] ?></td>
                    <td><?= $b['qty'] * $b['harga_satuan'] ?></td>
                </tr>

                <tr>
                    <td colspan="4">
                        <table width="100%" class="table-in">
                            <tr>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                            <?php
                            $bb_bom = Yii::$app->db->createCommand("SELECT akt_bom_detail_bb.*, akt_item.nama_item, akt_item_harga_jual.harga_satuan, akt_satuan.nama_satuan FROM akt_bom_detail_bb
                            LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_bom_detail_bb.id_item_stok
                            LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item
                            LEFT JOIN akt_item_harga_jual ON akt_item_harga_jual.id_item = akt_item.id_item
                            LEFT JOIN akt_satuan ON akt_satuan.id_satuan = akt_item.id_satuan
                            WHERE id_bom = '$b[id_bom]'
                            ")->query();

                            foreach ($bb_bom as $bb) {
                            ?>
                                <tr>
                                    <td> <?= $bb['nama_item'] ?></td>
                                    <td> <?= $bb['qty'] ?> <?= $bb['nama_satuan'] ?></td>
                                    <td> <?= $bb['harga'] ?></td>
                                    <td> <?= $bb['harga'] * $bb['qty'] ?></td>
                                </tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>

            <?php } ?>
        </table>
    </div>
</body>

</html>