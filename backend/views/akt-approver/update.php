<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktApprover */

$this->title = 'Ubah Data Approver : ' . $retVal = (!empty($model->login->nama)) ? $model->login->nama : '';
// $this->params['breadcrumbs'][] = ['label' => 'Akt Approvers', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->id_approver, 'url' => ['view', 'id' => $model->id_approver]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="akt-approver-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Data Approver', ['index']) ?></li>
        <!-- <li><?= Html::a('Detail Data Approver : ' . $retVal = (!empty($model->login->nama)) ? $model->login->nama : '', ['view', 'id' => $model->id_approver]) ?></li> -->
        <li class="active"><?= $this->title ?></li>
    </ul>

    <?= $this->render('_form', [
        'model' => $model,
        'data_login' => $data_login,
    ]) ?>

</div>