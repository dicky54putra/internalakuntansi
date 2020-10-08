<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\AktPermintaanBarang;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktPermintaanBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use backend\models\Login;
$this->title = 'Data Permintaan Barang';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-permintaan-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_permintaan_barang',
            'nomor_permintaan',
            [
                'attribute' => 'tanggal_permintaan',
                'value' => function ($model)
                {
                    return tanggal_indo($model->tanggal_permintaan);
                }
            ],
            [
                'attribute' => 'id_pegawai',
                'value' => function ($model)
                {
                    return $model->pegawai->nama_pegawai;
                }
            ],
            [
                'attribute' => 'status_aktif',
                'format' => 'html',
                'label' => 'Status',
                'filter' => array(
                    0 => 'Belum Disetujui',
                    1 => 'Disetujui',
                    2 => 'Ditolak',
                ),
                'value' => function ($model) {
                    if ($model->status_aktif == 0) {
                        # code...
                        return "<span class='label label-warning'>Belum Disetujui</span>";
                    } elseif ($model->status_aktif == 1) {
                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                        return "<span class='label label-success'>Disetujui pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve)))  . " oleh " . $nama_approver->nama . "</span>";
                    } elseif ($model->status_aktif == 2) {
                        $nama_approver = Login::find()->where(['id_login' => $model->id_login])->one();
                        return "<span class='label label-danger'>Ditolak pada " .  tanggal_indo2(date('D, d F Y H:i', strtotime($model->tanggal_approve)))  . " oleh " . $nama_approver->nama . "</span>";
                    }
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => "{view} {update} {delete}",
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<button class = "btn btn-info "><span class="glyphicon glyphicon-eye-open"></span> Detail</button>', $url, [
                            'title' => Yii::t('app', 'lead-view'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        if($model->status_aktif == 1 || $model->status_aktif == 2  ) {
                            return;
                        }
                        return Html::a('<button class = "btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</button>', $url, [
                            'title' => Yii::t('app', 'lead-update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if($model->status_aktif == 1 || $model->status_aktif == 2 ) {

                            return;
                         }

                        return Html::a('<button class = "btn btn-danger "><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
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
                        $url = 'index.php?r=akt-permintaan-barang/view&id=' . $model->id_permintaan_barang;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=akt-permintaan-barang/update&id=' . $model->id_permintaan_barang;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=akt-permintaan-barang/delete&id=' . $model->id_permintaan_barang;
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
            'heading' => '<span class="fa fa-file-text"></span> '.$this->title,
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
                'filename' => 'Daftar Pajak',
                'showPageSummary' => true,
            ]

        ],
    ]); ?>
</div>
