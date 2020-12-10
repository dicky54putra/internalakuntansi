<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Pengaturan */

$this->title = 'Update Pengaturan: ' . $model->id_pengaturan;
$this->params['breadcrumbs'][] = ['label' => 'Pengaturans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pengaturan, 'url' => ['view', 'id' => $model->id_pengaturan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pengaturan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
