<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_akun_laporan_detail".
 *
 * @property int $id_akun_laporan_detail
 * @property int $id_akun_laporan
 * @property int $id_akun
 * @property int $no_urut
 */
class AktAkunLaporanDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_akun_laporan_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_akun_laporan', 'id_akun', 'no_urut'], 'required'],
            [['id_akun_laporan', 'id_akun', 'no_urut'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_akun_laporan_detail' => 'Id Akun Laporan Detail',
            'id_akun_laporan' => 'Id Akun Laporan',
            'id_akun' => 'Id Akun',
            'no_urut' => 'No Urut',
        ];
    }
}
