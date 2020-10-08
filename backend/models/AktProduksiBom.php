<?php

namespace backend\models;

use Yii;
use backend\models\AktBom;
use backend\models\AktMitraBisnis;
use backend\models\AktPegawai;
use backend\models\AktAkun;

/**
 * This is the model class for table "akt_produksi_bom".
 *
 * @property int $id_produksi_bom
 * @property int $no_produksi_bom
 * @property string $tanggal
 * @property int $id_pegawai
 * @property int $id_customer
 * @property int $id_bom
 * @property string $tipe
 * @property int $id_akun
 */
class AktProduksiBom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_produksi_bom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_produksi_bom', 'tanggal', 'id_bom', 'tipe'], 'required'],
            [['id_pegawai', 'id_customer', 'id_bom', 'id_akun','status_produksi'], 'integer'],
            [['tanggal'], 'safe'],
            [['tipe'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_produksi_bom' => 'Id Produksi Bom',
            'no_produksi_bom' => 'No Produksi B.o.M',
            'tanggal' => 'Tanggal',
            'id_pegawai' => 'Pegawai',
            'id_customer' => 'Customer',
            'id_bom' => 'No B.o.M',
            'tipe' => 'Tipe',
            'id_akun' => 'Akun',
            'status_produksi' => 'Status'
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
    public function getbom()
    {
        return $this->hasOne(AktBom::className(), ['id_bom' => 'id_bom']);
    }
}
