<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktKlasifikasi;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktJurnalUmum;
use backend\models\AktSaldoAwalAkunDetail;

$this->title = 'Laporan Neraca Lajur';
?>

<div class="absensi-index">

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
                                        <input type="date" name="tanggal_awal" class="form-control" required>
                                    </div>
                                </td>
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
                                        <input type="date" name="tanggal_akhir" class="form-control" required>
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
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        # code...
    ?>
        <p style="font-weight: bold; font-size: 20px;">
            <?= 'Periode : ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
            <?= Html::a('Cetak', ['laporan-neraca-lajur-cetak', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-primary', 'target' => '_blank', 'method' => 'post']) ?>
            <?= Html::a('Export', ['laporan-neraca-lajur-excel', 'tanggal_awal' => $tanggal_awal, 'tanggal_akhir' => $tanggal_akhir], ['class' => 'btn btn-success', 'target' => '_blank', 'method' => 'post']) ?>
        </p>

        <div class="box">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="fa fa-file-text"></span> <?= $this->title ?></div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body" style="overflow-x: auto;">
                            <table class="table table-condensed table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;vertical-align: middle;text-align: center;" rowspan="2">#</th>
                                        <th style="width: 5%;vertical-align: middle;text-align: center;" rowspan="2">Kode Akun</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align: center;">Nama Akun</th>
                                        <th colspan="2" style="text-align: center;white-space: nowrap;">Saldo Sebelum Penyesuaian</th>
                                        <th colspan="2" style="text-align: center;white-space: nowrap;">Jurnal Penyesuaian</th>
                                        <th colspan="2" style="text-align: center;white-space: nowrap;">Saldo Sesudah Penyesuaian</th>
                                        <th colspan="2" style="text-align: center;white-space: nowrap;">Laba Rugi</th>
                                        <th colspan="2" style="text-align: center;white-space: nowrap;">Posisi Keuangan</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;min-width: 115px;">Debit</th>
                                        <th style="text-align: center;min-width: 115px;">Kredit</th>
                                        <th style="text-align: center;min-width: 115px;">Debit</th>
                                        <th style="text-align: center;min-width: 115px;">Kredit</th>
                                        <th style="text-align: center;min-width: 115px;">Debit</th>
                                        <th style="text-align: center;min-width: 115px;">Kredit</th>
                                        <th style="text-align: center;min-width: 115px;">Debit</th>
                                        <th style="text-align: center;min-width: 115px;">Kredit</th>
                                        <th style="text-align: center;min-width: 115px;">Debit</th>
                                        <th style="text-align: center;min-width: 115px;">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_akun = AktAkun::find()->all();
                                    foreach ($query_akun as $key => $data) {
                                        # code...
                                    ?>
                                        <tr>
                                            <td style="text-align: center;"><?= $no++ . '.' ?></td>
                                            <td style="text-align: center;"><?= $data['kode_akun'] ?></td>
                                            <td style="white-space: nowrap;"><?= $data['nama_akun'] ?></td>
                                            <?php
                                            $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();

                                            $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;

                                            $saldo_awal = $nilai_saldo_awal_akun;

                                            $angka = 0;
                                            $penentu_letak_sisa_total = 0;
                                            $query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum.no_jurnal_umum", "akt_jurnal_umum_detail.keterangan", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]' AND akt_jurnal_umum.tipe = 1")
                                                ->orderBy("id_jurnal_umum_detail ASC")
                                                ->asArray()->all();
                                            $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum.no_jurnal_umum", "akt_jurnal_umum_detail.keterangan", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]' AND akt_jurnal_umum.tipe = 1")
                                                ->orderBy("id_jurnal_umum_detail ASC")
                                                ->count();
                                            foreach ($query_jurnal_umum_detail as $key => $dataa) {
                                                # code...
                                                $angka++;

                                                if ($angka == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $saldo_akun = $saldo_awal + $dataa['debit'];
                                                        $perubahan_saldo_akun_1 = $saldo_akun - $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_1;
                                                    } else {
                                                        # code...
                                                        $saldo_akun = $saldo_awal - $dataa['debit'];
                                                        $perubahan_saldo_akun_1 = $saldo_akun + $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_1;
                                                    }
                                                }

                                                $sisa_saldo_1 = $saldo_sementara;

                                                if ($angka > 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $saldo_akun = $sisa_saldo_1 + $dataa['debit'];
                                                        $perubahan_saldo_akun_2 = $saldo_akun - $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_2;
                                                    } else {
                                                        # code...
                                                        $saldo_akun = $sisa_saldo_1 - $dataa['debit'];
                                                        $perubahan_saldo_akun_2 = $saldo_akun + $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_2;
                                                    }
                                                }

                                                $sisa_saldo_2 = $saldo_sementara;

                                                if ($angka == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $saldo_awal) >= $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 1;
                                                            // echo ribuan($sisa_saldo_1);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 1';
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $saldo_awal) < $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 2;
                                                            // echo ribuan($sisa_saldo_1);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 2';
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $sisa_saldo_2) >= $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 3;
                                                            // echo ribuan($sisa_saldo_2);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 1';
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $sisa_saldo_2) < $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 4;
                                                            // echo ribuan($sisa_saldo_2);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 2';
                                                        }
                                                    }
                                                }

                                                if ($angka == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $saldo_awal) < $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 5;
                                                            // echo ribuan($sisa_saldo_1);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 4';
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $saldo_awal) >= $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 6;
                                                            // echo ribuan($sisa_saldo_1);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 5';
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $sisa_saldo_2) < $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 7;
                                                            // echo ribuan($sisa_saldo_2);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 4';
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $sisa_saldo_2) >= $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 8;
                                                            // echo ribuan($sisa_saldo_2);
                                                        } else {
                                                            # code...
                                                            // echo 'pindah sebelah 5';
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <td style="text-align: right;">
                                                <?php
                                                $sebelum_penyesuaian_debit = 0;
                                                if ($count_query_jurnal_umum_detail == 0) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $sebelum_penyesuaian_debit = $saldo_awal;
                                                        echo ($sebelum_penyesuaian_debit != 0) ? ribuan($sebelum_penyesuaian_debit) : "";
                                                    }
                                                } else {
                                                    # code...
                                                    if ($penentu_letak_sisa_total == 1 || $penentu_letak_sisa_total == 2) {
                                                        # code...
                                                        $sebelum_penyesuaian_debit = $sisa_saldo_1;
                                                        echo ($sebelum_penyesuaian_debit != 0) ? ribuan($sebelum_penyesuaian_debit) : "";
                                                    } elseif ($penentu_letak_sisa_total == 3 || $penentu_letak_sisa_total == 4) {
                                                        # code...
                                                        $sebelum_penyesuaian_debit = $sisa_saldo_2;
                                                        echo ($sebelum_penyesuaian_debit != 0) ? ribuan($sebelum_penyesuaian_debit) : "";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                $sebelum_penyesuaian_kredit = 0;
                                                if ($count_query_jurnal_umum_detail == 0) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 2) {
                                                        # code...
                                                        $sebelum_penyesuaian_kredit = $saldo_awal;
                                                        echo ($sebelum_penyesuaian_kredit != 0) ? ribuan($sebelum_penyesuaian_kredit) : "";
                                                    }
                                                } else {
                                                    # code...
                                                    if ($penentu_letak_sisa_total == 5 || $penentu_letak_sisa_total == 6) {
                                                        # code...
                                                        $sebelum_penyesuaian_kredit = $sisa_saldo_1;
                                                        echo ($sebelum_penyesuaian_kredit != 0) ? ribuan($sebelum_penyesuaian_kredit) : "";
                                                    } elseif ($penentu_letak_sisa_total == 7 || $penentu_letak_sisa_total == 8) {
                                                        # code...
                                                        $sebelum_penyesuaian_kredit = $sisa_saldo_2;
                                                        echo ($sebelum_penyesuaian_kredit != 0) ? ribuan($sebelum_penyesuaian_kredit) : "";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php
                                            $akt_jurnal_umum = AktJurnalUmum::find()
                                                ->select(["akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit"])
                                                ->leftJoin("akt_jurnal_umum_detail", "akt_jurnal_umum_detail.id_jurnal_umum = akt_jurnal_umum.id_jurnal_umum")
                                                ->where(['BETWEEN', 'tanggal', $tanggal_awal, $tanggal_akhir])
                                                ->andWhere(['=', 'tipe', 2])
                                                ->andWhere(['akt_jurnal_umum_detail.id_akun' => $data['id_akun']])
                                                ->asArray()
                                                ->one();

                                            if ($akt_jurnal_umum) {
                                                # code...
                                                $nilai_debit = ($akt_jurnal_umum['debit'] > 0) ? ribuan($akt_jurnal_umum['debit']) : "";
                                                $nilai_kredit = ($akt_jurnal_umum['kredit'] > 0) ? ribuan($akt_jurnal_umum['kredit']) : "";
                                                $jurnal_penyesuaian_debit = $akt_jurnal_umum['debit'];
                                                $jurnal_penyesuaian_kredit = $akt_jurnal_umum['kredit'];
                                            } else {
                                                # code...
                                                $nilai_debit = "";
                                                $nilai_kredit = "";
                                                $jurnal_penyesuaian_debit = 0;
                                                $jurnal_penyesuaian_kredit = 0;
                                            }
                                            ?>
                                            <td style="text-align: right;"><?= $nilai_debit ?></td>
                                            <td style="text-align: right;"><?= $nilai_kredit ?></td>
                                            <?php
                                            $sesudah_penyesuaian_debit = $sebelum_penyesuaian_debit + $jurnal_penyesuaian_debit;
                                            $sesudah_penyesuaian_kredit = $sebelum_penyesuaian_kredit + $jurnal_penyesuaian_kredit;
                                            ?>
                                            <td style="text-align: right;">
                                                <?php
                                                if ($sesudah_penyesuaian_debit > $sesudah_penyesuaian_kredit) {
                                                    # code...
                                                    $nilai_sesudah_penyesuaian_debit = $sesudah_penyesuaian_debit - $sesudah_penyesuaian_kredit;
                                                    echo ($nilai_sesudah_penyesuaian_debit != 0) ? ribuan($nilai_sesudah_penyesuaian_debit) : "";
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                if ($sesudah_penyesuaian_kredit > $sesudah_penyesuaian_debit) {
                                                    # code...
                                                    $nilai_sesudah_penyesuaian_kredit = $sesudah_penyesuaian_kredit - $sesudah_penyesuaian_debit;
                                                    echo ($nilai_sesudah_penyesuaian_kredit != 0) ? ribuan($nilai_sesudah_penyesuaian_kredit) : "";
                                                }
                                                ?>
                                            </td>
                                            <?php
                                            $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();

                                            $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;

                                            $saldo_awal = $nilai_saldo_awal_akun;

                                            $angka_laba_rugi = 0;
                                            $penentu_letak_sisa_total = 0;
                                            $query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum.no_jurnal_umum", "akt_jurnal_umum_detail.keterangan", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                                ->orderBy("id_jurnal_umum_detail ASC")
                                                ->asArray()->all();
                                            $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum.no_jurnal_umum", "akt_jurnal_umum_detail.keterangan", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                                ->orderBy("id_jurnal_umum_detail ASC")
                                                ->count();
                                            foreach ($query_jurnal_umum_detail as $key => $dataa) {
                                                # code...
                                                $angka_laba_rugi++;

                                                if ($angka_laba_rugi == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $saldo_akun = $saldo_awal + $dataa['debit'];
                                                        $perubahan_saldo_akun_1 = $saldo_akun - $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_1;
                                                    } else {
                                                        # code...
                                                        $saldo_akun = $saldo_awal - $dataa['debit'];
                                                        $perubahan_saldo_akun_1 = $saldo_akun + $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_1;
                                                    }
                                                }

                                                $sisa_saldo_1 = $saldo_sementara;

                                                if ($angka_laba_rugi > 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $saldo_akun = $sisa_saldo_1 + $dataa['debit'];
                                                        $perubahan_saldo_akun_2 = $saldo_akun - $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_2;
                                                    } else {
                                                        # code...
                                                        $saldo_akun = $sisa_saldo_1 - $dataa['debit'];
                                                        $perubahan_saldo_akun_2 = $saldo_akun + $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_2;
                                                    }
                                                }

                                                $sisa_saldo_2 = $saldo_sementara;

                                                if ($angka_laba_rugi == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $saldo_awal) >= $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 1;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $saldo_awal) < $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 2;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $sisa_saldo_2) >= $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 3;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $sisa_saldo_2) < $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 4;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    }
                                                }

                                                if ($angka_laba_rugi == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $saldo_awal) < $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 5;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $saldo_awal) >= $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 6;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $sisa_saldo_2) < $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 7;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $sisa_saldo_2) >= $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 8;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <td style="text-align: right;">
                                                <?php
                                                $laba_rugi_debit = 0;
                                                if ($count_query_jurnal_umum_detail == 0) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $laba_rugi_debit = $saldo_awal;
                                                        if ($data['jenis'] == 4 || $data['jenis'] == 8) {
                                                            # code...
                                                            echo ($laba_rugi_debit != 0) ? ribuan($laba_rugi_debit) : "";
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($penentu_letak_sisa_total == 1 || $penentu_letak_sisa_total == 2) {
                                                        # code...
                                                        $laba_rugi_debit = $sisa_saldo_1;
                                                        if ($data['jenis'] == 4 || $data['jenis'] == 8) {
                                                            # code...
                                                            echo ($laba_rugi_debit != 0) ? ribuan($laba_rugi_debit) : "";
                                                        }
                                                    } elseif ($penentu_letak_sisa_total == 3 || $penentu_letak_sisa_total == 4) {
                                                        # code...
                                                        $laba_rugi_debit = $sisa_saldo_2;
                                                        if ($data['jenis'] == 4 || $data['jenis'] == 8) {
                                                            # code...
                                                            echo ($laba_rugi_debit != 0) ? ribuan($laba_rugi_debit) : "";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                $laba_rugi_kredit = 0;
                                                if ($count_query_jurnal_umum_detail == 0) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 2) {
                                                        # code...
                                                        $laba_rugi_kredit = $saldo_awal;
                                                        if ($data['jenis'] == 4 || $data['jenis'] == 8) {
                                                            # code...
                                                            echo ($laba_rugi_kredit != 0) ? ribuan($laba_rugi_kredit) : "";
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($penentu_letak_sisa_total == 5 || $penentu_letak_sisa_total == 6) {
                                                        # code...
                                                        $laba_rugi_kredit = $sisa_saldo_1;
                                                        if ($data['jenis'] == 4 || $data['jenis'] == 8) {
                                                            # code...
                                                            echo ($laba_rugi_kredit != 0) ? ribuan($laba_rugi_kredit) : "";
                                                        }
                                                    } elseif ($penentu_letak_sisa_total == 7 || $penentu_letak_sisa_total == 8) {
                                                        # code...
                                                        $laba_rugi_kredit = $sisa_saldo_2;
                                                        if ($data['jenis'] == 4 || $data['jenis'] == 8) {
                                                            # code...
                                                            echo ($laba_rugi_kredit != 0) ? ribuan($laba_rugi_kredit) : "";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <?php
                                            $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();

                                            $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;

                                            $saldo_awal = $nilai_saldo_awal_akun;

                                            $angka_posisi_keuangan = 0;
                                            $penentu_letak_sisa_total = 0;
                                            $query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum.no_jurnal_umum", "akt_jurnal_umum_detail.keterangan", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                                ->orderBy("id_jurnal_umum_detail ASC")
                                                ->asArray()->all();
                                            $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                                ->select(["akt_jurnal_umum.tanggal", "akt_jurnal_umum.no_jurnal_umum", "akt_jurnal_umum_detail.keterangan", "akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                                ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                                ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                                ->orderBy("id_jurnal_umum_detail ASC")
                                                ->count();
                                            foreach ($query_jurnal_umum_detail as $key => $dataa) {
                                                # code...
                                                $angka_posisi_keuangan++;

                                                if ($angka_posisi_keuangan == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $saldo_akun = $saldo_awal + $dataa['debit'];
                                                        $perubahan_saldo_akun_1 = $saldo_akun - $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_1;
                                                    } else {
                                                        # code...
                                                        $saldo_akun = $saldo_awal - $dataa['debit'];
                                                        $perubahan_saldo_akun_1 = $saldo_akun + $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_1;
                                                    }
                                                }

                                                $sisa_saldo_1 = $saldo_sementara;

                                                if ($angka_posisi_keuangan > 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $saldo_akun = $sisa_saldo_1 + $dataa['debit'];
                                                        $perubahan_saldo_akun_2 = $saldo_akun - $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_2;
                                                    } else {
                                                        # code...
                                                        $saldo_akun = $sisa_saldo_1 - $dataa['debit'];
                                                        $perubahan_saldo_akun_2 = $saldo_akun + $dataa['kredit'];
                                                        $saldo_sementara = $perubahan_saldo_akun_2;
                                                    }
                                                }

                                                $sisa_saldo_2 = $saldo_sementara;

                                                if ($angka_posisi_keuangan == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $saldo_awal) >= $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 1;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $saldo_awal) < $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 2;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $sisa_saldo_2) >= $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 3;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $sisa_saldo_2) < $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 4;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    }
                                                }

                                                if ($angka_posisi_keuangan == 1) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $saldo_awal) < $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 5;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $saldo_awal) >= $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 6;
                                                            // echo ribuan($sisa_saldo_1);
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        if (($dataa['debit'] + $sisa_saldo_2) < $dataa['kredit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 7;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    } else {
                                                        # code...
                                                        if (($dataa['kredit'] + $sisa_saldo_2) >= $dataa['debit']) {
                                                            # code...
                                                            $penentu_letak_sisa_total = 8;
                                                            // echo ribuan($sisa_saldo_2);
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <td style="text-align: right;">
                                                <?php
                                                $posisi_keuangan_debit = 0;
                                                if ($count_query_jurnal_umum_detail == 0) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 1) {
                                                        # code...
                                                        $posisi_keuangan_debit = $saldo_awal;
                                                        if ($data['jenis'] == 1 || $data['jenis'] == 2 || $data['jenis'] == 5 || $data['jenis'] == 6 || $data['jenis'] == 7) {
                                                            # code...
                                                            echo ($posisi_keuangan_debit != 0) ? ribuan($posisi_keuangan_debit) : "";
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($penentu_letak_sisa_total == 1 || $penentu_letak_sisa_total == 2) {
                                                        # code...
                                                        $posisi_keuangan_debit = $sisa_saldo_1;
                                                        if ($data['jenis'] == 1 || $data['jenis'] == 2 || $data['jenis'] == 5 || $data['jenis'] == 6 || $data['jenis'] == 7) {
                                                            # code...
                                                            echo ($posisi_keuangan_debit != 0) ? ribuan($posisi_keuangan_debit) : "";
                                                        }
                                                    } elseif ($penentu_letak_sisa_total == 3 || $penentu_letak_sisa_total == 4) {
                                                        # code...
                                                        $posisi_keuangan_debit = $sisa_saldo_2;
                                                        if ($data['jenis'] == 1 || $data['jenis'] == 2 || $data['jenis'] == 5 || $data['jenis'] == 6 || $data['jenis'] == 7) {
                                                            # code...
                                                            echo ($posisi_keuangan_debit != 0) ? ribuan($posisi_keuangan_debit) : "";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align: right;">
                                                <?php
                                                $posisi_keuangan_kredit = 0;
                                                if ($count_query_jurnal_umum_detail == 0) {
                                                    # code...
                                                    if ($data['saldo_normal'] == 2) {
                                                        # code...
                                                        $posisi_keuangan_kredit = $saldo_awal;
                                                        if ($data['jenis'] == 1 || $data['jenis'] == 2 || $data['jenis'] == 5 || $data['jenis'] == 6 || $data['jenis'] == 7) {
                                                            # code...
                                                            echo ($posisi_keuangan_kredit != 0) ? ribuan($posisi_keuangan_kredit) : "";
                                                        }
                                                    }
                                                } else {
                                                    # code...
                                                    if ($penentu_letak_sisa_total == 5 || $penentu_letak_sisa_total == 6) {
                                                        # code...
                                                        $posisi_keuangan_kredit = $sisa_saldo_1;
                                                        if ($data['jenis'] == 1 || $data['jenis'] == 2 || $data['jenis'] == 5 || $data['jenis'] == 6 || $data['jenis'] == 7) {
                                                            # code...
                                                            echo ($posisi_keuangan_kredit != 0) ? ribuan($posisi_keuangan_kredit) : "";
                                                        }
                                                    } elseif ($penentu_letak_sisa_total == 7 || $penentu_letak_sisa_total == 8) {
                                                        # code...
                                                        $posisi_keuangan_kredit = $sisa_saldo_2;
                                                        if ($data['jenis'] == 1 || $data['jenis'] == 2 || $data['jenis'] == 5 || $data['jenis'] == 6 || $data['jenis'] == 7) {
                                                            # code...
                                                            echo ($posisi_keuangan_kredit != 0) ? ribuan($posisi_keuangan_kredit) : "";
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>