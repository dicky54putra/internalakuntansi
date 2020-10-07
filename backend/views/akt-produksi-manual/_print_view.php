<?php

use backend\models\AktBomDetailBb;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktProduksiManualDetailBb;
use backend\models\AktProduksiManualDetailHp;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Produksi Manual</title>
    <style>
        table {
            width: 100%;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td>
                <h2><?= $setting->nama
                    ?></h2>
            </td>
        </tr>
        <tr>
            <td>
                <p type="ntext"><?= $setting->alamat
                                ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>Telp: <?= $setting->telepon
                            ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>NPWP: <?= $setting->npwp
                            ?></p>
            </td>
        </tr>
    </table>
    <br>
    <b>
        <p align="center">PRODUKSI MANUAL</p>
    </b>
    <br>
    <p>Bahan Baku</p>
    <table>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <tr>
            <td>No</td>
            <td>Nama Barang</td>
            <td align="center">Qty</td>
            <td align="right">Harga</td>
            <td>Keterangan</td>
        </tr>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <?php
        $no = 1;
        // $query_bb = AktProduksiBomDetailBb::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->asArray()->all();
        $query_bb = AktProduksiManualDetailBb::find()->where(['id_produksi_manual' => $model->id_produksi_manual])->asArray()->all();
        foreach ($query_bb as $key => $data) {
            # code...
            $id_item = AktItemStok::findOne($data['id_item_stok']);
            $item = AktItem::findOne($id_item->id_item);
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td>
                    <?= $item->nama_item ?>

                </td>
                <td><?= $data['qty'] ?></td>
                <td><?= $data['keterangan'] ?></td>
            </tr>
        <?php }
        ?>
    </table>
    <br>
    <p>Hasil Produksi</p>
    <table>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <tr>
            <td>No</td>
            <td>Nama Barang</td>
            <td align="center">Qty</td>
            <td>Keterangan</td>
        </tr>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <?php
        $no = 1;
        $query_bb = AktProduksiManualDetailHp::find()->where(['id_produksi_manual' => $model->id_produksi_manual])->asArray()->all();
        foreach ($query_bb as $key => $data) {
            # code...
            $id_item = AktItemStok::findOne($data['id_item_stok']);
            $item = AktItem::findOne($id_item->id_item);
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td><?= $item->nama_item ?></td>
                <td><?= $data['qty'] ?></td>
                <td><?= $data['keterangan'] ?></td>
            </tr>
        <?php }
        ?>
    </table>
</body>

</html>