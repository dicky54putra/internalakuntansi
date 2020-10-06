<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelianHartaTetap */

$this->title = $model->id_item_pembelian_harta_tetap;
$this->params['breadcrumbs'][] = ['label' => 'Item Pembelian Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-pembelian-harta-tetap-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_item_pembelian_harta_tetap], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_item_pembelian_harta_tetap], [
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
            'id_item_pembelian_harta_tetap',
            'id_pembelian_harta_tetap',
            'id_harta_tetap',
            'harga',
            'diskon',
            'pajak',
            'lokasi',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
