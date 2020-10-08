<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaanDetail */

$this->title = 'Create Akt Pembelian Penerimaan Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Penerimaan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-penerimaan-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
