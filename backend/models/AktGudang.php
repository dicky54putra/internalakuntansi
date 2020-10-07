<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_gudang".
 *
 * @property int $id_gudang
 * @property string $kode_gudang
 * @property string $nama_gudang
 * @property int $status_aktif_gudang
 */
class AktGudang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_gudang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_gudang', 'nama_gudang', 'status_aktif_gudang'], 'required'],
            [['status_aktif_gudang'], 'integer'],
            [['kode_gudang', 'nama_gudang'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_gudang' => 'Id Gudang',
            'kode_gudang' => 'Kode Gudang',
            'nama_gudang' => 'Nama Gudang',
            'status_aktif_gudang' => 'Status',
        ];
    }
}
