<?php

use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;
use backend\models\AktPenjualan;
/* @var $this yii\web\View */

if (Yii::$app->user->isGuest) {
    header("Location: index.php");
    exit;
}
$this->title = 'Home';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
    </ul>

    <!-- label -->
    <div class="row">
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>Rp. <?= pretty_money_minus($sum_omzet) ?> </h3>
                    <p>Total Omzet</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>Rp.<?= pretty_money_minus($saldo_kas->saldo_akun) ?> </h3>
                    <p>Total Kas</p>
                </div>
                <div class="icon">
                    <i class="fa fa-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>Rp. <?= pretty_money_minus($saldo_piutang) ?> </h3>
                    <p>Total Piutang</p>
                </div>
                <div class="icon">
                    <i class="fa fa-funnel-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <div class="col-lg-3">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>Rp. <?= pretty_money_minus($saldo_hutang) ?> </h3>
                    <p>Total Hutang</p>
                </div>
                <div class="icon">
                    <i class="fa fa-funnel-dollar"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    </div>
    <!-- label -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading panel-primary">
                    <h4 style="font-weight: bold;"> Data Penjualan Dan Pembelian per Hari </h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <canvas id="chart-area" style="height:350px;"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="chart-area2" style="height:350px;"></canvas>
                    </div>
                    <!-- <canvas id="chart-area" style="height:500px;"></canvas> -->
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading panel-primary">
                    <h4 style="font-weight: bold;"> Data Penjualan per Bulan </h4>
                </div>
                <div class="panel-body">
                    <div class="col-md-6">
                        <canvas id="chart-area-penjualan" style="height:350px;"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="chart-area-pie" style="height:350px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 style="font-weight: bold;"> Penjualan Terbanyak Bulan <?php // bulan(date('m')) 
                                                                                ?> </h4>
                </div>
                <div class="panel-body">
                    <?php
                    if (count($penjualan) == 0) {
                        echo "<p style='font-weight:bold;'>Belum ada penjualan</p>";
                    };
                    foreach ($penjualan as $p) {
                        $width = $p['penjualan'] / $sum_penjualan * 100 - 20;
                    ?>
                        <p><?= $p['nama_item'] ?></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= $p['penjualan'] ?>" aria-valuemin="0" aria-valuemax="150" style="width: <?= $width ?>%; margin-right:20px;">

                            </div>
                            <span style="font-weight: bold;">
                                <?= $p['penjualan'] ?> Penjualan
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 style="font-weight: bold;"> <span class="fas fa-money"></span> Daftar Kas Bank</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>MU</th>
                                <th>Saldo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($akt_kas_bank as $data_kas) { ?>
                                <tr>
                                    <td><?= $data_kas['keterangan'] ?></td>
                                    <td><?= $data_kas['mata_uang'] ?></td>
                                    <td><?= number_format($data_kas['saldo']) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" src="js/Chart.js"></script>
    <script>
        const ctx = document.getElementById("chart-area").getContext('2d');
        const ctx2 = document.getElementById("chart-area2").getContext('2d');
        const ctx3 = document.getElementById("chart-area-penjualan").getContext('2d');
        const ctx4 = document.getElementById("chart-area-pie").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                datasets: [{
                    data: [
                        <?php
                        foreach ($tanggal as $t) {
                            $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_penjualan) as penjualan FROM akt_penjualan WHERE tanggal_penjualan = '$t[tanggal_penjualan]' AND status >= 3")->query();
                            foreach ($data_count as $g) {
                                echo '"' . $g['penjualan'] . '",';
                            }
                        }
                        ?>, '0'
                    ],
                    backgroundColor: 'green',
                    borderColor: 'green',
                    fill: false,
                    lineTension: 0.5,
                    label: 'Penjualan'
                }],
                labels: [
                    <?php
                    foreach ($tanggal_label as $tgl) {
                        echo '"' . tanggal_indo($tgl['tanggal_penjualan']) . '",';
                    }
                    ?>
                ]
            },
            options: configOptions,
        });
        var myChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                datasets: [{
                    data: [
                        <?php
                        foreach ($tanggal2 as $t) {
                            $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_pembelian) as pembelian FROM akt_pembelian WHERE tanggal_order_pembelian = '$t[tanggal_order_pembelian]' AND status >= 3")->query();
                            foreach ($data_count as $g) {
                                echo '"' . $g['pembelian'] . '",';
                            }
                        }
                        ?>, '0'
                    ],
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    fill: false,
                    lineTension: 0.5,
                    label: 'Pembelian'
                }],
                labels: [
                    <?php
                    foreach ($tanggal_label2 as $tgl) {
                        echo '"' . tanggal_indo($tgl['tanggal_pembelian']) . '",';
                    }
                    ?>
                ]
            },
            options: configOptions
        });

        var myChart = new Chart(ctx3, {
            type: 'bar',
            data: {
                datasets: [{
                    data: [
                        <?php
                        $year = date('Y');
                        foreach ($bulan as $b) {
                            $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_penjualan) as penjualan FROM akt_penjualan WHERE MONTH(tanggal_penjualan) = '$b' AND YEAR(tanggal_penjualan) = '$year' AND status >= 3")->query();
                            foreach ($data_count as $g) {
                                echo '"' . $g['penjualan'] . '",';
                            }
                        } ?>, '0'
                    ],
                    backgroundColor: 'green',
                    borderColor: 'green',
                    fill: false,
                    lineTension: 0.5,
                    label: 'Penjualan'
                }, {
                    data: [
                        <?php
                        $year = date('Y') - 1;
                        foreach ($bulan as $b) {
                            $data_count = Yii::$app->db->createCommand("SELECT COUNT(id_penjualan) as penjualan FROM akt_penjualan WHERE MONTH(tanggal_penjualan) = '$b' AND YEAR(tanggal_penjualan) = '$year' AND status >= 3")->query();
                            foreach ($data_count as $g) {
                                echo '"' . $g['penjualan'] . '",';
                            }
                        } ?>, '0'
                    ],
                    backgroundColor: 'red',
                    borderColor: 'red',
                    fill: false,
                    lineTension: 0.5,
                    label: 'Penjualan Tahun Sebelumnya'
                }],
                labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            },
            options: configOptions
        });

        var myChart = new Chart(ctx4, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [<?= $penjualan_tahun_ini ?>, <?= $penjualan_tahun_sebelumnya ?>],
                    backgroundColor: ['#34BE4A', '#D72828'],
                    borderColor: ['#34BE4A', '#D72828'],
                    fill: false,
                    lineTension: 0.5,
                    label: 'Penjualan'
                }],
                labels: ['Penjualan Tahun Ini ', 'Penjualan Tahun Sebelumnya']
            },
            options: configOptions
        });

        var configOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: '#fff',
            segmentStrokeWidth: 1,
            percentageInnerCutout: 0,
            animationSteps: 100,
            animationEasing: 'easeOutBounce',
            animateRotate: true,
            animateScale: false,
            responsive: true,
            maintainAspectRatio: false,
            legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
            legend: {
                display: true,
                position: 'bottom',
                fontSize: 10,
                boxWidth: 20
            },
            title: {
                display: false,
            },
            chartArea: {
                backgroundColor: 'rgba(255, 255, 255, 1)'
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return 'Jumlah : ' + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                },
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 10
                    }
                }]
            }

        }
    </script>