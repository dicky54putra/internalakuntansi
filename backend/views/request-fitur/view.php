<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\RequestFitur */

$this->title = 'View Detail Data Request Fitur : '.$model->id_request_fitur;
$this->params['breadcrumbs'][] = ['label' => 'Request Fitur', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="request-fitur-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_request_fitur], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_request_fitur], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p> -->
<div class="box">
<div class="box-header">
<div class="col-md-12" style="padding: 0;">
<div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_request_fitur',
            'tanggal',
            'login.nama',
            'keterangan:ntext',
            [
                'attribute' => 'status',
                'value'     => function ($model)
                {
                    if ($model->status == 1) {
                        return "Submission";
                    } elseif ($model->status == 2) {
                        return "On Progress";
                    } else {
                        return "Completed";
                    }
                }
            ],
        ],
    ]) ?>

</div>
<?= Html::beginForm(['request-fitur/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
<?= Html::hiddenInput("id_tabel",$model->id_request_fitur) ?>
<?= Html::hiddenInput("nama_tabel","request_fitur") ?>
<div class="box">
<div class="col-md-4" style="padding: 0;">
<div class="box-body">
    <table class="table">
        <thead>
            <tr>
                <th>UPLOAD FOTO / DOKUMEN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input class = 'btn btn-warning' type="file" name="foto" id="exampleInputFile"><br>   
                    <b style="color: red;">Catatan:<br>- File harus bertype jpg, png.<br>- Ukuran maksimal 2 MB.</b>  
                </td>
                <td>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?= Html::endForm() ?>

<div class="box">
<div class="col-md-12" style="padding: 0;">
<div class="box-body">
    <table class="table">
        <thead>
            <tr>
                <th>FOTO / DOKUMEN :</th>
            </tr>
        </thead>
    </table>
    <div class="row">
        <?php 
        foreach ($foto as $data)
        {
            echo "<div class='col-md-6'>";
            echo "<a href='/backend/web/upload/".$data->foto."' target='_blank'><img src='/backend/web/upload/".$data->foto."' width='150'></a><br><a href='index.php?r=request-fitur/view&id=".$model->id_request_fitur."&id_hapus=".$data->id_foto."' onclick=\"return confirm('Anda yakin ingin menghapus?')\"><img src='images/hapus.png' width='32'></a>";
            echo "</div>";
        }
        
        ?>
    </div>
</div>
<div class="box">
<div class="col-md-12" style="padding: 0;">
<div class="box-body">