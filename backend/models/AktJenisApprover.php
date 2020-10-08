<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_jenis_approver".
 *
 * @property int $id_jenis_approver
 * @property string $nama_jenis_approver
 */
class AktJenisApprover extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_jenis_approver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_jenis_approver'], 'required'],
            [['nama_jenis_approver'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_approver' => 'Id Jenis Approver',
            'nama_jenis_approver' => 'Nama Jenis Approver',
        ];
    }
}
