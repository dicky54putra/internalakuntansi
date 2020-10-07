<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiaya */

$this->title = 'Update Akt Pembayaran Biaya: ' . $model->id_pembayaran_biaya;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembayaran Biayas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pembayaran_biaya, 'url' => ['view', 'id' => $model->id_pembayaran_biaya]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembayaran-biaya-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
