<?php

use yii\helpers\Html;

use backend\models\AktPenjualan;
use backend\models\AktPenjualanDetail;
use backend\models\AktMitraBisnis;
use backend\models\AktSales;
use backend\models\AktMataUang;
use backend\models\AktMitraBisnisAlamat;
use backend\models\AktItem;
use backend\models\AktItemStok;

$this->title = 'Tutup Buku';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$angka_modulus = 0;
$query_penjualan = AktPenjualan::find()->where(['BETWEEN', 'tanggal_order_penjualan', $tanggal_awal, $tanggal_akhir])->asArray()->all();
foreach ($query_penjualan as $key => $data) {
    # code...
    $customer = AktMitraBisnis::findOne($data['id_customer']);
    $sales = AktSales::findOne($data['id_sales']);
    $mata_uang = AktMataUang::findOne($data['id_mata_uang']);
    $penagih = AktMitraBisnis::findOne($data['id_penagih']);
    $alamat_pengantaran = AktMitraBisnisAlamat::findOne($data['id_mitra_bisnis_alamat']);
    $angka_modulus++;
?>
    <style>
        .table_heading th,
        .table_heading td {
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }

        .table,
        .table td,
        .table th {
            border: 1px solid #888888;
            text-align: center;
            font-size: 12px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            padding: 5px;
        }
    </style>
    <table class="table_heading">
        <thead>
            <tr>
                <th align="left">No. Order</th>
                <td>: <?= $data['no_order_penjualan'] ?></td>
                <th align="left">No. Faktur</th>
                <td>: <?= $data['no_faktur_penjualan'] ?></td>
                <th align="left">No. SPB</th>
                <td>: <?= $data['no_spb'] ?></td>
            </tr>
            <tr>
                <th align="left">Tanggal Order</th>
                <td>: <?= date('d/m/Y', strtotime($data['tanggal_order_penjualan'])) ?></td>
                <th align="left">Tanggal Faktur</th>
                <td>: <?= (!empty($data['tanggal_faktur_penjualan'])) ? date('d/m/Y', strtotime($data['tanggal_faktur_penjualan'])) : '&nbsp;' ?></td>
                <th align="left">Tanggal Pengiriman</th>
                <td>: <?= (!empty($data['tanggal_pengiriman'])) ? date('d/m/Y', strtotime($data['tanggal_pengiriman'])) : '&nbsp;' ?></td>

            </tr>
            <tr>
                <th align="left">Customer</th>
                <td>: <?= (!empty($customer->nama_mitra_bisnis)) ? $customer->nama_mitra_bisnis : '' ?></td>
                <th align="left">Materai</th>
                <td>: <?= $data['materai'] ?></td>
                <th align="left">Pengantar</th>
                <td>: <?= $data['pengantar'] ?></td>
            </tr>
            <tr>
                <th align="left">Sales</th>
                <td>: <?= (!empty($sales->nama_sales)) ? $sales->nama_sales : '&nbsp;' ?></td>
                <th align="left">Jatuh Tempo</th>
                <td>
                    <?php
                    if ($data['jenis_bayar'] == 1) {
                        # code...
                        if (!empty($data['tanggal_faktur_penjualan'])) {
                            # code...
                            echo ': ' . date('d/m/Y', strtotime($data['tanggal_faktur_penjualan']));
                        } else {
                            # code...
                            echo '&nbsp;';
                        }
                    } elseif ($data['jenis_bayar'] == 2) {
                        # code...
                        if (!empty($data['tanggal_tempo'])) {
                            # code...
                            echo ': ' . date('d/m/Y', strtotime($data['tanggal_tempo']));
                        } else {
                            # code...
                            echo '&nbsp;';
                        }
                    }
                    ?>
                </td>
                <th align="left">Status</th>
                <td>
                    <?php
                    if ($data['status'] == 1) {
                        # code...
                        echo ": Order Penjualan";
                    } elseif ($data['status'] == 2) {
                        # code...
                        echo ": Penjualan";
                    } elseif ($data['status'] == 3) {
                        # code...
                        echo ": Pengiriman";
                    } elseif ($data['status'] == 4) {
                        # code...
                        echo ": Completed";
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th align="left">Alamat Pengantaran</th>
                <td>: <?= (!empty($alamat_pengantaran->keterangan_alamat)) ? $alamat_pengantaran->keterangan_alamat : '&nbsp;' ?></td>
                <th align="left">Tanggal Penerimaan</th>
                <td>: <?= (!empty($data['tanggal_penerimaan'])) ? date('d/m/Y', strtotime($data['tanggal_penerimaan'])) : '&nbsp;' ?></td>
                <th align="left">Penerima</th>
                <td>: <?= $data['penerima'] ?></td>
            </tr>
        </thead>
    </table>
    <table class="table" border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Diskon Barang %</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $totalan_sub_total = 0;
            $query_penjualan_detail = AktPenjualanDetail::findAll(['id_penjualan' => $data['id_penjualan']]);
            foreach ($query_penjualan_detail as $key => $dataa) {
                # code...
                $item_stok = AktItemStok::findOne($dataa['id_item_stok']);
                $item = AktItem::findOne($item_stok->id_item);
                $totalan_sub_total += $dataa['total'];
            ?>
                <tr>
                    <td style="width: 1%;" align="center"><?= $no++ . '.' ?></td>
                    <td align="center"><?= (!empty($item->nama_item)) ? $item->nama_item : '&nbsp;' ?></td>
                    <td align="center"><?= $dataa['qty'] ?></td>
                    <td align="right"><?= ribuan($dataa['harga']) ?></td>
                    <td align="center"><?= $dataa['diskon'] ?></td>
                    <td align="right"><?= ribuan($dataa['total']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right;">Total</th>
                <th style="text-align: right;"><?= ribuan($totalan_sub_total) ?></th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Diskon Penjualan</th>
                <th style="text-align: right;">
                    <?php
                    $diskon = ($data['diskon'] * $totalan_sub_total) / 100;
                    echo ribuan($diskon);
                    ?>
                </th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Pajak 10% (<?= ($data['pajak'] == NULL) ? '' : $retVal = ($data['pajak'] == 1) ? '&#10004;' : '&#10006;' ?>)</th>
                <th style="text-align: right;">
                    <?php
                    $diskon = ($data['diskon'] * $totalan_sub_total) / 100;
                    $pajak_ = (($totalan_sub_total - $diskon) * 10) / 100;
                    $pajak = ($data['pajak'] == 1) ? $pajak_ : 0;
                    echo ribuan($pajak);
                    ?>
                </th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Ongkir</th>
                <th style="text-align: right;"><?= $data['ongkir'] ?></th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Grand Total</th>
                <th style="text-align: right;"><?= ribuan($data['total']) ?></th>
            </tr>
        </tfoot>
    </table>
    <br>
<?php } ?>
<?php
$fileName = "Tutup Buku Penjualan.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>