<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaranHartaTetap */

$this->title = 'Update Akt Penerimaan Pembayaran Harta Tetap: ' . $model->id_penerimaan_pembayaran_harta_tetap;
$this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayaran Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_penerimaan_pembayaran_harta_tetap, 'url' => ['view', 'id' => $model->id_penerimaan_pembayaran_harta_tetap]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-penerimaan-pembayaran-harta-tetap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
