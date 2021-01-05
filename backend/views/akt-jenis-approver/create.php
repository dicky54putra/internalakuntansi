<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktJenisApprover */

$this->title = 'Jenis Approver';
?>
<div class="akt-jenis-approver-create">

<h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a($this->title, ['index']) ?></li>
        <li class="active">Tambah <?= $this->title ?></li>
    </ul>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
