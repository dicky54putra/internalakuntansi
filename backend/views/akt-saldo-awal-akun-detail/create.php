<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktSaldoAwalAkunDetail */

$this->title = 'Create Akt Saldo Awal Akun Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Saldo Awal Akun Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-saldo-awal-akun-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
