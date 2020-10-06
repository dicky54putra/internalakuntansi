<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiayaHartaTetap */

$this->title = 'Create Akt Pembayaran Biaya Harta Tetap';
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembayaran Biaya Harta Tetaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembayaran-biaya-harta-tetap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
