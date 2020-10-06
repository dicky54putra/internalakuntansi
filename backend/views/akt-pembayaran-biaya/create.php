<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembayaranBiaya */

$this->title = 'Create Akt Pembayaran Biaya';
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembayaran Biayas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembayaran-biaya-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
