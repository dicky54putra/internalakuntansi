<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RequestFitur */

$this->title = 'Update Request Fitur: ' . $model->id_request_fitur;
$this->params['breadcrumbs'][] = ['label' => 'Request Fitur', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_request_fitur, 'url' => ['view', 'id' => $model->id_request_fitur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-fitur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
