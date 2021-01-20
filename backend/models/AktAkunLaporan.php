<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_akun_laporan".
 *
 * @property int $id_akun_laporan
 * @property string $nama_laporan
 */
class AktAkunLaporan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_akun_laporan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_laporan'], 'required'],
            [['nama_laporan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_akun_laporan' => 'Id Akun Laporan',
            'nama_laporan' => 'Nama Laporan',
        ];
    }
}
