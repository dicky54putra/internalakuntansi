<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaanDetail */

$this->title = 'Update Akt Pembelian Penerimaan Detail: ' . $model->id_pembelian_penerimaan_detail;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Penerimaan Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pembelian_penerimaan_detail, 'url' => ['view', 'id' => $model->id_pembelian_penerimaan_detail]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-penerimaan-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
