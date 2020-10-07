<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalStokDetail */

$this->title = 'Create Akt Saldo Awal Stok Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Stok Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-saldo-awal-stok-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
