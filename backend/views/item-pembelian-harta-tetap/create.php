<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ItemPembelianHartaTetap */

$this->title = 'Create Item Pembelian Harta Tetap';
$this->params['breadcrumbs'][] = ['label' => 'Item Pembelian Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-pembelian-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
