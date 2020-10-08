<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\Login;
use backend\models\AktApprover;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktReturPenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Retur Penjualan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 

    $approve = AktApprover::find()->leftJoin("akt_jenis_approver", "akt_jenis_approver.id_jenis_approver = akt_approver.id_jenis_approver")->where(['=', 'nama_jenis_approver', 'Retur Penjualan'])->all();

    # untuk menentukan yang login apakah approver, jika approver maka form tidak muncul
    $string_approve = array();
    foreach ($approve as $key => $value) {
        # code...
        $string_approve[] = $value['id_login'];
    }
    $hasil_string_approve = implode(", ", $string_approve);
    $hasil_array_approve = explode(", ", $hasil_string_approve);
    $angka_array_approve = 0;
    if (in_array(Yii::$app->user->identity->id_login, $hasil_array_approve)) {
        # code...
        $angka_array_approve = 1;
    }
    ?>

    <p>
        <?php
        if ($angka_array_approve == 0) {
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

            // 'id_retur_penjualan',
            'no_retur_penjualan',
            [
                'attribute' => 'tanggal_retur_penjualan',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal_retur_penjualan, true);
                }
            ],
            [
                'attribute' => 'id_penjualan_pengiriman',
                'value' => function ($model) {
                    if (!empty($model->penjualan_pengiriman->no_pengiriman)) {
                        # code...
                        return $model->penjualan_pengiriman->no_pengiriman;
                    } else {
                        # code...
                    }
                }
            ],
            [
                'attribute' => 'status_retur',
                'format' => 'html',
                'label' => 'Status',
                'filter' => array(
                    0 => 'Pengajuan',
                    1 => 'Disetujui',
                    2 => 'Ditolak'
                ),
                'value' => function ($model) {
                    $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                    $label = "";
                    if ($model->status_retur == 0) {
                        $label = "<span class='label label-warning'>Pengajuan</span>";
                    } elseif ($model->status_retur == 1) {
                        $label = "<span class='label label-success'>Disetujui pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                    } elseif ($model->status_retur == 2) {
                        $label = "<span class='label label-danger'>Ditolak pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                    }
                    return $label;
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
                        $url = 'index.php?r=akt-retur-penjualan/view&id=' . $model->id_retur_penjualan;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-retur-penjualan/update&id=' . $model->id_retur_penjualan;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-retur-penjualan/delete&id=' . $model->id_retur_penjualan;
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
            'heading' => '<span class="glyphicon glyphicon-repeat"></span> ' . $this->title,
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