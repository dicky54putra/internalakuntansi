<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use backend\models\MenuNavigasiRole;
use backend\models\Userrole;

/* @var $this yii\web\View */
/* @var $model backend\models\MenuNavigasi */

$this->title = "Detail Menu Navigasi: " . $model->nama_menu;
// $this->params['breadcrumbs'][] = ['label' => 'Menu Navigasi', 'url' => ['index']];
// if (isset($_GET["submenu"])) {
//     $this->params['breadcrumbs'][] = ['label' => 'Sub Menu', 'url' => ['view', 'id' => Yii::$app->request->get('submenu')]];
// }
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-navigasi-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Daftar Menu Navigasi', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>
    <?php
    $userrole = Yii::$app->db->createCommand("SELECT system_role.nama_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id . " AND  system_role.nama_role = 'DEVELOPER'")->queryScalar();
    if ($userrole == 'DEVELOPER') {
        $hidden = '';
    } else {
        $hidden = 'hidden';
    }
    ?>
    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_menu], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_menu], [
            'class' => 'btn btn-danger ' . $hidden . '',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-success">
        <div class="box-header">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id_menu',
                            'nama_menu',
                            'url:url',
                            'id_parent',
                            'no_urut',
                            'icon',
                            [
                                'attribute' => 'status',
                                'format'    => 'raw',
                                'filter'    => array(0 => "Aktif", 1 => "Tidak Aktif"),
                                'value'     => function ($model) {
                                    return $model->status == 0 ? "<span class='label label-success'>Aktif</span>" : "<span class='label label-warning'>Tidak Aktif</span>";
                                }
                            ],
                        ],
                    ]) ?>

                    <?php if ($jumlahSubmenu > 0) { ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                'nama_menu',
                                'url',
                                [
                                    'attribute' => 'parent',
                                    'value'     => function ($model) {
                                        return $model->parent == "" ? "" : $model->parent;
                                    }
                                ],
                                'no_urut',
                                'icon',
                                [
                                    'attribute' => 'status',
                                    'format'    => 'raw',
                                    'filter'    => array(0 => "Aktif", 1 => "Tidak Aktif"),
                                    'value'     => function ($model) {
                                        return $model->status == 0 ? "<span class='label label-success'>Aktif</span>" : "<span class='label label-warning'>Tidak Aktif</span>";
                                    }
                                ],

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Actions',
                                    'headerOptions' => ['style' => 'color:#337ab7'],
                                    'template' => "{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}",
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
                                            $userrole = Yii::$app->db->createCommand("SELECT system_role.nama_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id . " AND  system_role.nama_role = 'DEVELOPER'")->queryScalar();
                                            if ($userrole == 'DEVELOPER') {
                                                $hidden = '';
                                            } else {
                                                $hidden = 'hidden';
                                            }
                                            return Html::a('<button class = "btn btn-danger ' . $hidden . '"><span class="glyphicon glyphicon-trash"></span> Hapus</button>', $url, [
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
                                            $url = 'index.php?r=menu-navigasi/view&id=' . $model->id_menu . "&submenu=" . Yii::$app->request->get("id");
                                            return $url;
                                        }
                                        if ($action === 'update') {
                                            $url = 'index.php?r=menu-navigasi/update&id=' . $model->id_menu . "&submenu=" . Yii::$app->request->get("id");
                                            return $url;
                                        }
                                        if ($action === 'delete') {
                                            $url = 'index.php?r=menu-navigasi/delete&id=' . $model->id_menu . "&submenu=" . Yii::$app->request->get("id");
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
                                'heading' => 'Sub Menu',
                            ],
                            'persistResize' => false,
                            'toggleDataOptions' => ['minCount' => 100],
                            'exportConfig' => [
                                GridView::EXCEL =>  [
                                    'filename' => 'Data_LogistikRequest',
                                    'showPageSummary' => true,
                                ]

                            ],
                        ]); ?>

                    <?php } ?>

                </div>
            </div>
        </div>
    </div>

    <div class="box box-success">
        <div class="box-header ">
            <h3 class="box-title">HAK AKSES</h3>
        </div>
        <div class="box-body">

            <div class="col-md-12" style="padding: 0;">

                <?= Html::beginForm(['menu-navigasi/view', 'id' => $model->id_menu], 'post') ?>
                <?= Html::hiddenInput("id", $model->id_menu) ?>

                <?php
                foreach ($hakakses as $data) {
                    $cek = MenuNavigasiRole::find()->where(["id_system_role" => $data->id_system_role, "id_menu" => $model->id_menu])->count();
                    $value = "0";
                    if ($cek > 0) $value = "1";


                    echo Html::checkbox('data[' . $data->id_system_role . ']', $value, ['label' => $data->nama_role]);
                    echo "<br>";
                }

                ?>
                <?= Html::submitButton('Simpan Hak Akses', ['class' => 'btn btn-success']) ?>
                <?= Html::endForm() ?>

            </div>
        </div>
    </div>



</div>