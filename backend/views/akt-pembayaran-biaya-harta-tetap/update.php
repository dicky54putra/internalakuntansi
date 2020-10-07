<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiayaHartaTetap */

$this->title = 'Update Akt Pembayaran Biaya Harta Tetap: ' . $model->id_pembayaran_biaya_harta_tetap;
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembayaran Biaya Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pembayaran_biaya_harta_tetap, 'url' => ['view', 'id' => $model->id_pembayaran_biaya_harta_tetap]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-pembayaran-biaya-harta-tetap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
