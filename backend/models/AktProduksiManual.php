<?php

namespace backend\models;
use backend\models\AktMitraBisnis;
use backend\models\AktPegawai;
use backend\models\AktAkun;
use Yii;

/**
 * This is the model class for table "akt_produksi_manual".
 *
 * @property int $id_produksi_manual
 * @property string $no_produksi_manual
 * @property int $tanggal
 * @property int $id_pegawai
 * @property int $id_customer
 * @property int $id_akun
 * @property int $status_produksi
 */
class AktProduksiManual extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_produksi_manual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_produksi_manual', 'tanggal', 'id_customer'], 'required'],
            [['id_pegawai', 'id_customer', 'id_akun', 'status_produksi'], 'integer'],
            [['no_produksi_manual'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produksi_manual' => 'Id Produksi Manual',
            'no_produksi_manual' => 'No Produksi Manual',
            'tanggal' => 'Tanggal',
            'id_pegawai' => 'Pegawai',
            'id_customer' => 'Customer',
            'id_akun' => 'Akun',
            'status_produksi' => 'Status',
        ];
    }

    public function getmitra_bisnis()
    {
        return $this->hasOne(AktMitraBisnis::className(), ['id_mitra_bisnis' => 'id_customer']);
    }

    public function getakun()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun']);
    }

    public function getpegawai()
    {
        return $this->hasOne(AktPegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}
