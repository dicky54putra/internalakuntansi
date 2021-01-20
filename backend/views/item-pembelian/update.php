<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelian */

$this->title = 'Update Item Pembelian: ' . $model->id_item_pembelian;
$this->params['breadcrumbs'][] = ['label' => 'Item Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_item_pembelian, 'url' => ['view', 'id' => $model->id_item_pembelian]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-pembelian-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
            'array_item' => $array_item,
    ]) ?>

</div>
