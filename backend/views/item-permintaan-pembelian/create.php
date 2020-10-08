<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPermintaanPembelian */

$this->title = 'Create Item Permintaan Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Item Permintaan Pembelians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-permintaan-pembelian-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
