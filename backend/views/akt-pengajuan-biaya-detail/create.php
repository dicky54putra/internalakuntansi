<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AktPengajuanBiayaDetail */

$this->title = 'Create Akt Pengajuan Biaya Detail';
$this->params['breadcrumbs'][] = ['label' => 'Akt Pengajuan Biaya Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akt-pengajuan-biaya-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
