<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktReturPembelianDetail */

$this->title = 'Create Akt Retur Pembelian Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Retur Pembelian Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-retur-pembelian-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
