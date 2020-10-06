<?php

use backend\models\AktBomDetailBb;
use backend\models\AktItem;
use backend\models\AktItemStok;
use backend\models\AktProduksiBomDetailHp;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Retur Pembelian</title>
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
        <p align="center">PRODUKSI Bill Of Material</p>
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
        $query_bb = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->asArray()->all();
        foreach ($query_bb as $key => $data) {
            # code...
            $id_item = AktItemStok::findOne($data['id_item_stok']);
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $data['id_item_stok'] . "'")->queryScalar();
            if (!empty($id_item->id_item_stok)) {
                $item = AktItem::findOne($id_item->id_item);
        ?>
                <tr>
                    <td><?= $no++ . '.' ?></td>
                    <td>
                        <?= $item->nama_item ?>
                    </td>
                    <td align="center"><?= $data['qty'] ?></td>
                    <td align="right"><?= ribuan($data['harga']) ?></td>
                    <td><?= $data['keterangan'] ?></td>
                </tr>
        <?php }
        }
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
        $query_bb = AktProduksiBomDetailHp::find()->where(['id_produksi_bom' => $model->id_produksi_bom])->asArray()->all();
        foreach ($query_bb as $key => $data) {
            # code...
            $id_item = AktItemStok::findOne($data['id_item_stok']);
            $item = AktItem::find()->where(['id_item' => $id_item->id_item])->one();
            $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $data['id_item_stok'] . "'")->queryScalar();
        ?>
            <tr>
                <td><?= $no++ . '.' ?></td>
                <td>
                    <?= $item->nama_item ?>
                </td>
                <td align="center"><?= $data['qty'] ?></td>
                <td><?= $data['keterangan'] ?></td>
            </tr>
        <?php }
        ?>
    </table>
</body>

</html>