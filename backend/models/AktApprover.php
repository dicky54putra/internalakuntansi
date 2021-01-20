<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_approver".
 *
 * @property int $id_approver
 * @property int $id_login
 * @property int $jenis_approver
 * @property int $tingkat_approver
 */
class AktApprover extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_approver';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jenis_approver', 'tingkat_approver'], 'required'],
            [['id_login', 'id_jenis_approver', 'tingkat_approver'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_approver' => 'Id Approver',
            'id_login' => 'Akun Login',
            'id_jenis_approver' => 'Jenis Approver',
            'tingkat_approver' => 'Tingkat Approver',
        ];
    }

    public function getlogin()
    {
        return $this->hasOne(Login::className(), ['id_login' => 'id_login']);
    }
    public function getjenis_approver()
    {
        return $this->hasOne(AktJenisApprover::className(), ['id_jenis_approver' => 'id_jenis_approver']);
    }
}
