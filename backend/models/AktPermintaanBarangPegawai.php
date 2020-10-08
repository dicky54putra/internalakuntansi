<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "akt_permintaan_barang_pegawai".
 *
 * @property int $id_permintaan_barang_pegawai
 * @property int $id_permintaan_barang
 * @property int $id_pegawai
 */
class AktPermintaanBarangPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_permintaan_barang_pegawai';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_permintaan_barang', 'id_pegawai'], 'required'],
            [['id_permintaan_barang', 'id_pegawai'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_permintaan_barang_pegawai' => 'Id Permintaan Barang Pegawai',
            'id_permintaan_barang' => 'Id Permintaan Barang',
            'id_pegawai' => 'Pegawai',
        ];
    }
}
