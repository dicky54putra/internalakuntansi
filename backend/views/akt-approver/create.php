<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktApprover */

$this->title = 'Tambah Data Approver';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Approvers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-approver-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Approver', ['index']) ?></li>
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_login' => $data_login,
    ]) ?>

</div>