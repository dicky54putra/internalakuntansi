<?php
use yii\helpers\Html;
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
        <h3 class="print">
            <?= 'Laporan Neraca Saldo Sebelum Penyesuaian: ' . date('d/m/Y', strtotime($tanggal_awal)) . ' s/d ' . date('d/m/Y', strtotime($tanggal_akhir)) ?>
        </h3>
        <div class="box"> 
            <div class="panel">
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" style="vertical-align: middle;text-align: center;" rowspan="2">No</th>
                                        <th scope="col" style="vertical-align: middle;text-align: center;" rowspan="2">Kode Akun</th>
                                        <th scope="col" style="vertical-align: middle;text-align: center;" rowspan="2">Nama Akun</th>
                                        <th scope="col" style="vertical-align: middle;text-align: center;" colspan="2">Saldo</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;">Debet</th>
                                        <th style="text-align: center;">Kredit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $no = 1;
                                $query_akun = AktAkun::find()->where("1")->orderBy("nama_akun")->all();
                                foreach ($query_akun as $key => $data) {
                                    $akt_saldo_awal_akun_detail = AktSaldoAwalAkunDetail::find()->where(['id_akun' => $data['id_akun']])->orderBy("id_saldo_awal_akun_detail DESC")->limit(1)->one();
                                    $count_query_jurnal_umum_detail = AktJurnalUmumDetail::find()
                                    ->select(["akt_jurnal_umum.tanggal","akt_jurnal_umum_detail.debit", "akt_jurnal_umum_detail.kredit", "akt_jurnal_umum_detail.id_akun", "akt_jurnal_umum_detail.id_jurnal_umum_detail"])
                                    ->leftJoin("akt_jurnal_umum", "akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum")
                                    ->where("akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")
                                    ->orderBy("id_jurnal_umum_detail ASC")
                                    ->count();
                                    $nilai_saldo_awal_akun = (!empty($akt_saldo_awal_akun_detail['debet'])) ? $akt_saldo_awal_akun_detail['debet'] : $retVal = (!empty($akt_saldo_awal_akun_detail['kredit'])) ? $akt_saldo_awal_akun_detail['kredit'] : 0 ;
                                    $saldo_awal = $nilai_saldo_awal_akun;
                                    $sum_debit = Yii::$app->db->createCommand("SELECT SUM(debit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                                    $sum_kredit = Yii::$app->db->createCommand("SELECT SUM(kredit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum WHERE akt_jurnal_umum.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND akt_jurnal_umum_detail.id_akun = '$data[id_akun]'")->queryScalar();
                                    $saldo_debit = $saldo_awal + $sum_debit;
                                    $change_saldo = $saldo_debit - $sum_kredit;
                                    
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['kode_akun']?></td>
                                        <td><?= $data['nama_akun']?></td>
                                        <td style="text-align: right;">
                                            <?php
                                                if($count_query_jurnal_umum_detail == 0 ) {
                                                    if($data['saldo_normal'] == 1) {
                                                        echo ribuan(abs($saldo_awal));
                                                    }
                                                } else {
                                                    if($saldo_debit >= $sum_kredit) {
                                                        echo ribuan(abs($change_saldo));
                                                    }
                                                }
                                
                                            ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <?php
                                                if($count_query_jurnal_umum_detail == 0 ) {
                                                    if($data['saldo_normal'] == 2) {
                                                        echo ribuan(abs($saldo_awal));
                                                    }
                                                } else {
                                                    if($saldo_debit <= $sum_kredit) {
                                                        echo ribuan(abs($change_saldo));
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
</div>
<?php
$fileName = "Laporan Neraca Saldo Sebelum Penyesuaian.xls";
header("Content-Disposition: attachment; filename=$fileName");
header("Content-Type: application/vnd.ms-excel");
?>