<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AktLevelHargaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Piutang';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-level-harga-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <ul class="breadcrumb"><li><a href="/">Home</a></li>
        <li class="active">Daftar Piutang</li>
    </ul>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-dollar"></span> Daftar Piutang</div>
                <div class="panel-body">
                    <div class="col-md-12" style="padding: 0;">
                        <div class="box-body">

                            <div id="stok" class="tab-pane fade in active" >
                                <table class="table" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>