<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\models\AktCabang;
use backend\models\AktPegawai;
use backend\models\Login;
use backend\models\AktProyek;
use backend\models\AktDepartement;
use backend\models\AktSatuan;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPermintaanPembelianSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Permintaan Pembelian';
?>
<div class="akt-permintaan-pembelian-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">Permintaan Pembelian</li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_permintaan_pembelian',
            'no_permintaan',
            // 'tanggal',
            [
                'attribute' => 'tanggal',
                'format' => 'raw',
                'value' => function ($model) {
                    return tanggal_indo($model->tanggal);
                }
            ],
            // 'id_pegawai',
            [
                'attribute' => 'id_pegawai',
                'label' => 'Pegawai',
                'value' => function ($model) {

                    $pegawai = AktPegawai::find()->where(['id_pegawai' => $model->id_pegawai])->one();

                    return $pegawai->nama_pegawai;
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'filter' => array(
                    2 => ' Belum Disetujui ',
                    1 => 'Disetujui',
                    3 => 'Ditolak',
                ),
                'value' => function ($model) {
                    if ($model->status == '2') {
                        return '<p class="label label-default" style="font-weight:bold;"> Belum Disetujui </p> ';
                    } else if ($model->status == '1') {
                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                        return "<span class='label label-success'>Disetujui pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                    } else if ($model->status == '3') {
                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                        return "<span class='label label-danger'>Ditolak pada " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve))) . " oleh " . $nama_approver->nama . "</span>";
                    }
                }
            ],



            [
                // 'attribute' => 'status',
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Aksi',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update} {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info"><span class="glyphicon glyphicon-eye-open"></span> Detail </button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        if ($model->status == 1) {
                            return;
                        }
                        return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if ($model->status == 1) {
                            return;
                        }
                        return Html::a('<button class = "btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
                            'title' => Yii::t('app', 'lead-delete'),
                            'data' => [
                                'confirm' => 'Anda yakin ingin menghapus data?',
                                'method' => 'post'
                            ],
                        ]);
                    },

                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url = 'index.php?r=akt-permintaan-pembelian/view&id=' . $model->id_permintaan_pembelian;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-permintaan-pembelian/update&id=' . $model->id_permintaan_pembelian;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-permintaan-pembelian/delete&id=' . $model->id_permintaan_pembelian;
                        return $url;
                    }
                }
            ],
        ],
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        //'pjax' => true, // pjax is set to always true for this demo
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
            'heading' => '<span class="fa fa-file"></span> Permintaan Pembelian',
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
                'filename' => 'Permintaan Pembelian',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>