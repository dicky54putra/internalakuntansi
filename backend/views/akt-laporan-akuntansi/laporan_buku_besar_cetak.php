<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use backend\models\AktAkun;
use backend\models\AktJurnalUmumDetail;
use backend\models\AktSaldoAwalAkunDetail;
?>
<style>
    table,
    td {
        border: 1px solid #000000;
        text-align: left;
        padding: 5px;
    }

    table,
    th {
        border: 1px solid #000000;
        padding: 5px;
        text-align: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 13px;
        padding: 10px;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    th,
    td {
        padding: 5px;
    }
</style>
<div style="page-break-after: always;">
    <p style="font-weight: bold;font-size: 20px;">
        Laporan Buku Besar : <?= date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir))  ?>
    </p>
    <?php
    $filter_jenis = "";
    if (!empty($jenis)) {
        # code...
        $filter_jenis = " AND jenis = '$jenis'";
    }
    $filter_klasifikasi = "";
    if (!empty($klasifikasi)) {
        # code...
        $filter_klasifikasi = " AND klasifikasi = '$klasifikasi'";
    }

    $query_akun = AktAkun::find()->where("1 $filter_jenis $filter_klasifikasi")->orderBy("nama_akun")->all();
    foreach ($query_akun as $key => $data) {
        # code...
        $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();

        $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0;

        $saldo_awal = $nilai_saldo_awal_akun;
    ?>
        <table class="table">
            <tr>
                <th colspan="8" style="text-align: left;"><?= 'Akun : ' . $data['nama_akun'] ?></th>
            </tr>
            <tr>
                <th style="width: 1%; vertical-align: middle;" rowspan="2">#</th>
                <th style="width: 10%; vertical-align: middle;" rowspan="2">Tanggal</th>
                <th style="width: 10%; vertical-align: middle;" rowspan="2">No Jurnal</th>
                <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                <th rowspan="2" style="width: 10%; vertical-align: middle;">Debet</th>
                <th rowspan="2" style="width: 10%; vertical-align: middle;">Kredit</th>
                <th style="width: 30%;" colspan="2">Saldo</th>
            </tr>
            <tr>
                <th style="text-align: center;">Debet</th>
                <th style="text-align: center;">Kredit</th>
            </tr>
            <tr>
                <td colspan="3">Saldo Awal</td>
                <td colspan="3"></td>
                <td style="text-align: right;white-space: nowrap;"><?= ($data['saldo_normal'] == 1) ? ribuan($saldo_awal) : '' ?></td>
                <td style="text-align: right;white-space: nowrap;"><?= ($data['saldo_normal'] == 2) ? ribuan($saldo_awal) : '' ?></td>
            </tr>
            <?php
            $no = 0;
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
                $no++;

                if ($no == 1) {
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

                if ($no > 1) {
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

            ?>
                <tr>
                    <td><?= $no . '.' ?></td>
                    <td><?= date('d/m/Y', strtotime($dataa['tanggal'])) ?></td>
                    <td><?= $dataa['no_jurnal_umum'] ?></td>
                    <td><?= $dataa['keterangan'] ?></td>
                    <td style="text-align: right;white-space: nowrap;"><?= ($dataa['debit'] != 0) ? ribuan($dataa['debit']) : '' ?></td>
                    <td style="text-align: right;white-space: nowrap;"><?= ($dataa['kredit'] != 0) ? ribuan($dataa['kredit']) : '' ?></td>
                    <td style="text-align: right;white-space: nowrap;">
                        <?php
                        if ($no == 1) {
                            # code...
                            if ($data['saldo_normal'] == 1) {
                                # code...
                                if (($dataa['debit'] + $saldo_awal) >= $dataa['kredit']) {
                                    # code...
                                    $penentu_letak_sisa_total = 1;
                                    echo ribuan($sisa_saldo_1);
                                } else {
                                    # code...
                                    // echo 'pindah sebelah 1';
                                }
                            } else {
                                # code...
                                if (($dataa['kredit'] + $saldo_awal) < $dataa['debit']) {
                                    # code...
                                    $penentu_letak_sisa_total = 2;
                                    echo ribuan($sisa_saldo_1);
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
                                    echo ribuan($sisa_saldo_2);
                                } else {
                                    # code...
                                    // echo 'pindah sebelah 1';
                                }
                            } else {
                                # code...
                                if (($dataa['kredit'] + $sisa_saldo_2) < $dataa['debit']) {
                                    # code...
                                    $penentu_letak_sisa_total = 4;
                                    echo ribuan($sisa_saldo_2);
                                } else {
                                    # code...
                                    // echo 'pindah sebelah 2';
                                }
                            }
                            // if (($dataa['debit'] + $sisa_saldo_2) >= $dataa['kredit']) {
                            //     # code...
                            //     $penentu_letak_sisa_total = 3;
                            //     echo ribuan($sisa_saldo_2) . '3';
                            // } else {
                            //     # code...
                            //     echo 'pindah sebelah 3';
                            // }
                        }
                        ?>
                    </td>
                    <td style="text-align: right;white-space: nowrap;">
                        <?php
                        if ($no == 1) {
                            # code...
                            if ($data['saldo_normal'] == 1) {
                                # code...
                                if (($dataa['debit'] + $saldo_awal) < $dataa['kredit']) {
                                    # code...
                                    $penentu_letak_sisa_total = 5;
                                    echo ribuan($sisa_saldo_1);
                                } else {
                                    # code...
                                    // echo 'pindah sebelah 4';
                                }
                            } else {
                                # code...
                                if (($dataa['kredit'] + $saldo_awal) >= $dataa['debit']) {
                                    # code...
                                    $penentu_letak_sisa_total = 6;
                                    echo ribuan($sisa_saldo_1);
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
                                    echo ribuan($sisa_saldo_2);
                                } else {
                                    # code...
                                    // echo 'pindah sebelah 4';
                                }
                            } else {
                                # code...
                                if (($dataa['kredit'] + $sisa_saldo_2) >= $dataa['debit']) {
                                    # code...
                                    $penentu_letak_sisa_total = 8;
                                    echo ribuan($sisa_saldo_2);
                                } else {
                                    # code...
                                    // echo 'pindah sebelah 5';
                                }
                            }
                            // if (($dataa['debit'] + $sisa_saldo_1) < $dataa['kredit']) {
                            //     # code...
                            //     $penentu_letak_sisa_total = 6;
                            //     echo ribuan($sisa_saldo_2);
                            // } else {
                            //     # code...
                            //     echo 'pindah sebelah 6';
                            // }
                        }
                        ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th colspan="6" style="text-align: left;">Sisa Total</th>
                <th style="text-align: right;">
                    <?php
                    if ($count_query_jurnal_umum_detail == 0) {
                        # code...
                        if ($data['saldo_normal'] == 1) {
                            # code...
                            echo ribuan($saldo_awal);
                        }
                    } else {
                        # code...
                        if ($penentu_letak_sisa_total == 1 || $penentu_letak_sisa_total == 2) {
                            # code...
                            echo ribuan($sisa_saldo_1);
                        } elseif ($penentu_letak_sisa_total == 3 || $penentu_letak_sisa_total == 4) {
                            # code...
                            echo ribuan($sisa_saldo_2);
                        }
                    }
                    ?>
                </th>
                <th style="text-align: right;">
                    <?php
                    if ($count_query_jurnal_umum_detail == 0) {
                        # code...
                        if ($data['saldo_normal'] == 2) {
                            # code...
                            echo ribuan($saldo_awal);
                        }
                    } else {
                        # code...
                        if ($penentu_letak_sisa_total == 5 || $penentu_letak_sisa_total == 6) {
                            # code...
                            echo ribuan($sisa_saldo_1);
                        } elseif ($penentu_letak_sisa_total == 7 || $penentu_letak_sisa_total == 8) {
                            # code...
                            echo ribuan($sisa_saldo_2);
                        }
                    }
                    ?>
                </th>
            </tr>
        </table>
        <br>
    <?php } ?>
</div>
<script>
    window.print();
    setTimeout(window.close, 500);
</script>