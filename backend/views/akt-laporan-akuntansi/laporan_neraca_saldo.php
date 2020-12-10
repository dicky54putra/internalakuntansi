<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktKlasifikasi;
use backend\models\AktSaldoAwalAkunDetail;

$this->title = 'Laporan Neraca Saldo';
?>
<style>
    .head td {
        text-align: center;
    }

    .print {
        display: none;
        ;
    }

    @media print {
        @page {
            size: auto;
            margin: 0mm;
        }

        .no-print,
        .periode {
            display: none;
        }

        .print {
            display: block;
        }
    }
</style>
<div class="absensi-index">

    <div class="no-print">

        <h1><?= Html::encode($this->title) ?></h1>
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><?= Html::a('Daftar Laporan Akuntansi', ['index']) ?></li>
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
                                        <div class="form-group">Dari Tanggal</div>
                                    </td>
                                    <td align="center" width="5%">
                                        <div class="form-group">:</div>
                                    </td>
                                    <td width="30%">
                                        <div class="form-group">
                                            <input type="date" name="tanggal_awal" class="form-control" value="<?= date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))) ?>" required>
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                </tr>
                                <tr>
                                    <td width="10%">
                                        <div class="form-group">Sampai Tanggal</div>
                                    </td>
                                    <td align="center" width="5%">
                                        <div class="form-group">:</div>
                                    </td>
                                    <td width="30%">
                                        <div class="form-group">
                                            <input type="date" name="tanggal_akhir" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                    </td>
                                    <td width="5%"></td>
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
    </div>
    <?php
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <h3 class="print">
            <?= 'Laporan Neraca Saldo : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
        </h3>
        <p style="font-weight: bold; font-size: 20px;" class="periode">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <button class="btn btn-primary btn-cetak" onclick="funcPrint()">Cetak</button>
            <?= Html::a('Export', ['laporan-neraca-saldo-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success btn-export', 'target' => '_blank', 'method' => 'post']) ?>
        </p>

        <div class="box">
            <?php
            $jenis = AktAkun::find()->where("jenis IN(1,2,3,5,6,7)")->groupBy('jenis')->all();
            foreach ($jenis as $jen) {
                $data_jenis = array(
                    1 => 'Aset Lancar',
                    2 => 'Aset Tetap',
                    3 => 'Aset Tetap Tidak Berwujud',
                    4 => 'Pendapatan',
                    // 2 => 'Kewajiban',
                    5 => 'Liabilitas Jangka Pendek',
                    6 => 'Liabilitas Jangka Panjang',
                    // 3 => 'Modal',
                    7 => 'Ekuitas',
                    // 5 => 'Pendapatan Lain',
                    8 => 'Beban',
                    9 => 'Pengeluaran Lain',
                    10 => 'Pendapatan Lain',
                );
            ?>
                <div class="panel panel-primary" id="panel">
                    <div class="panel-heading">
                        <table class="table" style="margin-bottom: -20px;">
                            <tr>
                                <th><?= $data_jenis[$jen->jenis]; ?></th>
                                <th style="width: 15%;text-align: right;">Debet</th>
                                <th style="width: 15%;text-align: right;">Kredit</th>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12" style="padding: 0;">
                            <div class="box-body">
                                <?php
                                $klasifikasi = AktAkun::find()->where("jenis = $jen->jenis")->groupBy('klasifikasi')->all();
                                $sum_by_jenis_debet = 0;
                                $sum_by_jenis_kredit = 0;
                                foreach ($klasifikasi as $klas) {
                                    $klasname = AktKlasifikasi::find()->where(['id_klasifikasi' => $klas->klasifikasi])->one();
                                ?>
                                    <table class="table" style="margin-top: 20px;">
                                        <tr style="background-color: rgba(0,0,0,0.1);">
                                            <th><?= $klasname->klasifikasi ?></th>
                                        </tr>
                                        <tr>
                                            <table class="table">
                                                <?php
                                                $no = 1;
                                                $query_akun = AktAkun::find()->where(['jenis' => $jen->jenis, 'klasifikasi' => $klas->klasifikasi])->orderBy("nama_akun")->all();
                                                $t_debet = 0;
                                                $t_kredit = 0;
                                                foreach ($query_akun as $key => $data) {
                                                    $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();
                                                    $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                        ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                        ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                        ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                                        ->orderBy("id_jurnal_umum_detail ASC")
                                                        ->count();
                                                    $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;
                                                    $saldo_awal = $nilai_saldo_awal_akun;
                                                    $sum_debit = Yii::$app->db->createCommand("SELECT SUM(debit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                                                    $sum_kredit = Yii::$app->db->createCommand("SELECT SUM(kredit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                                                    $saldo_debit = $saldo_awal + $sum_debit;
                                                    $change_saldo = $saldo_debit - $sum_kredit;
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $data['kode_akun'] ?></td>
                                                        <td><?= $data['nama_akun'] ?></td>
                                                        <td style="text-align: right; width: 15%;">
                                                            <?php
                                                            if ($count_query_jurnal_umum_detail == 0) {
                                                                if ($data['saldo_normal'] == 1) {
                                                                    echo ribuan(abs($saldo_awal));
                                                                    $t_debet += abs($saldo_awal);
                                                                }
                                                            } else {
                                                                if ($saldo_debit >= $sum_kredit) {
                                                                    echo ribuan(abs($change_saldo));
                                                                    $t_debet += abs($change_saldo);
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td style="text-align: right; width: 15%;">
                                                            <?php
                                                            if ($count_query_jurnal_umum_detail == 0) {
                                                                if ($data['saldo_normal'] == 2) {
                                                                    echo ribuan(abs($saldo_awal));
                                                                    $t_kredit += abs($saldo_awal);
                                                                }
                                                            } else {
                                                                if ($saldo_debit <= $sum_kredit) {
                                                                    echo ribuan(abs($change_saldo));
                                                                    $t_kredit += abs($change_saldo);
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td align="right" colspan="3">Total <?= $klasname->klasifikasi ?></td>
                                                    <td align="right">
                                                        <?php
                                                        echo ribuan(abs($t_debet));
                                                        $sum_by_jenis_debet += $t_debet;
                                                        ?>
                                                    </td>
                                                    <td align="right">
                                                        <?php
                                                        echo ribuan(abs($t_kredit));
                                                        $sum_by_jenis_kredit += $t_kredit;
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </tr>
                                    </table>
                                <?php } ?>
                                <table class="table" style="margin-top: 20px;">
                                    <tr style="background-color: rgba(0,0,0,0.1);">
                                        <th>Total <?= $data_jenis[$jen->jenis]; ?></th>
                                        <th style="width: 15%; text-align: right;"><?= ribuan(abs($sum_by_jenis_debet)) ?></th>
                                        <th style="width: 15%; text-align: right;"><?= ribuan(abs($sum_by_jenis_kredit)) ?></th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
</div>
<?php } ?>
</div>

<script>
    const element = document.getElementById("panel");

    function funcPrint() {
        element.classList.remove("panel-primary");
        window.print();
    }

    window.onafterprint = function() {
        element.classList.add("panel-primary");
    }
</script>