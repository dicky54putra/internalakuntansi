<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\Login;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPengajuanBiayaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pengajuan Biaya';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pengajuan-biaya-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <p>
        <?php
        if (in_array("APPROVER", Yii::$app->session->get('user_role'))) {
        } else {
            # code...
        ?>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['style' => 'white-space:nowrap;table-layout:fixed;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                        $url = 'index.php?r=akt-pengajuan-biaya/view&id=' . $model->id_pengajuan_biaya;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-pengajuan-biaya/update&id=' . $model->id_pengajuan_biaya;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-pengajuan-biaya/delete&id=' . $model->id_pengajuan_biaya;
                        return $url;
                    }
                }
            ],

            // 'id_pengajuan_biaya',
            'nomor_pengajuan_biaya',
            [
                'attribute' => 'tanggal_pengajuan',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_pengajuan, true);
                }
            ],
            'nomor_purchasing_order',
            'nomor_kendaraan',
            'volume',
            'keterangan_pengajuan:ntext',
            [
                'attribute' => 'dibuat_oleh',
                'value' => function ($model) {
                    if (!empty($model->login->nama)) {
                        # code...
                        return $model->login->nama;
                    }
                }
            ],
            'jenis_bayar',
            'dibayar_oleh',
            'dibayar_kepada',
            'alamat_dibayar_kepada:ntext',
            [
                'attribute' => 'approver1',
                'format' => 'raw',
                'value' => function ($model) {
                    $login_approver1 = Login::findOne($model->approver1);
                    $approver1 = '';
                    if (!empty($login_approver1->nama)) {
                        # code...
                        $approver1 = $login_approver1->nama;
                    }
                    $approver1_date = '';
                    if ($model->approver1_date == '0000-00-00 00:00:00') {
                        # code...
                        $approver1_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                    } else {
                        # code...
                        $approver1_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver1_date))) . "</span>";
                    }
                    if ($model->status == 1) {
                        # code...
                        $approver1_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                    }
                    return $approver1 . '<br>' . $approver1_date;
                }
            ],
            [
                'attribute' => 'approver2',
                'format' => 'raw',
                'value' => function ($model) {
                    $login_approver2 = Login::findOne($model->approver2);
                    $approver2 = '';
                    if (!empty($login_approver2->nama)) {
                        # code...
                        $approver2 = $login_approver2->nama;
                    }
                    $approver2_date = '';
                    if ($model->approver2_date == '0000-00-00 00:00:00') {
                        # code...
                        $approver2_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                    } else {
                        # code...
                        $approver2_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver2_date))) . "</span>";
                    }
                    if ($model->status == 2) {
                        # code...
                        $approver2_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                    }
                    return $approver2 . '<br>' . $approver2_date;
                }
            ],
            [
                'attribute' => 'approver3',
                'format' => 'raw',
                'value' => function ($model) {
                    $login_approver3 = Login::findOne($model->approver3);
                    $approver3 = '';
                    if (!empty($login_approver3->nama)) {
                        # code...
                        $approver3 = $login_approver3->nama;
                    }
                    $approver3_date = '';
                    if ($model->approver3_date == '0000-00-00 00:00:00') {
                        # code...
                        $approver3_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                    } else {
                        # code...
                        $approver3_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver3_date))) . "</span>";
                    }
                    if ($model->status == 3) {
                        # code...
                        $approver3_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                    }
                    return $approver3 . '<br>' . $approver3_date;
                }
            ],
            [
                'attribute' => 'status',
                'filter' => array(
                    0 => "Belum Di Setujui",
                    1 => "Di Tolak Approver 1",
                    2 => "Di Tolak Approver 2",
                    3 => "Di Tolak Approver 3",
                    4 => "Sudah Di Setujui",
                ),
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status == 0) {
                        # code...
                        return "<span class='label label-default' style='font-size: 85%;'>Belum Di Setujui</span>";
                    } elseif ($model->status == 1) {
                        # code...
                        return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 1</span>";
                    } elseif ($model->status == 2) {
                        # code...
                        return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 2</span>";
                    } elseif ($model->status == 3) {
                        # code...
                        return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 3</span>";
                    } elseif ($model->status == 4) {
                        # code...
                        return "<span class='label label-success' style='font-size: 85%;'>Sudah Di Setujui</span>";
                    }
                }
            ],
            'alasan_reject:ntext',
            [
                'attribute' => 'tanggal_jatuh_tempo',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ]
                ],
                'value' => function ($model) {
                    if (!empty($model->tanggal_jatuh_tempo)) {
                        # code...
                        return tanggal_indo($model->tanggal_jatuh_tempo, true);
                    }
                }
            ],
            [
                'attribute' => 'sumber_dana',
                'filter' => array(
                    1 => "Kas Kecil Tanjung",
                    2 => "Bank",
                ),
                'value' => function ($model) {
                    if ($model->sumber_dana == 1) {
                        # code...
                        return "Kas Kecil Tanjung";
                    } elseif ($model->sumber_dana == 2) {
                        # code...
                        return "Bank";
                    }
                }
            ],
            [
                'attribute' => 'status_pembayaran',
                'filter' => array(
                    1 => "Belum Di Bayar",
                    2 => "Sudah Di Bayar",
                ),
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status_pembayaran == 1) {
                        # code...
                        return "<span class='label label-default' style='font-size: 85%;'>Belum Di Bayar</span>";
                    } elseif ($model->status_pembayaran == 2) {
                        # code...
                        return "<span class='label label-success' style='font-size: 85%;'>Sudah Di Bayar</span>";
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
            'heading' => '<span class="fa fa-book"></span> ' . $this->title,
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