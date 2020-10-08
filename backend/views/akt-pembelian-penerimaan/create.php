<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPembelianPenerimaan */

$this->title = 'Create Akt Pembelian Penerimaan';
$this->params['breadcrumbs'][] = ['label' => 'Akt Pembelian Penerimaans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pembelian-penerimaan-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'model_pembelian' => $model_pembelian,
    ]) ?>

</div>