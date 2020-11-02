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

    <style>
        .chart-area-penjualan-rupiah {
            display: none;
        }
    </style>

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
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading panel-primary">
                    <h4 style="font-weight: bold;"> Data Penjualan per Bulan </h4>

                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <select class="form-control" name="format-grafik" id="format-grafik">
                                <option value="1">Dalam Jumlah</option>
                                <option value="2">Dalam Rupiah</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="chart-area-penjualan-count" class="chart-area-penjualan-count" style="height:350px;"></canvas>
                            <canvas id="chart-area-penjualan-rupiah" class="chart-area-penjualan-rupiah" style="height:350px;"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="chart-area-pie" style="height:350px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 style="font-weight: bold;"> Penjualan Terbanyak Bulan <?= bulan(date('m'))
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

        const ctx3count = document.querySelector(".chart-area-penjualan-count");
        const ctxcount = ctx3count.getContext('2d');

        const ctx3rupiah = document.querySelector(".chart-area-penjualan-rupiah");
        const ctxrupiah = ctx3rupiah.getContext('2d');

        const ctx4 = document.getElementById("chart-area-pie").getContext('2d');

        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
            }
            return x1 + x2;
        }

        const configOptions = {
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
                    title: function(tooltipItems, data) {
                        return false;
                    },

                    label: function(tooltipItem, data) {
                        return `${data.datasets[tooltipItem.datasetIndex].label} ` + tooltipItem.yLabel.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    },
                },
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontSize: 10
                    }
                }],
                yAxes: [{
                    ticks: {
                        callback: function(value, index, values) {
                            return addCommas(value);
                        }
                    }
                }]
            }

        }
        setup();

        async function setup() {
            const formatGrafik = document.getElementById('format-grafik');

            chartPenjualanPerBulan(configOptions, 'get-data-per-bulan', ctx3count)

            const grafik = await formatGrafik.addEventListener('change', function() {
                if (this.value == 1) {
                    ctx3rupiah.style.display = "none";
                    ctx3count.style.display = "block";
                    chartPenjualanPerBulan(configOptions, 'get-data-per-bulan', ctx3count)
                } else {
                    ctx3count.style.display = "none";
                    ctx3rupiah.style.display = "block";
                    chartPenjualanPerBulan(configOptions, 'get-data-per-bulan-rupiah', ctx3rupiah)
                }
            });
        }



        chartPenjualanPerHari(configOptions);
        chartPembelianPerHari(configOptions);
        chartPiePenjualanPerBulan(configOptions)



        async function chartPiePenjualanPerBulan(option) {
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
                options: option
            });
        }

        async function chartPenjualanPerHari(option) {
            const dataPenjualan = await dataGrafik(`get-data-per-hari&select=tanggal_penjualan&tabel=akt_penjualan`)
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [{
                        data: dataPenjualan,
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
                options: option,
            });
        }

        async function chartPembelianPerHari(option) {
            const dataPembelian = await dataGrafik(`get-data-per-hari&select=tanggal_pembelian&tabel=akt_pembelian`)
            var myChart = new Chart(ctx2, {
                type: 'bar',
                data: {
                    datasets: [{
                        data: dataPembelian,
                        backgroundColor: 'green',
                        borderColor: 'green',
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
                options: option,
            });
        }

        async function chartPenjualanPerBulan(option, link, chart) {

            const dataTahunIni = await dataGrafik(`${link}&select=tanggal_penjualan&tabel=akt_penjualan&type=1`);
            const dataTahunSebelumnya = await dataGrafik(`${link}&select=tanggal_penjualan&tabel=akt_penjualan&type=0`);
            var myChart = new Chart(chart, {
                type: 'bar',
                data: {
                    datasets: [{
                        data: dataTahunIni,
                        backgroundColor: 'green',
                        borderColor: 'green',
                        fill: false,
                        lineTension: 0.5,
                        label: 'Penjualan Tahun Ini'
                    }, {
                        data: dataTahunSebelumnya,
                        backgroundColor: 'red',
                        borderColor: 'red',
                        fill: false,
                        lineTension: 0.5,
                        label: 'Penjualan Tahun Sebelumnya'
                    }],
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
                },
                options: option
            });

        }

        async function dataGrafik(type) {
            let penjualan;

            let data = await fetch(`index.php?r=setting/${type}`)
                .then(res => res.json())
                .then(res =>
                    penjualan = res
                ).catch(err => err);

            return penjualan;
        }
    </script>