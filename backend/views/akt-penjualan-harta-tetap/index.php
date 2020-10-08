<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\AktApprover;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPenjualanHartaTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Penjualan Harta Tetap';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penjualan-harta-tetap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <p>
        <?php
        $approver = AktApprover::find()->leftJoin("akt_jenis_approver", "akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver")->where(['=', 'nama_jenis_approver', 'Penjualan Harta Tetap'])->all();

        # untuk menentukan yang login apakah approver, jika approver maka form tidak muncul
        $string_approver = array();
        foreach ($approver as $key => $value) {
            # code...
            $string_approver[] = $value['id_login'];
        }
        $hasil_string_approver = implode(", ", $string_approver);
        $hasil_array_approver = explode(", ", $hasil_string_approver);
        $angka_array_approver = 0;
        if (in_array(Yii::$app->user->identity->id_login, $hasil_array_approver)) {
            # code...
            $angka_array_approver = 1;
        }
        ?>
        <?php
        if ($angka_array_approver == 0) {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_penjualan_harta_tetap',
            'no_penjualan_harta_tetap',
            [
                'attribute' => 'tanggal_penjualan_harta_tetap',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_penjualan_harta_tetap, true);
                }
            ],
            [
                'attribute' => 'id_customer',
                'value' => function ($model) {
                    if (!empty($model->customer->nama_mitra_bisnis)) {
                        # code...
                        return $model->customer->nama_mitra_bisnis;
                    }
                }
            ],
            // 'id_sales',
            //'id_mata_uang',
            //'the_approver',
            //'the_approver_date',
            //'no_faktur_penjualan_harta_tetap',
            //'tanggal_faktur_penjualan_harta_tetap',
            //'ongkir',
            //'pajak',
            //'uang_muka',
            //'id_kas_bank',
            //'total',
            //'diskon',
            //'jenis_bayar',
            //'jumlah_tempo',
            //'tanggal_tempo',
            //'materai',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => array(
                    1 => 'Belum Disetujui',
                    2 => 'Sudah Disetujui',
                    3 => 'Ditolak',
                ),
                'value' => function ($model) {
                    $the_approver_name = "";
                    if (!empty($model->approver->nama)) {
                        # code...
                        $the_approver_name = $model->approver->nama;
                    }

                    $the_approver_date = "";
                    if (!empty($model->the_approver_date)) {
                        # code...
                        $the_approver_date = tanggal_indo2(date('D, d F Y H:i', strtotime($model->the_approver_date)));
                    }

                    if ($model->status == 1) {
                        # code...
                        return "<span class='label label-default' style='font-size: 12px;'>Belum Disetujui</span>";
                    } elseif ($model->status == 2) {
                        # code...
                        return "<span class='label label-success' style='font-size: 12px;'>Disetujui pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-danger' style='font-size: 12px;'>Ditolak pada " . $the_approver_date . " oleh " . $the_approver_name . "</span>";
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail</button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                                'method' => 'post',
                            ],
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=akt-penjualan-harta-tetap/view&id=' . $model->id_penjualan_harta_tetap;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-penjualan-harta-tetap/update&id=' . $model->id_penjualan_harta_tetap;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-penjualan-harta-tetap/delete&id=' . $model->id_penjualan_harta_tetap;
                        return $url;
                    }
                }
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
        // set your toolbar
        'toolbar' =>  [

            '{export}',
            '{toggleData}',
        ],
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        // parameters from the demo form
        //'bordered' => $bordered,
        //'striped' => $striped,
        //'condensed' => $condensed,
        //'responsive' => $responsive,
        //'hover' => $hover,
        //'showPageSummary' => $pageSummary,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-shopping-cart"></span> ' . $this->title,
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'autoXlFormat' => true,
        'toggleDataContainer' => ['class' => 'btn-group mr-2'],
        'export' => [
            'showConfirmAlert' => false,
            'target' => GridView::TARGET_BLANK
        ],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => $this->title,
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>