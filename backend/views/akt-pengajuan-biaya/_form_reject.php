<?php

use backend\models\Login;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<div class="panel panel-primary">
    <div class="panel-heading"><span class="fa fa-book"></span> <?= $this->title ?></div>
    <div class="panel-body">
        <div class="col-md-12" style="padding: 0;">
            <div class="box-body">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'alasan_reject')->textarea(['rows' => 6]) ?>

                <div class="form-group">
                    <?php
                    if ($model->isNewRecord) {
                        # code...
                        $url = ['index'];
                    } else {
                        # code...
                        $url = ['view', 'id' => $model->id_pengajuan_biaya];
                    }

                    ?>
                    <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', $url, ['class' => 'btn btn-warning']) ?>
                    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> Simpan', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width:35%;">{label}</th><td>{value}</td></tr>',
                            'attributes' => [
                                // 'id_pengajuan_biaya',
                                'nomor_pengajuan_biaya',
                                [
                                    'attribute' => 'tanggal_pengajuan',
                                    'value' => function ($model) {
                                        return tanggal_indo($model->tanggal_pengajuan, true);
                                    }
                                ],
                                'nomor_purchasing_order',
                                'nomor_kendaraan',
                                'volume',
                                'keterangan_pengajuan:ntext',
                                [
                                    'attribute' => 'dibuat_oleh',
                                    'value' => function ($model) {
                                        if (!empty($model->login->nama)) {
                                            # code...
                                            return $model->login->nama;
                                        }
                                    }
                                ],
                                'jenis_bayar',
                                'dibayar_oleh',
                                'dibayar_kepada',
                                'alamat_dibayar_kepada:ntext',
                            ],
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= DetailView::widget([
                            'model' => $model,
                            'template' => '<tr><th style="width:35%;">{label}</th><td>{value}</td></tr>',
                            'attributes' => [
                                // 'id_pengajuan_biaya',
                                [
                                    'attribute' => 'approver1',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $login_approver1 = Login::findOne($model->approver1);
                                        $approver1 = '';
                                        if (!empty($login_approver1->nama)) {
                                            # code...
                                            $approver1 = $login_approver1->nama;
                                        }
                                        $approver1_date = '';
                                        if ($model->approver1_date == '0000-00-00 00:00:00') {
                                            # code...
                                            $approver1_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                                        } else {
                                            # code...
                                            $approver1_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver1_date))) . "</span>";
                                        }
                                        if ($model->status == 1) {
                                            # code...
                                            $approver1_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                                        }
                                        return $approver1 . '<br>' . $approver1_date;
                                    }
                                ],
                                [
                                    'attribute' => 'approver2',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $login_approver2 = Login::findOne($model->approver2);
                                        $approver2 = '';
                                        if (!empty($login_approver2->nama)) {
                                            # code...
                                            $approver2 = $login_approver2->nama;
                                        }
                                        $approver2_date = '';
                                        if ($model->approver2_date == '0000-00-00 00:00:00') {
                                            # code...
                                            $approver2_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                                        } else {
                                            # code...
                                            $approver2_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver2_date))) . "</span>";
                                        }
                                        if ($model->status == 2) {
                                            # code...
                                            $approver2_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                                        }
                                        return $approver2 . '<br>' . $approver2_date;
                                    }
                                ],
                                [
                                    'attribute' => 'approver3',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        $login_approver3 = Login::findOne($model->approver3);
                                        $approver3 = '';
                                        if (!empty($login_approver3->nama)) {
                                            # code...
                                            $approver3 = $login_approver3->nama;
                                        }
                                        $approver3_date = '';
                                        if ($model->approver3_date == '0000-00-00 00:00:00') {
                                            # code...
                                            $approver3_date = "<span class='label label-warning' style='font-size: 85%;'>Pending</span>";
                                        } else {
                                            # code...
                                            $approver3_date = "<span class='label label-success' style='font-size: 85%;'>Approved : " . tanggal_indo2(date('D, d F Y H:i', strtotime($model->approver3_date))) . "</span>";
                                        }
                                        if ($model->status == 3) {
                                            # code...
                                            $approver3_date = "<span class='label label-danger' style='font-size: 85%;'>Rejected</span>";
                                        }
                                        return $approver3 . '<br>' . $approver3_date;
                                    }
                                ],
                                [
                                    'attribute' => 'status',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if ($model->status == 0) {
                                            # code...
                                            return "<span class='label label-default' style='font-size: 85%;'>Belum Di Setujui</span>";
                                        } elseif ($model->status == 1) {
                                            # code...
                                            return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 1</span>";
                                        } elseif ($model->status == 2) {
                                            # code...
                                            return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 2</span>";
                                        } elseif ($model->status == 3) {
                                            # code...
                                            return "<span class='label label-warning' style='font-size: 85%;'>Di Tolak Approver 3</span>";
                                        } elseif ($model->status == 4) {
                                            # code...
                                            return "<span class='label label-success' style='font-size: 85%;'>Sudah Di Setujui</span>";
                                        }
                                    }
                                ],
                                'alasan_reject:ntext',
                                [
                                    'attribute' => 'tanggal_jatuh_tempo',
                                    'value' => function ($model) {
                                        if (!empty($model->tanggal_jatuh_tempo)) {
                                            # code...
                                            return tanggal_indo($model->tanggal_jatuh_tempo, true);
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'sumber_dana',
                                    'value' => function ($model) {
                                        if ($model->sumber_dana == 1) {
                                            # code...
                                            return "Kas Kecil Tanjung";
                                        } elseif ($model->sumber_dana == 2) {
                                            # code...
                                            return "Bank";
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'status_pembayaran',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if ($model->status_pembayaran == 1) {
                                            # code...
                                            return "<span class='label label-default' style='font-size: 85%;'>Belum Di Bayar</span>";
                                        } elseif ($model->status_pembayaran == 2) {
                                            # code...
                                            return "<span class='label label-success' style='font-size: 85%;'>Sudah Di Bayar</span>";
                                        }
                                    }
                                ],
                            ],
                        ]) ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>