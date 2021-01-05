<?php

use yii\helpers\Html;
use backend\models\AktAkun;
use backend\models\AktJurnalUmum;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKasBank;
use backend\models\AktMitraBisnis;
use backend\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

$this->title = 'Laporan Hutang Piutang Jatug Tempo';
?>

<div class="absensi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Laporan Kas', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
    </p>

    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">

                        <?= Html::beginForm(['', array('class' => 'form-inline')]) ?>

                        <table border="0" width="100%">
                            <tr>
                                <td width="10%">
                                    <div class="form-group">Jatuh Tempo</div>
                                </td>
                                <td align="center" width="5%">
                                    <div class="form-group">:</div>
                                </td>
                                <td width="30%">
                                    <div class="form-group">
                                        <input type="date" name="jatuh_tempo" value="<?= (!empty($jatuh_tempo)) ? $jatuh_tempo : date('Y-m-d'); ?>" class="form-control" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="form-group">
                                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <?= Html::endForm() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    if (!empty($jatuh_tempo)) {
        $query_hutang = Yii::$app->db->createCommand("SELECT * FROM akt_pembelian WHERE akt_pembelian.tanggal_tempo < '$jatuh_tempo' AND akt_pembelian.jenis_bayar = '2' AND akt_pembelian.status = '4'")->query();
        $query_piutang = Yii::$app->db->createCommand("SELECT * FROM akt_penjualan WHERE akt_penjualan.tanggal_tempo < '$jatuh_tempo' AND akt_penjualan.jenis_bayar = '2' AND akt_penjualan.status = '4'")->query();
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($jatuh_tempo)) . ' s/d ' . date('d/m/Y', strtotime($jatuh_tempo)) ?>
            <?= Html::a('Cetak', ['laporan-hutang-vs-piutang-cetak', 'jatuh_tempo' => $jatuh_tempo], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-hutang-vs-piutang-export', 'jatuh_tempo' => $jatuh_tempo], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>
        <div class="box">
            <div class="box box-primary">
                <div class="box-heading" style="overflow-x: auto;">
                </div>
                <div class="box-body" style="overflow-x: auto;">
                    <table class="table">
                        <tr>
                            <?php
                            $setting = Setting::find()->one();
                            if (!empty($setting->foto)) {
                            ?>
                                <th rowspan="3" style="width: 150px;"><img style="float: right;" width="150px" src="upload/<?= $setting->foto ?>" alt=""></th>
                            <?php } ?>
                            <th style="text-align: center;">
                                <h3 style="margin-top: -5px;margin-bottom: -5px;"><?= $setting->nama ?></h3>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">
                                <h3 style="margin-top: -5px;margin-bottom: -5px;">Hutang Jatuh Tempo Dan Piutang Jatuh Tempo</h3>
                            </th>
                        </tr>
                        <tr>
                            <th style="text-align: right;"><?= date('d/m/Y', strtotime($jatuh_tempo)) ?></th>
                        </tr>
                    </table>
                    <div class="col-md-6">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="6" style="text-align: center;">Hutang Jatuh Tempo</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Total</th>
                                    <th>Dibayar</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $gt = 0;
                                foreach ($query_hutang as $key => $value) {
                                    $mb = AktMitraBisnis::findOne($value['id_customer']);
                                    (!empty($mb->nama_mitra_bisnis)) ? $mb->nama_mitra_bisnis : '';
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $mb->nama_mitra_bisnis ?></td>
                                        <td><?= tanggal_indo($value['tanggal_tempo']) ?></td>
                                        <td>
                                            <?php
                                            $sum_nominal_pembayaran  = Yii::$app->db->createCommand("SELECT SUM(nominal) from akt_pembayaran_biaya WHERE id_pembelian = '$value[id_pembelian]'")->queryScalar();
                                            if ($sum_nominal_pembayaran  == null) {
                                                echo ribuan($total = $value['total']);
                                            } else {
                                                echo ribuan($total = $value['total'] - $sum_nominal_pembayaran);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya')->where(['id_pembelian' => $value['id_pembelian']]);
                                            $sum_nominal = $query->sum('nominal');
                                            echo ribuan($sum_nominal == 0 ? $dibayar = $value['uang_muka'] : $dibayar = $sum_nominal);
                                            ?>
                                        </td>
                                        <td><?= ribuan($sisa = $total - $dibayar) ?></td>
                                    </tr>
                                    <?php $gt += $sisa; ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align: left;">Total</th>
                                    <th style="text-align: right;"><?= ribuan($gt) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="6" style="text-align: center;">Piutang Jatuh Tempo</th>
                                </tr>
                                <tr>
                                    <th>#</th>
                                    <th>Customer</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Total</th>
                                    <th>Dibayar</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 0;
                                $gt = 0;
                                foreach ($query_piutang as $key => $value) {
                                    $mb = AktMitraBisnis::findOne($value['id_customer']);
                                    (!empty($mb->nama_mitra_bisnis)) ? $mb->nama_mitra_bisnis : '';
                                    $no++;
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $mb->nama_mitra_bisnis ?></td>
                                        <td><?= tanggal_indo($value['tanggal_tempo']) ?></td>
                                        <td>
                                            <?php
                                            $sum_nominal_pembayaran  = Yii::$app->db->createCommand("SELECT SUM(nominal) from akt_penerimaan_pembayaran WHERE id_penjualan = '$value[id_penjualan]'")->queryScalar();
                                            if ($sum_nominal_pembayaran  == null) {
                                                echo ribuan($total = $value['total']);
                                            } else {
                                                echo ribuan($total = $value['total'] - $sum_nominal_pembayaran);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $query = (new \yii\db\Query())->from('akt_penerimaan_pembayaran')->where(['id_penjualan' => $value['id_penjualan']]);
                                            $sum_nominal = $query->sum('nominal');
                                            echo ribuan($sum_nominal == 0 ? $dibayar = $value['uang_muka'] : $dibayar = $sum_nominal);
                                            ?>
                                        </td>
                                        <td><?= ribuan($sisa = $total - $dibayar) ?></td>
                                    </tr>
                                    <?php $gt += $sisa; ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align: left;">Total</th>
                                    <th style="text-align: right;"><?= ribuan($gt) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>