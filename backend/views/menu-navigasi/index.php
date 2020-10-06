<?php

use backend\models\Userrole;
use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MenuNavigasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Navigasi';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-navigasi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?php
    $userrole = Yii::$app->db->createCommand("SELECT system_role.nama_role FROM user_role INNER JOIN system_role ON system_role.id_system_role = user_role.id_system_role WHERE user_role.id_login = " . Yii::$app->user->id . " AND  system_role.nama_role = 'DEVELOPER'")->queryScalar();
    // $userrole = Userrole::find()
    //     ->select('*')
    //     ->leftJoin('system_role', 'system_role.id_system_role = user_role.id_system_role')
    //     // ->where(["user_role.id_login" => Yii::$app->user->id])
    //     // ->andWhere(["nama_role" => 'DEVELOPER'])
    //     ->one();
    // var_dump($userrole);
    ?>

    <?php
    if ($userrole == 'DEVELOPER') {
    ?>
        <p>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span>Tambah Menu Navigasi', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php } ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama_menu',
            'url',

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
                'template' => "{view} {update} {delete}",
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
                        $url = 'index.php?r=menu-navigasi/view&id=' . $model->id_menu;
                        return $url;
                    }

                    if ($action === 'update') {
                        $url = 'index.php?r=menu-navigasi/update&id=' . $model->id_menu;
                        return $url;
                    }

                    if ($action === 'delete') {
                        $url = 'index.php?r=menu-navigasi/delete&id=' . $model->id_menu;
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
            'heading' => '',
        ],
        'persistResize' => false,
        'toggleDataOptions' => ['minCount' => 100],
        'exportConfig' => [
            GridView::EXCEL =>  [
                'filename' => 'Data_Menu_Navigasi',
                'showPageSummary' => true,
            ]

        ],
        //'itemLabelSingle' => 'book',
        //'itemLabelPlural' => 'books'
    ]); ?>
</div>