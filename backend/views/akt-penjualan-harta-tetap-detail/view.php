<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenjualanHartaTetapDetail */

$this->title = $model->id_penjualan_harta_tetap_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penjualan Harta Tetap Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-penjualan-harta-tetap-detail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penjualan_harta_tetap_detail], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penjualan_harta_tetap_detail], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_penjualan_harta_tetap_detail',
            'id_penjualan_harta_tetap',
            'id_item_stok',
            'qty',
            'harga',
            'diskon',
            'total',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
