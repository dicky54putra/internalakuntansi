<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPenerimaanPembayaranHartaTetap */

$this->title = 'Create Akt Penerimaan Pembayaran Harta Tetap';
$this->params['breadcrumbs'][] = ['label' => 'Akt Penerimaan Pembayaran Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-penerimaan-pembayaran-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
