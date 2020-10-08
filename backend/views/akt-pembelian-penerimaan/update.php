<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaan */

$this->title = 'Update Akt Pembelian Penerimaan: ' . $model->id_pembelian_penerimaan;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Penerimaans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pembelian_penerimaan, 'url' => ['view', 'id' => $model->id_pembelian_penerimaan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembelian-penerimaan-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'model_pembelian' => $model_pembelian,
    ]) ?>

</div>